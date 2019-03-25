<?php

namespace app\controllers;

use app\models\Acta;
use app\models\Eleccion;
use app\models\Postulacion;
use app\models\RecintoEleccion;
use app\models\Voto;
use Da\User\Filter\AccessRuleFilter;
use Da\User\Form\LoginForm;
use yii\data\Sort;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRuleFilter::class,
                ],
//                'only' => ['error'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
//                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'index',
                            'votospostulacion',
                            'report',
                            'recintoactas',
                            'elecciones-totales'],
                        'allow' => true,
                        'roles' => ['site/index', 'junta/index'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $users = Yii::$app->authManager->getUserIdsByRole('Digitador');
        if(in_array(Yii::$app->user->getId(), $users))
        {
            $this->redirect(Url::toRoute(['junta/index']));
        }

        $totalElectores = 0;
        $totalVotos = 0;
        $totalVotosNulos = 0;
        $totalVotosBlancos = 0;

        return $this->render('index3', [
            'totalElectores' => $totalElectores,
            'totalVotos' => $totalVotos,
            'totalVotosNulos' => $totalVotosNulos,
            'totalVotosBlancos' => $totalVotosBlancos,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

//    public function actionLogin()
//    {
//        return $this->render('login');
//    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionReport()
    {
        $elecciones = Eleccion::find()->all();
        $eleccion = null;

        $labelsPorcientos = [];
        $dataPorcientos = [];
        $totalRecintos = 0;
        $totalJunta = 0;
        $totalActas = 0;
        $totalPostulacion = 0;

        if(count($elecciones)) {
            $eleccion = $elecciones[0];
            $labelsPorcientos = ['Votos Validos', 'Votos Nulos', 'Votos en Blanco', 'Ausentismo'];

            $dataPorcientos = [
                $eleccion->porcientoVotos,
                $eleccion->porcientoVotosNulos,
                $eleccion->porcientoVotosBlancos,
                $eleccion->porcientoAusentismo,
            ];
        }

        return $this->render('report', [
            'labelsPorcientos' => $labelsPorcientos,
            'dataPorcientos' => $dataPorcientos,
            'totalRecintos' => $totalRecintos,
            'totalJunta' => $totalJunta,
            'totalActas' => $totalActas,
            'totalPostulacion' => $totalPostulacion,
        ]);
    }

    function actionVotospostulacion() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['msg'] = '';
        $response['data'] = [];
        $response['msg_dev'] = '';
        $canton = Yii::$app->request->get('canton');
        $recinto = Yii::$app->request->get('recinto');
        $dignidad= Yii::$app->request->get('dignidad');

         $query = Voto::find()
            ->select('SUM(voto.vote) as total')
            ->innerJoin('postulacion', 'postulacion.id = voto.postulacion_id')
            ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id = postulacion.id')
            ->asArray();

        $query2 = Postulacion::find()
            ->select([
                'profile.name',
                'SUM(voto.vote) as vote'
            ])
            ->leftJoin('voto', 'voto.postulacion_id = postulacion.id')
            ->innerJoin('profile', 'profile.user_id = postulacion.candidate_id')
            ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id = postulacion.id')
            ->innerJoin('acta', 'acta.id = voto.acta_id')
            ->innerJoin('junta', 'junta.id = acta.junta_id')
            ->groupBy(['postulacion.id'])
            ->having(['>', 'vote', 0])
            ->orderBy(['vote'=>SORT_DESC])
            ->asArray();

         if(intval($canton) !== 0)
         {
             $query->andFilterWhere(['postulacion_canton.canton_id'=>intval($canton)]);
             $query2->andFilterWhere(['postulacion_canton.canton_id'=>intval($canton)]);
         }

         if(intval($dignidad) !== 0)
         {
             $query->andFilterWhere(['postulacion.role'=>intval($dignidad)]);
             $query2->andFilterWhere(['postulacion.role'=>intval($dignidad)]);
         }

        if(intval($recinto))
        {
            $query2->andFilterWhere(['junta.recinto_eleccion_id'=>intval($recinto)]);
        }

        $total = $query->all();
        $results = $query2->all();

        $total = intval($total[0]['total']);
        foreach ($results as $tuple)
        {
            $tuple['porciento'] = round((intval($tuple['vote']) * 100) / $total, 2);
            array_push($response['data'], $tuple);
        }

        return $response;
    }

    function actionRecintoactas() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['msg'] = '';
        $response['data'] = [];
        $response['msg_dev'] = '';

        $canton = Yii::$app->request->get('canton');
        $recinto = Yii::$app->request->get('recinto');
        $dignidad = Yii::$app->request->get('dignidad');
        $tipoJunta = Yii::$app->request->get('tipoJunta');

        $elecciones = Eleccion::find()->all();
        $eleccion = null;

        $totalRecintos = 0;
        $totalJunta = 0;
        $totalActas = 0;
        $totalPostulacion = 0;

        if(count($elecciones)) {
            $eleccion = $elecciones[0];

            $totalRecintos = $eleccion->getTotalRecintos();
            $totalJunta = $eleccion->getTotalJuntas();
            $totalActas = $eleccion->getTotalActasRegistradas();
            $totalPostulacion = $eleccion->getTotalPostulacion();
        }

        $response['data']['totales'] = [
            'totalRecintos' => $totalRecintos,
            'totalJunta' => $totalJunta,
            'totalActas' => $totalActas,
            'totalPostulacion' => $totalPostulacion,
        ] ;

        // id de las actas validas registradas
        $actasRegistradas = $eleccion->getActasRegistradas();

        $query = Acta::find()
            ->select([
                'canton.name',
                'count(acta.id) as cantidad'
            ])
            ->innerJoin('junta', 'junta.id = acta.junta_id')
            ->innerJoin('recinto_eleccion', 'recinto_eleccion.id=junta.recinto_eleccion_id')
            ->innerJoin('recinto_electoral', 'recinto_electoral.id=recinto_eleccion.recinto_id')
            ->innerJoin('zona', 'zona.id=recinto_electoral.zona_id')
            ->innerJoin('parroquia', 'zona.parroquia_id=parroquia.id')
            ->innerJoin('canton', 'canton.id=parroquia.canton_id')
            ->where(['in', 'acta.id', $actasRegistradas])
            ->groupBy(['canton.id'])
            ->orderBy(['cantidad'=>SORT_DESC])
            ->asArray();

        if(intval($canton))
        {
            $query->andFilterWhere(['canton.id'=>intval($canton)]);
        }

        if(intval($dignidad))
        {
            $query->andFilterWhere(['acta.type'=>intval($dignidad)]);
        }

        if(intval($recinto))
        {
            $query->andFilterWhere(['junta.recinto_eleccion_id'=>intval($recinto)]);
        }

        if(intval($tipoJunta))
        {
            $query->andFilterWhere(['junta.type'=>intval($tipoJunta)]);
        }

        $response['data']['rentintoActas'] = $query->all();

        return $response;
    }

    function actionEleccionesTotales() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['msg'] = '';
        $response['data'] = [];
        $response['msg_dev'] = '';

        $elecciones = Eleccion::find()->all();
        $eleccion = null;

        if(count($elecciones)) {
            $eleccion = $elecciones[0];

            $totalElectores = $eleccion->totalElectores;
            $totalVotos = $eleccion->totalVotos;
            $totalVotosNulos = $eleccion->totalVotosNulos;
            $totalVotosBlancos = $eleccion->totalVotosBlancos;
        }

        $response['data'] = [
            'totalElectores' => $totalElectores,
            'totalVotos' => $totalVotos,
            'totalVotosNulos' => $totalVotosNulos,
            'totalVotosBlancos' => $totalVotosBlancos,
        ];

        return $response;
    }
}

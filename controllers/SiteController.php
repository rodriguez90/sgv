<?php

namespace app\controllers;

use app\models\Acta;
use app\models\Eleccion;
use app\models\Postulacion;
use app\models\RecintoEleccion;
use Da\User\Filter\AccessRuleFilter;
use Da\User\Form\LoginForm;
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
                        'actions' => ['index', 'votospostulacion', 'report', 'recintoactas'],
                        'allow' => true,
                        'roles' => ['site/index', 'Registrador'],
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
            $this->redirect(Url::toRoute(['voto/index']));
        }

        $postulacionAlcaldia = Postulacion::find()
            ->innerJoin('partido', 'partido.id=postulacion.partido_id')
//            ->where(['role'=>Postulacion::ROL_ALCALDIA])
            ->orderBy([
                'partido.list'=>SORT_ASC,
                'partido.number'=>SORT_ASC,
            ])
            ->all();
        $labels = [];
        $data = [];
        $elecciones = Eleccion::find()->all();
        $eleccion = null;

        if(count($elecciones)) $eleccion = $elecciones[0];

        $totalElectores = $eleccion->totalElectores;
        $totalVotos = $eleccion->totalVotos;
        $totalVotosNulos = $eleccion->totalVotosNulos;
        $totalVotosBlancos = $eleccion->totalVotosBlancos;


        foreach ($postulacionAlcaldia as $p) {
            array_push($labels, $p->name);
            array_push($data, $p->totalVotos);
        }

        $labelsPorcientos = ['Votos', 'Votos Nulos', 'Votos en Blanco', 'Ausentismo'];
        $dataPorcientos = [
            $eleccion->porcientoVotos,
            $eleccion->porcientoVotosNulos,
            $eleccion->porcientoVotosBlancos,
            $eleccion->porcientoAusentismo,
        ];

        return $this->render('index3', [
            'totalElectores' => $totalElectores,
            'totalVotos' => $totalVotos,
            'totalVotosNulos' => $totalVotosNulos,
            'totalVotosBlancos' => $totalVotosBlancos,
            'labels' => $labels,
            'data' => $data,
            'labelsPorcientos' => $labelsPorcientos,
            'dataPorcientos' => $dataPorcientos,
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

            $totalRecintos = $eleccion->getTotalRecintos();
            $totalJunta = $eleccion->getTotalJuntas();
            $totalActas = $eleccion->getTotalActas();
            $totalPostulacion = $eleccion->getTotalPostulacion();
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

        $response['data'] = Postulacion::find()
            ->select([
                'profile.name',
                'SUM(voto.vote) as vote'
            ])
            ->leftJoin('voto', 'voto.postulacion_id = postulacion.id')
            ->innerJoin('profile', 'profile.user_id = postulacion.candidate_id')
            ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id = postulacion.id')
            ->innerJoin('acta', 'acta.id = voto.acta_id')
            ->innerJoin('junta', 'junta.id = acta.junta_id')
            ->andFilterWhere(['postulacion_canton.canton_id'=>$canton])
            ->andFilterWhere(['postulacion.role'=>$dignidad])
            ->andFilterWhere(['junta.recinto_eleccion_id'=>$recinto])
            ->groupBy(['postulacion.id'])
            ->having(['>', 'vote', 0])
            ->asArray()
            ->all();

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
        $dignidad= Yii::$app->request->get('dignidad');

        $response['data'] = Acta::find()
            ->select([
                'recinto_electoral.name',
                'count(acta.id) as cantidad'
            ])
            ->innerJoin('junta', 'junta.id = acta.junta_id')
            ->innerJoin('recinto_eleccion', 'recinto_eleccion.id=junta.recinto_eleccion_id')
            ->innerJoin('recinto_electoral', 'recinto_electoral.id=recinto_eleccion.recinto_id')
            ->innerJoin('zona', 'zona.id=recinto_electoral.zona_id')
            ->innerJoin('parroquia', 'zona.parroquia_id=parroquia.id')
            ->innerJoin('canton', 'canton.id=parroquia.canton_id')
            ->where(['>', 'acta.count_vote', 0])
            ->andFilterWhere(['canton.canton_id'=>$canton])
            ->andFilterWhere(['acta.type'=>$dignidad])
            ->andFilterWhere(['junta.recinto_eleccion_id'=>$recinto])
            ->groupBy(['recinto_eleccion.id'])
            ->asArray()
            ->all();

        return $response;
    }
}

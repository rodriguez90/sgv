<?php

namespace app\controllers;

use app\models\Acta;
use app\models\RecintoEleccion;
use app\models\VotoJuntaForm;
use app\models\Postulacion;
use app\models\Voto;
use Yii;
use app\models\Junta;
use app\models\JuntaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * JuntaController implements the CRUD actions for Junta model.
 */
class JuntaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRuleFilter::class,
                ],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['junta/index'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['junta/create', 'voto/create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['junta/update', 'voto/create'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['junta/delete', 'voto/create'],
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                        'roles' => ['junta/list', 'voto/create'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['junta/view', 'voto/create'],
                    ],
                    [
                        'actions' => ['ajaxcall', 'generar-actas'],
                        'allow' => true,
//                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Junta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JuntaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Junta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Junta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Junta();

        if (Yii::$app->request->isPost &&
            $model->load(Yii::$app->request->post())) {

            $data = Yii::$app->request->post();

            $result = $this->validarVoto($model);
            if(!$result['result']){
                $model->addError('', $result['error']);
            }
            else if($model->save())
            {
                Yii::$app->getSession()->setFlash('success', 'La junta fue creada.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Junta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost &&
            $model->load(Yii::$app->request->post())) {

            $data = Yii::$app->request->post();

            $result = $this->validarVoto($model);
            if(!$result['result']){

                $model->addError('', $result['error']);
            }
            else if($model->save())
            {
                Yii::$app->getSession()->setFlash('success', 'La junta fue creada.');
                return $this->redirect(['view', 'id' => $model->junta->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Junta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Junta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Junta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Junta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La junta no existe');
    }

    public function actionLists($id)
    {

        $results = Junta::find()
            ->where(['recinto_eleccion_id'=>$id])
            ->all();
        if(count($results) > 0)
        {
            foreach ( $results as $model )
            {
                echo "<option value='".$model->id."'>".$model->name."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
    }

    private function validarVoto($junta) {

        $result = [
            'result'=>true,
            'error'=>'',
        ];

        return $result;

        if($junta)
        {
            $recinto = $junta->recintoEleccion;
            if($recinto == null)
            {
                $result['result'] = false;
                $result['error'] = 'Debe seleccionar un recinto.';
                return $result;
            }
            $totalElectores = $recinto->count_elector;
            $ausentismo = $recinto->getAusentismo();
            $totalInvalidVotes = $junta->blank_vote + $junta->null_vote;

            if(!$junta->isNewRecord)
            {
                $oldJunta = Junta::findOne(['id' => $junta->id]);
                $ausentismo += $oldJunta->getTotalVotosBlancos() + $oldJunta->getTotalVotosNulos();
            }

            if ($junta->null_vote > $totalElectores) {
                $result['result'] = false;
                $result['error'] = 'Los votos nulos no pueden ser superior a la cantida de electores del recinto.';
                return $result;
            }

            if ($junta->blank_vote > $totalElectores) {
                $result['result'] = false;
                $result['error'] = 'Los votos en blanco no pueden ser superior a la cantida de electores del recinto.';
                return $result;
            }

            if($junta->null_vote > $ausentismo)
            {
                $result['result'] = false;
                $result['error'] = 'Los votos nulos no pueden ser superior a la cantida de votos admitidos por el recinto.';
                return $result;
            }

            if($junta->blank_vote > $ausentismo)
            {
                $result['result'] = false;
                $result['error'] = 'Los en blanco no pueden ser superior a la cantida de votos admitidos por el recinto.';
                return $result;
            }

            if ($totalInvalidVotes > $totalElectores) {
                $result['result'] = false;
                $result['error'] = 'Los votos nulos y en blanco no pueden ser superior a la cantida de electores del recinto.';
                return $result;
            }

            if($totalInvalidVotes > $ausentismo)
            {
                $result['result'] = false;
                $result['error'] = 'Los votos nulos y en blanco no pueden ser superior a la cantida de votos admitidos por el recinto.';
                return $result;
            }
        }
        else {
            $result['result'] = false;
            $result['error'] = 'Voto Ínvalido.';
        }

        return $result;
    }

    public function actionAjaxcall(){

        $data = Yii::$app->request->get();

        $recintoId= $data['recintoId'];
        $modelId = $data['modelId'];

        $model = new VotoJuntaForm();
        if($modelId == 0) // nueva junta
        {
            $model->junta = new Junta();
        }
        else {
            $model->junta = Junta::findOne(['id'=>$modelId]);
        }

        $model->junta->recinto_eleccion_id = $recintoId;

        $model->junta->loadDefaultValues();
        $model->loadVotes();

        return $this->renderAjax('_form_rol_actas', [
            'model'=>$model,
        ]);

    }

    public function actionGenerarActas(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['msg'] = '';
        $response['data'] = [];
        $response['msg_dev'] = '';

        $canton = Yii::$app->request->get('canton');
        $juntaId = Yii::$app->request->get('junta');
        $recintoId = Yii::$app->request->get('recinto');

        $junta = Junta::findOne(['id'=>$juntaId]);
        $recinto = RecintoEleccion::findOne(['id'=>$recintoId]);

        if($junta == null) // junta nueva
        {
            $junta = new Junta();
            $junta->loadDefaultValues();
        }

        $roles = Postulacion::find()
            ->select('postulacion.role')
            ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id=postulacion.id')
            ->where(['postulacion_canton.canton_id'=> $canton])
            ->groupBy(['postulacion.role'])
            ->asArray()
            ->all();

        $rolesIds = [];
        $postulacionesMapRol = [];

        foreach ($roles as $role) {
            array_push($postulacionesMapRol, []);
            array_push($rolesIds, $role['role']);
        }

        $postulaciones = Postulacion::find()
            ->select([
                'postulacion.id',
                'postulacion.role',
                'profile.name'
            ])
            ->innerJoin('postulacion_canton', 'postulacion_canton.postulacion_id=postulacion.id')
            ->innerJoin('profile', 'profile.user_id=postulacion.candidate_id')
            ->where(['postulacion_canton.canton_id'=> $canton])
            ->where(['in','postulacion.role' , $rolesIds])
            ->asArray()
            ->all();

        foreach ($postulaciones as $postulacion) {
            array_push($postulacionesMapRol[$postulacion['role']], $postulacion);
        }

        $actas = [];

        $userId = Yii::$app->user->id;

        foreach ($roles as $role)
        {
            $roleId = intval($role['role']);
            $acta = new Acta();
            $acta->junta_id = $juntaId;
            $acta->count_elector = 0;
            $acta->count_vote = 0;
            $acta->null_vote = 0;
            $acta->blank_vote = 0;
            $acta->type = $roleId;

            if(!$junta->isNewRecord)
            {
                $oldActa= Acta::find() // se asume q solo se tendra un acta por tipo de rol
                ->andWhere(['junta_id'=>$juntaId])
                    ->andWhere(['type'=>$roleId])
                    ->one();

                if($oldActa)
                {
                    $acta = $oldActa;
                }
            }

            $actaData = [
                'id' => $acta->id,
                'junta_id' => $juntaId,
                'count_elector' =>  $acta->count_elector,
                'count_vote' => $acta->count_vote,
                'null_vote' => $acta->null_vote,
                'blank_vote' => $acta->blank_vote,
                'type' => $roleId,
                'typeName' => Postulacion::ROL_LABEL[$roleId],
                'votos' => []
            ];

            // postulaciones por canton y roles (actas)
            $postulaciones = $postulacionesMapRol[$roleId];

            foreach ($postulaciones as $p) {
                $vote = new Voto();
                $vote->acta_id = $acta->id;
                $vote->vote = 0;
                $vote->postulacion_id = $p['id'];

                if(!$acta->isNewRecord)
                {
                    $oldVote = Voto::find()
                        ->andWhere(['acta_id'=>$acta->id])
                        ->andWhere(['postulacion_id'=>$p['id']])
                        ->one();

                    if($oldVote)
                    {
                        $vote = $oldVote;
                    }
                }

                $voteData = [
                    'id' => $vote->id,
                    'acta_id' => $vote->acta_id,
                    'vote' =>  $vote->vote,
                    'postulacion_id' => $p['id'],
                    'postulacion_name' => $p['name'],
                    'user_id' => $userId,
                    'type' => $p['role'],
                    'typeName' => Postulacion::ROL_LABEL[$p['role']],
                ];

                array_push($actaData['votos'], $voteData);
            }

            array_push($actas, $actaData);
        }

        $response['data'] = $actas;

        return $response;
    }
}

<?php

namespace app\controllers;

use app\models\PostulacionCanton;
use Yii;
use app\models\Postulacion;
use app\models\PostulacionSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;

/**
 * PostulacionController implements the CRUD actions for Postulacion model.
 */
class PostulacionController extends Controller
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
                        'roles' => ['postulacion/index'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['postulacion/create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['postulacion/update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['postulacion/delete'],
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                        'roles' => ['postulacion/list'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['postulacion/view'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Postulacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostulacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Postulacion model.
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
     * Creates a new Postulacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Postulacion();

        if(Yii::$app->request->isPost)
        {
            $cantones = $_POST['Postulacion']['postulacionCantons'];


            if($model->load(Yii::$app->request->post()))
            {
                $postulacion = Postulacion::findOne(['postulacion.candidate_id'=>$model->candidate_id]);
                if($postulacion)
                {
                    $model->addError('error', 'Ya para este candidato existe una postulación');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

                $transaction = Yii::$app->db->beginTransaction();
                if ($model->save()) {

                    PostulacionCanton::deleteAll(['postulacion_id' => $model->id]);

                    foreach ($cantones as $canton) {
                        $postulacionCanton = new PostulacionCanton();
                        $postulacionCanton->postulacion_id = $model->id;
                        $postulacionCanton->canton_id = $canton;
                        if (!$postulacionCanton->save()) {
                            $transaction->rollBack();
                            $model->addError('error', 'Ah ocurrido un error al asociar la postulación a los cantones');
                            return $this->render('create', [
                                'model' => $model,
                            ]);
                        }
                    }

                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else
                    $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Postulacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost)
        {
            $cantones = $_POST['Postulacion']['postulacionCantons'];
            if($model->load(Yii::$app->request->post()))
            {
                $postulacion = Postulacion::findOne(['postulacion.candidate_id'=>$model->candidate_id]);

                if($postulacion->id !== $model->id)
                {
                    $model->addError( 'error','Ya para este candidato existe una postulación');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }

                $transaction = Yii::$app->db->beginTransaction();
                if ($model->save()) {

                    PostulacionCanton::deleteAll(['postulacion_id' => $model->id]);

                    foreach ($cantones as $canton) {
                        $postulacionCanton = new PostulacionCanton();
                        $postulacionCanton->postulacion_id = $model->id;
                        $postulacionCanton->canton_id = $canton;
                        if (!$postulacionCanton->save()) {
                            $transaction->rollBack();
                            $model->addError('error','Ah ocurrido un error al asociar la postulación a los cantones');
                            return $this->render('update', [
                                'model' => $model,
                            ]);
                        }
                    }

                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else
                    $transaction->rollBack();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Postulacion model.
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
     * Finds the Postulacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Postulacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Postulacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLists($id)
    {

        $results = Postulacion::find()
            ->where(['eleccion_id'=>$id])
            ->all();
        if(count($results) > 0)
        {
            foreach ( $results as $model )
            {
                echo "<option value='".$model->id."'>".$model->getName()."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
    }

}

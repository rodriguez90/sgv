<?php

namespace app\controllers;

use Yii;
use app\models\RecintoEleccion;
use app\models\RecintoEleccionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Da\User\Filter\AccessRuleFilter;
use yii\filters\AccessControl;
/**
 * RecintoEleccionController implements the CRUD actions for RecintoEleccion model.
 */
class RecintoEleccionController extends Controller
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
                        'roles' => ['recinto-eleccion/index'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['recinto-eleccion/create'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['recinto-eleccion/update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['recinto-eleccion/delete'],
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                        'roles' => ['recinto-eleccion/list'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['recinto-eleccio/view'],
                    ],
                    [
                        'actions' => ['lists'],
                        'allow' => true,
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all RecintoEleccion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecintoEleccionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RecintoEleccion model.
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
     * Creates a new RecintoEleccion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RecintoEleccion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RecintoEleccion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RecintoEleccion model.
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
     * Finds the RecintoEleccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RecintoEleccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecintoEleccion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionLists($id=null, $cantonId=null)
    {

        $results = RecintoEleccion::find()
            ->select([
                'recinto_eleccion.id',
                'recinto_electoral.name'
            ])
            ->innerJoin('recinto_electoral', 'recinto_electoral.id=recinto_eleccion.recinto_id')
            ->innerJoin('zona', 'zona.id=recinto_electoral.zona_id')
            ->innerJoin('parroquia', 'zona.parroquia_id=parroquia.id')
            ->innerJoin('canton', 'canton.id=parroquia.canton_id')
            ->andFilterWhere(['eleccion_id'=>$id])
            ->andFilterWhere(['canton.id'=>$cantonId])
            ->asArray()
            ->all();

        echo "<option>-</option>";
        if(count($results) > 0)
        {
            foreach ( $results as $model )
            {
                echo "<option value='".$model['id']."'>".$model['name']."</option>";
            }
        }
    }
}

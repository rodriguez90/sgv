<?php

namespace app\controllers;

use Yii;
use app\models\Voto;
use app\models\VotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VotoController implements the CRUD actions for Voto model.
 */
class VotoController extends Controller
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
        ];
    }

    /**
     * Lists all Voto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Voto model.
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
     * Creates a new Voto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Voto();

        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();
            $data['Voto']['user_id'] = Yii::$app->user->id;

            if($model->load($data))
            {
                $result = $this->validarVoto($model);
                if(!$result['result']){

                    $model->addError('', $result['error']);
                }
                else if($model->save())
                    return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Voto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();
            $data['Voto']['user_id'] = Yii::$app->user->id;

            if($model->load($data))
            {
                $result = $this->validarVoto($model, 2);
                if(!$result['result']){

                    $model->addError('', $result['error']);
                }
                else if($model->save())
                    return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Voto model.
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
     * Finds the Voto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Voto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Voto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // mode 1 editar mode 2 crear
    private function validarVoto($voto, $mode=1) {

        $result = [
            'result'=>true,
            'error'=>'',
        ];

        if($voto)
        {
            $count = Voto::find()
                ->andFilterWhere(['postulacion_id'=>$voto->postulacion_id])
                ->andFilterWhere(['junta_id'=>$voto->junta_id])->count('id');

            if ($count > 0) {
                $result['result'] = false;
                $result['error'] = 'Ya para esta junta y esta postulación se registró el voto.';
                return $result;
            }

            $recinto = $voto->getRecintoEleccion();

            if(intval($voto->vote) > $recinto->count_elector)
            {
                $result['result'] = false;
                $result['error'] = 'El voto no puede ser mayor que la cantidad de electores en el recinto.';
                return $result;
            }

            if(intval($voto->vote) > $recinto->getAusentismo())
            {
                $result['result'] = false;
                $result['error'] = 'El voto no puede ser mayor que la cantidad de votos admitidos por el recinto.';
                return $result;
            }
        }
        else {
            $result['result'] = false;
            $result['error'] = 'Voto Ínvalido.';
        }

        return $result;
    }
}

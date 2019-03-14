<?php

namespace app\controllers;

use Yii;
use app\models\Junta;
use app\models\JuntaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        if (Yii::$app->request->isPost) {

            $data = Yii::$app->request->post();

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
     * Updates an existing Junta model.
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

        throw new NotFoundHttpException('The requested page does not exist.');
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

        if($junta)
        {
            $recinto = $junta->recintoEleccion;
            $totalElectores = $recinto->count_elector;
            $ausentismo = $recinto->getAusentismo();
            $totalInvalidVotes = $junta->blank_vote + $junta->null_vote;

            if(!$junta->isNewRecord)
            {
                $oldJunta = Junta::findOne(['id' => $junta->id]);
                $ausentismo += $oldJunta->blank_vote + $oldJunta->null_vote;
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

            if ($totalInvalidVotes > $totalElectores) {
                $result['result'] = false;
                $result['error'] = 'Los votos nulos y en blanco no pueden ser superior a la cantida de electores del recinto.';
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
}

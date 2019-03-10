<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VotoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Votos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">

                <?= Html::a('Nuevo Voto', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <div class="box-body">

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= \kartik\grid\GridView::widget([
                    'moduleId'=>'gridView',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
                            'label' => 'Recinto',
                            'attribute'=>'recintoEleccion',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->recintoEleccion->name, \yii\helpers\Url::toRoute(['recinto-eleccion/view', 'id' =>  $model->recintoEleccion->id]));
                            },
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()->joinWith('recinto')->orderBy(['recinto_electoral.name'=>SORT_ASC])->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Recintos']
                        ],
                        [
                            'label' => 'Junta',
                            'attribute'=>'junta',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->junta->name, \yii\helpers\Url::toRoute(['junta/view', 'id' =>  $model->junta->id]));
                            },
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\Junta::find()->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Junta']
                        ],
                        [
                            'label' => 'Postulación',
                            'attribute'=>'postulacion',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->postulacion->name, \yii\helpers\Url::toRoute(['postulacion/view', 'id' =>  $model->postulacion->id]));
                            },
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\Postulacion::find()->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Postulación']
                        ],
                        'vote',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

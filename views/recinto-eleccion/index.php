<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecintoEleccionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recinto en Elección';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">

                <p>
                    <?= Html::a('Nueva Recinto Eleccion', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>

            <div class="box-body">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


                <?= \kartik\grid\GridView::widget([
                    'moduleId'=>'gridView',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'striped' => true,
                    'hover' => true,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
                            'attribute' => 'eleccion',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->eleccion->name, \yii\helpers\Url::toRoute(['eleccion/view', 'id' =>  $model->eleccion->id]));
                            },
                            'label' => 'Elección',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\Eleccion::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Elección']
                        ],
                        [
                            'attribute' => 'parroquia',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->parroquia->name, \yii\helpers\Url::toRoute(['parroquia/view', 'id' =>  $model->parroquia->id]));
                            },
                            'label' => 'Parroquia',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\Parroquia::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Parroquia']
                        ],
                        [
                            'attribute'=> 'zona',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->zona->name, \yii\helpers\Url::toRoute(['zona/view', 'id' =>  $model->zona->id]));
                            },
                            'label' => 'Zona',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\Zona::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Zona']
                        ],
						[
                            'attribute'=> 'recinto',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->recinto->name, \yii\helpers\Url::toRoute(['recinto-electoral/view', 'id' =>  $model->recinto->id]));
                            },
                            'label' => 'Nombre',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()->joinWith('recinto')->orderBy(['recinto_electoral.name'=>SORT_ASC])->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Recintos']
						],
//                        [
////							'attribute'=> 'coordinator_jr_man',
////							'value' => function($model) {
////								return $model->coordinatorJrMan->getFullName();
////							}
////						],
////                        [
////							'attribute'=> 'coordinator_jr_woman',
////							'value' => function($model) {
////								return $model->coordinatorJrWoman->getFullName();
////							}
////						],
                        'jr_woman',
                        'jr_man',
                        'count_elector',
                        'totalJuntas',
                        'totalVotos',
                        'porcientoAusentismo',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


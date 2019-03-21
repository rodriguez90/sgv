<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\JuntaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Juntas Receptoras de Votos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Nueva JRV', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

            </div>
            <div class="box-body">

                <?= \kartik\grid\GridView::widget([
                    'moduleId'=>'gridView',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'striped' => true,
                    'hover' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'canton',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->getCanton()->name, \yii\helpers\Url::toRoute(['canton/view', 'id' =>  $model->getCanton()->id]));
                            },
                            'label' => 'Cantón',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filter' => \yii\helpers\ArrayHelper::map(\app\models\Canton::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true]
                            ],
                            'filterInputOptions' => ['placeholder' => 'Canton']
                        ],
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
                        'name',
                        [
                            'attribute'=>'type',
                            'value' => function ($model) {
                                return \app\models\Junta::JUNTA_LABEL[$model->type];
                            },
                            'filter' => \app\models\Junta::JUNTA_LABEL
                        ],
                        'null_vote',
                        'blank_vote',
                        'totalVotos',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

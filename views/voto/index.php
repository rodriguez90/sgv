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
                            'value' => 'recintoEleccion.name',
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
                            'value' => 'junta.name',
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
                            'value' => 'postulacion.name',
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

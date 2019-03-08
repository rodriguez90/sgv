<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\JuntaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Juntas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Nueva Junta', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

            </div>
            <div class="box-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Recinto',
                            'attribute'=>'recintoEleccion',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->recintoEleccion->name, \yii\helpers\Url::toRoute(['recinto-eleccion/view', 'id' =>  $model->recintoEleccion->id]));
                            },
                        ],
                        'name',
                        [
                            'attribute'=>'type',
                            'value' => function ($model) {
                                return \app\models\Junta::JUNTA_LABEL[$model->type];
                            },
                            'filter' => \app\models\Junta::JUNTA_LABEL
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

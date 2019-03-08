<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ZonaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zonas';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Nueva Zona', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
                            'attribute' => 'province',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->province->name, \yii\helpers\Url::toRoute(['province/view', 'id' =>  $model->province->id]));
                            },
                            'label' => 'Provincia'
                        ],
                        [
                            'attribute' => 'canton',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->canton->name, \yii\helpers\Url::toRoute(['canton/view', 'id' =>  $model->canton->id]));
                            },
                            'label' => 'Cantón'
                        ],
                        [
                            'attribute' => 'parroquia',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->parroquia->name, \yii\helpers\Url::toRoute(['parroquia/view', 'id' =>  $model->parroquia->id]));
                            },
                            'label' => 'Parroquia'
                        ],
                        'name',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

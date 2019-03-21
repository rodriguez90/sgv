<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ParroquiaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parroquias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Nueva Parroquia', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

            </div>
            <div class="box-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
                            'label' => 'Provincia',
                            'attribute'=>'province',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->province->name, \yii\helpers\Url::toRoute(['province/view', 'id' =>  $model->province->id]));
                            },
                        ],
                        [
                            'attribute'=>'canton',
                            'label'=>'Cantón',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->canton->name, \yii\helpers\Url::toRoute(['canton/view', 'id' =>  $model->canton->id]));
                            },
                        ],
                        'name',
                        [
                            'attribute'=>'type',
                            'value' => function ($model) {
                                return \app\models\Parroquia::PARROQUIA_LABEL[$model->type];
                            },
                            'filter' => \app\models\Parroquia::PARROQUIA_LABEL
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

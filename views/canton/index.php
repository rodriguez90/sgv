<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CantonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cantones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <p>
                    <?= Html::a('Nuevo Cantón', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <div class="box-body">

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        [
                            'attribute'=>'province_id',
                            'value'=>'province.name',
                        ],
                        'name',
                        [
                            'attribute'=>'type',
                            'value' => function ($model) {
                                    return \app\models\Canton::CANTON_LABEL[$model->type];
                            }
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

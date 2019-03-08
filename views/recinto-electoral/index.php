<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecintoElectoralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recintos Electorales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recinto-electoral-index">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <p>
                        <?= Html::a('Nueva Recinto Electoral', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>

                </div>
                <div class="box-body">
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            [
								'attribute'=> 'zona',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return  Html::a($model->zona->name, \yii\helpers\Url::toRoute(['zona/view', 'id' =>  $model->zona->id]));
                                },
								'label' => 'Zona'
							],
                            'name',
                            'address',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>

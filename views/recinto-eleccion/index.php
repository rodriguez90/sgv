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


                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
                            'attribute' => 'eleccion.name',
                            'label' => 'Elección',
                        ],
                        [
                            'attribute' => 'parroquia.name',
                            'label' => 'Parroquia',
                        ],
                        [
                            'attribute' => 'zona.name',
                            'label' => 'Zona',
                        ],
						[
								'attribute'=> 'recinto.name',
								'label' => 'Nombre'
						],
                        [
							'attribute'=> 'coordinator_jr_man',							
							'value' => function($model) {
								return $model->coordinatorJrMan->getFullName();
							}
						],
                        [
							'attribute'=> 'coordinator_jr_woman',							
							'value' => function($model) {
								return $model->coordinatorJrWoman->getFullName();
							}
						],
                        'jr_woman',
                        'jr_man',
                        'totalJuntas',
                        'count_elector',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PostulacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Postulacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Nueva Postulacion', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
							'attribute' => 'partido',
							'value' => 'partido.name',
							'label' => 'Partido',
						],
						[
							'attribute' => 'candidate',
							'value' => 'candidate.name',
							'label' => 'Candidato',
						],
						[
							'attribute' => 'eleccion',
							'value' => 'eleccion.name',
							'label' => 'Elección',
						],
						[
							'attribute' => 'role',							
							'value' => function($model)
							{
								return app\models\Postulacion::ROL_LABEL[$model->role];
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
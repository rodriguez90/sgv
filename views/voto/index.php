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

                    <?= Html::a('Nueva Voto', ['create'], ['class' => 'btn btn-success']) ?>
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
                            'label' => 'Recinto',
                            'attribute'=>'recintoEleccion',
                            'value' => 'recintoEleccion.name'
                        ],
                        [
                            'label' => 'Postulación',
                            'attribute'=>'postulacion',
                            'value' => 'postulacion.name'
                        ],
                        [
                            'label' => 'Junta',
                            'attribute'=>'junta',
                            'value' => 'junta.name'
                        ],
                        'vote',
                        'null_vote',
                        'blank_vote',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

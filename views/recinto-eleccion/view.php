<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */

$this->title = $model->recinto->name;
$this->params['breadcrumbs'][] = ['label' => 'Recinto Eleccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">

                <p>
                    <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Está seguro que desea eliminar el elemento?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
            <div class="box-body">
                <div class="col col-md-6">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'eleccion.name',
                                'label' => 'Elección'
                            ],
                            [
                                'attribute' => 'recinto.name',
                                'label' => 'Recinto'
                            ],
                            [
                                'attribute' => 'recinto.address',
                                'label' => 'Dirección'
                            ],
                            [
                                'label' => 'Coordinador JR Hombres',
                                'value' => $model->coordinatorJrMan->getFullName()
                            ],
                            [
                                'label' => 'Coordinador JR Mujeres',
                                'value' => $model->coordinatorJrMan->getFullName()
                            ],

                            'jr_woman',
                            'jr_man',
                            'count_elector',
                            'totalVotos',
                            [
                                'attribute'=>'totalVotosNulos',
                                'label' => 'Votos Nulos'
                            ],
                             [
                                'attribute'=>'totalVotosBlancos',
                                'label' => 'Votos en Blanco'
                            ],
                            [
//                                'attribute'=>'ausentismo',
                                'value'=> $model->getAusentismo(). '( ' . $model->getPorcientoAusentismo() . '% )',
                                'label' => 'Ausentismo'
                            ]
                        ],
                        'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoElectoral */

$this->title = 'Recinto: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recintos Electorales', 'url' => ['index']];
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
                <div class="box-body">
                    <div class="col col-md-6">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'id',
                                [
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return  Html::a($model->zona->canton->province->name, \yii\helpers\Url::toRoute(['province/view', 'id' =>  $model->zona->canton->province->id]));
                                    },
                                    'label' => 'Provincia'
                                ],
                                [
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return  Html::a($model->zona->canton->name, \yii\helpers\Url::toRoute(['canton/view', 'id' =>  $model->zona->canton->id]));
                                    },
                                    'label' => 'Cantón'
                                ],
                                [
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return  Html::a($model->zona->parroquia->name, \yii\helpers\Url::toRoute(['parroquia/view', 'id' =>  $model->zona->parroquia->id]));
                                    },
                                    'label' => 'Parroquía'
                                ],
                                [
                                    'attribute' => 'zona.name',
                                    'label' => 'Zona'
                                ],
                                'name',
                                'address',
                            ],
                            'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

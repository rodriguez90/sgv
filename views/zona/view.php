<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Zona */

$this->title = 'Zona: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zonas', 'url' => ['index']];
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

                <div class="col col-md-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            [
                                'attribute'=>'province.name',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return  Html::a($model->province->name, \yii\helpers\Url::toRoute(['province/view', 'id' =>  $model->province->id]));
                                },
                                'label' => 'Provincia'
                            ],
                            [
                                'attribute'=>'canton.name',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return  Html::a($model->canton->name, \yii\helpers\Url::toRoute(['canton/view', 'id' =>  $model->canton->id]));
                                },
                                'label' => 'Cantón'
                            ],
                            [
                                'attribute'=>'parroquia.name',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return  Html::a($model->parroquia->name, \yii\helpers\Url::toRoute(['parroquia/view', 'id' =>  $model->parroquia->id]));
                                },
                                'label' => 'Parroquia'
                            ],
                            'juntasMujeres',
                            'juntasHombres',
                            'totalJuntas',
                            'totalElectores',
                            'totalRecintos',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

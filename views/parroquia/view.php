<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Parroquia */

$this->title = 'Parroquia: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Parroquias', 'url' => ['index']];
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
                            'name',
                            [
                                'label' => 'Provincia',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return  Html::a($model->province->name, \yii\helpers\Url::toRoute(['province/view', 'id' =>  $model->province->id]));
                                },
                            ],
                            [
                                'attribute'=>'canton_id',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return  Html::a($model->canton->name, \yii\helpers\Url::toRoute(['canton/view', 'id' =>  $model->canton->id]));
                                },
                            ],
                            'juntasMujeres',
                            'juntasHombres',
                            'totalJuntas',
                            'totalElectores',
                            'totalRecintos',
                        ],
                        'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>


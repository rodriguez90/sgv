<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Junta */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Juntas', 'url' => ['index']];
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
                            'confirm' => 'Está seguro que desea eliminar la junta?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'recintoEleccion.name',
                        'name',
                        [
                            'attribute'=>'type',
                            'value' => \app\models\Junta::JUNTA_LABEL[$model->type]
                        ],
                    ],
                    'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                ]) ?>

            </div>
        </div>
    </div>
</div>


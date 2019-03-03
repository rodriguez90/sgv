<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Postulacion */

$this->title = $model->candidate->name . '-' . app\models\Postulacion::ROL_LABEL[$model->role];
$this->params['breadcrumbs'][] = ['label' => 'Postulacions', 'url' => ['index']];
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
                                'attribute' => 'partido.name',
                                'label' => 'Partido'
                            ],
                            [
                                'attribute' => 'candidate_id',
                                'value' => $model->candidate->name
                            ],
                            [
                                'attribute' => 'eleccion.name',
                                'label' => 'Elección'
                            ],
							[
								'attribute' => 'role',							
								'value' => app\models\Postulacion::ROL_LABEL[$model->role]
							],
                        ],
                        'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],

                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
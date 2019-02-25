<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Voto */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Votos', 'url' => ['index']];
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
                            'recinto_eleccion_id',
                            'postulacion_id',
                            'v_jr_man',
                            'v_jr_woman',
                            'vn_jr_man',
                            'vn_jr_woman',
                            'vb_jr_man',
                            'vb_jr_woman',
                        ],
                        'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

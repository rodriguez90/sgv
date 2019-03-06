<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Zona */

$this->title = $model->name;
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
                                'attribute'=>'parroquia.canton.province.name',
                                'label' => 'Provincia'
                            ],
                            [
                                'attribute'=>'parroquia.canton.name',
                                'label' => 'Cantón'
                            ],
                            [
                                'attribute'=>'parroquia.name',
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

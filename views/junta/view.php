<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Junta */

$this->title = 'Junta Receptora del Voto: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Junta Receptora del Voto', 'url' => ['index']];
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
                            'confirm' => 'Está seguro que desea eliminar la JRV?',
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
                        [
                            'label' => 'Recinto',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  Html::a($model->recintoEleccion->name, \yii\helpers\Url::toRoute(['recinto-eleccion/view', 'id' =>  $model->recintoEleccion->id]));
                            },
                        ],
                        'name',
                        [
                            'attribute'=>'type',
                            'value' => \app\models\Junta::JUNTA_LABEL[$model->type]
                        ],
//                        'count_elector',
//                        'count_vote',
//                        'null_vote',
//                        'blank_vote',
                    ],
                    'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                ]) ?>

                <h4>Acta de Votos</h4>

                <div class="row">

                    <div class="col-lg-3 col-md-3 col-xs-3">
                        <?= Html::label('Cantidad de Electores: '. $model->count_elector) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-3">
                        <?= Html::label('Cantidad de Votos: '. $model->count_vote) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-3">
                        <?= Html::label('Cantidad de Votos Nulos: '. $model->null_vote) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-3">
                        <?= Html::label('Cantidad de Votos en Blanco: '. $model->blank_vote) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        // $voto table
                        $voto = new \app\models\Voto();
                        $voto->loadDefaultValues();
                        echo '<table id="junta-voto" class="table table-condensed table-bordered">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>' . $voto->getAttributeLabel('postulacion_id') . '</th>';
                        echo '<th>' . $voto->getAttributeLabel('vote') . '</th>';
                        echo '<td>&nbsp;</td>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        // existing votos fields
                        foreach ($model->votos as $key => $_voto) {
                            echo '<tr>';
                            echo '<td>';
                            echo $_voto->postulacion->name;
                            echo '</td>';
                            echo '<td>';
                            echo $_voto->vote;
                            echo '</td>';
                            echo '</tr>';
                        }

                        echo '</tr>';
                        echo '</tbody>';
                        echo  '<tfooter>';
                        echo '<tr>';
                        echo '<td>Total Votos</td>';
                        echo '<td>';
                        echo Html::label($model->totalVotosValidos, null, ['id'=>'totalVotos']);
                        echo '</td>';
                        echo '</tr>';
                        echo  '</tfooter>';
                        echo '</table>';
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


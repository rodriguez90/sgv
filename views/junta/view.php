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
                        'totalVotosNulos',
                        'totalVotosBlancos',
                        'totalVotosValidos',
                        'totalVotos',
                    ],
                    'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                ]) ?>

                <h4>Acta de Votos</h4>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <?php
                                    $tmp = 0;
                                    echo '<li class="pull-left header"><i class="fa fa-th"></i> Actas de Votos</li>';
                                    foreach ($model->actas as $acta) {
                                        $rolName = \app\models\Postulacion::ROL_LABEL[$acta->type];

                                        $class = $tmp === 0 ? 'class="active"' : '';
                                        $tmp += 1;
                                        echo '<li ' . $class . '><a href="#tab_' . $acta->type . '" data-toggle="tab">' . $rolName .'</a></li>';
                                    }
                                ?>
                            </ul>
                            <div class="tab-content">
                                <?php
                                $tmp = 0;
                                foreach ($model->actas as $acta)
                                {
                                    $class = $tmp === 0 ? ' active' : '';
                                    $tmp += 1;

                                    $rolId = $acta->type;

                                    echo '<div class="tab-pane' . $class . '" id="tab_' . $rolId. '">';

                                    echo '<div class="row">';
                                        echo '<div class="col-lg-3 col-md-3 col-xs-3">';
                                         echo Html::label('Cantidad de Electores: ' . $acta->count_elector);
                                        echo '</div>';

                                    echo '<div class="col-lg-3 col-md-3 col-xs-3">';
                                    echo Html::label('Cantidad de Votantes: ' . $acta->count_vote);
                                    echo '</div>';

                                        echo '<div class="col-lg-3 col-md-3 col-xs-3">';
                                            echo Html::label('Votos en Blanco: ' . $acta->blank_vote);
                                        echo '</div>';

                                        echo '<div class="col-lg-3 col-md-3 col-xs-3">';
                                            echo Html::label('Votos Nulos: ' . $acta->null_vote);
                                        echo '</div>';
                                    echo '</div>';


                                    echo '<div class="row">';

                                        echo '<div class="col-lg-12">';

                                            // $voto table
                                            $voto = new \app\models\Voto();
                                            $voto->loadDefaultValues();
                                            echo '<table id="junta-voto-' . $rol['id'] . '" class="table table-condensed table-bordered">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th>' . $voto->getAttributeLabel('postulacion_id') . '</th>';
                                            echo '<th>' . $voto->getAttributeLabel('vote') . '</th>';
                                            echo '<td>&nbsp;</td>';
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';

                                            // existing votos fields
                                            $votos = $acta->votos;
                                            foreach ($votos as $key => $_voto) {
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
                                            echo Html::label($acta->totalVotosValidos, null);
                                            echo '</td>';
                                            echo '</tr>';
                                            echo  '</tfooter>';
                                            echo '</table>';

                                            echo  '</div>';
                                        echo  '</div>';
                                    echo  '</div>';
                                }
                                ?>
                            </div>
                        </div> <!-- end nav tabs-->
                    </div>  <!-- end col tabs-->
                </div> <!-- end row tabs-->
            </div> <!-- end body box-->
        </div> <!-- end box-->
    </div> <!-- end col-->
</div><!-- end row-->
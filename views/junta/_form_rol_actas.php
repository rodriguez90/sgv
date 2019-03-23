<?php

use yii\helpers\Html;
use app\models\Voto;

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VotoJuntaForm */
?>
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

    foreach ($model->actas as $acta) {
        $class = $tmp === 0 ? ' active' : '';
        $tmp += 1;
        $rolId = $acta->type;
        $actaKey = $acta->isNewRecord ? $acta->type : $acta->id;
        $actaName = 'Actas_' . $actaKey;

        echo '<div class="tab-pane' . $class . '" id="tab_' . $rolId . '">';

        echo '<div class="row">';

            echo Html::textInput(
                "Actas[$actaKey][type]",
                $acta->type,
                [
                    'id' => $actaName . "_type",
                    'data-acta' => $actaKey,
                    'require' => true,
                    'type'=> 'number',
                    'style'=>"display: none;",
                ]);

            echo '<div class="col-lg-3">';
                echo '<div class="form-group">';
                    echo Html::label('Cantidad de Electores', "Actas[$actaKey][count_elector]");
                    echo Html::textInput(
                        "Actas[$actaKey][count_elector]",
                        $acta->count_elector,
                        [
                            'id' => $actaName . "_count_elector",
                            'data-acta' => $actaKey,
                            'require' => true,
                            'type'=> 'number',
                            'min' => 0
                        ]);
                echo '</div>';
            echo '</div>';

            echo '<div class="col-lg-3">';
                echo '<div class="form-group">';
                    echo Html::label('Cantidad de Votantes', "Actas[$actaKey][count_vote]");
                    echo Html::textInput(
                        "Actas[$actaKey][count_vote]",
                        $acta->count_vote,
                        [
                            'id' => $actaName . "_count_vote",
                            'data-acta' => $actaKey,
                            'require' => true,
                            'type'=> 'number',
                            'min' => 0
                        ]);

                echo '</div>';
            echo '</div>';

            echo '<div class="col-lg-3">';
                echo '<div class="form-group">';
                    echo Html::label('Votos Nulos', "Actas[$actaKey][null_vote]");
                    echo Html::textInput(
                        "Actas[$actaKey][null_vote]",
                        $acta->null_vote,
                        [
                            'id' => $actaName . "_null_vote",
                            'data-acta' => $actaKey,
                            'require' => true,
                            'type'=> 'number',
                            'min' => 0
                        ]);
                echo '</div>';
            echo '</div>';

            echo '<div class="col-lg-3">';
                echo '<div class="form-group">';
                    echo Html::label('Votos en Blanco', "Actas[$actaKey][blank_vote]");
                    echo Html::textInput(
                        "Actas[$actaKey][blank_vote]",
                        $acta->blank_vote,
                        [
                            'id' => $actaName . "_blank_vote",
                            'data-acta' => $actaKey,
                            'require' => true,
                            'type'=> 'number',
                            'min' => 0
                        ]);

                echo '</div>';
            echo '</div>';
        echo '</div>';

        echo '<div class="row">';

        echo '<div class="col-lg-12">';

        // $voto table
        $voto = new \app\models\Voto();
        $voto->loadDefaultValues();
        echo '<table id="junta-voto-' . $rolId . '" class="table table-condensed table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>' . $voto->getAttributeLabel('postulacion_id') . '</th>';
        echo '<th>' . $voto->getAttributeLabel('vote') . '</th>';
        echo '<td>&nbsp;</td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // existing votos fields
        $votos = $model->getVotesByRole($rolId);
        foreach ($votos as $key => $voto) {
            $key = $voto->isNewRecord ? $voto->postulacion->id : $voto->id;
            $voteKey = 'Votes_' . $key;

            echo '<tr>';

            echo '<td>';
            echo Html::label($voto->postulacion->name);
            echo '</td>';
            echo '<td style="display: none;">';
            echo Html::textInput(
                "Votes[$key][role]",
                $acta->type,
                [
                    'id' => $voteKey . "_role",
                    'require' => true,
                ]);
            echo '</td>';
            echo '<td style="display: none;">';
            echo Html::textInput(
                "Votes[$key][acta_id]",
                $actaKey,
                [
                    'id' => $voteKey . "_acta_id",
                    'require' => true,
                ]);
            echo '</td>';
            echo '<td style="display: none;">';
            echo Html::textInput(
                "Votes[$key][postulacion_id]",
                $voto->postulacion->id,
                [
                    'id' => $voteKey . "_postulacion_id",
                    'require' => true,
                ]);
            echo '</td>';

            echo '<td style="display: none;">';
            echo Html::textInput(
                "Votes[$key][user_id]",
                Yii::$app->user->id,
                [
                    'id' => $voteKey . "_user_id",
                    'require' => true,
                ]);
            echo '</td>';

            echo '<td>';
            echo Html::textInput(
                "Votes[$key][vote]",
                $voto->vote,
                [
                    'id' => $voteKey . "_vote",
                    'require' => true,
                    'type' => 'number',
                    'class'=>'form-control',
                    'data-acta' => $actaKey,
                    'min' => 0
                ]);
            echo '</td>';
            echo '</tr>';
        }

        echo '</tr>';
        echo '</tbody>';
        echo  '<tfooter>';
        echo '<tr>';
        echo '<td>Total Votos</td>';
        echo '<td>';
        echo Html::label($acta->totalVotosValidos, null, ['id'=>'totalVotos_'. $rolId]);
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


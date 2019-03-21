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
    foreach (\app\models\Postulacion::ROL_CHOICES as $rol)
    {
        $class = $tmp === 0 ? 'class="active"' : '';
        echo '<li><a ' . $class . ' href="#tab_' . $rol['id']. '" data-toggle="tab">' . $rol['name'] .'</a></li>';
        $tmp += 1;
    }
    ?>
</ul>
<div class="tab-content">
    <?php
    $tmp = 0;
    foreach (\app\models\Postulacion::ROL_CHOICES as $rol)
    {
        $class = $tmp === 0 ? ' active' : '';

        echo '<div class="tab-pane' . $class . '" id="tab_' . $rol['id']. '">';

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
        $votos = $model->getVotesByRole($rol['id']);
        foreach ($votos as $key => $voto) {
            $key = $voto->isNewRecord ? $voto->postulacion->id : $voto->id;
            $voteKey = 'Votes_' . $key;

            echo '<tr>';

            echo '<td>';
            echo Html::label($voto->postulacion->name);
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
                    'class'=>'form-control'
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
        echo Html::label($model->junta->getTotalVotosValidosByRole($rol['id']), null, ['id'=>'totalVotos_'.$rol['id']]);
        echo '</td>';
        echo '</tr>';
        echo  '</tfooter>';
        echo '</table>';

        $tmp += 1;

        echo  '</div>';
    }
    ?>
</div>


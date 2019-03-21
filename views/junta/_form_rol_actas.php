<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Voto */
/* @var $model app\models\VotoJuntaForm */
?>

<?php

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
foreach ($votos as $key => $_voto) {
    echo '<tr>';
    echo $this->render('_form_junta_voto', [
        'key' => $_voto->isNewRecord ? $_voto->postulacion->id : $_voto->id,
        'form' => $form,
        'voto' => $_voto,
    ]);
    echo '</tr>';
}

echo '</tr>';
echo '</tbody>';
echo  '<tfooter>';
echo '<tr>';
echo '<td>Total Votos</td>';
echo '<td>';
echo Html::label($totalVotos, null, ['id'=>'totalVotos_'.$rolId]);
echo '</td>';
echo '</tr>';
echo  '</tfooter>';
echo '</table>';

?>
<?php
use app\models\Voto;
use yii\helpers\Html;
?>
<td>
    <?= Html::label($voto->postulacion->name) ?>
</td>
<td>
    <?= $form->field($voto, 'vote')->textInput([
        'id' => "Votes_{$key}_vote",
        'name' => "Votes[$key][vote]",
        'require' => true,
        'onchange'=>"validationVote(this, this.value)"
    ])->label(false) ?>
</td>
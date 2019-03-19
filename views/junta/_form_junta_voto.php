<?php
use app\models\Voto;
use yii\helpers\Html;
?>
<td>
    <?= Html::label($voto->postulacion->name) ?>

</td>
<td style="display: none;">
    <?= $form->field($voto, 'postulacion_id')->textInput([
        'id' => "Votes_{$key}_postulacion_id",
        'name' => "Votes[$key][postulacion_id]",
        'require' => true,
        'value'=>$voto->postulacion->id
    ])->label(false) ?>
</td>

<td style="display: none;">
    <?= $form->field($voto, 'user_id')->textInput([
        'id' => "Votes_{$key}_user_id",
        'name' => "Votes[$key][user_id]",
        'require' => true,
        'value'=>Yii::$app->user->id
    ])->label(false) ?>
</td>

<td>
    <?= $form->field($voto, 'vote')->textInput([
        'id' => "Votes_{$key}_vote",
        'name' => "Votes[$key][vote]",
        'require' => true,
        'onchange'=>"validationVote(this, this.value)"
    ])->label(false) ?>
</td>
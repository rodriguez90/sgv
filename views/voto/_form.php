<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Voto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="voto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recinto_eleccion_id')->textInput() ?>

    <?= $form->field($model, 'postulacion_id')->textInput() ?>

    <?= $form->field($model, 'v_jr_man')->textInput() ?>

    <?= $form->field($model, 'v_jr_woman')->textInput() ?>

    <?= $form->field($model, 'vn_jr_man')->textInput() ?>

    <?= $form->field($model, 'vn_jr_woman')->textInput() ?>

    <?= $form->field($model, 'vb_jr_man')->textInput() ?>

    <?= $form->field($model, 'vb_jr_woman')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

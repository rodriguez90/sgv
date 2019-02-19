<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Postulacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="postulacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'partido_id')->textInput() ?>

    <?= $form->field($model, 'candidate_id')->textInput() ?>

    <?= $form->field($model, 'eleccion_id')->textInput() ?>

    <?= $form->field($model, 'role')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

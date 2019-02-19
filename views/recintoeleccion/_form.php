<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recinto-eleccion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'recinto_id')->textInput() ?>

    <?= $form->field($model, 'coordinator_jr_man')->textInput() ?>

    <?= $form->field($model, 'coordinator_jr_woman')->textInput() ?>

    <?= $form->field($model, 'eleccion_id')->textInput() ?>

    <?= $form->field($model, 'jr_woman')->textInput() ?>

    <?= $form->field($model, 'jr_man')->textInput() ?>

    <?= $form->field($model, 'count_elector')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recinto-eleccion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'recinto_id') ?>

    <?= $form->field($model, 'coordinator_jr_man') ?>

    <?= $form->field($model, 'coordinator_jr_woman') ?>

    <?= $form->field($model, 'eleccion_id') ?>

    <?php // echo $form->field($model, 'jr_woman') ?>

    <?php // echo $form->field($model, 'jr_man') ?>

    <?php // echo $form->field($model, 'count_elector') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

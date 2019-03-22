<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ActaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'junta_id') ?>

    <?= $form->field($model, 'count_elector') ?>

    <?= $form->field($model, 'count_vote') ?>

    <?= $form->field($model, 'null_vote') ?>

    <?php // echo $form->field($model, 'blank_vote') ?>

    <?php // echo $form->field($model, 'type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VotoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="voto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'recinto_eleccion_id') ?>

    <?= $form->field($model, 'postulacion_id') ?>

    <?= $form->field($model, 'v_jr_man') ?>

    <?= $form->field($model, 'v_jr_woman') ?>

    <?php // echo $form->field($model, 'vn_jr_man') ?>

    <?php // echo $form->field($model, 'vn_jr_woman') ?>

    <?php // echo $form->field($model, 'vb_jr_man') ?>

    <?php // echo $form->field($model, 'vb_jr_woman') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

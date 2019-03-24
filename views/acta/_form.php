<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Acta */
/* @var $form yii\widgets\ActiveForm */
?>

<?php if ($model->hasErrors()) {
    \Yii::$app->getSession()->setFlash('error', $model->getErrorSummary(true));
}
?>

<div class="acta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'junta_id')->textInput() ?>

    <?= $form->field($model, 'count_elector')->textInput() ?>

    <?= $form->field($model, 'count_vote')->textInput() ?>

    <?= $form->field($model, 'null_vote')->textInput() ?>

    <?= $form->field($model, 'blank_vote')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

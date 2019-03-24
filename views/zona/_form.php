<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Zona */
/* @var $form yii\widgets\ActiveForm */
?>

<?php if ($model->hasErrors()) {
    \Yii::$app->getSession()->setFlash('error', $model->getErrorSummary(true));
}
?>

<!-- begin row -->
<div class="row">
    <!-- begin col-lg-12 -->
    <div class="col-lg-12">
        <!-- begin box -->
        <div class="box box-success">
            <div class="box-body">
                <div class="col-lg-6 col-md-6 col-xs-6">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="form-group">
                        <label class="control-label" for="province">Provincia</label>
                        <?= \yii\helpers\BaseHtml::dropDownList(
                            'province',
                    $model->isNewRecord ? null: $model->parroquia->canton->province_id,
                            \yii\helpers\ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                            [
                                'prompt'=>'Seleccione la Provincia',
                                'onchange' =>'
                                    $.get("../canton/lists?id='.'"+$(this).val(),function(data){
                                    $( "select#canton" ).html(data);
                                    });',
                                'class' =>'form-control',
                            ]);?>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="province">Cantón</label>
                        <?= \yii\helpers\BaseHtml::dropDownList(
                            'canton',
                        $model->isNewRecord ? null: $model->parroquia->canton_id,
                            \yii\helpers\ArrayHelper::map(\app\models\Canton::find()->all(),'id','name'),
                            [
                                'prompt'=>'Seleccione la Provincia',
                                'onchange' =>'
                                    $.get("../parroquia/lists?id='.'"+$(this).val(),function(data){
                                    $( "select#parroquia-parroquia_id" ).html(data);
                                    });',
                                'class' =>'form-control',
                            ]);?>
                    </div>

                    <?= $form->field($model, 'parroquia_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Parroquia::find()->all(),'id','name'),
                        [
                            'prompt'=>'Seleccione el Parroquia',
                        ]);?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

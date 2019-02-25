<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Parroquia */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-12">
        <!-- begin box -->
        <div class="box box-success">
            <div class="box-body">
                <div class="col-lg-6 col-md-6 col-xs-6">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="form-group">
                        <label class="control-label" for="province">Provincia</label>
                        <?= \yii\helpers\BaseHtml::dropDownList(
                                'province',
                            $model->isNewRecord ? null: $model->canton->province_id,
                            \yii\helpers\ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                            [
                                'prompt'=>'Seleccione la Provincia',
                                'onchange' =>'
                                    $.get("../canton/lists?id='.'"+$(this).val(),function(data){
                                    $( "select#parroquia-canton_id" ).html(data);
                                    });',
                                'class' =>'form-control',
                            ]);?>
                    </div>

                    <?= $form->field($model, 'canton_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Canton::find()->all(),'id','name'),
                        [
                            'prompt'=>'Seleccione el Cantón',
                        ]);?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                        <?= Html::button('Cancelar',['class'=>'btn btn-default','onclick'=>'window.history.go(-1)']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Persona */
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

                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'gender')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Persona::GENDER_CHOICES,'id','name'),
                        ['prompt'=>'Seleccione el Género',
                        ]);?>

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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Eleccion */
/* @var $form yii\widgets\ActiveForm */

$initDate = $model->isNewRecord ? date('d-m-Y') : date('d-m-Y', strtotime($model->delivery_date));
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

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'delivery_date')->widget(\kartik\widgets\DatePicker::className(),[
                        // inline too, not bad
                        'options' => ['placeholder'=>'Seleccione la fecha'],
                        'type' => \kartik\widgets\DatePicker::TYPE_COMPONENT_APPEND,
                        'value'=> $initDate,
                        'pickerIcon' => '<i class="fa fa-calendar text-primary"></i>',
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy'
                        ]
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
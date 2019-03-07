<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Voto */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-12">
        <!-- begin box -->
        <div class="box box-success">
            <div class="box-body">
                <div class="col-lg-6 col-md-6 col-xs-6 col-lg-offset-3">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'junta_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Junta::find()->asArray()->all(),'id','name'),
                                    ['prompt'=>'Seleccione la Junta',
                                ]);?>

                            <?= $form->field($model, 'postulacion_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Postulacion::find()->all(),'id','name'),
                                ['prompt'=>'Seleccione la Postulación',
                                ]);?>

                            <?= $form->field($model, 'voto')->textInput() ?>
                            <?= $form->field($model, 'null_voto')->textInput() ?>
                            <?= $form->field($model, 'blank_voto')->textInput() ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                            <?= Html::button('Cancelar',['class'=>'btn btn-default','onclick'=>'window.history.go(-1)']) ?>
                        </div>
                    </div>


                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */
/* @var $form yii\widgets\ActiveForm */
?>
<!-- begin row -->
<div class="row">
    <!-- begin col-lg-12 -->
    <div class="col-lg-12">
        <!-- begin box -->
        <div class="box box-success">
            <div class="box-body">

                <?php $form = ActiveForm::begin(); ?>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <?= $form->field($model, 'eleccion_id')->dropDownList(
                            \yii\helpers\ArrayHelper::map(\app\models\Eleccion::find()->all(),'id','name'),
                            ['prompt'=>'Seleccione la Elección',
                            ]);?>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <?= $form->field($model, 'recinto_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => \yii\helpers\ArrayHelper::map(\app\models\RecintoElectoral::find()->asArray()->all(),'id','name'),
                            'language' => 'es',
                            'options' => ['placeholder' => 'Seleccione la Recinto.',
                            ],

                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ]);?>

                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3">

                        <?= $form->field($model, 'coordinator_jr_man')->dropDownList(
                            \yii\helpers\ArrayHelper::map(\app\models\Persona::find()->all(),'id','first_name'),
                            ['prompt'=>'Seleccione el Coordinador',
                            ]);?>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3">

                        <?= $form->field($model, 'jr_man')->textInput() ?>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <?= $form->field($model, 'coordinator_jr_woman')->dropDownList(
                            \yii\helpers\ArrayHelper::map(\app\models\Persona::find()->all(),'id','first_name'),
                            ['prompt'=>'Seleccione el Coordinador',
                            ]);?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">

                        <?= $form->field($model, 'jr_woman')->textInput() ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">

                        <?= $form->field($model, 'count_elector')->textInput() ?>
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

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Junta */
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

                    <?= $form->field($model, 'recinto_eleccion_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()
                            ->select(['recinto_eleccion.id',
                                'recinto_electoral.name'
                            ])->innerJoin('recinto_electoral',
                                'recinto_electoral.id=recinto_eleccion.recinto_id')
                            ->asArray()->all(),'id','name'),
                        ['prompt'=>'Seleccione el Recinto',
                        ]);?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'type')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Junta::JUNTA_CHOICES,'id','name'),
                        ['prompt'=>'Seleccione el Tipo',
                        ]);?>

                    <?= $form->field($model, 'null_vote')->textInput() ?>
                    <?= $form->field($model, 'blank_vote')->textInput() ?>

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
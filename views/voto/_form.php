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
                            <?= $form->field($model, 'recinto_eleccion_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()
                                    ->select(['recinto_eleccion.id',
                                              'recinto_electoral.name'
                                    ])->innerJoin('recinto_electoral',
                                        'recinto_electoral.id=recinto_eleccion.recinto_id')
                                    ->asArray()->all(),'id','name'),
                                    ['prompt'=>'Seleccione la Elección',
                                ]);?>

                            <?= $form->field($model, 'postulacion_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Postulacion::find()->all(),'id','name'),
                                ['prompt'=>'Seleccione la Postulación',
                                ]);?>

                            <?= $form->field($model, 'v_jr_man')->textInput() ?>

                            <?= $form->field($model, 'v_jr_woman')->textInput() ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'vn_jr_man')->textInput() ?>

                            <?= $form->field($model, 'vn_jr_woman')->textInput() ?>

                            <?= $form->field($model, 'vb_jr_man')->textInput() ?>

                            <?= $form->field($model, 'vb_jr_woman')->textInput() ?>
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


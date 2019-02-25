<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Canton */
/* @var $form yii\widgets\ActiveForm */
?>
<?php if ($model->hasErrors()) {
    \Yii::$app->getSession()->setFlash('error', $model->getErrorSummary(true));
}
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

                    <?= $form->field($model, 'province_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Province::find()->all(),'id','name'),
                        ['prompt'=>'Seleccione la Provincia',
                        ]);?>

                    <?= $form->field($model, 'type')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Canton::CANTON_CHOICES,'id','name'),
                        ['prompt'=>'Seleccione el Rol',
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

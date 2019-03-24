<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoElectoral */
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

                    <?= $form->field($model, 'zona_id')->widget(\kartik\select2\Select2::classname(), [
                        'data' => \yii\helpers\ArrayHelper::map(\app\models\Zona::find()->all(),'id','name'),
                        'language' => 'es',
                        'options' => ['placeholder' => 'Seleccione la zona.',
                            'onchange'=>'
                                                                             
                                        '
                        ],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

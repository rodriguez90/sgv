<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Voto */
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
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="province">Recinto</label>
                                <?= \yii\helpers\BaseHtml::dropDownList(
                                    'recinto',
                                    $model->isNewRecord ? null: $model->junta->recinto_eleccion_id,
                                    \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()->all(),'id','name'),
                                    [
                                        'prompt'=>'Seleccione el Recinto',
                                        'onchange' =>'
                                    $.get("../junta/lists?id='.'"+$(this).val(),function(data){
                                    $( "select#voto-junta_id" ).html(data);
                                    });',
                                        'class' =>'form-control',
                                    ]);?>
                            </div>
                            <?= $form->field($model, 'junta_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Junta::find()->asArray()->all(),'id','name'),
                                ['prompt'=>'Seleccione la Junta',
                                ]);?>
                            <?= $form->field($model, 'postulacion_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Postulacion::find()->all(),'id','name'),
                                ['prompt'=>'Seleccione la Postulación',
                                ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'vote')->textInput() ?>
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


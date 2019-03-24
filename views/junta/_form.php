<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VotoJuntaForm */
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

                <?php $form = ActiveForm::begin([
                    'enableClientValidation' => false, // TODO get this working with client validation
                ]); ?>

                <fieldset>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label class="control-label" for="canton_select2">Cantón</label>
                            <?= \kartik\select2\Select2::widget( [
                                'id' => 'canton_select2',
                                'name' => 'canton_select2',
                                'data' => \yii\helpers\ArrayHelper::map(\app\models\Canton::find()->asArray()->all(),'id','name'),
                                'value' => $model->isNewRecord ? '' : $model->getCanton()->id ,
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione Cantón.',
                                    'onchange'=>'
                                        console.log("canton_select2", this.value);
                                        
                                         $.get(homeUrl + "/recinto-eleccion/lists?cantonId='.'"+$(this).val(),function(data){
                                                    $( "#junta-recinto_eleccion_id" ).html(data);
                                                    console.log("#junta-recinto_eleccion_id", $("#junta-recinto_eleccion_id").val());
                                                    recintoId = $("#junta-recinto_eleccion_id").val() === "-" ? 0 : $("#junta-recinto_eleccion_id").val();
                                                    reloadVotos();
                                                });'
                                ],

                                'pluginOptions' => [
                                    'allowClear' => false
                                ],
                            ]);?>
                        </div>

                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <?= $form->field($model, 'recinto_eleccion_id')->widget(\kartik\select2\Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()
                                    ->select(['recinto_eleccion.id',
                                        'recinto_electoral.name'
                                    ])->innerJoin('recinto_electoral',
                                        'recinto_electoral.id=recinto_eleccion.recinto_id')
                                    ->asArray()->all(),'id','name'),
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione la Recinto.',
                                    'onchange'=>'
                                        console.log("junta-recinto_eleccion_id", this.value);
                                         recintoId = $("#junta-recinto_eleccion_id").val() === "-" ? 0 : $("#junta-recinto_eleccion_id").val();
                                        '
                                ],
                                'pluginOptions' => [
                                    'allowClear' => false
                                ],
                            ]);?>
                        </div>

                        <div class="col-lg-3 col-md-3 col-xs-3">

                            <?= $form->field($model, 'type')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Junta::JUNTA_CHOICES,'id','name'),
                                ['prompt'=>'Seleccione el Tipo',
                                ]);?>
                        </div>

                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div id="container" class="nav-tabs-custom">

                            </div>
                        </div>
                    </div>

                    <?= Html::hiddenInput('actasValues', [], ['id'=>'actasValues'])?>
                </fieldset>


                <div class="form-group">
                    <?= Html::submitButton('Guardar', ['id'=>'btnSubmit', 'class' => 'btn btn-success']) ?>
                    <?= Html::button('Cancelar',['class'=>'btn btn-default','onclick'=>'window.history.go(-1)']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var recintoId = '<?php echo $model->isNewRecord ? 0 : $model->recinto_eleccion_id; ?>';
    var modelId = '<?php echo $model->isNewRecord ? 0 : $model->id; ?>';
</script>

<?php $this->registerJsFile('@web/js/junta/form.js', ['depends' => ['app\assets\DataTableAsset']]) ?>

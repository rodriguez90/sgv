<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Junta */
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
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <?= $form->field($model->junta, 'recinto_eleccion_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()
                                    ->select(['recinto_eleccion.id',
                                        'recinto_electoral.name'
                                    ])->innerJoin('recinto_electoral',
                                        'recinto_electoral.id=recinto_eleccion.recinto_id')
                                    ->asArray()->all(),'id','name'),
                                ['prompt'=>'Seleccione el Recinto',
                                ]);?>
                        </div>

                        <div class="col-lg-4 col-md-4 col-xs-4">

                            <?= $form->field($model->junta, 'type')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Junta::JUNTA_CHOICES,'id','name'),
                                ['prompt'=>'Seleccione el Tipo',
                                ]);?>
                        </div>

                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <?= $form->field($model->junta, 'name')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <h4>Acta de Votos</h4>

                    <div class="row">

                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <?= $form->field($model->junta, 'count_elector')->textInput() ?>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <?= $form->field($model->junta, 'count_vote')->textInput() ?>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <?= $form->field($model->junta, 'null_vote')->textInput() ?>
                        </div>
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <?= $form->field($model->junta, 'blank_vote')->textInput() ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            // $voto table
                            $voto = new \app\models\Voto();
                            $voto->loadDefaultValues();
                            echo '<table id="junta-voto" class="table table-condensed table-bordered">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>' . $voto->getAttributeLabel('postulacion_id') . '</th>';
                            echo '<th>' . $voto->getAttributeLabel('vote') . '</th>';
                            echo '<td>&nbsp;</td>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            // existing votos fields
                            foreach ($model->votes as $key => $_voto) {
                                echo '<tr>';
                                echo $this->render('_form_junta_voto', [
                                    'key' => $_voto->isNewRecord ? $_voto->postulacion->id : $_voto->id,
                                    'form' => $form,
                                    'voto' => $_voto,
                                ]);
                                echo '</tr>';
                            }

                            echo '</tr>';
                            echo '</tbody>';
                            echo  '<tfooter>';
                            echo '<tr>';
                            echo '<td>Total Votos</td>';
                            echo '<td>';
                            echo Html::label($model->junta->totalVotos, null, ['id'=>'totalVotos']);
                            echo '</td>';
                            echo '</tr>';
                            echo  '</tfooter>';
                            echo '</table>';
                            ?>
                        </div>
                    </div>
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

<?php $this->registerJsFile('@web/js/junta/form.js', ['depends' => ['app\assets\AppAsset']]) ?>

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
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <?= $form->field($model->junta, 'recinto_eleccion_id')->widget(\kartik\select2\Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(\app\models\RecintoEleccion::find()
                                    ->select(['recinto_eleccion.id',
                                        'recinto_electoral.name'
                                    ])->innerJoin('recinto_electoral',
                                        'recinto_electoral.id=recinto_eleccion.recinto_id')
                                    ->asArray()->all(),'id','name'),
                                'language' => 'de',
                                'options' => ['placeholder' => 'Seleccione la Recinto.',
                                    'onchange'=>'
                                        console.log("junta-recinto_eleccion_id", this.value);
                                        $.ajax({
                                            url: homeUrl + "/junta/ajaxcall",
                                            data:{
                                                 "recintoId":$(this).val(),
                                                 "modelId": modelId
                                            },
                                            success:function (data) {
                                                $("#tab_1").html(data);
                                            }
                                        });
                                        
                                        '
                                ],

                                'pluginOptions' => [
                                    'allowClear' => false
                                ],
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

                    <div class="row">
                        <div class="col-lg-6"><h4>Acta de Votos</h4></div>
                    </div>

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
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <?php
                                    $tmp = 0;
                                    foreach (\app\models\Postulacion::ROL_CHOICES as $rol)
                                    {
                                        $class = $tmp === 0 ? 'class="active"' : '';
                                        echo '<li><a ' . $class . ' href="#tab_' . $rol['id']. '" data-toggle="tab">' . $rol['name'] .'</a></li>';
                                        $tmp += 1;
                                    }
                                    ?>
                                </ul>
                                <div class="tab-content">
                                    <?php
                                    $tmp = 0;
                                    foreach (\app\models\Postulacion::ROL_CHOICES as $rol)
                                    {
                                        $class = $tmp === 0 ? ' active' : '';

                                        echo '<div class="tab-pane' . $class . '" id="tab_' . $rol['id']. '">';

                                        // $voto table
                                        $voto = new \app\models\Voto();
                                        $voto->loadDefaultValues();
                                        echo '<table id="junta-voto-' . $rol['id'] . '" class="table table-condensed table-bordered">';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th>' . $voto->getAttributeLabel('postulacion_id') . '</th>';
                                        echo '<th>' . $voto->getAttributeLabel('vote') . '</th>';
                                        echo '<td>&nbsp;</td>';
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';

                                        // existing votos fields
                                        $votos = $model->getVotesByRole($rol['id']);
                                        foreach ($votos as $key => $_voto) {
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
                                        echo Html::label($model->junta->getTotalVotosValidosByRole($rol['id']), null, ['id'=>'totalVotos_'.$rol['id']]);
                                        echo '</td>';
                                        echo '</tr>';
                                        echo  '</tfooter>';
                                        echo '</table>';

                                        $tmp += 1;

                                        echo  '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
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

<script type="text/javascript">
    var modelId = '<?php echo $model->junta->isNewRecord ? 0 : $model->junta->id; ?>';
</script>

<?php $this->registerJsFile('@web/js/junta/form.js', ['depends' => ['app\assets\AppAsset']]) ?>

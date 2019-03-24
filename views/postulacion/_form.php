<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Postulacion */
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
                <div class="col-lg-12 col-md-12 col-xs-12">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'eleccion_id')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Eleccion::find()->all(),'id','name'),
                                ['prompt'=>'Seleccione la Elección',
                                ]);?>

                            <?= $form->field($model, 'partido_id')->widget(\kartik\select2\Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(\app\models\Partido::find()->all(),'id','name'),
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione el partido.',
                                    'onchange'=>'
                                        console.log("postulacion-partido_id", this.value);
                                                                             
                                        '
                                ],
                                'pluginOptions' => [
                                    'allowClear' => false
                                ],
                            ]);?>

                            <?= $form->field($model, 'candidate_id')->widget(\kartik\select2\Select2::classname(), [
                                'data' =>  \yii\helpers\ArrayHelper::map(\Da\User\Model\Profile::find()
                                    ->innerJoin('auth_assignment', 'profile.user_id=auth_assignment.user_id and auth_assignment.item_name="Candidato"')
                                    ->innerJoin('postulacion', 'postulacion.candidate_id=profile.user_id')
                                    ->asArray()
                                    ->all(),'user_id','name'),
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione el Candidato.',
                                    'onchange'=>'                                        
                                                                             
                                        '
                                ],
                                'pluginOptions' => [
                                    'allowClear' => false
                                ],
                            ]);?>

                        </div>

                        <div class="col-lg-6">
                            <?= $form->field($model, 'role')->dropDownList(
                                \yii\helpers\ArrayHelper::map(\app\models\Postulacion::ROL_CHOICES,'id','name'),
                                ['prompt'=>'Seleccione el Rol',
                                ]);?>

                            <?= $form->field($model, 'postulacionCantons')->widget(
                                \dosamigos\selectize\SelectizeDropDownList::class,
                                [

                                    'items' => \yii\helpers\ArrayHelper::map(\app\models\Canton::find()->all(), 'id', 'name'),
                                    'options' => [
                                        'value' => \yii\helpers\ArrayHelper::map($model->postulacionCantons,'id', 'canton_id'),
                                        'id' => 'id',
                                        'multiple' => true,
                                    ],
                                ]
                            ) ?>
                        </div>
                    </div>

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

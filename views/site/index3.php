<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */

$this->title = '';
?>
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Electores</span>
                    <!--                    <span class="info-box-number">41,410<small>%</small></span>-->
                    <span class="info-box-number"><?=$totalElectores?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-android-document"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Votos</span>
                    <span class="info-box-number"><?=$totalVotos?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-ios-circle-filled"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Votos Nulos</span>
                    <span class="info-box-number"><?= $totalVotosNulos ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-circle-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Votos En Blanco</span>
                    <span class="info-box-number"><?= $totalVotosBlancos ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">

        <div class="col-lg-12">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Votos por Postulación</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <label class="control-label" for="canton_select2">Cantón</label>
                            <?= \kartik\select2\Select2::widget( [
                                'id' => 'canton_select2',
                                'name' => 'canton_select2',
                                'data' => \yii\helpers\ArrayHelper::map(\app\models\Canton::find()->asArray()->all(),'id','name'),
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione Cantón.',
                                    'onchange'=>'                                        
                                         $.get(homeUrl + "recinto-eleccion/lists?cantonId='.'"+$(this).val(),function(data){
                                                    $( "#recinto_select2" ).html(data);
                                                    reloadVotos();
                                               });'
                                ],

                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <label class="control-label" for="recinto_select2">Recinto</label>
                            <?= \kartik\select2\Select2::widget( [
                                'id' => 'recinto_select2',
                                'name' => 'recinto_select2',
                                'language' => 'es',
                                'options' => ['placeholder' => 'Seleccione Recinto.',
                                    'onchange'=>'
                                        console.log("recinto_select2", this.value);
                                        reloadVotos();
                                        '
                                ],

                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);?>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <label class="control-label" for="canton_select2">Dignidad</label>
                            <?= \kartik\select2\Select2::widget( [
                                'id' => 'dignidad_select2',
                                'name' => 'dignidad_select2',
                                'language' => 'es',
                                'data' => \yii\helpers\ArrayHelper::map(\app\models\Postulacion::ROL_CHOICES,'id','name'),
                                'options' => [
                                    'placeholder' => 'Seleccione Dignidad.',
                                    'onchange'=>'
                                        reloadVotos();
                                        '
                                ],

                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="chart">
                                <canvas id="postulacion_voto_chart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>


<?php $this->registerJsFile('@web/js/site/index.js', ['depends' => ['app\assets\ChartAsset']]) ?>
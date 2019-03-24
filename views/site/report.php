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
                <span class="info-box-icon bg-aqua"><i class="fa fa-th-large"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Recintos en Elección</span>
                    <!--                    <span class="info-box-number">41,410<small>%</small></span>-->
                    <span id="totalRecintos" class="info-box-number"><?=$totalRecintos?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-archive"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Juntas</span>
                    <span id="totalJunta"  class="info-box-number"><?=$totalJunta?></span>
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
                <span class="info-box-icon bg-red"><i class="ion ion-android-document"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Actas</span>
                    <span id="totalActas" class="info-box-number"><?= $totalActas ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-paw"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Postulaciones</span>
                    <span id="totalPostulacion" class="info-box-number"><?= $totalPostulacion ?></span>
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
                    <h3 class="box-title">Actas por Recinto</h3>

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
                            <label class="control-label" for="canton_select2">Recinto</label>
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

    <div class="row">
        <div class="col-md-6">
            <!-- DONUT CHART -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Votos en Porcientos</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <?= ChartJs::widget([
                            'type' => 'pie',
                            'options' => [
                                'height' => 200,
                            ],
                            'data' => [
                                'labels' => $labelsPorcientos,
                                'datasets' => [
                                    [
                                        'backgroundColor'=> [
                                            '#00a65a',
                                            '#dd4b39',
                                            '#f39c12',
                                            '#cc65fe',
                                        ],
                                        'data' => $dataPorcientos
                                    ],
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

<?php $this->registerJsFile('@web/js/site/report.js', ['depends' => ['app\assets\AppAsset']]) ?>
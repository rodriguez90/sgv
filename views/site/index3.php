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

        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Area Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <?= ChartJs::widget([
                            'type' => 'bar',
                            'options' => [
                                'height' => 200,
//                            'width' => 200
                            ],
                            'data' => [
                                'labels' => $labels,
                                'datasets' => [
                                    [
                                        'label' => "Votos por Postulación",
//                                    'scaleBeginAtZero'=> true,
                                        'backgroundColor' => "rgba(179,181,198,0.2)",
                                        'borderColor' => "rgba(179,181,198,1)",
                                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                        'data' => $data
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

        <div class="col-md-6">
            <!-- DONUT CHART -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Donut Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <?= ChartJs::widget([
                            'type' => 'pie',
                            'options' => [
                                'height' => 200,
//                            'width' => 200
                            ],
                            'data' => [
                                'labels' => $labels,
                                'datasets' => [
                                    [
                                        'label' => "Votos por Postulación",
//                                    'scaleBeginAtZero'=> true,
                                        'backgroundColor' => "rgba(179,181,198,0.2)",
                                        'borderColor' => "rgba(179,181,198,1)",
                                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                        'data' => $data
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

<?php $this->registerJsFile('@web/js/site/index.js', ['depends' => ['app\assets\DataTableAsset']]) ?>
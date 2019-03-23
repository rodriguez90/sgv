<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */

$this->title = '';
?>

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
//                            'width' => 200
                            ],
                            'data' => [
                                'labels' => $labelsPorcientos,
                                'datasets' => [
                                    [
                                        'label' => "Votos por Postulación",
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
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Junta */

$this->title = 'Junta Receptora del Voto: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Junta Receptora del Voto', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <p>
                        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Está seguro que desea eliminar la JRV?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'label' => 'Recinto',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return  Html::a($model->recintoEleccion->name, \yii\helpers\Url::toRoute(['recinto-eleccion/view', 'id' =>  $model->recintoEleccion->id]));
                                },
                            ],
                            'name',
                            [
                                'attribute'=>'type',
                                'value' => \app\models\Junta::JUNTA_LABEL[$model->type]
                            ],
                            'totalVotosNulos',
                            'totalVotosBlancos',
                            'totalVotosValidos',
                            'totalVotos',
                        ],
                        'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                    ]) ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div id="container" class="nav-tabs-custom">

                            </div>
                        </div>
                    </div>
                </div> <!-- end body box-->
            </div> <!-- end box-->
        </div> <!-- end col-->
    </div><!-- end row-->

    <script type="text/javascript">
        var recintoId = '<?php  $model->recinto_eleccion_id; ?>';
        var cantonId = '<?php echo $model->getCanton()->id; ?>';
        var modelId = '<?php echo $model->id; ?>';
    </script>

<?php $this->registerJsFile('@web/js/junta/view.js', ['depends' => ['app\assets\DataTableAsset']]) ?>
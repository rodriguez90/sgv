<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recinto Eleccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recinto-eleccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar el elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'recinto_id',
            'coordinator_jr_man',
            'coordinator_jr_woman',
            'eleccion_id',
            'jr_woman',
            'jr_man',
            'count_elector',
        ],
    ]) ?>

</div>

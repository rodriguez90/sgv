<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Voto */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Votos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'recinto_eleccion_id',
            'postulacion_id',
            'v_jr_man',
            'v_jr_woman',
            'vn_jr_man',
            'vn_jr_woman',
            'vb_jr_man',
            'vb_jr_woman',
        ],
    ]) ?>

</div>

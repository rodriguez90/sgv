<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */

$this->title = 'Update Recinto Eleccion: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recinto Eleccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recinto-eleccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

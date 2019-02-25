<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */

$this->title = 'Modificar Recinto en Elección: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Recinto en Elección', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="recinto-eleccion-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

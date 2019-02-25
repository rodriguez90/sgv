<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Province */

$this->title = 'Modificar Provincia: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Provincias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Guardar';
?>
<div class="province-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Canton */

$this->title = 'Modificar Canton: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cantones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="canton-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

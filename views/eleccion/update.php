<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Eleccion */

$this->title = 'Modificar Elección: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Elecciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="eleccion-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

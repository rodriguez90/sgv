<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Zona */

$this->title = 'ModificarZona: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Zonas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="zona-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

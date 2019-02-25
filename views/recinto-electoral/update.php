<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoElectoral */

$this->title = 'Modificar Recinto Electoral: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recintos Electorales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="recinto-electoral-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

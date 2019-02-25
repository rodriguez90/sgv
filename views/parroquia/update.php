<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parroquia */

$this->title = 'Modificar Parroquia: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Parroquias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="parroquia-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

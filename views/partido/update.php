<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Partido */

$this->title = 'ModificarPartido: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Partidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="partido-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

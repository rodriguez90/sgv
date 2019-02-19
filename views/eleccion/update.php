<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Eleccion */

$this->title = 'Update Eleccion: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Eleccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="eleccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

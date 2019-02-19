<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RecintoElectoral */

$this->title = 'Update Recinto Electoral: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recinto Electorals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recinto-electoral-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

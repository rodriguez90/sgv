<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Voto */

$this->title = 'Modificar Voto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Votos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="voto-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

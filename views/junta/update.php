<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Junta */

$this->title = 'Modificar Junta: ' . $model->junta->name;
$this->params['breadcrumbs'][] = ['label' => 'Juntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->junta->name, 'url' => ['view', 'id' => $model->junta->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="junta-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

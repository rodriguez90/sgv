<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Postulacion */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Postulacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="postulacion-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

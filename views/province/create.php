<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Province */

$this->title = 'Nueva Provincia';
$this->params['breadcrumbs'][] = ['label' => 'Provincias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="province-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

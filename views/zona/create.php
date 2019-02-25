<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Zona */

$this->title = 'Nueva Zona';
$this->params['breadcrumbs'][] = ['label' => 'Zonas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zona-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

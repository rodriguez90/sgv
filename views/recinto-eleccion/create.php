<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */

$this->title = 'Nueva Recinto en Elección';
$this->params['breadcrumbs'][] = ['label' => 'Recinto en Elección', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recinto-eleccion-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Persona */

$this->title = 'Nueva Persona';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persona-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Eleccion */

$this->title = 'Nueva Elección';
$this->params['breadcrumbs'][] = ['label' => 'Elecciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eleccion-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

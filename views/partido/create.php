<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Partido */

$this->title = 'Nueva Partido';
$this->params['breadcrumbs'][] = ['label' => 'Partidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partido-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

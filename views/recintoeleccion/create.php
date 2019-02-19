<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecintoEleccion */

$this->title = 'Create Recinto Eleccion';
$this->params['breadcrumbs'][] = ['label' => 'Recinto Eleccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recinto-eleccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

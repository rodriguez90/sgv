<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecintoElectoral */

$this->title = 'Nuevo Recinto Electoral';
$this->params['breadcrumbs'][] = ['label' => 'Recintos Electorales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recinto-electoral-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

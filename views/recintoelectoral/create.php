<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RecintoElectoral */

$this->title = 'Create Recinto Electoral';
$this->params['breadcrumbs'][] = ['label' => 'Recinto Electorals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recinto-electoral-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

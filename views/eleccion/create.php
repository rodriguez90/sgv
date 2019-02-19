<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Eleccion */

$this->title = 'Create Eleccion';
$this->params['breadcrumbs'][] = ['label' => 'Eleccions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eleccion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

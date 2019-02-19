<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Partido */

$this->title = 'Create Partido';
$this->params['breadcrumbs'][] = ['label' => 'Partidos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

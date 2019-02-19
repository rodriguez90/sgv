<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Canton */

$this->title = 'Create Canton';
$this->params['breadcrumbs'][] = ['label' => 'Cantons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="canton-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

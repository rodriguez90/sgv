<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parroquia */

$this->title = 'Create Parroquia';
$this->params['breadcrumbs'][] = ['label' => 'Parroquias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parroquia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

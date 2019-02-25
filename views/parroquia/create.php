<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parroquia */

$this->title = 'Nueva Parroquia';
$this->params['breadcrumbs'][] = ['label' => 'Parroquias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parroquia-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

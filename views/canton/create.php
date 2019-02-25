<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Canton */

$this->title = 'Nuevo Canton';
$this->params['breadcrumbs'][] = ['label' => 'Cantones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="canton-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

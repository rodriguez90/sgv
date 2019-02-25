<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Postulacion */

$this->title = 'Nueva Postulacion';
$this->params['breadcrumbs'][] = ['label' => 'Postulacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postulacion-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

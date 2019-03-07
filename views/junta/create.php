<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Junta */

$this->title = 'Nueva Junta';
$this->params['breadcrumbs'][] = ['label' => 'Juntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="junta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

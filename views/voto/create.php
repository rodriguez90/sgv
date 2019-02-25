<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Voto */

$this->title = 'Nuevo Voto';
$this->params['breadcrumbs'][] = ['label' => 'Votos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voto-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

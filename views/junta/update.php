<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Junta */

$this->title = 'Modificar Junta Receptora de Votos: ' . $model->junta->name;
$this->params['breadcrumbs'][] = ['label' => 'Juntas Receptoras de Votos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->junta->name, 'url' => ['view', 'id' => $model->junta->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="junta-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

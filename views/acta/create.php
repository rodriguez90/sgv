<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Acta */

$this->title = 'Create Acta';
$this->params['breadcrumbs'][] = ['label' => 'Actas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

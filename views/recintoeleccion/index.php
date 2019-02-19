<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RecintoEleccionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recinto Eleccions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recinto-eleccion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Recinto Eleccion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'recinto_id',
            'coordinator_jr_man',
            'coordinator_jr_woman',
            'eleccion_id',
            //'jr_woman',
            //'jr_man',
            //'count_elector',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

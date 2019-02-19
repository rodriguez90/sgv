<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VotoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Votos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Voto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'recinto_eleccion_id',
            'postulacion_id',
            'v_jr_man',
            'v_jr_woman',
            //'vn_jr_man',
            //'vn_jr_woman',
            //'vb_jr_man',
            //'vb_jr_woman',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

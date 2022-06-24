<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modelsVeplStationariesGrnItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vepl Stationaries Grn Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-grn-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vepl Stationaries Grn Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'grn_id',
            'item_id',
            'quantity',
            'rate',
            'amount',
            //'unit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

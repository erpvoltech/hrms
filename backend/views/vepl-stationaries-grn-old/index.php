<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VeplStationariesGrnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vepl Stationaries GRNs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-grn-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vepl Stationaries GRN', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        //    'id',
            'grn_date',
            'item_id',
            'supplier_id',
            'bill_no',
            //'quantity',
            //'amount',
            //'unit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

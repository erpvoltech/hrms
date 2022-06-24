<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VeplStationariesPoSubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vepl Stationaries Po Subs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-po-sub-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Vepl Stationaries Po Sub', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'po_id',
            'po_item_id',
            'po_qty',
            'po_rate',
            //'po_amount',
            //'po_total_amount',
            //'po_sgst',
            //'po_igst',
            //'po_cgst',
            //'po_net_amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

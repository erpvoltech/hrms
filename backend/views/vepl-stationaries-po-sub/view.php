<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPoSub */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Po Subs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vepl-stationaries-po-sub-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'po_id',
            'po_item_id',
            'po_qty',
            'po_rate',
            'po_amount',
            'po_total_amount',
            'po_sgst',
            'po_igst',
            'po_cgst',
            'po_net_amount',
        ],
    ]) ?>

</div>

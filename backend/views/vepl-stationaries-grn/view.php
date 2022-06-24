<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VeplStationaries;
use app\models\VeplSupplier;
use app\models\VeplStationariesGrnItem;

/* @var $this yii\web\View */
/* @var $model app\models\VeplStationariesGrn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Grns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .b{
        color:#fff;
        visibility: hidden
    }
    .text{
        color: #009933 ;
        font-weight:bold;
        font-size:16px;

    }   
    .addrline {
        border-bottom: 1px solid;
        color: #942509;
        font-weight: normal;
        font-size: 14px;
        margin-bottom: 1em;
        padding-bottom: 2px;
    }

</style>
<div class="vepl-stationaries-grn-view">

    <!--<h1><? Html::encode($this->title) ?></h1>-->

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title">Bill No: <?= $model->bill_no ?></h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="8"><div class="addrline"><span class="text"> GRN Details</span></div></th></tr>
                        <tr><th style="text-align : right">Bill No</th><td> <?= $model->bill_no ?> </td><th style ="text-align : right">GRN Date</th><td> <?= date('d.m.Y', strtotime($model->grn_date)) ?> </td><th style="text-align : right">Supplier Name</th><td colspan="4"> <?= $model->suppliers->supplier_name ?> </td></tr>
                        <tr><td colspan="8"></td></tr>
                        <tr><th colspan="2" style="text-align : center">Item Name</th><th colspan="2" style ="text-align : center">Quantity</th><th colspan="2" style ="text-align : center">Amount</th><th colspan="2" style ="text-align : center">Unit</th></tr>
                        <?php foreach ($grnItem as $grnModel){ 
                        $itemName = VeplStationaries::find()->where(['id'=>$grnModel->item_id])->one(); 
                        ?>
                        <tr style="text-align: right;"><td colspan="2"><?= $itemName->item_name ?></td><td colspan="2"><?= $grnModel->quantity ?></td><td colspan="2"><?= $grnModel->amount ?></td><td colspan="2"><?= $grnModel->unit ?></td></tr>
                        <?php } ?>
                    </table>

                </div>
                <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
            </div>
        </div>
    </div>

</div>

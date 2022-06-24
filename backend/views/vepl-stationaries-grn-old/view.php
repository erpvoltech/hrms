<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesGrn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries GRNs', 'url' => ['index']];
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

    <!--<h1><= Html::encode($this->title) ?></h1>-->

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
                        <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Stationary GRN</span></div></th></tr>
                        <tr><th style ="text-align : right">GRN Date</th><td> <?= $model->grn_date ?> </td><th style ="text-align : right">Item</th><td> <?= $model->item_id ?> </td></tr>
                        <tr><th style ="text-align : right">Supplier</th><td> <?= $model->supplier_id ?> </td><th style ="text-align : right">Bill No</th><td> <?= $model->bill_no ?> </td></tr>
                        <tr><th style ="text-align : right">Quantity</th><td> <?= $model->quantity ?> </td><th style ="text-align : right">Amount</th><td> <?= $model->amount ?> </td></tr>
                        <tr><th style ="text-align : right">Unit</th><td> <?= $model->unit ?> </td></tr>
                    </table>

                </div>
                <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
            </div>
        </div>
    </div>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VeplStationaries */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries', 'url' => ['index']];
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
<div class="vepl-stationaries-view">


    <!--<h1><= Html::encode($this->title) ?></h1>-->

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title">Item Category: <?= $model->item_category ?></h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Stationary/Printing Material Details</span></div></th></tr>
                        <tr><th style ="text-align : right">Item Category</th><td> <?= $model->item_category ?> </td><th style ="text-align : right">Item Name</th><td> <?= $model->item_name ?> </td></tr>
                    </table>

                </div>
                <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
            </div>
        </div>
    </div>

</div>

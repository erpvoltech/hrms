<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VeplStationaries;
use app\models\VeplStationariesIssueSub;
//use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesIssue */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Issue', 'url' => ['index']];
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
<div class="vepl-stationaries-issue-view">

    <!--<h1><= Html::encode($this->title) ?></h1>-->

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title">Stationary Issued Details: <?= $model->issued_to ?></h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="12">  <div class="addrline"><span class="text"> Stationary Issued </span></div></th></tr>
                        <tr><th style ="text-align : right">Date of Issue</th><td colspan="4"> <?= $model->issue_date ?> </td><th style ="text-align : right">Issued To</th><td colspan="4"> <?= $model->issued_to ?> </td><th style ="text-align : right">Remarks</th><td colspan="4"> <?= $model->remarks ?> </td></tr>
                        <tr><td colspan="12"></td></tr>
                        <tr><th colspan="6" style="text-align : center">Item Name</th><th colspan="6" style ="text-align : center">Issued Quantity</th></tr>
                        <?php foreach ($issueItem as $itemIssueModel){ 
                        $itemName = VeplStationaries::find()->where(['id'=>$itemIssueModel->issue_item_id])->one(); 
                        ?>
                        <tr style="text-align: right;"><td colspan="6"><?= $itemName->item_name ?></td><td colspan="6"><?= $itemIssueModel->issued_qty ?></td><!--<td colspan="4"><= Html::button('Return', ['id' => 'modelButton', 'value' => \yii\helpers\Url::to(['vepl-stationaries-issue/stationaryReturn']), 'class' => 'btn btn-success']) ?></td>--></tr>
                                                                                                                                                                                
                            <?php } ?>
                    </table>

                </div>
                <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
            </div>
        </div>
    </div>

</div>


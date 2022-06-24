<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VeplStationaries;
use app\models\VeplSupplier;
use app\models\VeplStationariesPoSub;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vepl Stationaries Pos', 'url' => ['index']];
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
<div class="vepl-stationaries-po-view">

    <!--<h1><= Html::encode($this->title) ?></h1>-->

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title">PO No: <?= $model->po_no ?></h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="12"><div class="addrline"><span class="text">PO Details</span></div></th></tr>
                        <tr><th style="text-align : right">PO No</th><td> <?= $model->po_no ?> </td><th style ="text-align : right">PO Date</th><td> <?= date('d.m.Y', strtotime($model->po_date)) ?> </td><th style="text-align : right">Previous PO Date</th><td colspan="4"> <?= date('d.m.Y', strtotime($model->last_purchase_date)) ?> </td><th style="text-align : right">Supplier Name</th><td colspan="4"> <?= $model->suppliers->supplier_name ?> </td></tr>
                        <tr><td colspan="12"></td></tr>
                        <tr><th colspan="3" style="text-align : center">Item Name</th><th colspan="3" style ="text-align : center">Quantity</th><th colspan="3" style ="text-align : center">Rate</th><th colspan="3" style ="text-align : center">Amount</th></tr>
                        <?php
                        foreach ($grnItem as $grnModel) {
                            $itemName = VeplStationaries::find()->where(['id' => $grnModel->po_item_id])->one();
                            ?>
                            <tr style="text-align: right;"><td colspan="3"><?= $itemName->item_name ?></td><td colspan="3"><?= $grnModel->po_qty ?></td><td colspan="3"><?= $grnModel->po_rate ?></td><td colspan="3"><?= $grnModel->po_amount ?></td></tr>
                        <?php } ?>
                        <tr>
                            <td colspan="9"></td>
                            <th>Total Amount</th>
                            <td style="text-align: right;"><?= $model->po_total_amount ?></td>
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                            <th>SGST(<?= $model->po_sgst . ' %' ?>)</th>
                            <td style="text-align: right;"><?= ($model->po_total_amount) * ($model->po_sgst / 100) ?></td>
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                            <th>CGST(<?= $model->po_cgst . ' %' ?>)</th>
                            <td style="text-align: right;"><?= ($model->po_total_amount) * ($model->po_cgst / 100) ?></td>
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                            <th>Net Amount</th>
                            <td style="text-align: right;"><?= $model->po_net_amount ?></td>
                        </tr>
                        <tr>
                            <th>PO Prepared by</th>
                            <td colspan="3">
                                <?php
                                $user1 = User::find()->where(['id' => $model->po_prepared_by])->one();
                                echo $user1->username
                                ?></td>
							<?php /*
                            <th>PO Approved by</th>
                            <?php if ($model->po_approval_status == 0) { ?>
                                <td colspan="4"><b><a href="approve?id=<?= $model->id ?>">Click to Approve</a></b></td>
                            <?php
                            } else {
                                $user = User::find()->where(['id' => $model->po_approved_by])->one();
                                ?>
                                <td colspan="4"><b><?= $user->username ?></b></td>
                            <?php } ?>
							*/ ?>
							<th>PO Approved by</th>
                            <?php
                            if ($model->po_approval_status == 0 && Yii::$app->user->identity->username == 'administrator') { ?>
                                <td colspan="4"><b><a href="approve?id=<?= $model->id ?>">Click to Approve</a></b></td>
                            <?php
                            } else if($model->po_approval_status == 1){
                                $user = User::find()->where(['id' => $model->po_approved_by])->one();
                                ?>
                                <td colspan="4"><b><?= $user->username ?></b></td>
                                <?php
                            } else {
                                ?>
                                <td colspan="4"><b><?php echo 'Permission denied' ?></b></td>
                            <?php } ?>
                            <td colspan="3"></td>
                        </tr>
                    </table>

                </div>
                <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
            </div>
        </div>
    </div>
</div>


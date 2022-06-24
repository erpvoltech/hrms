<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Policies', 'url' => ['cmdindex']];
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
            <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body" style="padding: 5px">
            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%">
                    <table class="table table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="4">  <div class="addrline"><span class="text"> Policy Detail</span></div></th></tr>
                        <tr><th style ="text-align : right">Name</th><td> <?= $model->name ?> </td><th style ="text-align : right">Policy No</th><td> <?= $model->policy_number ?> </td></tr>
                        <tr><th style ="text-align : right">Insured Company</th><td> <?= $model->insured_company ?> </td><th style ="text-align : right">Sum Insured</th><td> <?= $model->sum_insured ?> </td></tr>
                        <tr><th style ="text-align : right">Premium Amount</th><td> <?= $model->premium_amount ?> </td><th style ="text-align : right">Terms</th><td> <?= $model->terms ?> </td></tr>
                        <tr><th style ="text-align : right">Policy Date</th><td> <?= date('d.m.Y', strtotime($model->policy_date)) ?> </td><th style ="text-align : right">Maturity Date</th><td> <?= date('d.m.Y', strtotime($model->maturity_date)) ?> </td></tr>
                        <tr><th style ="text-align : right">Policy Paid Date</th>
                            <td>
                                <?php
                                if ($model->policy_paid_date == NULL || $model->policy_paid_date == '') {
                                    echo '';
                                } else {
                                    echo $model->policy_paid_date;
                                }
                                ?> </td>
                            <th style ="text-align : right">Remarks</th><td> <?= $model->remarks ?> </td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

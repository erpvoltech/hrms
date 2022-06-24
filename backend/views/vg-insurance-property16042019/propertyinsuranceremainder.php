<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceProperty;

$this->title = 'VG Property Insurance Remainder';
$this->params['breadcrumbs'][] = ['label' => 'VG Property Insurance', 'url' => ['index']];
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
<div class="vg-property-view">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="7">  <div class="addrline"><span class="text">Property Insurance Remainder Details</span></div></th></tr>
                        <tr>
                            <th>Property Type</th>
                            <th>Insurance No</th>
                            <th>Property Name</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                        </tr>
                        <?php
                        //$sql = "SELECT id,property_type,valid_from,valid_to FROM vg_insurance_property WHERE valid_to BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 45 DAY)";
                        foreach ($propertyRemainder as $data) {
                            ?>
                            <tr>
                                <td> <?= $data->property_type ?> </td>
                                <td> <?= $data->insurance_no ?> </td>
                                <td><?= $data->property_name ?></td>
                                <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
                                <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
                                <td><?= $data->premium_paid ?></td>
                                <td><?= $data->insured_to ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceVehicle;

$this->title = 'Policy Remainder - Vehicle';
$this->params['breadcrumbs'][] = ['label' => 'Policy - Vehicle', 'url' => ['index']];
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
                        <tr class=" "><th colspan="12">  <div class="addrline"><span class="text">Policy Remainder Details-Vehicle</span></div></th></tr>
                        <tr>
                            <th>Vehicle Type</th>
                            <th>Policy No</th>
                            <th>Property Name</th>
                            <th>Reg.No</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                            <th>Location</th>
                            <th>User</th>
                            <th>User Division</th>
                        </tr>
                        <?php
                        foreach ($propertyRemainder as $data) { ?>
                            <tr>
                                <td> <?= $data->vehicle_type ?> </td>
                                <td> <?= $data->insurance_no ?> </td>
                                <td><?= $data->property_name ?></td>
                                <td><?= $data->property_no ?></td>
                                <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
                                <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
                                <td><?= $data->sum_insured ?></td>
                                <td><?= $data->premium_paid ?></td>
                                <td><?= $data->insured_to ?></td>
                                <td><?= $data->location ?></td>
                                <td><?= $data->user ?></td>
                                <td><?= $data->user_division ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

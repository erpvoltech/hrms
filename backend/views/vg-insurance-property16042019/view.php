<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgInsuranceCompany;


/* @var $this yii\web\View */
/* @var $model app\models\VeplStationariesGrn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vg Insurance Properties', 'url' => ['index']];
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
                <h3 class="panel-title">PIS Detail View</h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="8"><div class="addrline"><span class="text"><?php echo $model->property_name. ' Details' ?></span></div></th></tr>
                        <tr>
                            <th style="text-align : right">Property Type</th><td> <?= $model->property_type ?> </td>
                            <th style ="text-align : right">Insurance No</th><td> <?= $model->insurance_no ?> </td>
                            <th style="text-align : right">Property Name</th><td colspan="4"> <?= $model->property_name ?> </td>
                        </tr>
                        <tr>
                            <th style="text-align : right">Property No</th><td> <?= $model->property_no ?> </td>
                            <th style ="text-align : right">Property Value</th><td> <?= $model->property_value ?> </td>
                            <th style="text-align : right">Sum Insured</th><td colspan="4"> <?= $model->sum_insured ?> </td>
                        </tr>
                        <tr>
                            <th style="text-align : right">Premium Paid</th><td> <?= $model->premium_paid ?> </td>
                            <th style ="text-align : right">Valid From</th><td> <?= date('d.m.Y', strtotime($model->valid_from)) ?> </td>
                            <th style="text-align : right">Valid To</th><td colspan="4"> <?= date('d.m.Y', strtotime($model->valid_to)) ?> </td>
                        </tr>
                        <tr>
                            <th style="text-align : right">Location</th><td> <?= $model->location ?> </td>
                            <th style ="text-align : right">User</th><td> <?= $model->user ?> </td>
                            <th style="text-align : right">User Division</th><td colspan="4"> <?= $model->user_division ?> </td>
                        </tr>
                        <tr>
                            <th style="text-align : right">Insured To</th><td> <?= $model->insured_to ?> </td>
                            <th style ="text-align : right">Equipment Service</th><td> <?= $model->equipment_service ?> </td>
                            <th style="text-align : right">Remarks</th><td colspan="4"> <?= $model->remarks ?> </td>
                        </tr>
                        <tr><td colspan="8"></td></tr>
                        <tr>
                            
                            <th>Insurance Company</th>
                            <td><?= $model->company->company_name ?> </td>
                            <th>Agent Name</th>
                            <td><?= $model->agent->agent_name ?> </td>
                            <th>Agent Name</th>
                            <td><?= $model->agent->official_contact_no ?> </td>
                        </tr>
                    </table>

                </div>
                <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
            </div>
        </div>
    </div>

</div>

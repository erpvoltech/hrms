<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceProperty;
use app\models\VgInsuranceMotherPolicy;
use app\models\VgInsuranceCompany;
use app\models\VgInsuranceAgents;
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
<div class="vg-insurance-agents-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title" style="text-align: center;">
                    <?php
                    echo 'Property Information System';
                    ?><br>
                </h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%"> 

                    <!--table class="table  table-condense" style="font-size:12px;" >
                        <tr><th style="width:20%">Policy No</th><th style="width:20%">From Date</th><th style="width:20%">To Date</th><th style="width:20%">Premium Paid</th><th style="width:20%">Asset Sum Insured</th></tr>
                        <php
                        $motherPolicyId = VgInsuranceMotherPolicy::find()->where(['policy_for_id' => $_GET['id']])->one();
                        ?>
                        <tr>
                            <td><= $motherPolicyId->policy_no ?></td><td><= $motherPolicyId->from_date ?></td><td><= $motherPolicyId->to_date ?></td><td><= $motherPolicyId->premium_paid ?></td><td><= $motherPolicyId->asset_sum_insured ?></td>
                        </tr>
                    </table-->
                    <table class="table  table-condense" style="font-size:12px; overflow-x:auto;" >
                        <tr class=" "><th colspan="17">  <div class="addrline"><span class="text">Building/Vehicle/Equipment Details</span></div></th></tr>
                        <tr>
                            <th>Sl.No</th>
                            <th>Property Type</th>
                            <th>Insurance No</th>
                            <th>Property Name</th>
                            <th>Property No</th>
                            <th>Property Value</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Location</th>
                            <th>User</th>
                            <th>User Division</th>
                            <th>Equipment Service</th>
                            <th>ISP</th>
                            <th>Agent Name</th>
                            <th>Remarks</th>
                        </tr>
                        <?php
                        $model = VgInsuranceProperty::find()->Where(['mother_id' => $_GET['id']])->all();
                        $i=1;
                        foreach ($model as $property) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td style="text-align: left;"><?= $property->property_type ?></td>
                                <td style="text-align: left;"><?= $property->insurance_no ?></td>
                                <td style="text-align: left;"><?= $property->property_name ?></td>
                                <td style="text-align: left;"><?= $property->property_no ?></td>
                                <td style="text-align: right;"><?= $property->property_value ?></td>
                                <td style="text-align: right;"><?= $property->sum_insured ?></td>
                                <td style="text-align: right;"><?= $property->premium_paid ?></td>
                                <td style="text-align: left;"><?= $property->valid_from ?></td>
                                <td style="text-align: left;"><?= $property->valid_to ?></td>
                                <td style="text-align: left;"><?= $property->location ?></td>
                                <td style="text-align: left;"><?= $property->user ?></td>
                                <td style="text-align: left;"><?= $property->user_division ?></td>
                                <td style="text-align: left;"><?= $property->equipment_service ?></td>
                                <?php 
                                $ispName = VgInsuranceCompany::find()->Where(['id' => $property->icn_id])->all();
                                foreach($ispName as $isp){
                                ?>
                                <td style="text-align: left;"><?= $isp->company_name ?></td>
                                <?php }
                                $agentName = VgInsuranceAgents::find()->Where(['id' => $property->insurance_agent_id])->all();
                                foreach($agentName as $agent){
                                ?>
                                <td style="text-align: left;"><?= $agent->agent_name ?></td>
                                <?php } ?>
                                <td style="text-align: left;"><?= $property->remarks ?></td>
                            </tr>
                        <?php $i++; } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
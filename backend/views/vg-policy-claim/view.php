<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgPolicyClaim */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Policy Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-policy-claim-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">Claim Policy of <?= $model->insurance_type ?></font>
        </div>
        <div class="panel-body" style="padding: 3px"> 
            <div class="row">
                <div class="col-md-12"> 
                    <table style="font-size:12px;" >
                        <tr>
                            <th style="width: 250px;">Insurance Type</th><td style="width: 250px;"> <?= $model->insurance_type ?> </td>
                        </tr>
                        <?php if($model->insurance_type == 'GPA' || $model->insurance_type == 'GMC' || $model->insurance_type == 'WC') { ?>
                        <tr>
                            <th style="width: 250px;">Employee Name/Code</th><td style="width: 250px;"><?= $model->employee_name . '/' . $model->employee_code ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th >Policy No</th><td> <?= $model->policy_no ?> </td>
                            <th >Policy Serial No</th><td> <?= $model->policy_serial_no ?> </td>   
                        </tr>
                        <tr>
                            <th >Contact Person</th><td> <?= $model->contact_person ?> </td>
                            <th >Contact No</th><td> <?= $model->contact_no ?> </td>  
                        </tr>
                        <tr>
                            <th >Nature of Loss/Damage/Accident</th><td> <?= $model->nature_of_accident ?> </td>
                            <th >Loss Type</th><td> <?= $model->loss_type ?> </td>
                        </tr>
                        <tr>
                            <th >Details of Damage/Theft/Injury</th><td> <?= $model->injury_detail ?> </td>
                            <th >Place of Accident/Loss</th><td> <?= $model->accident_place_address ?> </td> 
                        </tr>
                        <tr>
                            <th >Date and Time of Loss/Accident</th><td> <?= $model->accident_time ?> </td>
                            <th >Des.of Accident/Loss</th><td> <?= $model->accident_notes ?> </td>
                        </tr>
                        <tr>
                            <th >Des.of Settlement</th><td> <?= $model->settlement_notes ?> </td>
                            <th >Settlement Amount</th><td> <?= $model->settlement_amount ?> </td>  
                        </tr>
                        <tr>
                            <th >Claim Estimate</th><td> <?= $model->claim_estimate ?> </td>
                            <th >Claim Status</th><td style="width: 180px;"> <?= $model->claim_status ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
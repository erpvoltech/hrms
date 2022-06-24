<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceVehicle */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insurance-Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-vehicle-view">
<div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">Insurance Data of <?= $model->property_name ?></font>
        </div>
        <div class="panel-body" style="padding: 3px"> 
            <div class="row">
                <div class="col-md-12"> 
                    <table style="font-size:12px;" >
                        <tr>
                            <th >ISP Name</th><td style="width: 275px;"> <?= $model->company->company_name ?> </td>
                            <th >Agent Name</th><td> <?= $model->agent->agent_name ?> </td>
                            <th >Property Type</th><td> <?= $model->property_type ?> </td>
                        </tr>
                        <tr>
                            <th >Vehicle Type</th><td> <?= $model->vehicle_type ?> </td>
                            <th >Insurance No</th><td style="width: 250px;"> <?= $model->insurance_no ?> </td>
                            <th >Property Name</th><td> <?= $model->property_name ?> </td>
                        </tr>
                        <tr>
                            <th >Property No</th><td> <?= $model->property_no ?> </td>
                            <th >Property Value</th><td> <?= $model->property_value ?> </td>
                            <th >Sum Insured</th><td> <?= $model->sum_insured ?> </td>
                        </tr>
                        <tr>
                            <th >Premium Paid</th><td> <?= $model->premium_paid ?> </td>
                            <th >Valid From</th><td> <?= date('d.m.Y', strtotime($model->valid_from)) ?> </td>
                            <th >Valid To</th><td> <?= date('d.m.Y', strtotime($model->valid_to)) ?> </td>
                        </tr>
						<tr>
                            
                            <th >Pollution Valid From</th><td><?php if($model->pollution_valid_from){ ?><?= date('d.m.Y', strtotime($model->pollution_valid_from)) ?> <?php }?></td>
                            <th >Pollution Valid To</th><td><?php if($model->pollution_valid_to){ ?> <?= date('d.m.Y', strtotime($model->pollution_valid_to)) ?><?php }?> </td>
                        </tr>
						<tr>
                            <th >Year</th><td><?php
                            if($model->financial_year != ''){
                                echo $model->financial_year;
                            }else{
                                echo '';
                            }
                            ?> </td>
                            <th >Status</th><td> <?php
                            if($model->insurance_status != ''){
                                echo $model->insurance_status;
                            }else{
                                echo '';
                            }
                            ?> </td>
							
                        </tr>
                        <tr>
                            <th >Location</th><td> <?= $model->location ?> </td>
                            <th >User</th><td> <?= $model->user ?> </td>
                            <th >User Division</th><td style="width: 180px;"> <?= $model->user_division ?> </td>
                        </tr>
                        <tr>
                            <th >Insured To</th><td> <?= $model->insured_to ?> </td>
                            <th >Remarks</th><td> <?= $model->remarks ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    

    

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceBuilding */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Insurance-Buildings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vg-insurance-building-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">Insurance Data of <?= $model->property_name ?></font>
        </div>
        <div class="panel-body" style="padding: 3px"> 
            <div class="row">
                <div class="col-md-12"> 
                    <table style="font-size:12px;" >
                        <tr>
                            <th >ISP Name</th><td> <?= $model->company->company_name ?> </td>
                            <th >Agent Name</th><td> <?= $model->agent->agent_name ?> </td>
                            <th >Property Type</th><td> <?= $model->property_type ?> </td>
                        </tr>
                        <tr>
                            <th >Insurance No</th><td> <?= $model->insurance_no ?> </td>
                            <th >Property Name</th><td style="width:300px"> <?= $model->property_name ?> </td>
                            <th >Property No</th><td> <?= $model->property_no ?> </td>
                        </tr>
                        <tr>
                            <th >Property Value</th><td> <?= $model->property_value ?> </td>
                            <th >Sum Insured</th><td style="width:300px"> <?= $model->sum_insured ?> </td>
                            <th >Premium Paid</th><td> <?= $model->premium_paid ?> </td>
                        </tr>
                        <tr>
                            <th >Valid From</th><td> <?= date('d.m.Y', strtotime($model->valid_from)) ?> </td>
                            <th >Valid To</th><td style="width:300px"> <?= date('d.m.Y', strtotime($model->valid_to)) ?> </td>
                            <th >Year</th><td>
                            <?php
                            if($model->financial_year != ''){
                                echo $model->financial_year;
                            }else{
                                echo '';
                            }
                            ?>
                            </td>
                        </tr>
                        <tr>
                            <th >Location</th><td> <?= $model->location ?> </td>
                            <th >Insured To</th><td> <?= $model->insured_to ?> </td>
                            <th >Remarks</th><td style="width:300px"> <?= $model->remarks ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
        



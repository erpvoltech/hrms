<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceAgents */

$this->title = $model->agent_name;
$this->params['breadcrumbs'][] = ['label' => 'ISP/Agents', 'url' => ['index']];
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
<div class="vg-insurance-agents-view">
<div class="panel panel-info">
        <div class="panel-heading">
            <h5 class="panel-title">ISP View</h5>
        </div>
        <div class="panel-body" style="padding: 5px"> 
            <div class="row" style="width:100%">
                <div class="col-lg-8" style="width:100%"> 
                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr>
                            <th style="text-align : right">Company Name</th><td> <?= $model->companyName->company_name ?> </td>
                            <th style="text-align : right">Agent Name</th><td> <?= $model->agent_name ?> </td>
                            <th style="text-align : right">Official Contact No</th><td> <?= $model->official_contact_no ?> </td>
                        </tr>
                        <tr>
                            <th style="text-align : right">Personal Contact No</th><td> <?= $model->personal_contact_no ?> </td>
                            <th style="text-align : right">E-mail Address</th><td> <?= $model->email_address ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    

    

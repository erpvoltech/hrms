<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgInsuranceAgents;
use app\models\VgInsuranceCompany;
use yii\helpers\ArrayHelper;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'VG Insurance', 'url' => ['index']];
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

    <!--<h1><= Html::encode($this->title) ?></h1>-->
<?php
//print_r($agentNames);
?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 
                <h3 class="panel-title">
                    Company Name: <?= $model->company_name ?>
                </h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="12">  <div class="addrline"><span class="text"> Agent Details</span></div></th></tr>
                        <tr><th>Sl.No</th><th colspan="3" style="text-align : center">Agent Name</th><th colspan="3" style ="text-align : center">Official No</th><th colspan="2" style ="text-align : center">Personal No</th><th colspan="3" style ="text-align : center">E-mail ID</th></tr>
                        
                        <?php
                        $i=1;
                        foreach ($agentNames as $grnModel) {
                            $itemName = VgInsuranceAgents::find()->where(['id' => $grnModel->company_id])->one();
                            ?>
                        <tr style="text-align: left;"><td><?= $i ?></td><td colspan="3"><?= $grnModel->agent_name ?></td><td colspan="3"><?= $grnModel->official_contact_no ?></td><td colspan="2"><?= $grnModel->personal_contact_no ?></td><td colspan="3"><?= $grnModel->email_address ?></td></tr>
                        <?php  $i++; } ?>
                    </table>

                </div>
                <!-- <div class="col-lg-2 b" style="width:10%">r</div>-->
            </div>
        </div>
    </div>

</div>

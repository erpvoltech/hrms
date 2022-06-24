<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgInsuranceAgents;
use app\models\VgInsuranceCompany;
use app\models\VgInsurancePolicy;
use app\models\VgInsuranceMotherPolicy;
use app\models\VgInsuranceHierarchy;
use app\models\VgInsuranceEndorsement;
use app\models\VgInsuranceEndorsementHierarchy;
use yii\helpers\ArrayHelper;

$this->title = $model->policy_type;
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
                <h3 class="panel-title" style="text-align: center;">
                    <?php
                    if ($model->policy_type == 'GPA') {
                        echo $model->policy_type . '(Group Personal Accident)';
                    } else if ($model->policy_type == 'GMC') {
                        echo $model->policy_type . '(Group Medical Coverage)';
                    } else if ($model->policy_type == 'WC') {
                        echo $model->policy_type . "(Workmen's Compensation)";
                    }
                    ?><br>
                </h3>
        </div>
        <div class="panel-body" style="padding: 5px"> 

            <div class="row" style="width:100%">
                <!-- <div class="col-lg-4 b" style="width:10%">l</div>-->
                <div class="col-lg-8" style="width:100%"> 

                    <table class="table  table-condense" style="font-size:12px;" >
                        <tr class=" "><th colspan="12">  <div class="addrline"><span class="text"> Policy Details</span></div></th></tr>
                        <tr><th>ISP Name</th><th>Agent Name</th><th>Policy No</th><th style="width:8%"> Valid From </th><th style="width:8%"> Valid To </th><th style="width:10%">Premium Paid</th><th style="width:10%">Remarks</th><th style="width:8%">Endorsement</th></tr>
                        <?php
                        foreach ($motherPolicy as $motherModel) {
                            $ispName = VgInsuranceCompany::find()->where(['id' => $motherModel->insurance_comp_id])->one();
                            $ispAgent = VgInsuranceAgents::find()->where(['id' => $motherModel->insurance_agents_id])->one();
                            $insuranceHierarchy = VgInsuranceHierarchy::find()->where(['master_policy_id' => $motherModel->id])->one();
                            ?>
                            <tr style="text-align: left;">
                                <td><?= $ispName->company_name ?></td><td><?= $ispAgent->agent_name ?></td>
                                <td><!-- $motherModel->policy_no -->
                                    <?php
                                    
                                    echo Html::a($motherModel->policy_no, \yii::$app->homeUrl . '/vg-insurance-mother-policy/policyhierarchy?id=' . $insuranceHierarchy->id, ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold']) . '<br>';
                                    ?>
                                </td>
                                <td><?= date('d.m.Y', strtotime($motherModel->from_date)) ?></td><td><?= date('d.m.Y', strtotime($motherModel->to_date)) ?></td><td style="text-align: right;"><?= $motherModel->premium_paid ?></td><td><?= $motherModel->remarks ?></td>
                                <td>
                                    <?php
                                    echo Html::a('Add', \yii::$app->homeUrl . '/vg-insurance-endorsement/create?id=' . $motherModel->id, ['target' => '_blank', 'style' => 'color:#000']) . '<br>';
                                    ?>
                                </td>
                            </tr>
                        <?php 
                        $endorsementPolicy = VgInsuranceEndorsement::find()->where(['mother_policy_id' => $motherModel->id])->all();
                        foreach ($endorsementPolicy as $endorsementModel) {
                            $endorsementHierarchy = VgInsuranceEndorsement::find()->where(['id' => $endorsementModel->id])->one();
                            ?>
                            <tr style="text-align: left;">
                                <td colspan="2"></td>
                                <td>
                                    <?php
                                    //echo $endorsementModel->endorsement_no;
                                    echo Html::a($endorsementModel->endorsement_no, \yii::$app->homeUrl . '/vg-insurance-endorsement/endorsementhierarchy?id=' . $endorsementHierarchy->id, ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold']) . '<br>';
                                    ?>
                                </td>
                                <td><?= date('d.m.Y', strtotime($endorsementModel->start_date)) ?></td><td><?= date('d.m.Y', strtotime($endorsementModel->end_date)) ?></td><td style="text-align: right;"><?= $endorsementModel->endorsement_premium_paid ?></td>
                            </tr>
                        <?php } } ?>    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

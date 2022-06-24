<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgGmcEndorsement;
use app\models\VgGmcEndorsementHierarchy;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VgGmcPolicy */

$this->title = $model->policy_no;
$this->params['breadcrumbs'][] = ['label' => 'VG GMC Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    /*.b{
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
    }*/
tr {
        line-height: 10px;
        min-height: 10px;
        height: 10px;
    }
</style>
<div class="vg-gmc-policy-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">GMC View</font>
        </div>
        <div class="panel-body" style="padding: 5px"> 
            <div class="row">
                <div class="col-md-12"> 
                    <table style="font-size:12px;" >
                        <tr>
                            <th >Policy Name</th><td> <?= $model->policy_name ?> </td>
                            <th >ISP Name</th><td style="width:300px"> <?= $model->company->company_name ?> </td>
                            <th >Agent Name</th><td> <?= $model->agent->agent_name ?> </td>
                            <th >Policy No</th><td> <?= $model->policy_no ?> </td>
                        </tr>
                        <tr>
                            <th >Valid From</th><td> <?= date('d.m.Y', strtotime($model->from_date)) ?> </td>
                            <th >Valid To</th><td> <?= date('d.m.Y', strtotime($model->to_date)) ?> </td>
                            <th >Premium Paid</th><td> <?= $model->premium_paid ?> </td>
                            <th >Remarks</th><td> <?= $model->remarks ?> </td>
                        </tr>
                    
                        <tr><td colspan="8" style="font-size: 1em; font-weight: bold; color: #31708f; background-color: #d9edf7;">GMC Hierarchy</td></tr>
                        <tr><th colspan="3" style="text-align : right">Sum Insured</th><th colspan="3" style ="text-align : right">Fellow Share</th><th colspan="2" style ="text-align : right">Age Group</th></tr>
                        <?php foreach ($gmcItem as $gmcModel){ ?>
                        <tr style="text-align: right;">
                            <td colspan="3"><?= $gmcModel->sum_insured ?></td>
                            <td colspan="3"><?= $gmcModel->fellow_share ?></td>
                            <td colspan="2"><?= $gmcModel->age_group ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th>Endorsement</th>
                            <td colspan="8" style="font-weight: bold;">
                                <?php
                                echo Html::a('Add', \yii::$app->homeUrl . 'vg-gmc-endorsement/create?id=' . $model->id.'&ispid='.$model->insurance_comp_id, ['target' => '_blank', 'style' => 'color:red']) . '<br>';
                                ?>
                            </td>
                        </tr>
                        <tr><td colspan="8" style="font-size: 1em; font-weight: bold; color: #31708f; background-color: #d9edf7;">GMC Endorsement List</td></tr>
                        <tr>
                                <th colspan="2">Endorsement No</th>
                                <th>Valid From</th>
                                <th>Valid To</th>
                                <th colspan="2" style="text-align: right;">Premium Paid</th>
                                <th>View/Edit</th>
                                <th>Annexure</th>
                            </tr>
                        <?php
                        $endorsementPolicy = VgGmcEndorsement::find()->where(['gmc_mother_policy_id' => $model->id])->all();
                        foreach ($endorsementPolicy as $endorsementModel) {
                            $endorsementHierarchy = VgGmcEndorsementHierarchy::find()->where(['id' => $endorsementModel->id])->one();
                            ?>
                            
                            <tr style="text-align: left;">
                                <td colspan="2">
                                    <?php
                                    echo $endorsementModel->endorsement_no
                                    //echo Html::a($endorsementModel->endorsement_no, \yii::$app->homeUrl . 'vg-gpa-endorsement/endorsementhierarchy?id=' . $endorsementHierarchy->id, ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold']) . '<br>';
                                    ?>
                                </td>
                                <td><?= date('d.m.Y', strtotime($endorsementModel->start_date)) ?></td>
                                <td><?= date('d.m.Y', strtotime($endorsementModel->end_date)) ?></td>
                                <td colspan="2" style="text-align: right;"><?= $endorsementModel->endorsement_premium_paid ?></td>
                                <td >
                                    <?php
                                    echo Html::a('View/Edit', \yii::$app->homeUrl . 'vg-gmc-endorsement/index', ['target' => '_blank', 'style' => 'color:#000']) . '<br>';
                                    //echo Html::a($endorsementModel->endorsement_no, \yii::$app->homeUrl . 'vg-gpa-endorsement/update?id=' . $endorsementHierarchy->id);//, ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold']) . '<br>';
                                    ?>
                                </td>
                                <td >
                                    <?php
                                    echo Html::a('View', \yii::$app->homeUrl . 'vg-gmc-endorsement/gmcendoannexure?id='. $endorsementModel->endorsement_no, ['target' => '_blank', 'style' => 'color:#000']) . '/'.Html::a('Export', \yii::$app->homeUrl . 'vg-gmc-endorsement/exportgmcendoannexdata?id='. $endorsementModel->endorsement_no) . '<br>';
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VgGpaPolicy */

$this->title = $model->policy_no;
$this->params['breadcrumbs'][] = ['label' => 'GPA Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->policy_no;
?>
<style>
    /*   .b{
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
<div class="vg-gpa-policy-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">GPA View</font>
        </div>
        <div class="panel-body" style="padding: 3px"> 
            <div class="row">
                <div class="col-md-12"> 
                    <table style="font-size:12px;" >
                        <tr>
                            <th >Policy Name</th><td colspan="4"> <?= $model->policy_name ?> </td>
                            <th >ISP Name</th><td colspan="4"> <?= $model->company->company_name ?> </td>
                            <th >Agent Name</th><td colspan="4"> <?= $model->agent->agent_name ?> </td>
                        </tr>
                        <tr>
                            <th >Policy No</th><td colspan="4"> <?= $model->policy_no ?> </td>
                            <th >Valid From</th><td colspan="4"> <?= date('d.m.Y', strtotime($model->from_date)) ?> </td>
                            <th >Valid To</th><td colspan="4"> <?= date('d.m.Y', strtotime($model->to_date)) ?> </td>
                        </tr>
                        <tr>
                            <th >Premium Paid</th><td colspan="4"> <?= $model->premium_paid ?> </td>
                            <th >Remarks</th><td colspan="4"> <?= $model->remarks ?> </td>
                            <th >GPA Type</th><td colspan="4"> <?= $model->gpa_type ?> </td>
                        </tr>
                        <tr><td colspan="12" style="font-size:1em; font-weight: bold; color: #31708f; background-color: #d9edf7;">GPA Hierarchy</td></tr>
                        <tr><th colspan="6" style="text-align : right">Sum Insured</th><th colspan="6" style ="text-align : right">Fellow Share</th></tr>
                        <?php foreach ($gpaItem as $gpaModel) { ?>
                            <tr style="text-align: right;"><td colspan="6"><?= $gpaModel->sum_insured ?></td><td colspan="6"><?= $gpaModel->fellow_share ?></td></tr>
                        <?php } ?>
                        <tr>
                            <th>Endorsement</th>
                            <td colspan="12" style="font-weight: bold;">
                                <?php
                                echo Html::a('Add', \yii::$app->homeUrl . 'vg-gpa-endorsement/create?id=' . $model->id, ['target' => '_blank', 'style' => 'color:red']) . '<br>';
                                ?>
                            </td>
                        </tr>

                        <tr><td colspan="12" style="font-size: 1em; font-weight: bold; color: #31708f; background-color: #d9edf7;">GPA Endorsement List</td></tr>
                        <tr>
                                <th colspan="3">Endorsement No</th>
                                <th >Valid From</th>
                                <th >Valid To</th>
                                <th colspan="3" style="text-align: right;">Premium Paid</th>
                                <th colspan="2">View/Edit</th>
                                <th colspan="2">Annexure</th>
                            </tr>
                        <?php
                        $endorsementPolicy = VgGpaEndorsement::find()->where(['gpa_mother_policy_id' => $model->id])->all();
                        foreach ($endorsementPolicy as $endorsementModel) {
                            $endorsementHierarchy = VgGpaEndorsementHierarchy::find()->where(['id' => $endorsementModel->id])->one();
                            ?>
                            
                            <tr style="text-align: left;">
                                <td colspan="3">
                                    <?php
                                    echo $endorsementModel->endorsement_no
                                    //echo Html::a($endorsementModel->endorsement_no, \yii::$app->homeUrl . 'vg-gpa-endorsement/endorsementhierarchy?id=' . $endorsementHierarchy->id, ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold']) . '<br>';
                                    ?>
                                </td>
                                <td ><?= date('d.m.Y', strtotime($endorsementModel->start_date)) ?></td>
                                <td ><?= date('d.m.Y', strtotime($endorsementModel->end_date)) ?></td>
                                <td colspan="3" style="text-align: right;"><?= $endorsementModel->endorsement_premium_paid ?></td>
                                <td colspan="2">
                                    <?php
                                    echo Html::a('View/Edit', \yii::$app->homeUrl . 'vg-gpa-endorsement/index', ['target' => '_blank', 'style' => 'color:#000']) . '<br>';
                                    //echo Html::a($endorsementModel->endorsement_no, \yii::$app->homeUrl . 'vg-gpa-endorsement/update?id=' . $endorsementHierarchy->id);//, ['target' => '_blank', 'style' => 'color:#0000FF; font-weight: bold']) . '<br>';
                                    ?>
                                </td>
                                <td colspan="2">
                                    <?php
                                    echo Html::a('View', \yii::$app->homeUrl . 'vg-gpa-endorsement/gpaendoannexure?id='. $endorsementModel->endorsement_no, ['target' => '_blank', 'style' => 'color:#000']) . '/'.Html::a('Export', \yii::$app->homeUrl . 'vg-gpa-endorsement/exportgpaendoannexdata?id='. $endorsementModel->endorsement_no) . '<br>';
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





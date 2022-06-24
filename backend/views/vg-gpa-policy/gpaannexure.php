<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
use app\models\VgGpaPolicy;
use app\models\VgGpaHierarchy;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Division;
use common\models\EmpStatutorydetails;
use yii\helpers\ArrayHelper;

error_reporting(0);
?>
<style>
    tr {
        line-height: 10px;
        min-height: 10px;
        height: 10px;
    }
</style>
<div class="vg-gpa-policy-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <font style="font-weight: bold; font-size: 1em;">GPA Annexure</font>
        </div>
        <div class="panel-body" style="padding: 3px"> 
            <div class="row">
                <div class="col-md-12"> 
                    <table style="font-size:12px;" >
                        <tr>
                            <th>Emp Code</th>
                            <th>Emp Name</th>
                            <th>Designation</th>
                            <th>Division</th>
                            <th>GPA Type</th>
                            <th>Policy No</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Fellow Share</th>
                           
                        </tr>
                        <?php
                        foreach ($statuory as $statuoryModel) {
                            $emp = EmpDetails::find()->where(['id' => $statuoryModel->empid])->one();
                            $designation = Designation::find()->where(['id' => $emp->designation_id])->one();
                            $division = Division::find()->where(['id' => $emp->division_id])->one();
                            $gpaModel = VgGpaPolicy::find()->where(['policy_no' => $statuoryModel->gpa_no])->one();
                            $gpaHierarchy = VgGpaHierarchy::find()->where(['sum_insured' => $statuoryModel->gpa_sum_insured])->one();
                            ?>
                            <tr>
                                <td><?= $emp->empcode; ?></td>
                                <td><?= $emp->empname; ?></td>
                                <td><?= $designation->designation; ?></td>
                                <td><?= $division->division_name; ?></td>
                                <td><?= $gpaModel->gpa_type; ?></td>
                                <td><?= $statuoryModel->gpa_no; ?></td>
                                <td><?= date('d.m.Y', strtotime($gpaModel->from_date)); ?></td>
                                <td><?= date('d.m.Y', strtotime($gpaModel->to_date)); ?></td>
                                <td style="text-align: right;"><?= $statuoryModel->gpa_sum_insured; ?></td>
                                <td style="text-align: right;"><?= $gpaHierarchy->fellow_share; ?></td>
                            </tr>
                        <?php  } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


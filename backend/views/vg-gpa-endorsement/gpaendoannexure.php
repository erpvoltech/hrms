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
use common\models\Unit;
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
            <font style="font-weight: bold; font-size: 1em;">GPA Endorsement Annexure</font>
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
                            <th>Unit</th>
                            <th>Policy No</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Fellow Share</th>
                        </tr>
                        <?php
                        foreach ($endoStatuory as $statuoryModel) {
                            $emp = EmpDetails::find()->where(['id' => $statuoryModel->empid])->one();
                            $designation = Designation::find()->where(['id' => $emp->designation_id])->one();
                            $division = Division::find()->where(['id' => $emp->division_id])->one();
                            $unit = Unit::find()->where(['id' => $emp->unit_id])->one();
                            $gpaModel = VgGpaEndorsement::find()->where(['endorsement_no' => $statuoryModel->gpa_no])->one();
                            $gpaHierarchy = VgGpaEndorsementHierarchy::find()->where(['endorsement_sum_insured' => $statuoryModel->gpa_sum_insured])->one();
                            ?>
                            <tr>
                                <td><?= $emp->empcode ?></td>
                                <td><?= $emp->empname ?></td>
                                <td><?= $designation->designation ?></td>
                                <td><?= $division->division_name ?></td>
                                <td><?= $unit->name ?></td>
                                <td><?= $statuoryModel->gpa_no ?></td>
                                <td><?= date('d.m.Y', strtotime($gpaModel->start_date)) ?></td>
                                <td><?= date('d.m.Y', strtotime($gpaModel->end_date)) ?></td>
                                <td><?= $statuoryModel->gpa_sum_insured ?></td>
                                <td><?= $gpaHierarchy->endorsement_fellow_share ?></td>
                            </tr>
<?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


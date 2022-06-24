<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\VgGmcEndorsement;
use app\models\VgGmcEndorsementHierarchy;
use app\models\VgGmcPolicy;
use app\models\VgGmcHierarchy;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Division;
use common\models\Unit;
use common\models\EmpStatutorydetails;
use common\models\EmpFamilydetails;
use yii\helpers\ArrayHelper;
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
            <font style="font-weight: bold; font-size: 1em;">GMC Endorsement Annexure</font>
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
                            <th>Age Group</th>
                        </tr>
                        <?php
                        foreach ($endoStatuory as $statuoryModel) {
                            $emp = EmpDetails::find()->where(['id' => $statuoryModel->empid])->one();
                            $designation = Designation::find()->where(['id' => $emp->designation_id])->one();
                            $division = Division::find()->where(['id' => $emp->division_id])->one();
                            $unit = Unit::find()->where(['id' => $emp->unit_id])->one();
                            $gpaModel = VgGmcEndorsement::find()->where(['endorsement_no' => $statuoryModel->gmc_no])->one();
                            $gpaHierarchy = VgGmcEndorsementHierarchy::find()->where(['endorsement_sum_insured' => $statuoryModel->gmc_sum_insured])->one();
                            $gmcEndoAge = VgGmcEndorsementHierarchy::find()->where(['endorsement_age_group' => $statuoryModel->age_group])->one();
							//print_r($gpaHierarchy);
							if($gpaHierarchy){
								$fellow = $gpaHierarchy->endorsement_fellow_share;
								}else{
								 $fellow ="";
								
								}
								if($gmcEndoAge){
								$age = $gmcEndoAge->endorsement_age_group;
								}else{
								 $age = "";
								
								}
							
                            ?>
                            <tr>
                                <td><?= $emp->empcode; ?></td>
                                <td><?= $emp->empname; ?></td>
                                <td><?= $designation->designation; ?></td>
                                <td><?= $division->division_name; ?></td>
                                <td><?= $unit->name ?></td>
                                <td><?= $statuoryModel->gmc_no; ?></td>
                                <td><?= date('d.m.Y', strtotime($gpaModel->start_date)); ?></td>
                                <td><?= date('d.m.Y', strtotime($gpaModel->end_date)); ?></td>
                                <td><?= $statuoryModel->gmc_sum_insured;?></td>
                                <td><?= $fellow; ?></td>
                                <td><?= $age; ?></td>
                            </tr>
                            <?php
                            $gmcDependent = EmpFamilydetails::find()->where("empid = $emp->id AND gmc_no!=''")->all();
                            foreach ($gmcDependent as $dependent) {
                                ?>
                                <tr>
                                    <td style="color: #0033ff;"><?= $emp->empname ?>/Dependent</td>
                                    <td><?= $dependent->name ?></td>  
                                    <td><?= $dependent->relationship ?></td>
                                    <td></td>
                                    <td><?= $dependent->gmc_no; ?></td>
                                    <td><?= date('d.m.Y', strtotime($gpaModel->start_date)); ?></td>
                                    <td><?= date('d.m.Y', strtotime($gpaModel->end_date)); ?></td>
                                    <td><?= $dependent->sum_insured; ?></td>
                                    <td></td>
									<td></td>
                                    <td><?= $dependent->age_group; ?></td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


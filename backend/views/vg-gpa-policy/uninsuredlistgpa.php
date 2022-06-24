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
use yii\widgets\LinkPager;
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
            <font style="font-weight: bold; font-size: 1em;">GPA Uninsured List</font>
        </div>
        <div class="panel-body" style="padding: 3px"> 
            <div class="row">
                <div class="col-md-12"> 
                    <table style="font-size:12px;" >
                        <tr>
                            <th style="text-align : left">Sl.No</th>
                            <th style="text-align : left">Emp Code</th>
                            <th style="text-align : left">Emp Name</th>
                            <th style="text-align : left">Designation</th>
                            <th style="text-align : left">Division</th>
                        </tr>
                            <?php 
                            $i=1;
                            foreach ($models as $statuoryModel) {
                                $emp = EmpDetails::find()->where(['id' => $statuoryModel->empid, 'status' => 'Active'])->one();
                                $designation = Designation::find()->where(['id' => $emp->designation_id])->one();
                                $division = Division::find()->where(['id' => $emp->division_id])->one();
                            ?>
                        <tr>
                            <td style="text-align : left"><?= $i ?></td>
                            <td style="text-align: left;"><?= $emp->empcode; ?></td>
                            <td style="text-align: left;"><?= $emp->empname; ?></td>
                            <td style="text-align: left;"><?= $designation->designation; ?></td>
                            <td style="text-align: left;"><?= $division->division_name; ?></td>
                        </tr>
                        <?php $i++; } ?>
                        
                    </table>
                    <?php
   // display pagination
   echo LinkPager::widget([
      'pagination' => $pages,
   ]);
?>
                </div>
            </div>
        </div>
    </div>
</div>


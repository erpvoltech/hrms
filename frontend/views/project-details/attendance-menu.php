<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ProjectDetails;
use common\models\User;
use common\models\AttendanceAccessRule;
use common\models\EmpDetails;
use common\models\Division;
use common\models\Unit;
use common\models\UnitGroup;
use common\models\EngineerAttendance;
error_reporting(0);
?>

<h2>Welcome</h2>


<?php
$modelEmpcount = 0;
foreach ($model as $att) {
	$unit = unit::findOne($att->unit);
	$division = division::findOne($att->division);
	if (Yii::$app->user->identity->role == 'project admin') {
		$Unitgroup = UnitGroup::find()->where(['unit_id' => $att->unit])->all();
		foreach ($Unitgroup as $group) {
			$unit_one = unit::find()->where(['id' => $group->unit_id])->one();
			$div_one = Division::find()->where(['id' => $group->division_id])->one();
			$modelEmpcount  += EmpDetails::find()->where(['division_id' => $div_one->id, 'unit_id' => $unit_one->id, 'status' => 'Active'])
			->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->count();
		}
	} else {
		$modelEmpcount  += EmpDetails::find()->where(['division_id' => $division->id, 'unit_id' => $unit->id, 'status' => 'Active'])
		->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->count();
		}
}
?>

<div class="project-details-attendance-menu">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4">
				<h1>Total Employee</h1>
				<?php
				echo "<h2>$modelEmpcount</h2>";
				?>
				<?php if (Yii::$app->user->identity->role == 'project admin'){
				echo '<h4><a href="index.php?r=project-details/mis-view&ec=">viewlist</a></h4>';
				}else{
				echo '<h4><a href="index.php?r=project-details/employee-list">viewlist</a></h4>';
				 }?>

			</div>
			<div class="col-sm-4">
				<h1>Active Projects</h1>
				<?php
				$project = ProjectDetails::find()->where(['project_status' => 'Active'])->count();
				echo "<h2>$project</h2>";
				?>
				<?php if (Yii::$app->user->identity->role == 'project admin'){
				echo '<h4><a href="index.php?r=project-details%2Findex">viewlist</a></h4>';
				}else{
				echo '<h4><a href="index.php?r=project-details/project-list">viewlist</a></h4>';
				 }?>
				
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<?php
				if (Yii::$app->user->identity->role == 'project admin' || Yii::$app->user->identity->role == 'unit users') {
					echo '<h4><a href="index.php?r=project-details/attendance-index">Cast Attendance</a></h4>';
				}
				if (Yii::$app->user->identity->role == 'project admin') {
					//echo '<h4><a href="#">Change Division</a></h4>';
					echo '<h4><a href="index.php?r=project-details/engineerlist-projectadmin&ec=">Unit Transfer </a></h4>';
					//echo '<h4><a href="index.php?r=project-details/mis-view&ec=">MIS</a></h4>';
					echo '<h4><a href="index.php?r=project-details/attendancereport-project">Project Wise Attendance Report</a></h4>';
					echo '<h4><a href="index.php?r=project-details/po-create">Po Create</a></h4>';
					echo '<h4><a href="index.php?r=project-details/invoice-create">Invoice</a></h4>';
					echo '<h4><a href="index.php?r=project-details/compliance-report">Compliance Report</a></h4>';
					
				}
				//if (Yii::$app->user->identity->role == 'project admin') {
				//	echo '<h4><a href="index.php?r=project-details%2Findex">Project Create</a></h4>';
				//}
				echo '<h4><a href="index.php?r=project-details/attendance-report">Attendance Report</a></h4>';
				echo '<h4><a href="index.php?r=project-details/ot-report">OT Report</a></h4>';
				?>
			</div>
			<div class="col-sm-4">
				<br>
				<?php
				$modelAtt = EngineerAttendance::find()->orderBy([
					'date' => SORT_DESC,
				])->one();

				foreach ($model as $att) {

					$unit = unit::findOne($att->unit);
					$division = division::findOne($att->division);
					//if (Yii::$app->user->identity->role == 'attendance admin') {
						/*	$Unitgroup = UnitGroup::find()->where(['unit_id'=>$att->unit])->all();
						foreach($Unitgroup as $group){
						$unit_one = unit::find()->where(['id'=>$group->unit_id])->one();		
						$div_one = Division::find()->where(['id'=>$group->division_id])->one();
						$modelEmp = EmpDetails::find()->where(['division_id'=>$division->id,'unit_id'=>$unit->id,'status'=>'Active'])->all();
						foreach($modelEmp as $list){
						echo '<tr>
						<td>'.$slno.'</td>
						<td>'.$list->empcode.'</td>
					   <td>'.$list->empname.'</td>
					   <tr>';	
					   $slno++;
						}	 
					 } */
					//} else {
						$ids = array();
						$modelEmp = EmpDetails::find()->where(['division_id' => $division->id, 'unit_id' => $unit->id])->all();
						foreach ($modelEmp as $item) {
							$ids[] = $item->id;
						}
					//}
				}
				$present = EngineerAttendance::find()->where(['date' => $modelAtt->date, 'attendance' => 'Present'])->andWhere(['IN', 'emp_id', $ids])->count();
				$Travel = EngineerAttendance::find()->where(['date' => $modelAtt->date, 'attendance' => 'Travel'])->andWhere(['IN', 'emp_id', $ids])->count();
				$Idle = EngineerAttendance::find()->where(['date' => $modelAtt->date, 'attendance' => 'Idle'])->andWhere(['IN', 'emp_id', $ids])->count();
				$HO = EngineerAttendance::find()->where(['date' => $modelAtt->date, 'attendance' => 'HO'])->andWhere(['IN', 'emp_id', $ids])->count();
				$Leave = EngineerAttendance::find()->where(['date' => $modelAtt->date, 'attendance' => 'Leave'])->andWhere(['IN', 'emp_id', $ids])->count();
				$Absent = EngineerAttendance::find()->where(['date' => $modelAtt->date, 'attendance' => 'Absent'])->andWhere(['IN', 'emp_id', $ids])->count();
				$WO = EngineerAttendance::find()->where(['date' => $modelAtt->date, 'attendance' => 'WO'])->andWhere(['IN', 'emp_id', $ids])->count();

				?>
				<h1>Attendance Summary</h1>
				<table>
					<tr>
						<td colspan="2"> Attendance Date : <?= $modelAtt->date ?>
					</tr>
					<tr>
						<td> Present</td>
						<td><?= $present ?></td>
					</tr>
					<tr>
						<td> Travel</td>
						<td><?= $Travel ?></td>
					</tr>
					<tr>
						<td> Idle</td>
						<td><?= $Idle ?></td>
					</tr>
					<tr>
						<td> HO</td>
						<td><?= $HO ?></td>
					</tr>
					<tr>
						<td> Leave</td>
						<td><?= $Leave ?></td>
					</tr>
					<tr>
						<td> WO</td>
						<td><?= $WO ?></td>
					</tr>
					<tr>
						<td> Absent</td>
						<td><?= $Absent ?></td>
					</tr>
				</table>
			<br>
			</div>
		<div class="col-sm-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Probationary Period</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div> 
                    <!-- /.box-header -->
                    <div class="box-body">                  
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-list"></i></span>

                            <div class="info-box-content">  
							<div class="col-md-2" style="margin-top:15px"><?php echo '<button class="btn btn-success" id="export">Export</button>';?></div>

                                <?php
								
								
								echo '<div class="row">';
                                echo '<table id="table2excel">';
                                echo '<tr><th>ECode</th><th>Name</th><th>DoJ</th><th>Days</th><th>Probation</th></tr>';
								$model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
								foreach($model as $emp){
								
								//print_r($emp->unit);
								
                                $connection = \Yii::$app->db;
								if (Yii::$app->user->identity->role == 'project admin') {
                                $command = $connection->createCommand("SELECT empcode,empname,category,unit_id,doj,DATEDIFF(CURDATE(), doj) AS days,probation FROM emp_details WHERE probation IS NOT NULL AND probation <> '' AND status='Active' AND unit_id=".$emp->unit." AND category IN('International Engineer','Domestic Engineer') ORDER BY doj ASC");
								}else{
								 $command = $connection->createCommand("SELECT empcode,empname,category,unit_id,division_id,doj,DATEDIFF(CURDATE(), doj) AS days,probation FROM emp_details WHERE probation IS NOT NULL AND probation <> '' AND status='Active' AND division_id=".$emp->division." AND unit_id=".$emp->unit." AND category IN('International Engineer','Domestic Engineer') ORDER BY doj ASC");
								}
                                $result = $command->queryAll();
								//print_r($result->unit_id);
                                foreach ($result as $duration) {
                                    $probationMonths = strtolower(str_replace(' ', '', $duration['probation']));
									//print_r($probationMonths);
                                    if ($probationMonths == 'oneyear' || $probationMonths == '1year') {
                                        if ($duration['days'] >= 335 && $duration['days'] <= 365) {
                                            //echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            //echo '</div>';
                                        }
                                    } else if ($probationMonths == 'ninemonths') {
                                        if ($duration['days'] >= 240 && $duration['days'] <= 270) {
                                            //echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            //echo '</div>';
                                        }
                                    } else if ($probationMonths == 'sixmonths' || $probationMonths == '6months') {
                                        if ($duration['days'] >= 150 && $duration['days'] <= 180) {
                                            //echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            //echo '</div>';
                                        }
                                    } else if ($probationMonths == 'fourmonths') {
                                        if ($duration['days'] >= 90 && $duration['days'] <= 120) {
                                            //echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            //echo '</div>';
                                        }
                                    } else if ($probationMonths == 'threemonths') {
                                        if ($duration['days'] >= 60 && $duration['days'] <= 90) {
                                            //echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            //echo '</div>';
                                        }
                                    }
                                }
								}
                                echo '</table>';
                                echo '</div>';
								
                                ?>

                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <!-- /.box-footer -->
                </div>
            </div>
		</div>
	</div>


</div><!-- project-details-attendance-menu -->
<?php
$script = <<< JS

$("#export").click(function(){
 $("#table2excel").table2excel({					
					name: "Probation Report",
					filename: "Probation Report",
					fileext: ".xlsx",					
	});
});
JS;
$this->registerJs($script);
?>
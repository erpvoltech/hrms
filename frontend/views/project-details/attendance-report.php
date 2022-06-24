<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Unit;
use common\models\Division;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\EngineerAttendance;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\UnitGroup;
use kartik\select2\Select2;
ini_set('max_execution_time', 0);
ini_set("memory_limit", "1024M");
error_reporting(0);

$model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
if(Yii::$app->user->identity->role=='unit admin'){
	foreach($model as $item){		
		$Unitgroup = UnitGroup::find()->where(['unit_id'=>$item->unit])->all();
		foreach($Unitgroup as $group){
		$division_ids[] = $group->division_id;
		}	
		$unit_ids[] = $item->unit;
}
	
} else {
foreach ($model as $item) {
    $division_ids[] = $item->division;
    $unit_ids[] = $item->unit;
}
}
$unitData = ArrayHelper::map(Unit::find()->where(['IN', 'id', $unit_ids])->all(), 'id', 'name');
$divData = ArrayHelper::map(Division::find()->where(['IN', 'id', $division_ids])->all(), 'id', 'division_name');
#print_r($unitData);

if ($_GET['dt']) {
    $todate = Yii::$app->formatter->asDate($_GET['dt'], "yyyy-MM-dd");
} else {
    $todate = date('Y-m-d');
}
if ($_GET['df']) {
    $fromdate = Yii::$app->formatter->asDate($_GET['df'], "yyyy-MM-dd");
} else {
    $fromdate = date('Y-m-d');
}

if ($_GET['uid']) {
    $unit = $_GET['uid'];
} else {
    foreach ($unitData as $id_u => $d_name) {
        $unit = $id_u;
        break;
    }
}
if ($_GET['did']) {
    $divsion = $_GET['did'];
} else {
    foreach ($divData as $id_d => $d_name) {
        $divsion = $id_d;
        break;
    }
}

?>

<div class="row">
    <div class="col-md-2"> Date From<?= yii\jui\DatePicker::widget([
                                        'id'  => 'from_date',
                                        'dateFormat' => 'dd-MM-yyyy',
                                        'value' => $fromdate,
                                    ]); ?></div>
    <div class="col-md-2"> To<?= yii\jui\DatePicker::widget([
                                    'id'  => 'to_date',
                                    'dateFormat' => 'dd-MM-yyyy',
                                    'class' => 'form-control',
                                    'value' => $todate,
                                ]); ?></div>
    <div class="col-md-2" style="margin-right:20px"> Unit
        <select id="ut" class="form-control">
            <?php
            foreach ($unitData as $u_id => $uname) {
                echo '<option value="' . $u_id . '"';
                if ($unit == $u_id)
                    echo 'selected';
                echo  '>' . $uname . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-2" style="margin-right:40px"> Division
        <select id="dv" class="form-control">
            <?php
            foreach ($divData as $did => $dname) {
                echo '<option value="' . $did . '"';
                if ($divsion == $did)
                    echo 'selected';
                echo '>' . $dname . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="col-md-2" style="margin-top:15px"><button class=" btn btn-primary btn-md" id='go'>Go</button></div>
    <div class="col-md-2" style="margin-top:15px;margin-bottom:10px;"><?php echo '<button class="btn btn-success" id="export">Export</button>';?></div>
</div>
<div class="row" style="overflow-x: auto;">
    <table class="table"id="table2excel" border="2">
        <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>Ecode</th>
            <?php
            $end = date('Y-m-d', strtotime($todate . ' +1 day'));
            $daterange = new DatePeriod(new DateTime($fromdate), new DateInterval('P1D'), new DateTime($end));
            foreach ($daterange as $date) {
                echo '<th>' . $date->format("d") . '</th>';
            }
            echo '<th>P</th>';
            echo '<th>L</th>';
            echo '<th>I</th>';
            echo '<th>HO</th>';
            echo '<th>T</th>';
            echo '<th>A</th>';
            echo '<th>WO</th>';
			echo '<th>H</th>';
			echo '<th>FN</th>';
			echo '<th>AN</th>';
            echo '</tr>';
            $sl = 1;

             $EmpModel = EmpDetails::find()->where(['unit_id' => $unit, 'division_id' => $divsion])->andwhere(['!=','category','HO Staff'])->andwhere(['!=','category','BO Staff'])->all();
            foreach ($EmpModel as $emp) {
				
				
                $p = 0;
                $ab = 0;
                $idle = 0;
                $ho = 0;
                $t = 0;
                $l = 0;
                $wo = 0;
				$h = 0;
				$fn = 0;
				$an =0;
                if ($emp->last_working_date >= $fromdate || $emp->last_working_date == '') {
                    echo '<tr><td>' . $sl . '</td><td>' . $emp->empname . '</td><td>' . $emp->empcode . '</td>';
                    foreach ($daterange as $attdate) {
					
                       $EnggAttModel = EngineerAttendance::find()->where(['emp_id' => $emp->id, 'date' => $attdate->format("Y-m-d")])->one();
					   if($EnggAttModel) {
                        if ($EnggAttModel->attendance == 'Present') {
                            echo '<td bgcolor="#4CAF50">P</td>';
                            $p += 1;
                        } else if ($EnggAttModel->attendance == 'Idle') {
                            echo '<td>I</td>';
                            $idle += 1;
                        } else if ($EnggAttModel->attendance == 'HO') {
                            echo '<td>HO</td>';
                            $ho += 1;
                        } else if ($EnggAttModel->attendance == 'Leave') {
                            echo '<td>L</td>';
                            $l += 1;
                        } else if ($EnggAttModel->attendance == 'Travel') {
                            echo '<td>T</td>';
                            $t += 1;
                        } else if ($EnggAttModel->attendance == 'Absent') {
                            echo '<td bgcolor="#FF0000">A</td>';
                            $ab += 1;
                        }else if ($EnggAttModel->attendance == 'WO') {
                            echo '<td>WO</td>';
                            $wo += 1;
                        }else if ($EnggAttModel->attendance == 'H') {
                            echo '<td>H</td>';
                            $h += 1;
                        }else if ($EnggAttModel->attendance == 'FN') {
                            echo '<td>FN</td>';
                            $fn += 0.5;
                        }else if ($EnggAttModel->attendance == 'AN') {
                            echo '<td>AN</td>';
                            $an += 0.5;
                        } else {
                            echo '<td>N/A</td>';
                        }
} else {
  echo '<td>N/A</td>';
} 
                    }
                    echo '<td>' . $p . '</td><td>' . $l . '</td><td>' . $idle . '</td><td>' . $ho . '</td><td>' . $t . '</td><td>' . $ab . '</td><td>' . $wo . '</td><td>' . $h . '</td><td>' . $fn . '</td><td>' . $an . '</td>';
                    $sl++;
                }
            }

            ?>
    </table>
</div>

<?php
$script = <<< JS
$(document).ready(function(){	
    
	$('#go').click(function(event){	   
		window.location.href ="index.php?r=project-details/attendance-report&df="+ $('#from_date').val() +"&dt="+ $('#to_date').val()+"&uid="+$('#ut').val()+"&did="+$('#dv').val()
	});
	
});
$("#export").click(function(){
 $("#table2excel").table2excel({                    
                    name: "Attendance Report",
                    filename: "attendance-report",
                    fileext: ".xls",                    
    });
});
JS;
$this->registerJs($script);
?>
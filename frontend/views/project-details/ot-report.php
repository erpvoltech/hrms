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
use common\models\ProjectDetails;
use common\models\AttendanceAccessRule;
use common\models\UnitGroup;
use kartik\select2\Select2;

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
error_reporting(0);
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
	<div class="col-md-2" style="margin-top:15px"><?php echo '<button class="btn btn-success" id="export">Export</button>';?></div>
</div>
<div class="row" style="overflow-x: auto;">
    <table class="table" id="table2excel" border="2">
        <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>Ecode</th>
			<th>Project Code</th>
			<th>Date</th>
			<th>Over Time</th>
            <?php
            $sl = 1;
             $end = date('Y-m-d', strtotime($todate . ' +1 day'));
            $daterange = new DatePeriod(new DateTime($fromdate), new DateInterval('P1D'), new DateTime($end));

            $EmpModel = EmpDetails::find()->where(['unit_id' => $unit, 'division_id' => $divsion,'status'=>'Active'])->andwhere(['!=','category','HO Staff'])->andwhere(['!=','category','BO Staff'])->all();
            foreach ($EmpModel as $emp) {
              foreach($daterange as $attdate){
                //if ($emp->last_working_date >= $fromdate || $emp->last_working_date == '') {
					$Engatt = EngineerAttendance::find()->where(['emp_id'=>$emp->id,'date' => $attdate->format("Y-m-d")])->one();
					$pro_code = ProjectDetails::find()->where(['id'=>$Engatt->project_id])->one();
                    //print_r($Engatt->overtime);
                    //exit;
					if($Engatt->overtime!=NULL){
					
                    echo '<tr><td>' . $sl . '</td><td>' . $emp->empname . '</td><td>' . $emp->empcode . '</td><td>'. $pro_code->project_code .'</td><td>'. $Engatt->date .'</td><td>'. $Engatt->overtime .'</td>';
                   
                    $sl++;
                }
                }
                //}
            }

            ?>
    </table>
</div>

<?php
$script = <<< JS
$(document).ready(function(){	
    
	$('#go').click(function(event){	   
		window.location.href ="index.php?r=project-details/ot-report&df="+ $('#from_date').val() +"&dt="+ $('#to_date').val()+"&uid="+$('#ut').val()+"&did="+$('#dv').val()
	});
	
});
$("#export").click(function(){
 $("#table2excel").table2excel({					
					name: "Attendance Report",
					filename: "ot-report",
					fileext: ".xlsx",					
	});
});
JS;
$this->registerJs($script);
?>
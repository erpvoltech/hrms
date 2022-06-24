<?php
use yii\helpers\Html;
use common\models\Division;
use common\models\Unit;
use common\models\User;
use common\models\UnitGroup;
use common\models\AttendanceAccessRule;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;

$i =1;
$result=0;

?>
<style>
.table{
	width: 80%;
    max-width: 60%;
    margin-bottom: 20px;
}
</style>
<h2>Attendance</h2>
<br>
<table class="table table-striped"><tr><th style="width:10px;text-align:center;">Sl.No</th><th style="text-align:center;width:20px">Division</th><th style="text-align:center;width:10px">Date</th><th style="width:20px;text-align:center">Cast Attendance</th><th style="width:20px;text-align:center">View</th></tr>
<?php 
foreach($model as $att){
		
	$unit = unit::findOne($att->unit);
	$division = division::findOne($att->division);
	if(Yii::$app->user->identity->role=='project admin'){
		$Unitgroup = UnitGroup::find()->where(['unit_id'=>$att->unit])->all();
		
		foreach($Unitgroup as $key => $group){
		$unit_one = unit::find()->where(['id'=>$group->unit_id])->one();		
		$div_one = Division::find()->where(['id'=>$group->division_id])->one();
		echo "<tr><td style='text-align:center;'>".$i."</td><td> $unit_one->name.$div_one->division_name</td><td>".\yii\jui\DatePicker::widget( [ 'options' => ['class' => 'form-control','autocomplete'=>'off'],
					//'language' => 'ru',
					
					'dateFormat' => 'dd-MM-yyyy',
					/* 'clientOptions' =>[               
               'minDate' => '-2d',
			   'maxDate' => '+0d',
			   
            ],*/
				])
				."</td><td style='text-align:center;'><a href='#' onclick='return clickMark(".$unit_one->id.", ".$div_one->id.", ".$key.")'> Mark </a></td><td style='text-align:center;'><a href='index.php?r=project-details/attendance-view&uid=$unit_one->id&did=$div_one->id&dt=&ec=&pid=&att=&dff=&dtt'>View </a></td></tr>";
		$i++;
		}
	} else 
 {
	
	?>	
	<tr><td style="text-align:center"><?=$i?></td><td><?=$unit->name.'-->'.$division->division_name?></a></td><td><?=\yii\jui\DatePicker::widget( [ 'options' => ['class' => 'form-control','autocomplete'=>'off'],
					//'language' => 'ru',
					
					'dateFormat' => 'dd-MM-yyyy',
					/*'clientOptions' =>[               
              'minDate' => '-2d',
			   'maxDate' => '+0d',
			   
            ],*/
				])
				?></td><td style="text-align:center"><a href="#" onclick="return clickMark1(<?=$unit->id?>,<?=$division->id?>,<?=$result++?>)"> Mark </a></td><td style="text-align:center"><a href="index.php?r=project-details/attendance-view&uid=<?=$unit->id?>&did=<?=$division->id?>&dt=&ec=&pid=&att=&dff=&dtt=">View</a></td></tr>
	<?php
	$i++;
	}
}
?>
</table>
<script>
	function clickMark(u_id, div_id, date_id) {
	var date_i = $('#w'+date_id).val();
	if(date_i==''){
		alert("Please Choose The Date")
		return false;}else{
		location.href= "index.php?r=project-details/attendance&uid="+u_id+"&did="+div_id+"&att_date="+date_i;
		}
	}
	function clickMark1(u_id1, div_id1, date_id1) {
		//alert(clickMark1);
	var date_i1 = $('#w'+date_id1).val();
	if(date_i1==''){
		alert("Please Choose The Date")
		return false;}else{
		location.href= "index.php?r=project-details/attendance&uid="+u_id1+"&did="+div_id1+"&att_date="+date_i1;
		}
	}
</script>


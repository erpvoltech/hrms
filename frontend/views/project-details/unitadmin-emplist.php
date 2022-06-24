<?php
use yii\helpers\Html;
use common\models\Division;
use common\models\Unit;
use common\models\User;
use common\models\UnitGroup;
use common\models\AttendanceAccessRule;
use yii\helpers\ArrayHelper;

$i =1;

?>
<style>
.table{
	width: 40%;
    max-width: 40%;
    margin-bottom: 20px;
}
</style>
<h2>Engineer Transfer</h2>

<br>
<table class="table table-striped"><tr><th style="width:10px;text-align:center;">Sl.No</th><th style="text-align:center;width:20px">Division</th><th style="width:20px;text-align:center">Engg Transfer</th></tr>
<?php 
foreach($model as $att){
		
	$unit = unit::findOne($att->unit);
	//$division = division::findOne($att->division);
		$Unitgroup = UnitGroup::find()->where(['unit_id'=>$att->unit])->all();
		foreach($Unitgroup as $group){
		$unit_one = unit::find()->where(['id'=>$group->unit_id])->one();		
		$div_one = Division::find()->where(['id'=>$group->division_id])->one();
		echo "<tr><td style='text-align:center;'>".$i."</td><td> $unit_one->name.$div_one->division_name</td><td style='text-align:center;'><a href='index.php?r=project-details/engineer-list&id=".$div_one->id."'>list</a></td></tr>";
		$i++;
		}	
}
?>
</table>


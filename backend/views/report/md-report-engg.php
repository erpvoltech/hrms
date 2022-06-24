<?php
use yii\helpers\Html;
use common\models\Unit;
use common\models\UnitGroup;
use common\models\EmpDetails;
use common\models\Division;
use common\models\EmpSalary;
use yii\jui\DatePicker;	
use common\models\SalaryMonth;
use common\models\EmpRemunerationDetails;
error_reporting(0);

$modelUnit = Unit::find()->orderBy('id')->all();
$ModelEmp = EmpDetails::find()->one();
$salmonth = SalaryMonth::find()->orderBy(['id'=> SORT_DESC])->one();
$vgunit = Unit::find()->where(['id'=>$_GET['id']])->one();

	if($_GET['dt']){		
		$value = Yii::$app->formatter->asDate($_GET['dt'], "dd-MM-yyyy");		
	} else {	
		$value = Yii::$app->formatter->asDate($salmonth->month, "dd-MM-yyyy");		
	}
?>
<div class="row" style="padding:20px 0px">
	<div class=" col-md-2" align="right"><label class='control-label'>Select Month </label></div>
	<div class="col-md-3">		
		<?= DatePicker::widget([
		'name'  => 'month',	
		'id'  => 'month',	
		'value'  => $value, 
		'dateFormat' => 'MM-yyyy',
		'options' => ['class' => 'form-control']]);
         ?>
	</div>
	<div class=" col-md-2"> <?= Html::submitButton('Display', ['class' => 'btn btn-primary', 'name' => 'display', 'id'=>'display','value' => 'submit']) ?></div>
    <div class="form-group col-md-1">  <?= Html::submitButton('Export', ['class' => 'btn btn-danger', 'id' => 'export','name' => 'export', 'value' => 'reset']) ?>
	</div>
</div>

<div class="wizard">
   <ul class="steps" >
    <li ><a href="md-report?dt=<?=$value?>">Overall</a><span class="chevron"></span></li>
      <li ><a href="md-report-staff?dt=<?=$value?>">Staff</a><span class="chevron"></span></li>
		<?php foreach($modelUnit as $unit){
			if($_GET['id']== $unit->id) { ?>
				<li class="active"><?=$unit->name?><span class="chevron"></span></li>
				<?php } else { ?>
		<li ><a href="md-report-engg?id=<?=$unit->id?>&dt=<?=$value?>"><?=$unit->name?></a><span class="chevron"></span></li>
		<?php } }?>		
	
	</ul>
</div>

   <h1><?=$vgunit->name?> Employee Summary</h1>
	<table>
	 <thead>
		<tr><th>Sl. No</th><th >Unit</th><th >Engg. Strength</th><th >Gross Amount</th><th >Nett Salary</th><th >Nett Allowance Paid</th><th >CTC</th></tr>		
	</thead>
	<tbody>
	
	<?php		
	$divarry = array("Cluster A", "Cluster B", "Cluster C","Cluster D");
	$arrlength = count($divarry);
	$i=1;
	$totengg = 0;
	$totengg_gross = 0;
	$totengg_net = 0;
	$totengg_allowance = 0;
	$totengg_ctc = 0;
	//for($x = 0; $x < $arrlength; $x++) {
	$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$vgunit->id])->orderBy('priority')->all();
	//$division = Division::find()->where(['LIKE', 'division_name', $divarry[$x]])->all();
	foreach($UnitGroupModel as $groupmodel){	
		$div = Division::find()->Where(['id'=>$groupmodel->division_id])->One();	
		$engg_count =0;
		$engg_grossamt = 0;
		$engg_netamt = 0;
		$engg_paidallowance = 0;
		$engg_ctc = 0;
		
		$queryengg = EmpSalary::find()->joinWith('employee')
		->where(['emp_salary.division_id' => $div->id,'emp_salary.unit_id'=>$vgunit->id,'month'=>Yii::$app->formatter->asDate($value, "yyyy-MM-dd"),'emp_details.category'=>['International Engineer','Domestic Engineer']])
		//->andWhere(['IN','emp_salary.salary_structure',['Contract']])
		->all();
		
		foreach($queryengg as $EnggReport){
		$engg_count +=1;
		$remu = EmpRemunerationDetails::find()->where(['empid'=>$EnggReport->empid])->one();
		$engg_grossamt +=$remu->gross_salary;
		$engg_netamt += $EnggReport->net_amount;
		$engg_paidallowance += $EnggReport->paidallowance;
		$engg_ctc += $EnggReport->earned_ctc;
		}
		$totengg += $engg_count;
		$totengg_gross += $engg_grossamt;
		$totengg_net += $engg_netamt;
		$totengg_allowance += $engg_paidallowance;
		$totengg_ctc += $engg_ctc;
		if(!empty($engg_count)){
			echo '<tr><td>'.$i.'</td><td>'.$div->division_name.'</td>
			 <td>'.$engg_count.'</td><td align="right">'.$ModelEmp->moneyFormatIndia($engg_grossamt).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($engg_netamt).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($engg_paidallowance).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($engg_ctc).'</td>
			 </tr>';
			 $i++;
		}		
		}		
		
		?>
		<tr><td colspan="2" align="right">Total</td><td><?=$totengg?>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_gross)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_net)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_allowance)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_ctc)?></td>
			</tr>
	</tbody>
	</table>
<?php
$script = <<< JS
$("#display").click(function(){
	var mon = $("#month").val();
	window.location = "md-report?dt=01-"+mon;
});
$("#export").click(function(){
	var mon = $("#month").val();
	window.location = "md-report-export?dt=01-"+mon;
});
JS;
$this->registerJs($script);

?>
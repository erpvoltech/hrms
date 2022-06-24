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
use app\models\EmpSalarystructure;
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
    <li class="active">Overall<span class="chevron"></span></li>
	   <li ><a href="md-report-staff?dt=<?=$value?>">Staff</a><span class="chevron"></span></li>
	    <li ><a href="md-report-slot?dt=<?=$value?>">Salary Slot</a><span class="chevron"></span></li>
		<?php foreach($modelUnit as $unit){?>			
		<li ><a href="md-report-engg?id=<?=$unit->id?>&dt=<?=$value?>"><?=$unit->name?></a><span class="chevron"></span></li>
		<?php } ?>		
	
	</ul>
</div>

   <h1><?=$vgunit->name?> Employee Summary</h1>
	<table>
	 <thead>
		<tr><th rowspan="2">Sl. No</th><th rowspan="2">Unit</th><th colspan="5">Operation</th><th colspan="5">Engineers</th></tr>
		<tr><th >Manpower</th><th >Gross Salary</th><th >Nett Salary</th><th >CTC</th><th>Bank Transfer</th><th >Manpower</th><th >Gross Salary</th><th >Net Salary</th><th >CTC</th><th>Bank Transfer</th></tr>
		
	</thead>
	<tbody>
	
	<?php
	$i=1;
	$totengg = 0;
	$totengg_gross = 0;
	$totengg_net = 0;
	$totengg_allowance = 0;
	$totengg_ctc = 0;
	$totbank_amt =0;
	
	$totengg2 = 0;
	$totengg_gross2 = 0;
	$totengg_net2 = 0;
	$totengg_allowance2 = 0;
	$totengg_ctc2 = 0;
	$totbank_amt2 =0;
	
	$UnitModel = Unit::find()->all();
	foreach($UnitModel as $model_unit){	
			
		$engg_count =0;
		$engg_grossamt = 0;
		$engg_netamt = 0;
		$engg_paidallowance = 0;
		$engg_ctc = 0;
		$bank_amt1 =0;
		$bank_amt2 =0;
		
		$engg_count2 =0;
		$engg_grossamt2 = 0;
		$engg_netamt2 = 0;
		$engg_paidallowance2 = 0;
		$engg_ctc2 = 0;
		$bank_amt3 =0;
		$bank_amt4 =0;
		
		$queryengg = EmpSalary::find()->joinWith('employee')
		->where(['emp_salary.unit_id'=>$model_unit->id,'month'=>Yii::$app->formatter->asDate($value, "yyyy-MM-dd"),'emp_details.category'=>['HO Staff','BO Staff']])
		//->andWhere(['NOT IN','emp_salary.salary_structure',['Contract']])
		->all();
		
		$queryengg2 = EmpSalary::find()->joinWith('employee')
		->where(['emp_salary.unit_id'=>$model_unit->id,'month'=>Yii::$app->formatter->asDate($value, "yyyy-MM-dd"),'emp_details.category'=>['International Engineer','Domestic Engineer']])
		//->andWhere(['NOT IN','emp_salary.salary_structure',['Contract']])
		->all();
		
		foreach($queryengg as $EnggReport){
		$engg_count +=1;
		$remu = EmpRemunerationDetails::find()->where(['empid'=>$EnggReport->empid])->one();
		$engg_grossamt +=$remu->gross_salary;
		$engg_netamt += $EnggReport->net_amount;
		$engg_paidallowance += $EnggReport->paidallowance;
		$engg_ctc += $EnggReport->earned_ctc;
		
				
					$Salarystructure = EmpSalarystructure::find()
                 ->where(['salarystructure' => $remu->salary_structure])
                 ->one();
				 
					//if($data->employee->category == 'International Engineer'|| $data->employee->category == 'Domestic Engineer'){
					if($Salarystructure){
					 $bank_amt1 += ($EnggReport->net_amount + $EnggReport->tes) - ($EnggReport->dearness_allowance + $EnggReport->advance_arrear_tes);
					} else {
					 $bank_amt2 += $EnggReport->net_amount;	
					} 
		
		
		}
		
		foreach($queryengg2 as $EnggReport2){
		$engg_count2 +=1;
		$remu2 = EmpRemunerationDetails::find()->where(['empid'=>$EnggReport2->empid])->one();
		$engg_grossamt2 +=$remu2->gross_salary;
		$engg_netamt2 += $EnggReport2->net_amount;
		$engg_paidallowance2 += $EnggReport2->paidallowance;
		$engg_ctc2 += $EnggReport2->earned_ctc;
		

				$Salarystructure = EmpSalarystructure::find()
                 ->where(['salarystructure' => $remu2->salary_structure])
                 ->one();
				 					
					if($Salarystructure){
					 $bank_amt3 += ($EnggReport2->net_amount + $EnggReport2->tes) - ($EnggReport2->dearness_allowance + $EnggReport2->advance_arrear_tes);
					} else {
					 $bank_amt4 += $EnggReport2->net_amount;	
					} 
					
		}
		$totengg += $engg_count;
		$totengg_gross += $engg_grossamt;
		$totengg_net += $engg_netamt;
		$totengg_allowance += $engg_paidallowance;
		$totengg_ctc += $engg_ctc;
		$totbank_amt += $bank_amt1 + $bank_amt2;
		
		$totengg2 += $engg_count2;
		$totengg_gross2 += $engg_grossamt2;
		$totengg_net2 += $engg_netamt2;
		//$totengg_allowance2 += $engg_paidallowance2;
		$totengg_ctc2 += $engg_ctc2;
		$totbank_amt2 += $bank_amt3 + $bank_amt4;
		if(!empty($engg_count) || !empty($engg_count2)){
			echo '<tr><td>'.$i.'</td><td>'.$model_unit->name.'</td>
			 <td>'.$engg_count.'</td><td align="right">'.$ModelEmp->moneyFormatIndia($engg_grossamt).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($engg_netamt).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($engg_ctc).'</td>
			  <td align="right">'.$ModelEmp->moneyFormatIndia($bank_amt1 + $bank_amt2).'</td>
			  <td>'.$engg_count2.'</td><td align="right">'.$ModelEmp->moneyFormatIndia($engg_grossamt2).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($engg_netamt2).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($engg_ctc2).'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($bank_amt3 + $bank_amt4).'</td>
			 </tr>';
			 $i++;
		}		
		}		
		
		?>
		<tr><td colspan="2" align="right">Total</td><td><?=$totengg?>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_gross)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_net)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_ctc)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totbank_amt)?></td>
			
			<td ><?=$totengg2?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_gross2)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_net2)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totengg_ctc2)?></td>
			<td align="right"><?=$ModelEmp->moneyFormatIndia($totbank_amt2)?></td>
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
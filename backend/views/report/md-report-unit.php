<?php
use common\models\Unit;
use common\models\UnitGroup;
use common\models\EmpDetails;
use common\models\Division;
use common\models\EmpSalary;

$modelUnit = Unit::find()->orderBy('id')->all();
$vgunit = Unit::find()->where(['id'=>$_GET['id']])->one();
$ModelEmp = EmpDetails::find()->one();
?>
<style>
th {
    text-align: center;   
}
</style>

<div class="wizard">
   <ul class="steps" >	    
        <li><a href="md-report">ManPower</a><span class="chevron"></span></li>
		<li><a href="md-report-summary">Salary Summary</a><span class="chevron"></span></li>
		<?php foreach($modelUnit as $unit){
			if($_GET['id']== $unit->id) { ?>
				<li class="active"><?=$unit->name?><span class="chevron"></span></li>
				<?php } else { ?>
		<li ><a href="md-report-unit?id=<?=$unit->id?>"><?=$unit->name?></a><span class="chevron"></span></li>
		<?php } }?>
	</ul>
</div>

   <h1><?=$vgunit->name?> Employee Summary</h1>
	<table>
	 <thead>
		<tr><th rowspan="2">Sl. No</th><th rowspan="2">Division</th><th rowspan="2">Strength</th><th rowspan="2">Salary</th><th colspan="2">Staff</th><th colspan="2">Engineers</th><th colspan="2">Contract</th></tr>
		<tr><th>Strength</th><th>Salary</th><th>Strength</th><th>Salary</th><th>Strength</th><th>Salary</th></tr>
	</thead>
	<tbody>
	
	<?php		
		$unit_group = UnitGroup::find()->Where(['unit_id'=>$vgunit->id])->orderBy('priority')->all();
		$i=1;		
		foreach($unit_group as $group){	
		$emp_count = NULL;
		$sum_amt = NULL;
		$staff_count = NULL;
		$staff_amt = NULL;
		$engg_count = NULL;
		$engg_amt = NULL;
		$cont_count = NULL;
		$cont_amt = NULL;
		$division = Division::find()->where(['id'=>$group->division_id])->one();	
		// Overall Strength
		$query = EmpSalary::find()
				->where(['division_id' => $group->division_id,'unit_id'=>$vgunit->id,'month'=>'2018-11-01']);
		$sum_amt = $query->sum('net_amount');
		$emp_count = $query->count();
		// Staff Strength & salary
		$querystaff = EmpSalary::find()
				->joinWith('employee')
				->where(['emp_salary.division_id' => $group->division_id,'emp_salary.unit_id'=>$vgunit->id,'month'=>'2018-11-01',
				'emp_details.category'=>['HO Staff','BO Staff']])
				->andWhere(['NOT IN','emp_salary.salary_structure',['Contract']]);
		$staff_count = $querystaff->count();
		$staff_count = $staff_count > 0 ?$staff_count:NULL;
		$staff_amt = $querystaff->sum('net_amount');
		// Engg Strength & salary
		$queryengg = EmpSalary::find()
				->joinWith('employee')
				->where(['emp_salary.division_id' => $group->division_id,'emp_salary.unit_id'=>$vgunit->id,'month'=>'2018-11-01',
				'emp_details.category'=>['International Engineer','Domestic Engineer']])
				->andWhere(['NOT IN','emp_salary.salary_structure',['Contract']]);
		$engg_count = $queryengg->count();		
		$engg_count = $engg_count > 0 ?$engg_count:NULL;
		$engg_amt = $queryengg->sum('net_amount');
		// Contract Strength & salary
		$querycont = EmpSalary::find()
				->joinWith('employee')
				->where(['emp_salary.division_id' => $group->division_id,'emp_salary.unit_id'=>$vgunit->id,'month'=>'2018-11-01'])
				->andWhere(['IN','emp_salary.salary_structure',['Contract']]);
		$cont_count = $querycont->count();
		$cont_count = $cont_count > 0 ?$cont_count:NULL;
		$cont_amt = $querycont->sum('net_amount');
		
		echo '<tr><td>'.$i.'</td><td>'.$division->division_name.'</td><td>'.$emp_count.'</td><td align="right">'.$ModelEmp->moneyFormatIndia($sum_amt).'</td><td>'.$staff_count.'</td>
			 <td align="right">'.$ModelEmp->moneyFormatIndia($staff_amt).'</td><td>'.$engg_count.'</td><td align="right">'.$ModelEmp->moneyFormatIndia($engg_amt).'</td><td>'.$cont_count.'</td><td align="right">'.$ModelEmp->moneyFormatIndia($cont_amt).'</td></tr>';
		$i++;
		}		
		?>
		<tr><td colspan="2" align="right">Total</td></tr>
	</tbody>
	</table>
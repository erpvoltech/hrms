<?php
use common\models\Unit;
use common\models\UnitGroup;
use common\models\EmpDetails;
use common\models\EmpRemunerationDetails;
	
$modelUnit = Unit::find()->orderBy('id')->all();
$ModelEmp = EmpDetails::find()->one();
?>
<div class="wizard">
   <ul class="steps" >	    
        <li ><a href="md-report">ManPower</a><span class="chevron"></span></li>
		<li class="active">Salary Summary<span class="chevron"></span></li>
		<?php foreach($modelUnit as $unit){?>
		<li ><a href="md-report-unit?id=<?=$unit->id?>"><?=$unit->name?></a><span class="chevron"></span></li>
		<?php } ?>
	</ul>
</div>

     <h1>INDEPENDENT COMPANYWISE SALARY REPORT</h1>
	<table>
	<thead><tr><th>Sl. No</th><th>UNITS</th><th>Manpower</th><th >Gross Salary</th></tr></thead>
	<tbody>
	<?php
	$manpoerTot = 0;
	$grossTot = 0;
	$vgunit = Unit::find()->all();
	$i=1;
	foreach($vgunit as $group){
		$unit_array=[];
		$unit_group = UnitGroup::find()->Where(['unit_id'=>$group->id])->all();
		foreach($unit_group as $units){		
		$unit_array[] = $units->unit_id;
		} ?>
		<tr><td><?=$i?></td><td><?=$group->name?></td><td align="right">		
		<?php 
		 $manpoer =  EmpDetails::find()
				->where(['unit_id' => $unit_array])
				->count();
		$manpoerTot += $manpoer;	
		?>
		<?=$manpoer?>
		</td>
		<td align="right">
		<?php
		$tot_sal = 0;
		$EmpDetail = EmpDetails::find()->where(['unit_id' => $unit_array])->all();
		foreach($EmpDetail as $emp){	
		$Remu = EmpRemunerationDetails::find()->Where(['empid'=>$emp->id])->one();
		$tot_sal += $Remu->gross_salary;
		}
		$grossTot +=$tot_sal;
		?>
		<?=$ModelEmp->moneyFormatIndia($tot_sal)?>		
		</td>		
		</tr>
		<?php
		$i++;
		}
		?>
		<tr><td colspan="2" align="right">Total</td><td align="right"><?=$manpoerTot?></td><td align="right"><?=$ModelEmp->moneyFormatIndia($grossTot)?></td></tr>
	</tbody>
	</table>

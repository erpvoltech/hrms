<?php
	use common\models\Unit;
	use common\models\EmpDetails;
	use common\models\Vgunit;
	use common\models\UnitGroup;
	use common\models\EmpRemunerationDetails;
	?>
      <h1>INDEPENDENT COMPANYWISE SALARY REPORT</h1>
	<table>
	<thead><tr><th>Sl. No</th><th>UNITS</th><th>Manpower</th><th>Gross Salary</th></tr></thead>
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
		<tr><td><?=$i?></td><td><?=$group->name?></td><td>		
		<?php 
		 $manpoer =  EmpDetails::find()
				->where(['unit_id' => $unit_array])
				->count();
		$manpoerTot += $manpoer;	
		?>
		<?=$manpoer?>
		</td>
		<td>
		<?php
		$tot_sal = 0;
		$EmpDetail = EmpDetails::find()->where(['unit_id' => $unit_array])->all();
		foreach($EmpDetail as $emp){	
		$Remu = EmpRemunerationDetails::find()->Where(['empid'=>$emp->id])->one();
		$tot_sal += $Remu->gross_salary;
		}
		$grossTot +=$tot_sal;
		?>
		<?=$tot_sal?>		
		</td>		
		</tr>
		<?php
		$i++;
		}
		?>
		<tr><td colspan="2">Total</td><td><?=$manpoerTot?></td><td><?=$grossTot?></td></tr>
	</tbody>
	</table>

<?php
	use common\models\Unit;
	use common\models\EmpDetails;
	use common\models\Vgunit;
	use common\models\UnitGroup;
	?>
      <h1>VEPL MANPOWER</h1>
	<table>
	<thead><tr><th>Sl. No</th><th>UNITS</th><th>Manpower</th></tr></thead>
	<tbody>
	<?php
	
	$vgunit = Unit::find()->all();
	$i=1;
	foreach($vgunit as $group){
		$unit_array=[];
		$unit_group = UnitGroup::find()->Where(['unit_id'=>$group->id])->all();
		foreach($unit_group as $units){		
		$unit_array[] = $units->unit_id;
		} ?>
		<tr><td><?=$i?></td><td><?=$group->name?></td><td>
		<?= EmpDetails::find()
				->where(['unit_id' => $unit_array])
				->count();
		?>
		</td></tr>
		<?php
		$i++;
		}
		?>
	</tbody>
	</table>

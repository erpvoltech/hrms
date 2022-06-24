<?php
use common\models\EmpPromotion;
use common\models\EmpDetails;
use common\models\EmpSalary;
use common\models\EngineerTransfer;
use common\models\EngineertransferProject;
use common\models\Unit;
use common\models\Division;
use common\models\Designation;
use common\models\Status;
use yii\helpers\Html;
//print_r($model);
error_reporting(0);
$salfirst= EmpSalary::find()->where(['empid'=>$model])->orderBy('date')->one();
//print_r($salfirst);
//exit;
$selstatus = Status::find()->where(['empid'=>$model])->orderBy('Status_change_date')->all();
$salmodel= EngineerTransfer::find()->where(['empid'=>$model])->orderBy('transfer_date')->all();
$selunit = EngineertransferProject::find()->where(['empid'=>$model])->orderBy('transfer_date')->all();
$promotionmodel = EmpPromotion::find()->where(['empid'=>$model])->orderBy('effectdate')->all();
 $firstunit = $salfirst->division_id;
 //print_r($firstunit);
 //exit;
 $unitchange = $salfirst->unit_id;
  $statuschange = $selstatus->status_from;
 //print_r($firstunit);
?>
<div class="emp-log-view">
	<div class="row">
	<div class="col-md-12">
	<label class="control-label"><b>Promotion Tracking </b><label>
	</div>
    </div> <br>
	<div class="row">
	<div class="col-md-12">
	<table>
	<tr><th rowspan="2">Date</th><th colspan="2"> Designation </th><th colspan="2"> SS </th><th colspan="2"> WL </th><th colspan="2"> Grade </th><th colspan="2"> Gross </th><th colspan="2"> PLI </th></tr>
	<tr><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th></tr>
	<?php
	if($promotionmodel){
		foreach($promotionmodel as $promotion){ ?>
		<tr><td><?=$promotion->effectdate?></td>		
		<?php
			if($promotion->designation_from != $promotion->designation_to && !empty($promotion->designation_to)){ 
				$DesignationFrom = Designation::find()->where(['id'=>$promotion->designation_from])->one();
				$DesignationTo = Designation::find()->where(['id'=>$promotion->designation_to])->one();			
				?>
					<td><?=$DesignationFrom->designation?></td><td><?=$DesignationTo->designation?></td>
				<?php 
			 } else { ?>
			 <td></td> <td></td>
			<?php }
			 
			 if($promotion->ss_from != $promotion->ss_to && !empty($promotion->ss_to)){ ?>
				<td><?=$promotion->ss_from?></td><td><?=$promotion->ss_to?></td>
			<?php } else { ?>
			 <td></td> <td></td>
			<?php }
		    if($promotion->wl_from != $promotion->wl_to && !empty($promotion->wl_to)){ ?>
				<td><?=$promotion->wl_from?></td><td><?=$promotion->wl_to?></td>
			<?php }else { ?>
			 <td></td> <td></td>
			<?php  }
			if($promotion->grade_from != $promotion->grade_to && !empty($promotion->grade_to)){ ?>
			<td><?=$promotion->grade_from?></td><td><?=$promotion->grade_to?></td>
			<?php }	else { ?>
			 <td></td> <td></td>
			<?php }
			if($promotion->gross_from != $promotion->gross_to && !empty($promotion->gross_to)){ ?>
			<td><?=$promotion->gross_from?></td><td><?=$promotion->gross_to?></td>
			<?php }	else { ?>
			 <td></td> <td></td>
			<?php }
			if($promotion->pli_from != $promotion->pli_to && !empty($promotion->pli_to)){ ?>
			<td><?=$promotion->pli_from?></td><td><?=$promotion->pli_to?></td>
			<?php }	else { ?>
			 <td></td> <td></td>
			<?php }
		}
	}
	?>
	    </tr>
	</table>
	</div>
    </div><br>
	<div class="row">
	<div class="col-md-12">
	<label class="control-label"><b>Unit Tracking </b><label>
	</div>
    </div> <br>
	<div class="row">
	<div class="col-md-12">
	<table>
	<tr><th rowspan="2">Date</th><th colspan="2"> Unit </th><th colspan="2"> Division </th></tr>
	<tr><th>From</th><th>To</th><th>From</th><th>To</th></tr>
	<?php
	if($selunit){
		foreach($selunit as $modelunit){ 
		
			if($modelunit->unit_to != $unitchange && $modelunit->division_to != $firstunit){ 
				$UnitFrom = Unit::find()->where(['id'=>$unitchange])->one();
				$DivisionFrom = Division::find()->where(['id'=>$firstunit])->one();
				$UnitTo = Unit::find()->where(['id'=>$modelunit->unit_to])->one();
				$DivisionTo = Division::find()->where(['id'=>$modelunit->division_to])->one();
				echo '<tr><td>'.$modelunit->transfer_date.'</td><td>'.$UnitFrom->name.'</td><td>'.$UnitTo->name.'</td><td>'.$DivisionFrom->division_name.'</td><td>'.$DivisionTo->division_name.'</td>';
				$unitchange = $modelunit->unit_to;
				$firstunit = $modelunit->division_to;

		}
	}
	}
	?>
	    </tr>
	</table>
	</div>
    </div><br>
	<div class="row">
	<div class="col-md-12">
	<label class="control-label"><b>Division Tracking </b><label>
	</div>
    </div> <br>
	<div class="row">
	<div class="col-md-12">
	<table>
	<tr><th rowspan="2">Date</th><th> Unit </th><th colspan="2"> Division </th></tr>
	<tr><th>unit</th><th>From</th><th>To</th></tr>
	<?php
	if($salmodel){
		foreach($salmodel as $modelsal){ 
		
			if($modelsal->division_to != $firstunit){ 
				$UnitFrom = Division::find()->where(['id'=>$modelsal->division_from])->one();
				$Unit = Unit::find()->where(['id'=>$unitchange])->one();
				$UnitTo = Division::find()->where(['id'=>$modelsal->division_to])->one();
				echo '<tr><td>'.$modelsal->transfer_date.'</td><td>'.$Unit->name.'</td><td>'.$UnitFrom->division_name.'</td><td>'.$UnitTo->division_name.'</td>';
				$firstunit = $modelsal->division_to;

		}
	}
	}
	?>
	    </tr>
	</table>
	</div>
    </div><br>
  <div class="row">
	<div class="col-md-12">
	<label class="control-label"><b>Status Tracking </b><label>
	</div>
    </div> <br>
	<div class="row">
	<div class="col-md-12">
	<table>
	<tr><th rowspan="2">Date</th><th colspan="2" style="text-align:center;"> Status </th></tr>
	<tr><th>From</th><th>To</th></tr>
	<?php
	if($selstatus){
		foreach($selstatus as $modelstatus){ 
		
			if($modelstatus->status_to != $statuschange){ 
		
				//$StatusFrom = Status::find()->where(['id'=>$modelstatus->status_from])->one();
				//$Unit = Unit::find()->where(['id'=>$unitchange])->one();
				//$StatusTo = Status::find()->where(['id'=>$modelstatus->status_to])->one();
				echo '<tr><td>'.$modelstatus->status_change_date.'</td><td>'.$modelstatus->status_from.'</td><td>'.$modelstatus->status_to.'</td>';
				$statuschange = $modelstatus->status_to;

		}
	}
	}
	?>
	    </tr>
	</table>
	</div>
    </div>
</div>
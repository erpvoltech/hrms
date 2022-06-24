<?php
use common\models\EmpDetails;
use common\models\EmpBankdetails;
use common\models\EmpStatutorydetails;
use common\models\EmpSalary;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;

$this->title = 'Emp Salaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-salary-index">
<?php
$month ='2018-10-01';
$modelUnit = Unit::find()->all();
echo '<table>';
	foreach ($modelUnit as $unit){
		$modelDivision = Division::find()->all();
		foreach ($modelDivision as $division){
		$modelSal = EmpSalary::find()->where(['month'=>$month,'unit_id'=>$unit->id,'division_id'=>$division->id])->orderBy('empid')->all();
			if($modelSal) {
			   echo '<tr><td colspan="4">'.$unit->name .'/'. $division->division_name.'</td></tr>';
				$tot_earn = 0;
				$tot_dedu = 0;
				$tot_net = 0;
				foreach ($modelSal as $salary){
					$tot_earn += $salary->total_earning;
					$tot_dedu += $salary->total_deduction;
					$tot_net += $salary->net_amount;
					echo '<tr><td>'.$salary->empid .'</td><td>'.$salary->total_earning .'</td><td>'.$salary->total_deduction .'</td><td>'.$salary->net_amount .'</td></tr>';
				}
				echo '<tr><td></td><td>'.$tot_earn .'</td><td>'.$tot_dedu .'</td><td>'.$tot_net .'</td></tr>'; 
			}
		}
	}
	echo '</table>';
?>
</div>
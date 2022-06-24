<?php
use common\models\EmpDetails;
use common\models\EmpBankdetails;
use common\models\EmpStatutorydetails;
use common\models\EmpSalary;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use app\models\SalaryStatementsearch;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\UnitGroup;

$this->title = 'Salaries Statement';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="emp-salary-index">
	<div style="overflow-x:auto;">
<?php
	
if (Yii::$app->getRequest()->getQueryParam('month'))
   $month = Yii::$app->getRequest()->getQueryParam('month');
else
   $month = '';  
   
if (Yii::$app->getRequest()->getQueryParam('group')) {
   $group = Yii::$app->getRequest()->getQueryParam('group');
} else {  
   $group ='';
}
   
   $model = new SalaryStatementsearch();

   echo $this->render('statement', ['model' => $model, 'group' => $group,'month'=>$month]);
 
   if($month !=''){
$modelUnit = Unit::find()->all();
echo '<table id="table2excel" border="2" >';
echo '<tr><th>Emp. Code</th><th>Emp. Name</th><th>Designation</th><th>DoJ</th><th>Paid Days</th><th>Paid Allowance</th><th>Basic</th><th>HRA</th><th>Spl. Allowance</th><th>DA</th><th>Conveyance Allowance</th><th>Over Time</th>
<th>Arrear</th><th>Advance/Arrear TES</th><th>LTA Earning</th><th>Medical Earning</th><th>Guaranted Benefit</th><th>Other Allowance</th><th>Total Earning</th><th>PF</th><th>ESI</th><th>PT</th><th>TES</th><th>Mobile</th><th>Loan</th><th>Rent</th>
<th>TDS</th><th>LWF</th><th>Other Deduction</th><th>Total Deduction</th><th>Net Amount</th></tr>';
	            $ftot_earn = 0;
				$ftot_dedu = 0;				
				$ftot_net = 0;
				$fpaidallowance = 0;
				$fBasic =0;	$fHRA = 0;
				$fsplAllowance=0;
				$fDA = 0; $fCA =0;$fOT =0;
				$farrear = 0; $farrear_tes = 0; $flta = 0; $fmedical = 0;
				$fGB = 0; $fOtherAllowance = 0; $fpf = 0; $fesi = 0;
				$fpt = 0; $ftes = 0; $flta = 0; $fmobile = 0;
				$floan = 0; $frent = 0; $flta = 0; $ftds = 0;
				$flwf = 0; $fOtherDeduction =0;
				
	foreach ($modelUnit as $unit){
	$unit_group = UnitGroup::find()->Where(['vgunit_id'=>$group])->all();
    foreach($unit_group as $units){	
      $division = Division::find()->Where(['id'=>$units->unit_id])->One();
		//$modelDivision = Division::find()->all();
		//foreach ($modelDivision as $division){
		$modelSal = EmpSalary::find()->where(['month'=>$month,'unit_id'=>$unit->id,'division_id'=>$division->id])->orderBy('empid')->all();
			if($modelSal) {
			   echo '<tr><td colspan="28">'.$unit->name .'/'. $division->division_name.'</td></tr>';
				$tot_earn = 0;
				$tot_dedu = 0;				
				$tot_net = 0;
				$paidallowance = 0;
				$Basic =0;	$HRA = 0;
				$splAllowance=0;
				$DA = 0; $CA =0;$OT =0;
				$arrear = 0; $arrear_tes = 0; $lta = 0; $medical = 0;
				$GB = 0; $OtherAllowance = 0; $pf = 0; $esi = 0;
				$pt = 0; $tes = 0; $lta = 0; $mobile = 0;
				$loan = 0; $rent = 0; $lta = 0; $tds = 0;
				$lwf = 0; $OtherDeduction =0;
				foreach ($modelSal as $salary){
				$dedu =0;
				$net =0;
				$Emp = EmpDetails::find()->where(['id'=>$salary->empid])->one();
				$designation = Designation::find()->where(['id'=>$salary->designation])->one();
					$tot_earn += round($salary->total_earning);
					//$tot_dedu += $salary->total_deduction;
					$dedu = round($salary->pf + $salary->insurance +$salary->professional_tax +$salary->esi +$salary->advance +$salary->tes +$salary->mobile +$salary->loan +$salary->rent +$salary->tds +$salary->lwf +$salary->other_deduction);
					$tot_dedu += $dedu;
					$net = round(round($salary->total_earning) - $dedu);
					$tot_net += $net;
					$paidallowance += $salary->paidallowance;
					$Basic += $salary->basic;
					$HRA += $salary->hra;
					$splAllowance += $salary->spl_allowance;
					$DA += $salary->dearness_allowance;
					$CA += $salary->conveyance_allowance ;
					$OT += $salary->over_time;
					$arrear += $salary->arrear;
					$arrear_tes += $salary->advance_arrear_tes;
					$lta += $salary->lta_earning;
					$medical += $salary->medical_earning;
					$GB += $salary->guaranted_benefit;
					$OtherAllowance += $salary->other_allowance;
					$pf += $salary->pf;
					$esi += $salary->esi;
					$pt += $salary->professional_tax;
					$tes += $salary->tes;
					$mobile += $salary->mobile;
					$loan += $salary->loan;
					$rent += $salary->rent;
					$tds += $salary->tds;
					$lwf += $salary->lwf;
					$OtherDeduction += $salary->other_deduction;
					echo '<tr><td>'.$Emp->empcode.'</td><td>'.$Emp->empname .'</td><td>'.$designation->designation .'</td><td>'.Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy") .'</td><td>'.$salary->paiddays.'</td><td>'.$salary->paidallowance.'</td><td>'.$salary->basic.'</td><td>'.$salary->hra.'</td><td>'.$salary->spl_allowance.'</td><td>'.$salary->dearness_allowance.'</td><td>'.$salary->conveyance_allowance.'</td>
					<td>'.$salary->over_time.'</td><td>'.$salary->arrear.'</td><td>'.$salary->advance_arrear_tes.'</td><td>'.$salary->lta_earning.'</td><td>'.$salary->medical_earning.'</td><td>'.$salary->guaranted_benefit.'</td><td>'.$salary->other_allowance.'</td><td>'.$salary->total_earning .'</td>
					<td>'.round($salary->pf).'</td><td>'.$salary->esi.'</td><td>'.$salary->professional_tax.'</td><td>'.$salary->tes.'</td><td>'.$salary->mobile.'</td><td>'.$salary->loan.'</td><td>'.$salary->rent.'</td><td>'.$salary->tds.'</td><td>'.$salary->lwf.'</td><td>'.$salary->other_deduction.'</td><td>'.$dedu .'</td><td>'.$net .'</td></tr>';
				}
				echo '<tr><td></td><td align="right">Sub Total</td><td></td><td></td><td></td><td>'.$paidallowance.'</td><td>'.$Basic.'</td><td>'.$HRA.'</td>
				<td>'.$splAllowance.'</td><td>'.$DA.'</td><td>'.$CA.'</td><td>'.$OT.'</td>
				<td>'.$arrear.'</td><td>'.$arrear_tes.'</td><td>'.$lta.'</td><td>'.$medical.'</td>
				<td>'.$GB.'</td><td>'.$OtherAllowance.'</td> <td>'.$tot_earn .'</td> <td>'.$pf.'</td><td>'.$esi.'</td>
				<td>'.$pt.'</td><td>'.$tes.'</td><td>'.$mobile.'</td>
				<td>'.$loan.'</td><td>'.$rent.'</td><td>'.$tds.'</td>
				<td>'.$lwf.'</td><td>'.$OtherDeduction.'</td>
				<td>'.$tot_dedu .'</td><td>'.$tot_net .'</td></tr>'; 
				
				
				$ftot_earn += $tot_earn;
				$ftot_dedu += 	$tot_dedu;
					$ftot_net += $tot_net;
					$fpaidallowance += $paidallowance;
					$fBasic += $Basic;
					$fHRA += $HRA;
					$fsplAllowance += $splAllowance;
					$fDA += $DA;
					$fCA += $CA;
					$fOT += $OT;
					$farrear += $arrear;
					$farrear_tes += $arrear_tes;
					$flta += $lta;
					$fmedical += $medical;
					$fGB += $GB;
					$fOtherAllowance += $OtherAllowance;
					$fpf += $pf;
					$fesi += $esi;
					$fpt += $pt;
					$ftes += $tes;
					$fmobile += $mobile;
					$floan += $loan;
					$frent += $rent;
					$ftds += $tds;
					$flwf += $lwf;
					$fOtherDeduction += $OtherDeduction;
				
			}
		}
	}
	echo '<tr><td colspan="31"></td></tr>';
	echo '<tr><td></td><td align="right">Grand Total</td><td></td><td></td><td></td><td>'.$fpaidallowance.'</td><td>'.$fBasic.'</td><td>'.$fHRA.'</td>
				<td>'.$fsplAllowance.'</td><td>'.$fDA.'</td><td>'.$fCA.'</td><td>'.$fOT.'</td>
				<td>'.$farrear.'</td><td>'.$farrear_tes.'</td><td>'.$flta.'</td><td>'.$fmedical.'</td>
				<td>'.$fGB.'</td><td>'.$fOtherAllowance.'</td> <td>'.$ftot_earn .'</td> <td>'.$fpf.'</td><td>'.$fesi.'</td>
				<td>'.$fpt.'</td><td>'.$ftes.'</td><td>'.$fmobile.'</td>
				<td>'.$floan.'</td><td>'.$frent.'</td><td>'.$ftds.'</td>
				<td>'.$flwf.'</td><td>'.$fOtherDeduction.'</td>
				<td>'.$ftot_dedu .'</td><td>'.$ftot_net .'</td></tr>'; 
	echo '</table>';
   }
?>
</div>
</div>
<button id="export">Export</button>

<?php
$script = <<< JS
$("#export").click(function(){
 $("#table2excel").table2excel({
					
					name: "Salary Statement",
					filename: "SalaryStatement",
					fileext: ".xls",					
				});
});
JS;
$this->registerJs($script);

?>
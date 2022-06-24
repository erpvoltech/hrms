<?php
use yii\helpers\Html;
use common\models\EmpDetails;
use common\models\StatutoryHr;
use common\models\EmpSalary;
use common\models\EmpRemunerationDetails;
use common\models\EmpStatutorydetails;
use common\models\PfList;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use common\models\UnitGroup;
use app\models\SalaryStatementsearch;
error_reporting(0);
$this->title = 'EPF Month Report';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="epf-report">
	
<?php
if (Yii::$app->getRequest()->getQueryParam('month'))
   $month = Yii::$app->getRequest()->getQueryParam('month');
else
   $month = '';  
   
if (Yii::$app->getRequest()->getQueryParam('group')) {
   $group = Yii::$app->getRequest()->getQueryParam('group');
   $groupdata = Yii::$app->getRequest()->getQueryParam('group');
} else {  
   $group ='';
   $groupdata ='';
}

if (Yii::$app->getRequest()->getQueryParam('unit')) {
   $unit = Yii::$app->getRequest()->getQueryParam('unit');
   $unitdata = Yii::$app->getRequest()->getQueryParam('unit');
} else {  
   $unit ='';
   $unitdata ='';
}
   
   $model = new SalaryStatementsearch();

 echo $this->render('epfsearch', ['model' => $model, 'group' => $group,'month'=>$month,'unit' => $unit]);
   ?>
   <div style="overflow-x:auto;">
 <?php  
 
if($month !=''){
	
			$m = date("m", strtotime($month));
            $y = date("Y", strtotime($month));
            $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y); 
			$workdays = 0;
			for ($i = 1; $i <= $day_count; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
            }
	
	
   $unitda = serialize($unitdata);
   if($dataunit = unserialize($unitda)){
		$modelUnit = Unit::find()->Where(['IN','id',$dataunit])->orderBy('id')->all();
	} else {		
		$modelUnit = Unit::find()->orderBy('id')->all();  
	}

echo '<table id="table2excel" border="2" >';
echo '<tr><th>Sl.No</th><th>Region</th><th>EPF WAGES</th><th>EE Contribute</th><th>ER Contribute</th><th>EDLI </th><th>Total</th></tr>';
	          $slno =1;
	foreach ($modelUnit as $unit){
	$groupda = serialize($groupdata);
	$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();
   	foreach ($UnitGroupModel as $groupmodel){
      $division = Division::find()->Where(['id'=>$groupmodel->division_id])->One();
		if($data = unserialize($groupda)){
				$modelSal = EmpSalary::find()->joinWith(['employee'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])				 
				 ->andWhere(['IN','emp_details.category',$data])
				 ->all();
				} else {
				 $modelSal = EmpSalary::find()->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				 ->all();
				}
		$epfwages =0;
		$ee_epf = 0;
		$edli =0;
		$total =0;
		$epswagestotal =0;
			if($modelSal) {	
				foreach ($modelSal as $salary){	
				$gross =0;
				$Emp = EmpDetails::find()->where(['id'=>$salary->empid])->one();
				 $remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $Emp->id])->one();
				if(!empty($salary->statutoryrate)){
						if($salary->paiddays == $day_count){
						$gross = max(($salary->statutoryrate * $workdays), $salary->earnedgross);
						} else {
						  $lopdays = $day_count - $salary->paiddays;
						  $gross = max(($salary->statutoryrate * ( $workdays - $lopdays)), $salary->earnedgross);
						}
					} else {
						$gross = $salary->earnedgross;
					}
					
					//$epfwages = round(($salary->pf * 100)/12);	
					$epfwages =  round($salary->pf_wages);
					if ($remunerationmodel->restrict_pf == 'Yes') {
					$epswagestotal += ($epfwages < 15000 ? $epfwages : 15000);
					 } else {
					 $epswagestotal += $epfwages;
					 }					
				$grosswages += $gross;
				$ee_epf += $salary->pf;
				} 
			}
			$edli = round($epswagestotal*0.01);
			$total = $ee_epf + $ee_epf + $edli;
			if($epswagestotal != 0){
			 echo '<tr><td>'.$slno.'</td><td >'.$unit->name .'/'. $division->division_name.'</td><td>'.$epswagestotal.'</td><td>'.$ee_epf.'</td><td>'.$ee_epf.'</td><td>'.$edli.'</td><td>'.$total .'</td></tr>';
			 $slno++;
			}
		}
		
	}
	echo '</table><br>';
	echo '<button class="btn btn-success" id="export">Export</button>';
   }
?>
</div>
</div>
<br>
 <!-- <?= Html::a('Export', ['statementexport?group='.serialize($group).'&month='.$month.'&unit='.serialize($unitdata)], ['class' => 'btn btn-md btn-success']) ?> -->


<?php
$script = <<< JS
$("#export").click(function(){
 $("#table2excel").table2excel({					
					name: "EPF Report",
					filename: "epfreport",
					fileext: ".xls",					
	});
});
JS;
$this->registerJs($script);

?>
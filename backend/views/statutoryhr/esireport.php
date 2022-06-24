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
//error_reporting(0);
$this->title = 'ESI Month Report';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="esi-report">

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

	echo $this->render('esisearch', ['model' => $model, 'group' => $group,'month'=>$month,'unit' => $unit]);
	?>
	<div style="overflow-x:auto;">
		<?php
		if($month !=''){

			$m = date("m", strtotime($month));
			$y = date("Y", strtotime($month));
			$day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
			$unitda = serialize($unitdata);
			if($dataunit = unserialize($unitda)){
				$modelUnit = Unit::find()->Where(['IN','id',$dataunit])->orderBy('id')->all();
			} else {
				$modelUnit = Unit::find()->orderBy('id')->all();
			}

			echo '<table id="table2excel" border="2" >';
			echo '<tr><th>Sl.No</th><th>Region</th><th>ESI WAGES</th><th>EE Contribute</th><th>ER Contribute</th><th>Total</th></tr>';
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
					$esiwages =0;
					$ee_esi = 0;
					$er_esi = 0;
					$total =0;
					$tot_val = 0;
					if($modelSal) {
						foreach ($modelSal as $salary){
							$EMP = EmpDetails::find()->where(['id'=>$salary->empid])->one();
							if($salary->esi != 0){
								$gross =0;
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
								if(!empty($salary->statutoryrate)){
									
								if($salary->paiddays == $day_count){
										$tot_val =($salary->statutoryrate * $workdays) + $salary->over_time + $salary->arrear + $salary->holiday_pay;
										$gross = max($tot_val, ($salary->earnedgross - ($salary->spl_allowance + $salary->misc)));										
									} else {
								 $dojmonth = date("m-Y", strtotime($EMP->doj));
								 $salprocessing = date("m-Y", strtotime($salary->month));						
								 if ($dojmonth == $salprocessing) {
									$doj = date("d", strtotime($EMP->doj));
									$your_date = date("t", strtotime($salary->month));
									$workingDays = ($your_date - $doj) + 1;
									$work = 0 ;
												for ($i = 1; $i <= $workingDays; $i++) {
													  $date = $y . '/' . $m . '/' . $i; //format date
													  $get_name = date('l', strtotime($date)); //get week day
													  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
													  //if not a weekend add day to array
													  if ($day_name != 'Sun') {
														 $work += 1;
													  }
												   }
										if($salary->paiddays == $workingDays){	
											$workdays = $work;
										} else {
											$workdays = $work - ($workingDays - $salary->paiddays);
										}
								} else {
								$workdays = $workdays - ($day_count - $salary->paiddays);
								}
							
							$tot_val =($salary->statutoryrate * $workdays) + $salary->over_time + $salary->arrear + $salary->holiday_pay;
							$gross = max($tot_val, ($salary->earnedgross - ($salary->spl_allowance + $salary->misc)));	
							}
						} else {
							$gross = $salary->earnedgross - ($salary->spl_allowance + $salary->misc);						
						}
								$esiwages += $gross;
								$ee_esi += $salary->esi;
								$er_esi += $salary->esi_employer_contribution;
								
								
							}
						}
						
					}

					$total = $ee_esi + $er_esi;
					if($esiwages != 0){
						echo '<tr><td>'.$slno.'</td><td >'.$unit->name .'/'. $division->division_name.'</td><td>'.$esiwages.'</td><td>'.$ee_esi.'</td><td>'.$er_esi.'</td><td>'.$total .'</td></tr>';
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
		filename: "esireport",
		fileext: ".xls",
	});
});
JS;
$this->registerJs($script);

?>

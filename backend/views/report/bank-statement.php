<?php
use yii\helpers\Html;
use common\models\EmpDetails;
use common\models\EmpBankdetails;
use common\models\EmpStatutorydetails;
use common\models\EmpSalary;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use common\models\Customer;
use app\models\SalaryStatementsearch;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\UnitGroup;
error_reporting(0);
$this->title = 'Salaries Statement';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="emp-salary-index">
	
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
}

if (Yii::$app->getRequest()->getQueryParam('unit')) {
   $unit = Yii::$app->getRequest()->getQueryParam('unit');
   $unitdata = Yii::$app->getRequest()->getQueryParam('unit');
} else {  
   $unit ='';
}
   
   $model = new SalaryStatementsearch();

   echo $this->render('bankfilter', ['model' => $model, 'group' => $group,'month'=>$month,'unit' => $unit]);
   ?>
   <div style="overflow-x:auto;">
 <?php  

   if($month !=''){
   $unitda = serialize($unitdata);
   if($dataunit = unserialize($unitda)){
		$modelUnit = Unit::find()->Where(['IN','id',$dataunit])->orderBy('id')->all();
	} else {		
		$modelUnit = Unit::find()->orderBy('id')->all();  
	}

echo '<table id="table2excel" border="2" >';
echo '<tr><th>Sl.No</th><th>Emp. Code</th><th>Emp. Name</th><th>Bank Name</th><th>Account No</th><th>IFSC Code</th><th>Net Amount</th><th>Unit</th><th>Division</th><th>Customer</th></tr>';
	$GrandTot = 0;
	$i=1;
	foreach ($modelUnit as $unit){
	$groupda = serialize($groupdata);
	$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();
   	foreach ($UnitGroupModel as $groupmodel){
      $division = Division::find()->Where(['id'=>$groupmodel->division_id])->One();
		if($data = unserialize($groupda)){
				$modelSal = EmpSalary::find()->joinWith(['employee'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])				 
				 ->andWhere(['IN','emp_details.category',$data])
				 ->andWhere(['NOT IN', 'emp_details.status', ['Non-paid Leave']])
				 ->all();
				} else {
				 $modelSal = EmpSalary::find()->joinWith(['employee'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				 ->andWhere(['NOT IN', 'emp_details.status', ['Non-paid Leave']])
				 ->all();
				}		
			if($modelSal) {
			
			foreach ($modelSal as $salary){
			 // echo '<tr><td colspan="28">'.$unit->name .'/'. $division->division_name.'</td></tr>';				
				 $Emp = EmpDetails::find()->where(['id'=>$salary->empid])->one();
				$bank = EmpBankdetails::find()->where(['empid'=>$salary->empid])->one();
				$cust = Customer::find()->where(['id'=>$salary->customer_id])->one();				
				echo '<tr><td>'.$i.'</td><td>'.$Emp->empcode.'</td><td>'.$Emp->empname .'</td><td>'.$bank->bankname .'</td> <td>'.$bank->acnumber .'</td><td>'.$bank->ifsc .'</td><td>'.$salary->net_amount.'</td><td>'.$unit->name .'</td><td>'. $division->division_name.'</td><td>'. $cust->customer_name.'</td></tr>';
				$i++;
				}
			  }	
			}
		}	
	echo '</table>';
   }
?>
</div>
</div>
<br>
  <?= Html::a('Export', ['bank-statement-export?group='.serialize($group).'&month='.$month.'&unit='.serialize($unitdata)], ['class' => 'btn btn-md btn-success']) ?>
<!--<button id="export">Export</button> -->

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
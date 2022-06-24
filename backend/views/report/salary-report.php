<?php
use app\models\EmpReportSearch;
use common\models\Unit;
use common\models\EmpDetails;
use common\models\Vgunit;
use common\models\UnitGroup;
use common\models\Division;
use common\models\EmpSalary;
use common\models\EmpRemunerationDetails;

 $model = new Vgunit();


if (Yii::$app->getRequest()->getQueryParam('group')) {
   $group = Yii::$app->getRequest()->getQueryParam('group');
} else {  
   $group ='';
}

if (Yii::$app->getRequest()->getQueryParam('month'))
   $month = Yii::$app->getRequest()->getQueryParam('month');
else
   $month = '';

echo $this->render('salary-search', ['model' => $model, 'group' => $group,'month'=>$month]);
?>
<table>
   <thead><tr><th>Sl. No</th><th>UNITS</th><th>Engrs Strength</th><th>Gross Amount</th><th>Nett Allowance Paid</th><th>Nett Salary Payable</th><th>CTC</th></tr></thead>
      <tbody>
<?php
if($group !=''){
   $month = '01-' . $month;
   $salMonth = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");
   $i=1;
   $unit_group = UnitGroup::find()->Where(['vgunit_id'=>$group])->all();
   foreach($unit_group as $units){	
      $division = Division::find()->Where(['id'=>$units->unit_id])->One();
      
      $EmpDetail = EmpDetails::find()->where(['division_id' => $division->id])->all();
      $EngrStrength = 0;
      $gross_sal = 0;
      $tot_allowance = 0;
      $SalPayable = 0;
      $EarnedCTC = 0;
      foreach($EmpDetail as $emp){	
		$sal = EmpSalary::find()->Where(['empid'=>$emp->id,'month'=>$salMonth,'revised'=>0])->one();
            if($sal){
               $Remu = EmpRemunerationDetails::find()->Where(['empid'=>$emp->id])->one();               
               $EngrStrength++;
               $gross_sal += $Remu->gross_salary;
               $tot_allowance += $sal->paidallowance;
               $SalPayable +=	$sal->net_amount;
               $EarnedCTC += $sal->earned_ctc;
            }
          
		}
   
?>
         <tr>
            <td><?=$i?></td>
            <td><?=$division->division_name?></td>
            <td><?=$EngrStrength?></td> 
            <td><?=$gross_sal?></td>
            <td><?=$tot_allowance?></td>
            <td><?=$SalPayable?></td>
             <td><?=$EarnedCTC?></td>
         </tr>       
<?php
$i++; 

   } 
}
?>
	
	</tbody>
	</table>

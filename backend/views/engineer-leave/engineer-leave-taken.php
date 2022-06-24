<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use common\models\EngineerLeaveTaken;
use common\models\EmpDetails;
use common\models\EngineerLeave;
$currentYear = date('Y');
//$prev = $_GET['yr'];
//$year = '2020-2021';
?>
<div class="engineer-leave-form">

<?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>
<div class="row">
 <div class="col-lg-4 form-group"></div>
 </div>
   <br>
   <br>
   <br>
   <div class="row">
    <div class="col-lg-2 form-group"></div>
      <div class="col-lg-2 form-group">
	  
	  <?= $form->field($model, 'year')->hiddenInput(['value'=>$currentYear])->label(False);?>
	 
	  
	  </div>
	  <div class="col-lg-2 form-group">
	  </div>
      <div class="col-lg-6 form-group" style="left:35px;">
	<?= Html::submitButton('Consolidate', ['class' => 'btn-sm btn-success']) ?>
      </div>
   </div>
	<h2>Engineer Leave Eligibility - <?php echo $currentYear;?>-<?php echo $currentYear+1;?></h2>
      <div class="container">
	  <div class="row">
	  <table id="table2excel" border="2">
	  <tr><th style="width:1px;">Sl.No</th><th style="width:1px;">Empcode</th><th>EmpName</th><th>Eligible First Half</th><th>Leave Taken First Half</th><th>Remaining First Half</th><th>Eligible Second Half</th><th>Leave Taken Second Half</th><th>Remaining Second Half</th><th>Year Balance</th></tr>
	  <?php 
	 
		
	  $slno =1;
	 
		 $emp_list = EngineerLeaveTaken::find()->all();
		 foreach($emp_list as $list){
		
		
		  $emplist1 = EmpDetails::find()->where(['id'=>$list->empid])->one();
		  $eligible = EngineerLeave::find()->where(['empid'=>$list->empid])->one();
		  $first_half = $list->apr + $list->may + $list->jun + $list->jul + $list->aug +$list->sep;
		  $second_half = $list->oct + $list->nov + $list->decm + $list->jan + $list->feb +$list->mar;
		  $leave_rem_first = $eligible->eligible_first_half - $first_half;
		  $leave_rem_second = $eligible->eligible_second_half - $second_half;
		  $eligible_tot = $eligible->eligible_first_half + $eligible->eligible_second_half;
		  $leave_take_tot = $first_half + $second_half;
		  $year_bal = $eligible_tot - $leave_take_tot;
		 echo '<tr>
		 <td style="text-align:center">'.$slno.'</td>
		 <!--<td style="text-align:center">'.$emplist1->empcode.'</td>-->
		 <td><a href="engineer-leave-separate?empid='.$list->empid.'">'.$emplist1->empcode.'</a></td>
		 <td>'.$emplist1->empname.'</td>
		 <td style="text-align:center">'.$eligible->eligible_first_half.'</td>
		 <td style="text-align:center">'. $first_half.'</td>
		 <td style="text-align:center">'.$leave_rem_first.'</td>
		 <td style="text-align:center">'.$eligible->eligible_second_half.'</td>
		 <td style="text-align:center">'.$second_half.'</td>
		 <td style="text-align:center">'.$leave_rem_second.'</td>
		 <td style="text-align:center">'.$year_bal.'</td>
		
		 </tr>';
		 $slno++;
		  }
	 // }
	  
	  
	  ?>
	  </table>
	  </div>
	  </div>
<?php ActiveForm::end(); ?>
</div>
<div class="col-md-2" style="margin-top:15px"><?php echo '<button class="btn btn-danger" id="export">Export</button>';?></div>
<?php
$script = <<< JS
$(document).ready(function(){	

   var pro =$("#project").val();
   if(pro==""){
   $("#table2excel").hide();
   $("#export").hide();
   }
	$('#go').click(function(event){	  
	
		window.location.href ="index.php?r=project-details/attendancereport-project&df="+ $('#from_date').val() +"&dt="+ $('#to_date').val()+"&pro="+ $('#project').val()
	
	});
	
});
$("#export").click(function(){
 $("#table2excel").table2excel({					
					name: "Leave Report",
					filename: "engineer-leave-taken",
					fileext: ".xlsx",					
	});
});
JS;
$this->registerJs($script);
?>


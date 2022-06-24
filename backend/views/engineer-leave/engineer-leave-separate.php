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
$emp_id = $_GET['empid'];
$emplist1 = EmpDetails::find()->where(['id'=>$emp_id])->one();


?>

	<h3><?php echo $emplist1->empname;?> Leave Eligibility - <?php echo $currentYear;?>-<?php echo $currentYear+1;?></h3>
      <div class="container">
	  <div class="row">
	  <table id="table2excel" border="2">
	  <tr><th style="width:1px;">Empcode</th><th style="width:200px;">EmpName</th><th>April</th><th>May</th><th>June</th><th>July</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><th>Jan</th><th>Feb</th><th>Mar</th><th>Total Leave</th></tr>
	  <?php 
	 
		
	
	 
		 $emp_list = EngineerLeaveTaken::find()->where(['empid'=>$emp_id])->all();
		 foreach($emp_list as $list){
		
		
		  $emplist1 = EmpDetails::find()->where(['id'=>$list->empid])->one();
		  
		 echo '<tr>
		 
		 <td style="text-align:center">'.$emplist1->empcode.'</td>
		 <td style="width:100px;">'.$emplist1->empname.'</td>
		 <td style="text-align:center">'.$list->apr.'</td>
		 <td style="text-align:center">'. $list->may.'</td>
		 <td style="text-align:center">'.$list->jun.'</td>
		 <td style="text-align:center">'.$list->jul.'</td>
		 <td style="text-align:center">'.$list->aug.'</td>
		 <td style="text-align:center">'.$list->sep.'</td>
		 <td style="text-align:center">'.$list->oct.'</td>
		 <td style="text-align:center">'.$list->nov.'</td>
		 <td style="text-align:center">'.$list->decm.'</td>
		 <td style="text-align:center">'.$list->jan.'</td>
		 <td style="text-align:center">'.$list->feb.'</td>
		 <td style="text-align:center">'.$list->mar.'</td>
		 <td style="text-align:center">'.$list->leave_days.'</td>
		 
		
		 </tr>';
		 
		  }
	 // }
	  
	  
	  ?>
	  </table>
	  </div>
	  </div>
	  <div class="col-md-2" style="margin-top:15px"><?php echo '<button class="btn btn-success" id="export">Export</button>';?></div>

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
					filename: "engineer-leave-separate",
					fileext: ".xlsx",					
	});
});
JS;
$this->registerJs($script);
?>


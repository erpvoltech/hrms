<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmailSeparate;
use common\models\EmpSalary;
use common\models\EmpDetails;
use common\models\Unit;
use common\models\Designation;
use common\models\Division;
use common\models\Department;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;






?>
<style>
   .alert {
      padding: 5px;
      margin-bottom: 8px;
   }
</style>
<div class="emp-salary-form">
   <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size:18px;"> Import </div>
      <div class="panel-body"> 
         <?php  $form = ActiveForm::begin([ 'layout' => 'horizontal']);?>
         <br>  
		 
		  <div class="row">
            <div class="form-group col-lg-3 "></div>
            <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'file')->fileInput() ?>
            </div>
			<div class="form-group col-md-3" ><a href="../doc_file/email-separate.xlsx" class='btn btn-xs btn-primary'>Template link</a></div>
         </div>
		  <div class="row">
            <div class="form-group col-lg-5" ></div>
            <div class="form-group col-lg-3" >
               <?= Html::submitButton('Upload', ['class' => 'btn-sm btn-success','name'=>'email-separate', 'value'=>'email-separate']) ?>
            </div>
         </div>
         <br>
         <?php ActiveForm::end(); ?>
      </div>
   </div>
   <div class="emp-salary-index">
   <div class="row">
   <div class="form-group col-lg-5">
   </div>
   <div class="form-group col-lg-5">
   </div>
   <div class="form-group col-lg-1">
   <?=  Html::a('Send All', ['bulk-mail1'], ['class'=>'btn btn-md btn-success']) ?>
   </div>
   </div>
   <br>
  
  <table id="table2excel" border="2">
	  <tr><th style="width:1px;">Sl.No</th><th style="width:1px;">Empcode</th><th>EmpName</th><th>Designation</th><th>Unit</th><th>Department</th><th>Month</th><th>Basic</th><th>HRA</th><th>DA</th><th>Other Allowance</th><th>Net Amount</th></tr>
	  <?php 
	 
		
	  $slno =1;
	 
		 $email_sep = EmailSeparate::find()->all();		 
		 foreach($email_sep as $email){
			// echo $email->emp_id;
		 $emp_sal = EmpSalary::find()->where(['empid'=>$email->emp_id,'month'=>$email->month])->andWhere(['email_status' => 0])->one();
		 $emp_det = EmpDetails::find()->where(['id'=>$emp_sal->empid])->one();
		 $emp_desig = Designation::find()->where(['id'=>$emp_sal->designation])->one();
		 $emp_unit = Unit::find()->where(['id'=>$emp_sal->unit_id])->one();
		 $emp_div = Division::find()->where(['id'=>$emp_sal->division_id])->one();
		 $emp_dept = Department::find()->where(['id'=>$emp_sal->department_id])->one();
		 
			
		
		  /*$emplist1 = EmpDetails::find()->where(['id'=>$list->empid])->one();
		  $eligible = EngineerLeave::find()->where(['empid'=>$list->empid])->one();
		  $first_half = $list->apr + $list->may + $list->jun + $list->jul + $list->aug +$list->sep;
		  $second_half = $list->oct + $list->nov + $list->decm + $list->jan + $list->feb +$list->mar;
		  $leave_rem_first = $eligible->eligible_first_half - $first_half;
		  $leave_rem_second = $eligible->eligible_second_half - $second_half;
		  $eligible_tot = $eligible->eligible_first_half + $eligible->eligible_second_half;
		  $leave_take_tot = $first_half + $second_half;
		  $year_bal = $eligible_tot - $leave_take_tot;*/
		  ?>
        
		 <tr>
		 <td style="text-align:center"><?=$slno;?></td>
		 <td style="text-align:center"><?=$emp_det->empcode?></td>
		 <td><?=$emp_det->empname?></td>
		 <td><?=$emp_desig->designation?></td>
		 <td><?=$emp_unit->name?></td>
		 <td><?=$emp_div->division_name?></td>
		 <td><?=Yii::$app->formatter->asDate($emp_sal->month, 'php: M Y')?></td>
		 <td><?=$emp_sal->basic?></td>
		 <td><?=$emp_sal->hra?></td>
		 <td><?=$emp_sal->dearness_allowance?></td>
		 <td><?=$emp_sal->other_allowance?></td>
		 <td><?=$emp_sal->net_amount?></td>
		 </tr>
		 <?php
		 $slno++;
		  }
	// }
	  
	  
	  ?>
	  </table>
</div>

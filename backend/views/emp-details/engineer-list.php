<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\Division;
use common\models\Unit;
$div=$_GET['id'];
//print_r($div);
//exit;
//$model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
?>
<style>

</style>

<div class="project-details-employee-list">

    <?php $form = ActiveForm::begin(); ?>
	<h2>Employee List</h2>
      <div class="container">
	  <div class="row">
	  <table>
	  <tr><th style="width:1px;">Sl.No</th><th style="width:1px;">Empcode</th><th>EmpName</th><th>Division Transfer</th><th>Unit Transfer</th><th>Status</th></tr>
	  <?php 
	 // foreach ($model as $att) {
		//$unit = unit::findOne($att->unit);
		//$division = division::findOne($id);
	  $slno =1;
	  //$emp_list = EmpDetails::find()->where(['status'=>'active'])->all();
	  $emp_list = EmpDetails::find()->all();
	  foreach($emp_list as $list){
		 echo '<tr>
		 <td>'.$slno.'</td>
		 <td>'.$list->empcode.'</td>
		 <td>'.$list->empname.'</td>
		 <td><a href="division-transfer?id='.$list->id.'">Division</a></td>
		 <td><a href="engineertransfer-project?id='.$list->id.'">Unit</a></td>
		 <td><a href="status-change?id='.$list->id.'">Status</a></td>
		
		 </tr>';
		 $slno++;
	  }
	  
	  ?>
	  </table>
	  </div>
	  </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-attendance-menu -->

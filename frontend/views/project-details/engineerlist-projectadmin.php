<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\Division;
use common\models\Unit;
use yii\helpers\ArrayHelper;

//$div=$_GET['id'];
//print_r($div);
//exit;
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
//$model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
		//$unit = $_GET['uid'];
		//$division = $_GET['did'];
		//$date = $_GET['dt'];
		$ecode = $_GET['ec'];
?>
<style>

</style>

<div class="project-details-employee-list">

    <?php $form = ActiveForm::begin(); 
	$model->empcode = $ecode;
	//$model->unit_id = $unit;
	//$model->division_id = $division;
	
	?>
	<div class="row">
	<div class="col-md-3">
		 <?= $form->field($model, 'empcode')->label('ECode')?>
		 </div>
		 <div class="col-lg-1"> <?= Html::Button('Search', ['class' => 'btn-xs btn-primary','id'=>'submitbutton']) ?></div>
		 </div>
	
	<h2>Employee List</h2>
      <div class="container">
	  <div class="row">
	  <table>
	  <tr><th style="width:1px;">Sl.No</th><th style="width:1px;">Empcode</th><th>EmpName</th><th>Transfer</th></tr>
	  <?php 
	 // foreach ($model as $att) {
		//$unit = unit::findOne($att->unit);
		//$division = division::findOne($id);
	  $slno =1;
	  //$emp_list = EmpDetails::find()->where(['status'=>'active'])->all();
	  if($ecode==""){
	  $emp_list = EmpDetails::find()->where([ 'status' => 'Active'])
		->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->all();
	  }else{
	  $emp_list = EmpDetails::find()->where([ 'status' => 'Active','empcode'=>$ecode])
		->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->all();
	  }
		 
	  foreach($emp_list as $list){
		 echo '<tr>
		 <td>'.$slno.'</td>
		 <td>'.$list->empcode.'</td>
		 <td>'.$list->empname.'</td>
		 <td><a href="index.php?r=project-details/engineertransfer-project&id='.$list->id.'">Transfer</a></td>
		 
		 </tr>';
		 $slno++;
	  }
	  
	  ?>
	  </table>
	  </div>
	  </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-attendance-menu -->
<?php

$script = <<< JS
$(document).ready(function(){
	var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
     if (!confirm('Are you sure you want to delete this item?.')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
	
	$('#submitbutton').click(function(event){
		//var dt = $('#engineerattendance-date').val();
		var ec = $('#empdetails-empcode').val();
		//var uid = $('#empdetails-unit_id').val();
		//var did = $('#empdetails-division_id').val();
		window.location.href ="index.php?r=project-details/engineerlist-projectadmin&ec="+ec
	});
	
	$("#export").click(function(){
	$("#tblexp").table2excel({					
					name: "Attendance",
					filename: "attendance",
					fileext: ".xls",					
	});
});
});
JS;
$this->registerJs($script);

   ?>



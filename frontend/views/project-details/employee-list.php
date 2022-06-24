<?php
error_reporting(0);
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\Division;
use common\models\Unit;
use kartik\grid\GridView;

$model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
?>
<style>

</style>

<div class="project-details-employee-list">

    <?php $form = ActiveForm::begin(); ?>
	<h2>Employee List</h2>
      <div class="container">
	  <div class="row">
	  <table>
	  <tr><th style="width:1px;">Sl.No</th><th style="width:1px;">Empcode</th><th>EmpName</th><th>Designation</th><th>Department</th><th>Unit</th><th>Region</th><th></th><th>Transfer</th></tr>
	  <?php 
	  foreach ($model as $att) {
		$unit = unit::findOne($att->unit);
		$division = division::findOne($att->division);
	  $slno =1;
	 
	  $emp_list = EmpDetails::find()->where(['division_id' => $division->id, 'unit_id' => $unit->id, 'status' => 'Active'])
		->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->all();
		 echo '<tr>
		 <td colspan="9">'.$division->division_name.'</td></tr>';
	  foreach($emp_list as $list){
		 echo '<tr>
		 <td>'.$slno.'</td>
		 <td>'.$list->empcode.'</td>
		 <td>'.$list->empname.'</td>
		 <td>'.$list->designation->designation.'</td>
		 <td>'.$list->department->name.'</td>
		 <td>'.$list->units->name.'</td>
		 <td>'.$list->division->division_name.'</td>
		 <td><a href="index.php?r=project-details/engineer-view&id='.$list->id.'" class="fa fa-eye"></a></td>
		 <td><a href="index.php?r=project-details/division-transfer&id='.$list->id.'">Transfer</a></td>

		 </tr>';
		 $slno++;
		 		// <td><a href="index.php?r=project-details/status-change&id='.$list->id.'">Status</a></td>
	  }
	  }
	  ?>
	  </table>
	  </div>
	  </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-attendance-menu -->

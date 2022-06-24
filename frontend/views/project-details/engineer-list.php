<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\Division;
use common\models\Unit;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use yii\db\Query;
//print_r($dataProvider);
//exit;

//$model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
?>
<style>

</style>

<div class="project-details-employee-list">

    <?php $form = ActiveForm::begin(); ?>
	<h2>Employee List</h2>
	<?php
	//$gridColumns = [
    //['class' => 'yii\grid\SerialColumn'],
    //'empcode',
    //'empname',
	//'emp_password',
//];
	//echo ExportMenu::widget([
    //'dataProvider' => $dataProvider,
    //'columns' => $gridColumns,
//]);
?>
      <div class="container">
	  <div class="row">
	  <table>
	  <tr><th style="width:1px;">Sl.No</th><th style="width:1px;">Empcode</th><th>EmpName</th><th>Transfer</th></tr>
	  <?php 
	 // foreach ($model as $att) {
		//$unit = unit::findOne($att->unit);
		$division = division::findOne($id);
	  $slno =1;
	  //$emp_list = EmpDetails::find()->where(['status'=>'active'])->all();
	  $emp_list = EmpDetails::find()->where(['division_id' => $division->id, 'status' => 'Active'])
		->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->all();
		 echo '<tr>
		 <td colspan="5">'.$division->division_name.'</td></tr>';
	  foreach($emp_list as $list){
		 echo '<tr>
		 <td>'.$slno.'</td>
		 <td>'.$list->empcode.'</td>
		 <td>'.$list->empname.'</td>
		 <td><a href="index.php?r=project-details/engineer-transfer&id='.$list->id.'">Transfer</a></td>
		
		 </tr>';
		 $slno++;
	  }
	  
	  ?>
	  </table>
	  </div>
	  </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-attendance-menu -->

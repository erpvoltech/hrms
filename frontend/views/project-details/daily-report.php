<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Unit;
use common\models\Division;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\EngineerAttendance;
use common\models\EmpDetails;
use common\models\AttendanceAccessRule;
use common\models\UnitGroup;
//$Attendance = ArrayHelper::map(User::find()->all(), 'id', 'username');
//$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
//$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$this->title ='Attendance Summary';
$AccessRule = AttendanceAccessRule::find()->where(['user'=>Yii::$app->user->identity->id])->all();

 /*$dataprovider = new ActiveDataProvider([
            'query' => EngineerAttendance::find()->where(),
        ]);*/
		
		//$unit = $_GET['uid'];
		//$division = $_GET['did'];
		//$date = $_GET['dt'];
?>
<style>
.sidenav {
  width: 130px;
  position: fixed;
  z-index: 1;
  top: 83px;
  left: 5px;
  background: #fff;
  overflow-x: hidden;
  padding: 8px 0;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 14px;
  color: #2196F3;
  display: block;
}

.sidenav a:hover {
  color: #064579;
}
</style>
<div class="project-details-daily_report">

  

	<div class="row">
	<div class="col-sm-2">
	<!--<div class="sidenav">
  <a href="index.php?r=site%2Findex">Home</a>
  <a href="index.php?r=project-details%2Fattendance-menu">Main-Menu</a>
  <a href="index.php?r=project-details/attendance-index">Attendance</a>
  <!--<a href="#contact">Contact</a>
</div>-->
	</div>
	<div class="col-sm-10">
	
	 <?php $form = ActiveForm::begin();
	//$model->date = $date;
	 ?>
	<div class="row">
	<div class="col-lg-4">
    <?= $form->field($model, 'date')->widget(yii\jui\DatePicker::className(), [
            'dateFormat' => 'dd-MM-yyyy',			
        ]) ?> 
		<!--<input type="hidden" value="<?=//$_GET['uid']?>" id="unit">
		<input type="hidden" value="<?=//$_GET['did']?>" id="division">-->
		</div>
		 <div class="col-lg-1"> <?= Html::Button('Search', ['class' => 'btn-xs btn-primary','id'=>'submitbutton']) ?></div>
     
	
   </div>
    <?php ActiveForm::end(); ?>
	<!--<h4><?= Html::encode($this->title) ?></h4>
	</br>
	<table>
	<tr><th>Name </th><th> Date</th><th> Project</th><th>Attendance </th><th>Action </th> </tr>
	<?php
	
		/* $Engineer = EmpDetails::find()->where(['unit_id'=>$unit,'division_id'=>$division,'status'=>'Active'])->all();
		 foreach($Engineer as $Engg){
			 if($date==""){
				 $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id])->orderBy(['id' => SORT_DESC])->all();
			 }else{
			 $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id,'date'=>Yii::$app->formatter->asDate($date, "yyyy-MM-dd")])->orderBy(['id' => SORT_DESC])->all();
			 }
			  foreach($Attendance as $Att){
				 echo '<tr><td>'.$Engg->empname.'</td>
				 <td>'.$Att->date.'</td>
				 <td>'.$Att->projects->project_code.'</td>
				 <td>'.$Att->attendance.'</td>
				 <td><a href="index.php?r=project-details/attendance-update&id='.$Att->id.'&uid='.$unit.'&did='.$division.'&dt="><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="index.php?r=project-details/attendance-delete&id='.$Att->id.'&uid='.$unit.'&did='.$division.'&dt=" class="confirmation"><span class="glyphicon glyphicon-trash" style="color:red;"></span></a>
				 </td>
				 </tr>'; 
			  }		 
		 }
	
	
	
	/* GridView::widget([
        'dataProvider' => $dataprovider,
        'layout'=>"{items}",
		'columns' => [
		
		//'emp_id',
		
           ['class' => 'yii\grid\SerialColumn',
			'headerOptions' => ['style' => 'width:1%'],
			],
            [
				
               'attribute' => 'emp_id',
               'value' => 'emps.empname',
			   'headerOptions' => ['style' => 'width:3%'],
            ],  
			[
               'attribute' => 'project_id',
               'value' => 'projects.project_code',
			   'headerOptions' => ['style' => 'width:3%'],
            ],  
			[
			   'attribute' => 'date',
				'value'	=>	'date',
				'headerOptions' => ['style' => 'width:5%'],
			
			],
			[
				'attribute'=>'attendance',
				'value'=>'attendance',
				'headerOptions' => ['style' => 'width:5%'],
			],
		   
			/*[
               'attribute' => 'division',
               'value' => 'divisions.division_name',
            ],*/
			
		   
        /*   ['class' => 'yii\grid\ActionColumn',
		   'template' => '{update} {delete} {link}',
		   'buttons' => [                    
					  'update' => function ($model,$key) {
                     return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['attendance-update','id' => $key->id]);                   
                     },
					  'delete' => function ($model,$key) {
                     return Html::a('<span class="glyphicon glyphicon-trash"></span>',['attendance-delete','id' => $key->id],[
					
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?.',
                    
                ],
					 ]);
					
                     },
					 
                ],
		   'headerOptions' => ['style' => 'width:5%'], 
		   
		   ],
        ],
    ]); */
	?>
	</table>-->
   </div>
   </div>
   </div>
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
		var dt = $('#engineerattendance-date').val();
		window.location.href ="index.php?r=project-details/attendance-view&uid="+ $('#unit').val() +"&did="+ $('#division').val() +"&dt="+dt	
	});
	
});
JS;
$this->registerJs($script);

   ?>


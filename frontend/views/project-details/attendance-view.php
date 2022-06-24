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
use common\models\ProjectDetails;
//$Attendance = ArrayHelper::map(User::find()->all(), 'id', 'username');
//$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
//$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$this->title ='Attendance Summary';
$AccessRule = AttendanceAccessRule::find()->where(['user'=>Yii::$app->user->identity->id])->all();
$ProjectDetails = ArrayHelper::map(ProjectDetails::find()->all(), 'id', 'project_code');


 /*$dataprovider = new ActiveDataProvider([
            'query' => EngineerAttendance::find()->where(),
        ]);*/
		
		$unit = $_GET['uid'];
		$division = $_GET['did'];
		$date = $_GET['dt'];
		$ecode = $_GET['ec'];
		$project_id = $_GET['pid'];
		$attendance = $_GET['att'];
		if ($_GET['dtt']) {
    $to_date = Yii::$app->formatter->asDate($_GET['dtt'], "yyyy-MM-dd");
} else {
    $to_date = date('Y-m-d');
}
if ($_GET['dff']) {
    $from_date = Yii::$app->formatter->asDate($_GET['dff'], "yyyy-MM-dd");
} else {
    $from_date = date('Y-m-d');
}
?>
<style>

</style>
<div class="project-details-attendance-view">

  

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
	
	 <?php $form = ActiveForm::begin(['layout' => 'horizontal']);
	$model->date = $date;
	$model->ecode = $ecode;
	$model->project_id = $project_id;
	$model->attendance = $attendance;
	 ?>
	<div class="row">
	<div class="col-md-3">
    From<?= yii\jui\DatePicker::widget([
                                        'id'  => 'from_date',
                                        'dateFormat' => 'dd-MM-yyyy',
										'class' => 'form-control',
                                        'value' => $_GET['dff'],
                                    ]); ?>
		</div>
		<div class="col-md-3">
   To<?= yii\jui\DatePicker::widget([
                                    'id'  => 'to_date',
                                    'dateFormat' => 'dd-MM-yyyy',
                                    'class' => 'form-control',
                                    'value' => $_GET['dtt'],
                                ]); ?>
		</div>	
		<div class="col-md-3">
		 <?= $form->field($model, 'ecode')->label('ECode')?>
		 </div>
		 </div>
		<div class="row">
		 <div class="col-md-4">
		  <?= $form->field($model, 'project_id')->dropDownList(
        $ProjectDetails,
        ['prompt'=>'']
        )->label('Project');?>
		</div>
		<div class="col-lg-3">
		   <?= $form->field($model, 'attendance')->dropDownList(['Present'=>'Present','Leave'=>'Leave','Absent'=>'Absent','Idle'=>'Idle','Travel'=>'Travel','HO'=>'HO','H'=>'H','WO'=>'WO','FN'=>'FN','AN'=>'AN'],['prompt'=>''])->label('Attendance');?>
		   </div>
		<input type="hidden" value="<?=$_GET['uid']?>" id="unit">
		<input type="hidden" value="<?=$_GET['did']?>" id="division">
		<div class="col-lg-1"></div>
		 <div class="col-lg-1"> <?= Html::Button('Search', ['class' => 'btn-xs btn-primary','id'=>'submitbutton']) ?></div>
     
	
   </div>
    <?php ActiveForm::end(); ?>
	<h4><?= Html::encode($this->title) ?></h4>
	</br>
	<table id="tblexp">
	<tr><th>Ecode </th><th>Name </th><th> Date</th><th> Project</th><th>Project Name</th><th>Attendance </th><th>Overtime</th><th>Role</th><th>Spl Allowance</th><th>Advance Amt</th><th>Action </th> </tr>
	<?php
	if($ecode ==""){
		 $Engineer = EmpDetails::find()->where(['unit_id'=>$unit,'division_id'=>$division,'status'=>'Active'])->all();
	}else {
		 $Engineer = EmpDetails::find()->where(['unit_id'=>$unit,'division_id'=>$division,'status'=>'Active','empcode'=>$ecode])->all();
	}
	$end = date('Y-m-d', strtotime($to_date.'+1 day'));
            $daterange = new DatePeriod(new DateTime($from_date), new DateInterval('P1D'), new DateTime($end));
		foreach ($daterange as $attdate) {
		 foreach($Engineer as $Engg){
			 if($date=="" && $project_id=="" && $attendance =="" ){
				 $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id])				 
				 ->orderBy(['id' => SORT_DESC])->all();

			 }else if($attdate !="" && $project_id=="" && $attendance ==""){
					  $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id,'date'=>Yii::$app->formatter->asDate($attdate, "yyyy-MM-dd")])->orderBy(['id' => SORT_DESC])->all();
			
				 }

			 else{
				 if( $project_id !="" && $attdate!= "" && $attendance !="" ){
					  $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id,'project_id'=>$project_id,'attendance'=>$attendance,'date'=>Yii::$app->formatter->asDate($attdate, "yyyy-MM-dd")])->orderBy(['id' => SORT_DESC])->all();
			
				 }else if($project_id !=""  && $attdate!= ""){
					   $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id,'project_id'=>$project_id,'date'=>Yii::$app->formatter->asDate($attdate, "yyyy-MM-dd")])->orderBy(['id' => SORT_DESC])->all();
			
				 }else if( $project_id !="" && $attendance !="" ){
					  $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id,'attendance'=>$attendance])->orderBy(['id' => SORT_DESC])->all();
			
				 }else if( $attdate !="" && $attendance !="" ){
					  $Attendance =  EngineerAttendance::find()->where(['emp_id'=>$Engg->id,'attendance'=>$attendance,'date'=>Yii::$app->formatter->asDate($attdate, "yyyy-MM-dd")])->orderBy(['id' => SORT_DESC])->all();
			
				 }

			 }
			  foreach($Attendance as $Att){
			  	 $project_code = ProjectDetails::find()->Where(['id'=>$Att->project_id])->one();
			  	 if($project_code){
			  		$code=$project_code->project_code;
					$location=$project_code->project_name;
				  }else{
				  $code ="";
				  $location="";}
			  	 //print_r($project_code);
				 echo '<tr><td>'.$Engg->empcode.'</td>
				 <td>'.$Engg->empname.'</td>
				 <td>'.$Att->date.'</td>
				 <td>'.$code.'</td>
				 <td>'.$location.'</td>
				 <td>'.$Att->attendance.'</td>
				 <td>'.$Att->overtime.'</td>
				 <td>'.$Att->role.'</td>
				 <td>'.$Att->special_allowance.'</td>
				 <td>'.$Att->advance_amount.'</td>
				 <td><a href="index.php?r=project-details/attendance-update&id='.$Att->id.'&uid='.$unit.'&did='.$division.'&dt=&ec=&pid=&att=&dff=&dtt="><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="index.php?r=project-details/attendance-delete&id='.$Att->id.'&uid='.$unit.'&did='.$division.'&dt=&ec=&pid=&att=&dff=&dtt=" class="confirmation"><span class="glyphicon glyphicon-trash" style="color:red;"></span></a>
				 </td>
				 </tr>'; 
			  }		 
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
	</table> <br>
<button class="btn btn-success" id="export">Export</button>
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
	
	/*$('#submitbutton').click(function(event){
		var dt = $('#engineerattendance-date').val();
		var ec = $('#engineerattendance-ecode').val();
		var pid = $('#engineerattendance-project_id').val();
		var att = $('#engineerattendance-attendance').val();
		window.location.href ="index.php?r=project-details/attendance-view&uid="+ $('#unit').val() +"&did="+ $('#division').val() +"&dt="+dt+"&ec="+ec+"&pid="+pid+"&att="+att	
	});*/
	$('#submitbutton').click(function(event){
		var dt = $('#engineerattendance-date').val();
		var ec = $('#engineerattendance-ecode').val();
		var pid = $('#engineerattendance-project_id').val();
		var att = $('#engineerattendance-attendance').val();
		window.location.href ="index.php?r=project-details/attendance-view&uid="+ $('#unit').val() +"&did="+ $('#division').val() +"&dt="+dt+"&ec="+ec+"&pid="+pid+"&att="+att+"&dff="+$('#from_date').val()+"&dtt="+$('#to_date').val()
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


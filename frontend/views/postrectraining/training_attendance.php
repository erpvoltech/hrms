<?php
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\TrainingFaculty;
use app\models\TrainingTopics;
use app\models\TrainingBatch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PorecTrainingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Post Recruitment Training';
$this->params['breadcrumbs'][] = $this->title;
$trainingBatchData	=	ArrayHelper::map(TrainingBatch::find()->all(),'id','training_batch_name');
$trainingTopicData	=	ArrayHelper::map(TrainingTopics::find()->all(),'id','topic_name');
$facultyData=ArrayHelper::map(TrainingFaculty::find()->all(),'id','faculty_name');
$facmodel = new TrainingFaculty();
$topicmodel = new TrainingTopics();
?>

<style>
/*tbody{
	display: none;
}*/
</style>

<div class="porec-training-index">
<div class="panel panel-info">
   <div class="panel-heading text-center" style="font-size:18px;">Training Attendance</div>
   <div class="panel-body">
   <h1><?= Html::encode($this->title) ?></h1>
    <div class="porec-training-index">
		<?php $form = ActiveForm::begin(			
				['action' => ['postrectraining/attendanceadd'],'method' => 'post','layout' => 'horizontal',
				]); ?>
		<br>	
		<div class="row">
			<div class="form-group col-lg-6">
				<?= $form->field($model, 'training_batch_id')->dropDownList($trainingBatchData,
				['prompt'=>'Select...']) ?>
			</div>				
	
			<div class="form-group col-lg-2" id="submit_div" style="display: none;">
				<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
				<?php //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
			</div>	
		</div>
		<div class="row" >
			<div align="right" id='statusdiv' style="display: none;">
				<?php #echo $this->render('_faculty'); ?>
				<div class="form-group col-lg-4">
				<?= $form->field($facmodel, 'faculty_name')->dropDownList($facultyData,
					['prompt'=>'Select...']) ?>
				</div>	

				<div class="form-group col-lg-4">
				<?= $form->field($topicmodel, 'topic_name')->dropDownList($trainingTopicData,
					['prompt'=>'Select...']) ?>
				</div>					
				<?php /*<?= $form->field($model, 'training_batch_id')->hiddenInput(['value'=>$training_batch_id])->label(false); ?>
				<?= $form->field($model, 'training_topic_id')->hiddenInput(['value'=>$training_topic_id])->label(false); ?> */ ?>
				
				<div class="form-group col-lg-4">
					<?php /* <?= $form->field($model, 'attendance_date')->widget(\yii\jui\DatePicker::class, [ 'options' => ['class' => 'form-control'],
						'clientOptions' =>[
							'numberOfMonths' => 1,							
							'minDate' => '+1m +1w',
							'changeMonth' => true,
							'onClose' => new \yii\web\JsExpression('function( selectedDate ) {
								$( "#'.Html::getInputId($model, 'date_to').'" ).datepicker( "option", "minDate", selectedDate ); 
							}'),
						],
					]) ?> */ ?>
					
					 <?= $form->field($model, 'attendance_date')->widget(\yii\jui\DatePicker::class, [ 'options' => ['class' => 'form-control'],
						//'language' => 'ru',
						//'dateFormat' => 'yyyy-MM-dd',											
					]) ?> 
					<!--<input type="text" name="porectraining-attendance_date" id="porectraining-attendance_date" class="form-control" />-->										
				</div>				
			</div>
		</div>
		<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">		
		</div>
		
			<!--<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">			
			</div>-->
			<br>
			<?= $form->field($model, 'rec_id')->hiddenInput(['value'=>''])->label(false); ?>
				
		<?php ActiveForm::end(); ?>
	</div>	
</div>
</div>
</div>

<?php 
$script = <<< JS
	$("#porectraining-training_batch_id").change(function(){		

		var training_batch	= $("#porectraining-training_batch_id").val();
		
		$.post("index.php?r=postrectraining/ajax-trainingselection",{'training_batch_id':training_batch},function(response){	
		//$.post("ajax-trainingselection",{'training_batch_id':training_batch},function(response){	
			//alert(response);
			$("#trainingbatch_grid").html(response).show();
			$("#statusdiv").show();
			$("#submit_div").show();
		})		
	});
	
	function dateWithin(StartDate,EndDate,CheckDate) {
	var b,e,c;
	s = Date.parse(StartDate);
	e = Date.parse(EndDate);
	c = Date.parse(CheckDate);
	if((c <= e && c >= s)) {
	return true;
	}
	return false;
	}
	
	$("#w0").submit(function(){
		var attendance_date		=	$("#porectraining-attendance_date").val();
		var checklength			=	$('[name="selection[]"]:checked').length;
		//alert("checklength: "+checklength);
		if(checklength == 0){
			alert("choose the name");
			return false;
		}
	});
	
	
	/*$("#porectraining-attendance_date").change(function(){
		var attendance_date		=	$(this).val();
		//alert(attendance_date);
		
		var training_startdate	=	$("#training_startdate").val();
		var training_enddate	=	$("#training_enddate").val();
		
		fDate = Date.parse($('#training_startdate').val());   
		lDate = Date.parse($('#training_enddate').val());
		cDate = Date.parse($(this).val());
		
		alert("fDate: "+fDate);
		alert("lDate: "+lDate);
		alert("cDate: "+cDate);
		
		if((cDate <= fDate && cDate >= lDate)) {
			alert("true");
			return true;
		}else{
			alert("false");
			return false;
		}
				
		
		
	});*/
JS;
$this->registerJs($script);
?>
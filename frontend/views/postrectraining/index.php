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

$facultyData=ArrayHelper::map(TrainingFaculty::find()->all(),'id','faculty_name');
$facmodel = new TrainingFaculty();

$topicData=ArrayHelper::map(TrainingTopics::find()->all(),'id','topic_name');
$topicmodel = new TrainingTopics();

?>

<style>
/*tbody{
	display: none;
}*/
</style>

<div class="porec-training-index">
<div class="panel panel-info">
   <div class="panel-heading text-center" style="font-size:18px;">Post Recruitment Training</div>
   <div class="panel-body">
   <h1><?= Html::encode($this->title) ?></h1>
    <div class="porec-training-index">
		<?php $form = ActiveForm::begin(
				
				['action' => ['postrectraining/print1'],'method' => 'post','layout' => 'horizontal',
				]); ?>
		<br>	
		<div class="row">
				<div class="form-group col-lg-6">
					<?= $form->field($model, 'training_batch_id')->dropDownList($trainingBatchData,
					['prompt'=>'Select...']) ?>
				</div>		
				
				<div class="form-group col-lg-2" id="print_div" style="display: none;">
					<?= Html::submitButton('Print', ['class' => 'btn btn-success print_submit']) ?>
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
				
				<div class="form-group col-lg-8">
				<?= $form->field($topicmodel, 'topic_name')->dropDownList($topicData,
					['prompt'=>'Select...']) ?>
				</div>
				<div class="form-group col-lg-4">
				<?= $form->field($model, 'print_date')->widget(\yii\jui\DatePicker::class, [ 'options' => ['class' => 'form-control'],
						//'language' => 'ru',
						//'dateFormat' => 'yyyy-MM-dd',											
					]) ?> 
				</div>
				<div class="form-group col-lg-4">
				<?= $form->field($facmodel, 'print_type')->dropDownList(
					['print1'=>'attendance','print2'=>'feedback','print3'=>'feedback effectiveness'],['prompt'=>'Select...']) ?>
				</div>				
				<?php /*<?= $form->field($model, 'training_batch_id')->hiddenInput(['value'=>$training_batch_id])->label(false); ?>
				<?= $form->field($model, 'training_topic_id')->hiddenInput(['value'=>$training_topic_id])->label(false); ?> */ ?>
							
			</div>
		</div>
		<div style="color: #a94442;display: none; padding: 15px;" id="selection_error"></div>
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
	$("#w0").trigger('reset');
	$("#selection_error").hide();

	$("#porectraining-training_batch_id").change(function(){		

		var training_batch	= $("#porectraining-training_batch_id").val();
		//alert("training_batch: "+training_batch);
		$.post("index.php?r=postrectraining/ajax-trainingselection",{'training_batch_id':training_batch},function(response){	
		//$.post("postrectraining/ajax-trainingselection",{'training_batch_id':training_batch},function(response){	
			//alert(response);
			$("#trainingbatch_grid").html(response).show();
			$("#statusdiv").show();
			$("#print_div").show();
		})		
	});
	
	$(".print_submit").click(function(){
		
		var cheklength	=	$('input[name="selection[]"]:checked').length;
		if(cheklength	==	0){
			var newRowContent = "Selection cannot be blank";

			$("#selection_error").html(newRowContent).show(); 
			return false;
		}
		
	});
	
	$("#trainingfaculty-print_type").change(function(){
		var print_type	=	$("#trainingfaculty-print_type").val();
		if(print_type	==	"print1")
		{ 			
			$('#w0').attr('action', 'index.php?r=postrectraining/print1');
			//$('#w0').attr('action', 'postrectraining/print1');
		}
		if(print_type	==	"print2" )
		{ 
			$('#w0').attr('action', 'index.php?r=postrectraining/print2');
			//$('#w0').attr('action', 'postrectraining/print2');
		}
		if(print_type	==	"print3" )
		{ 
			$('#w0').attr('action', 'index.php?r=postrectraining/print3');
			//$('#w0').attr('action', 'postrectraining/print3');
		}
	})	
	
	$("#porectraining-attendance_date").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '2018:2030',
            firstDay: 1,
            dateFormat: 'dd-mm-yy',
            //maxDate:0
    });
	
	

JS;
$this->registerJs($script);
?>
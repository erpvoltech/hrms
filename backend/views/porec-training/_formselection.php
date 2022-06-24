<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */
/* @var $form yii\widgets\ActiveForm */
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

use app\models\TrainingTopics;
use app\models\TrainingBatch;
use yii\helpers\ArrayHelper;

use yii\db\ActiveQuery;
use yii\db\Query;

$trainingBatchData	=	ArrayHelper::map(TrainingBatch::find()->all(),'id','training_batch_name');
#echo "<pre>";print_r($recruitmentData);echo "</pre>";
?>

<div class="porec-training-form">
<div class="porec-training-index">
	<?php $form = ActiveForm::begin(			
            ['action' => ['porec-training/statusupdate'],'layout' => 'horizontal']); ?>
    <br>	
	<div class="row">
            <div class="form-group col-lg-4">
				<?= $form->field($model, 'training_batch_id')->dropDownList($trainingBatchData,
				['prompt'=>'Select...']) ?>
			</div>
			<div class="form-group col-lg-4" id='statusdiv' style="display: none;">
                <?= $form->field($model, 'status')->dropDownList([ 'selected' => 'Selected', 'hold' => 'Hold', 'rejected' => 'Rejected',], ['prompt' => '']) ?>
			</div>
    </div>
	<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">
		
	</div>	  		
		<!--<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">
		
		</div>-->
		<br>
		<?= $form->field($model, 'rec_id')->hiddenInput(['value'=>''])->label(false); ?>
    <br>
    <div class="form-group">
      <div class="col-lg-5"> </div>
      <div class="col-lg-3"> <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success savebutton']) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php 
$script = <<< JS
$(".field-porectraining-name").hide();
$(".field-porectraining-register_no").hide();
$('form').attr('autocomplete', 'off');

$("#porectraining-training_enddate").change(function(){	
	
	var startDate = new Date($('#porectraining-training_startdate').val());
	var endDate = new Date($('#porectraining-training_enddate').val());
	
	if (endDate < startDate){
		alert("Training End date should greater than start date");
		$('#porectraining-training_enddate').select();
		$('#porectraining-training_enddate').focus();
		$('#porectraining-training_enddate').val('');
		return false;
	}
});

$("#porectraining-training_batch_id").change(function(){		

	var training_batch	= $("#porectraining-training_batch_id").val();
			
		//$.post("ajax-exist",{'training_batch':training_batch,'action':'trainingSelection'},function(response){		
		$.post("ajax-trainingselection",{'training_batch_id':training_batch},function(response){	
			//alert(response);
			$("#trainingbatch_grid").html(response).show();
			$("#statusdiv").show();
		})		
});

$("#porectraining-ecode").change(function(){
	var ecode_val	=	$("#porectraining-ecode option:selected").text();	
	var ecode_name	=	ecode_val.split("-");	
	$("#porectraining-name").val(ecode_name);
});

$("#porectraining-name").change(function(){
	$("#porectraining-batch_id").val('');
	var recruitment_id	=	$("#porectraining-name").val();
	$.post("ajax-getregisterno",{'id':recruitment_id},function(response){
			//alert("response: "+response);
			$("#regno_id").show();
			$("#register_no").html(response);				
	})
});

$(".savebutton").click(function(){
	var status			=	$("#porectraining-status").val();
	var checklength		=	$('input[name="selection[]"]:checked').length;
	
	if(status	==	''){
		alert("Choose the status");
		$("#porectraining-status").focus();
		return false;
	}
	
	if(checklength  == 0 ){
		alert("Choose the name to give status");
		$("recruitmentcheckbox").focus();
		return false;
	}
})

/*$("#w0").submit(function(){
	//alert("hi");
	var training_type	=	$("#porectraining-training_type").val();
	//alert("training_type: "+training_type);
	if(training_type == 'new'){
		var name	=	$("#porectraining-name").val();
		if(name	==	''){
			alert("Please enter name");
			$("#porectraining-name").focus();
			return false;
		}
	}
	
	if(training_type == 'existing'){		
		var ecode				= $("#porectraining-ecode").val();
		var division			= $("#porectraining-division").val();
		var unit_id				= $("#porectraining-unit_id").val();
		var department_id		= $("#porectraining-department_id").val();
		if(ecode	==	''){
			alert("Please choose the ecode");
			$("#porectraining-ecode").focus();
			return false;
		}
		
		if(division	==	''){
			alert("Please choose the division");
			$("#porectraining-division").focus();
			return false;
		}
		
		if(unit_id	==	''){
			alert("Please choose the unit");
			$("#porectraining-unit_id").focus();
			return false;
		}
		
		if(department_id	==	''){
			alert("Please choose the department");
			$("#porectraining-department_id").focus();
			return false;
		}
	}
});*/

JS;
$this->registerJs($script);
?>
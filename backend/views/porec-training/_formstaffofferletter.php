<?php
#use Yii;
#use DateTime;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
#use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */
/* @var $form yii\widgets\ActiveForm */
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\TrainingTopics;
use app\models\RecruitmentBatch;
use app\models\TrainingBatch;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\db\Query;

$recruitmentBatchData	=	ArrayHelper::map(RecruitmentBatch::find()->all(),'id','batch_name');
$trainingBatchData		=	ArrayHelper::map(TrainingBatch::find()->all(),'id','training_batch_name');
#echo "<pre>";print_r($recruitmentData);echo "</pre>";
?>

<div class="porec-training-form">
<div class="porec-training-index">

	<?php $form = ActiveForm::begin(			
            ['action' => ['porec-training/sendbulkofferletter'],'layout' => 'horizontal']); ?>
    <br>	
	<div class="row">
            <div class="form-group col-lg-4">
				<?= $form->field($model, 'offerletter_type')->dropDownList([ 'bulk' => 'Bulk', 'individual' => 'Individual'], ['prompt' => '']) ?>
			</div>
	</div>
	
	<div class="form-group col-lg-4" id="offerdate_div" >		
			<?= $form->field($model,'offer_date')->widget(yii\jui\DatePicker::className(),['clientOptions' => ['dateFormat' => 'yy-mm-dd']]) ?> 
	</div>
	
	<!--<div class="row">
            <div class="form-group col-lg-4">
				<?= $form->field($model, 'id')->dropDownList($trainingBatchData,
				['prompt'=>'Select...']) ?>				
			</div>			
    </div>-->
	
	
	<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">		
			
	</div>	
	
	<!--<div id="offerletter_grid" class="col-lg-12" style="display: none;">
		<input type="hidden" name="recruitment_id" id="recruitment_id" value="" />
		<?php /*<?= $form->field($model, 'offerletter')->widget(CKEditor::className(), [
			'options' => ['rows' => 10],		
			'preset' => 'full',		
		]) ?> */?>
		<textarea id="offerletter" name="offerletter"></textarea>		
	</div>	-->
	
		<!--<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">
		
		</div>-->
		<br>
		<?= $form->field($model, 'porec_id')->hiddenInput(['value'=>''])->label(false); ?>
    
    <?php ActiveForm::end(); ?>
</div>

<?php 
$script = <<< JS
$(".field-porectraining-name").hide();
$(".field-porectraining-register_no").hide();
$('form').attr('autocomplete', 'off');

$("#recruitment-offer_date").change(function(){	
	var offer_date				=	$("#recruitment-offer_date").val();	
	var offerletter_type		= 	$("#recruitment-offerletter_type").val();
	if(offerletter_type	==	'individual'){		
		$.post("ajax-staffofferletterselection",{'offer_date':offer_date},function(response){		
			$("#offerdate_div").show();
			$("#trainingbatch_grid").html('').show();
			$("#trainingbatch_grid").html(response).show();
			$("#statusdiv").show();
		})
	}
	if(offerletter_type	==	'bulk'){		
		
		$.post("ajax-staffbulkofferletterselection",{'offer_date':offer_date},function(response){	
			//alert(response);
			$("#trainingbatch_grid").html('').show();
			$("#offerdate_div").show();
			$("#trainingbatch_grid").html(response);
			$("#statusdiv").show();
		})
	}
});

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

$("#recruitment-id").change(function(){		

	var recruitment_batch		= $("#recruitment-id").val();
	var offerletter_type		= $("#recruitment-offerletter_type").val();
	var offer_date				= $('#recruitment-offer_date').val();
	//alert('offer_date: '+offer_date);	
	if(offerletter_type	==	'individual'){		
		$("#trainingbatch_grid").html('<center><img src="../../web/img/loadingimg.gif" ></center>');
		$.post("ajax-offerletterselection",{'batch_id':recruitment_batch,'offer_date':offer_date},function(response){	
			//alert(response);
			//$("#trainingbatch_grid").append(response).show();
			$("#offerdate_div").show();
			
			$("#trainingbatch_grid").html(response).show();
			$("#statusdiv").show();
		})
	}
	
	if(offerletter_type	==	'bulk'){		
		//$("#trainingbatch_grid").html('<center><img src="../../web/img/loadingimg.gif" ></center>');
		$.post("ajax-bulkofferletterselection",{'batch_id':recruitment_batch,'offer_date':offer_date},function(response){	
			//alert(response);
			$("#trainingbatch_grid").show();
			$("#offerdate_div").show();
			$("#trainingbatch_grid").html(response);
			$("#statusdiv").show();
		})
	}
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
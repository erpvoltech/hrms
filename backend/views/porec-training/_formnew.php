<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Division;
use common\models\Unit;
use common\models\Department;
use app\models\TrainingTopics;
use app\models\TrainingBatch;
use app\models\RecruitmentBatch;
use app\models\Recruitment;
use common\models\EmpDetails;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\db\Query;

$divisionData=ArrayHelper::map(Division::find()->all(),'id','division_name');
$unitData=ArrayHelper::map(Unit::find()->all(),'id','name');
$deptData=ArrayHelper::map(Department::find()->all(),'id','name');
$topicsData=ArrayHelper::map(TrainingTopics::find()->all(),'id','topic_name');
$batchData=ArrayHelper::map(RecruitmentBatch::find()->all(),'id','batch_name');
$recruitmentData=ArrayHelper::map(Recruitment::find()->where(['and',"status='selected'"])->all(),'id','name');
if($model->ecode){
	$ecodeData=[$model->ecode];
}else{
	$ecodeData=[];
}
$trainingBatchData	=	ArrayHelper::map(TrainingBatch::find()->all(),'id','training_batch_name');
#echo "<pre>";print_r($recruitmentData);echo "</pre>";
?>

<div class="porec-training-form">
<div class="porec-training-index">
	<?php
		Modal::begin([
			'header' => '<h4 style="color:#007370;text-align:center">Training Batch Creation</h4>',
			'id' => 'TrainingModelBatch',
		]);
		echo "<div id='TrainingModelBatchContent'></div>";
		Modal::end();
	?>
    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
    <br>
	
	<div class="row">
            <div class="form-group col-lg-4 ">
    <?= $form->field($model, 'batch_id')->dropDownList($batchData,
        ['prompt'=>'Select...']) ?>
            </div>
    </div>
	<div id="recruitmentbatch_grid" class="col-lg-12" style="display: none;">		
	</div>
	  
    <!--<div class="row">    		
		<div class="form-group col-lg-4">				
		</div>      
		<div class="form-group col-lg-4" id="regno_id" style="display: none;">
			<label>Register No<div id="register_no"></div></label>	
		</div>   
    </div>-->
    <br>	
		<div class="row">
			<div class="form-group col-lg-4">
			<?= $form->field($model, 'training_batch_id')->dropDownList($trainingBatchData,
				['prompt'=>'Select...']) ?>
			</div>
			
			<div class="col-md-1"><?= Html::button('', ['value' => Url::to('trainingbatchcreate'), 'class' => 'glyphicon glyphicon-plus-sign btn btn-default btn-sm', 'id' => 'TrainingBatchButton']) ?>  </div> 
		</div>
	
        <div class="row">
           <div class="form-group col-lg-4">
			<?= $form->field($model, 'training_startdate')->widget(\yii\jui\DatePicker::class, [ 'options' => ['class' => 'form-control'],
				//'language' => 'ru',
				//'dateFormat' => 'yyyy-MM-dd',
			]) ?>
          </div>
          <div class="form-group col-lg-4">
			<?= $form->field($model, 'training_enddate')->widget(\yii\jui\DatePicker::class, [ 'options' => ['class' => 'form-control'],
				//'language' => 'ru',
				//'dateFormat' => 'yyyy-MM-dd',
			]) ?>
          </div>
          <!--<div class="form-group col-lg-4 ">
			<?= $form->field($model, 'trainig_topic_id')->dropDownList($topicsData,
				['prompt'=>'Select...']) ?>
          </div>-->
        </div>
		
		<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">
		
		</div>
		<br>
		<?= $form->field($model, 'recruitment_id')->hiddenInput(['value'=>''])->label(false); ?>
                
    <!--<?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>-->
    <br>
    <div class="form-group">
      <div class="col-lg-5"> </div>
      <div class="col-lg-3"> <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?></div>
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

$("#porectraining-batch_id").change(function(){		

	var batch	= $("#porectraining-batch_id").val();
			
		//$.post("ajax-exist",{'ecode':ecode,'batch':batch,'startDate':startDate,'endDate':endDate,'action':'create'},function(response){		
		$.post("ajax-selectedrecriutment",{'batch':batch},function(response){	
			//alert(response);
			$("#recruitmentbatch_grid").html(response).show();
			//$("#recruitmentbatch_grid").show();
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
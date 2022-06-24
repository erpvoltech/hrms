<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */
/* @var $form yii\widgets\ActiveForm */

use common\models\Division;
use common\models\Unit;
use common\models\Department;
use app\models\TrainingTopics;
use app\models\RecruitmentBatch;
use app\models\Recruitment;
use common\models\EmpDetails;
use yii\helpers\ArrayHelper;

$divisionData=ArrayHelper::map(Division::find()->all(),'id','division_name');
$unitData=ArrayHelper::map(Unit::find()->all(),'id','name');
$deptData=ArrayHelper::map(Department::find()->all(),'id','name');
$topicsData=ArrayHelper::map(TrainingTopics::find()->all(),'id','topic_name');
$batchData=ArrayHelper::map(RecruitmentBatch::find()->all(),'id','batch_name');
$recruitmentData=ArrayHelper::map(Recruitment::find()->where(['and',"status='selected'"])->all(),'id','name');
if($model->ecode){
	$ecodeData	=	[$model->ecode];
	#$ecodeData	=	ArrayHelper::map($model->ecode,'id','name');
}else{
	$ecodeData=[];
}
#echo "<pre>";print_r($recruitmentData);echo "</pre>";
?>

<div class="porec-training-form">
<div class="porec-training-index">

    <?php $form = ActiveForm::begin(
            ['layout' => 'horizontal']); ?>
    <br>
	
	<!--<div class="row">
            <div class="form-group col-lg-4 ">
    <?= $form->field($model, 'batch_id')->dropDownList($batchData,
        ['prompt'=>'Select...']) ?>
            </div>
     </div>-->
	
<div class="row">
            <div class="form-group col-lg-4 ">
    <?= $form->field($model, 'training_type')->dropDownList(['existing' => 'Existing','new' => 'New']) ?>
            </div>
	<?php if($model->training_type == 'existing'){ ?>
    <div class="form-group col-lg-4">
	<!--<?= $form->field($model, 'division')->dropDownList([ 'Ho Staff' => 'Ho Staff', 'Bo Staff' => 'Bo Staff', 'International Engineer' => 'International Engineer', 'Domestic Engineer' => 'Domestic Engineer'],['prompt'=>' '] ) ?>-->
    <?= $form->field($model, 'division')->dropDownList($divisionData,
        ['prompt'=>'Select...']) ?>
	</div>
    <div class="form-group col-lg-4">
    <?= $form->field($model, 'unit_id')->dropDownList($unitData,
        ['prompt'=>'Select...']) ?>
    </div>
	<?php } ?>
</div>
    <br>
    <?php if($model->training_type == 'existing'){ ?>
    <div class="row">
            <div class="form-group col-lg-4">
    <?= $form->field($model, 'department_id')->dropDownList($deptData,
        ['prompt'=>'Select...']) ?>
            </div>
       <div class="form-group col-lg-4 ">		   
		   <div class="form-group field-porectraining-ecode">
		   <label class="control-label col-sm-3" for="porectraining-ecode">Ecode</label>
		   <div class="col-sm-6"> 
		   <select id="porectraining-ecode" class="form-control" name="PorecTraining[ecode]">
				<option value="<?php echo $model->ecode ?>"><?php echo $model->ecode ?></option>
		   </select>
		   </div>
		   </div>
		   
		<!--<?= $form->field($model, 'ecode')->dropDownList($ecodeData) ?>	-->	<!--<?= $form->field($model, 'ecode')->dropDownList($ecodeData,['prompt'=>'Select...']) ?>-->
       </div>       
    </div>
	<?php } ?>
	<?php if($model->training_type == 'new'){ ?>
    <div class="row">    		
		<div class="form-group col-lg-4">
			<?= $form->field($model, 'name')->dropDownList($recruitmentData,['prompt'=>'Select...']) ?>
			<!--<?= $form->field($model, 'name')->textInput() ?>-->
		</div>      
		<div class="form-group col-lg-4" id="regno_id" style="display: none;">
			<label>Register No<div id="register_no"></div></label>	
		</div>   
    </div>
	<?php } ?>
    <br>
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
          <div class="form-group col-lg-4 ">
    <?= $form->field($model, 'trainig_topic_id')->dropDownList($topicsData,
        ['prompt'=>'Select...']) ?>
          </div>
        </div>
    <br>
     <div class="row">
            <div class="form-group col-lg-4 ">
    <?= $form->field($model, 'batch_id')->dropDownList($batchData) ?>
            </div>
     </div>
    <!--<?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>-->
    <br>
    <div class="form-group">
      <div class="col-lg-5" > </div>
      <div class="col-lg-3" > <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php 
$script = <<< JS

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

$("#porectraining-department_id").change(function(){
	var division	=	$("#porectraining-division").val();
	var unit		=	$("#porectraining-unit_id").val();
	var department	=	$("#porectraining-department_id").val();
	//alert("division: "+division);
	//alert("unit: "+unit);
	//alert("department: "+department);
	
	$.post("ajax-ecode",{'division':division,'unit':unit,'department':department},function(data){
		//alert(data);
		$("#porectraining-ecode").html(data);
		var ecode_val	=	$("#porectraining-ecode option:selected").text();		
		var ecode_name	=	ecode_val.split("-");	
		$("#porectraining-name").val(ecode_name[1]);
	});	
});

$("#porectraining-batch_id").change(function(){	

	var training_type	=	$("#porectraining-training_type").val();
	var name			= $("#porectraining-name").val();
	//var ecode			= $("#porectraining-ecode").val();
	var batch			= $("#porectraining-batch_id").val();
	var startDate 		= $('#porectraining-training_startdate').val();
	var endDate 		= $('#porectraining-training_enddate').val();
	
	if(name	==	'' && training_type == 'new'){
		alert("Enter the name");
		$("#porectraining-name").focus();
		$("#porectraining-batch_id").val('');
		return false;
	}
	
	if(training_type	==	'new' && name != ''){	
		//$.post("ajax-exist",{'ecode':ecode,'batch':batch,'startDate':startDate,'endDate':endDate},function(response){		
		$.post("ajax-exist",{'name':name,'batch':batch,'startDate':startDate,'endDate':endDate,'action':'update'},function(response){		
			
			if(response >= 1){
				alert("Name already assigned for training");
				$("#porectraining-batch_id").val('');
				return false;
			}		
		})	
	}
});

$("#porectraining-training_type").change(function(){
	var training_type	=	$("#porectraining-training_type").val();
	//alert("training_type: "+training_type);
	
	if(training_type == 'new'){
		$(".field-porectraining-division").hide();
		$(".field-porectraining-unit_id").hide();
		$(".field-porectraining-department_id").hide();
		$(".field-porectraining-ecode").hide();		
		$(".field-porectraining-name").show();		
	}
	
	if(training_type == 'existing'){
		$(".field-porectraining-division").show();
		$(".field-porectraining-unit_id").show();
		$(".field-porectraining-department_id").show();
		$(".field-porectraining-ecode").show();		
		$(".field-porectraining-name").hide();
	}
})

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

$("#w0").submit(function(){
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
});

JS;
$this->registerJs($script);
?>
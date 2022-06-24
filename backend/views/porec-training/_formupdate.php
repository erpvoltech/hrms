<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */
/* @var $form yii\widgets\ActiveForm */
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\models\Division;
use common\models\Unit;
use common\models\Department;
use app\models\TrainingTopics;
use app\models\RecruitmentBatch;
use app\models\Recruitment;
use yii\helpers\ArrayHelper;
use app\models\TrainingBatch;
use common\models\EmpDetails;


$divisionData=ArrayHelper::map(Division::find()->all(),'id','division_name');
$unitData=ArrayHelper::map(Unit::find()->all(),'id','name');
$deptData=ArrayHelper::map(Department::find()->all(),'id','name');
$topicsData=ArrayHelper::map(TrainingTopics::find()->all(),'id','topic_name');
$batchData=ArrayHelper::map(RecruitmentBatch::find()->all(),'id','batch_name');
#$recruitmentData=ArrayHelper::map(Recruitment::find()->all(),'id','register_no');
$ecodeData	=	[];
$trainingBatchData	=	ArrayHelper::map(TrainingBatch::find()->all(),'id','training_batch_name');
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
	
    <?php $form = ActiveForm::begin(
            ['layout' => 'horizontal']); ?>
    <br>
	
	<div class="row">
			<input type="hidden" id="training_id_hidden" value="<?php echo $model->id; ?>" />
			<div class="form-group col-lg-4 ">
				<?= $form->field($model, 'training_type')->dropDownList(['existing' => 'Existing','new'=>'New']) ?>
			</div>
			<!--<div class="form-group col-lg-4 ">
				<?= $form->field($model, 'division')->dropDownList($divisionData,['prompt'=>'Select...']) ?>
			</div>
			<div class="form-group col-lg-4 ">
				<?= $form->field($model, 'unit_id')->dropDownList($unitData,
					['prompt'=>'Select...']) ?>
			</div>-->
	</div>
    <br>
    
    <div class="row">
            <!--<div class="form-group col-lg-4">
    <?= $form->field($model, 'department_id')->dropDownList($deptData,
        ['prompt'=>'Select...']) ?>
            </div>-->
       <!--<div class="form-group col-lg-4 ">
	<?= $form->field($model, 'ecode')->dropDownList($ecodeData,['prompt'=>'Select...']) ?>
       </div>   -->    
    </div>
  
    <br>
	<?= $form->field($model, 'ecode_id')->hiddenInput(['value'=>''])->label(false); ?>
	<div id="employee_grid" class="col-lg-12" style="display: none;">	
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
          <div class="form-group col-lg-4">
    <?= $form->field($model, 'trainig_topic_id')->dropDownList($topicsData,
        ['prompt'=>'Select...']) ?>
          </div>
        </div>
    <br>
     <div class="row">
            <div class="form-group col-lg-4">
			<?php /* $form->field($model, 'batch_id')->dropDownList($batchData,
			['prompt'=>'Select...']) */ ?>
			<?= $form->field($model, 'training_batch_id')->dropDownList($trainingBatchData,
				['prompt'=>'Select...']) ?>
            </div>
			<div class="col-md-1"><?= Html::button('', ['value' => Url::to('trainingbatchcreate'), 'class' => 'glyphicon glyphicon-plus-sign btn btn-default btn-sm', 'id' => 'TrainingBatchButton']) ?>  </div> 
     </div>
	<div id="trainingbatch_grid" class="col-lg-12" style="display: none;">	
		<?php			
			/*$empModel = new EmpDetails();	
			$query = EmpDetails::find()->where(['status'=>'active']);
						
			$dataProvider = new ActiveDataProvider([
				'query' => $query,
			]);
		
			echo GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $empModel,
				'id' => 'ecode_grid',		
				'columns' => [
					['class' => 'yii\grid\SerialColumn'], 						
					['class' => 'yii\grid\CheckboxColumn',
						'checkboxOptions' => ["attribute" => 'id', "class" => 'ecodecheckbox'],
					],	
					'empcode',
					'empname',	
				],
			]);*/
		?>
	</div>	
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

var training_id_hidden	=	$("#training_id_hidden").val();
//alert("training_id_hidden: "+training_id_hidden);
$.post("ajax-ecodeupdate",{'training_id':training_id_hidden},function(data){
	$("#employee_grid").html(data).show();	
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

/*$("#porectraining-department_id").change(function(){
	var division	=	$("#porectraining-division").val();
	var unit		=	$("#porectraining-unit_id").val();
	var department	=	$("#porectraining-department_id").val();
	//alert("division: "+division);
	//alert("unit: "+unit);
	//alert("department: "+department);
	
	$.post("ajax-ecode",{'division':division,'unit':unit,'department':department},function(data){
		$("#employee_grid").html(data).show();
		//$("#porectraining-ecode").html(data);
		//var ecode_val	=	$("#porectraining-ecode option:selected").text();		
		//var ecode_name	=	ecode_val.split("-");	
		//$("#porectraining-name").val(ecode_name[1]);
	});	
});*/

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
		$.post("ajax-exist",{'name':name,'batch':batch,'startDate':startDate,'endDate':endDate},function(response){		
			
			if(response >= 1){
				alert("Ecode already assigned for training");
				$("#porectraining-batch_id").val('');
				return false;
			}		
		})	
	}
});

$("#porectraining-ecode").change(function(){
	var ecode	= $("#porectraining-ecode").val();
	$.post("ajax-selectedecode",{'ecode':ecode},function(response){	
		//alert(response);
		$("#trainingbatch_grid").html(response).show();
		//$("#recruitmentbatch_grid").show();
	})		
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

$("#porectraining-name").keyup(function(){
	$("#porectraining-batch_id").val('');
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
		
		/*if(division	==	''){
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
		}*/
	}
});

JS;
$this->registerJs($script);
?>
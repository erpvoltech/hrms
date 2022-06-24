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
use app\models\Recruitment;
use app\models\PorecTraining;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\db\Query;

$recruitmentBatchData	=	ArrayHelper::map(RecruitmentBatch::find()->all(),'id','batch_name');
$trainingBatchData		=	ArrayHelper::map(TrainingBatch::find()->all(),'id','training_batch_name');
#echo "<pre>";print_r($recruitmentData);echo "</pre>";
?>

<div class="porec-training-create">
<div class="panel panel-default">
   <div class="panel-heading text-center">Waiting for Join </div>
	<div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(			
            ['action' => ['porec-training/joinprocess'],'layout' => 'horizontal']);  
	#$query 	= PorecTraining::find()->where(['offerletter_status'=>'1'])->all();
	$query 	= Recruitment::find()->where(['offerletter_status'=>'1'])->orderBy(['training_batch_id' => SORT_DESC])->all();
	?>	
				
		<table> 
		<thead>
		<th> <input type="checkbox" id="check_head" name="check_head" class="check_head"></th> 
		<th> Name </th>
		<th> Register no </th>		
		<!--<th> Training Start </th>
		<th> Training End </th>-->
		<th> Training Batch </th>
		<th> Status </th>
		</thead>
		<?php
		foreach($query as $res){		
			
				$recid_val	=	$res->id;
				#$queryrec 	= 	PorecTraining::find()->where(['id'=>$res->training_id])->one();
				#echo "<pre>";echo $res->training_id;echo "</pre>";
				//exit;
			
		?>		<?php
					if($res->join_status == ''){
					?>	
			<tr>
				<td>
					
						<input type="checkbox" name="join[]" id="join_<?php echo $recid_val; ?>" class="join" value="<?php echo $recid_val; ?>" >
					<?php //} ?>
				</td>
				<td>
				
				<?php echo $res->name; ?>
				</td>
				
				<td><?php echo $res->register_no; ?></td>				
				<!--<td><?php #echo date("d-m-Y",strtotime($queryrec->training_startdate)); ?></td>
				<td><?php #echo date("d-m-Y",strtotime($queryrec->training_enddate)); ?></td>
				<?php $querytrainbatch = TrainingBatch::find()->where(['id'=>$res->training_batch_id])->all(); ?>
				-->
				<td>
				<?php #echo "</br>training_batch_id: ".$res->training_batch_id; ?>
				<?php foreach($querytrainbatch as $restrbatch){ 	
					echo $restrbatch->training_batch_name; 
				} ?>
				</td>
				<td>
					<?php if($res->join_status == ''){ ?> Waiting For Join <?php }
					else{ echo $res->join_status; } ?>
				</td>
			</tr>		
		<?php
			}
}			
		?>
		</table>
		
	</br>
	</br>
	<div id="checklen_error" style="color: #FF0000;"></div>
	<div class="row">
		<div class="col-md-4"><?= $form->field($model, 'join_status')->dropDownList([ 'Joined' => 'Joined', 'Rejected' => 'Rejected', 'Offer Declined' => 'Offer Declined',]) ?><div id="prststatus_error" style="color: #FF0000;"></div></div>			
		<!--<div class="col-md-4" id="join_remarks" style="display: none;"><textarea name="join_statusremarks" id="join_statusremarks" rows="4" cols="50" placeholder="Remarks"></textarea></div>-->
		<div class="col-md-1" >
			<input type="submit" name="recruitmentjoin" id="recruitmentjoin" class="btn-sm btn-success" value="Submit" >
		</div>	
	</div>
    <?php ActiveForm::end();  ?>
</div>
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


$("#recruitment-id").change(function(){		

	var recruitment_batch		= $("#recruitment-id").val();
	var offerletter_type		= $("#recruitment-offerletter_type").val();
	var offer_date				=  $('#recruitment-offer_date').val();
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

$('#check_head').change(function() {
		if ($(this).is(':checked')) {
			//alert("hi");
			$('input[type="checkbox"]').prop( "checked", true );
		}else{
			$('input[type="checkbox"]').prop( "checked", false );
		}
	});

JS;
$this->registerJs($script);
?>
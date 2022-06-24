<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\RecruitmentBatch;
use common\models\AuthAssignment;
$batch = RecruitmentBatch::find()->orderBy(['id' => SORT_DESC])->all();
$batchData = ArrayHelper::map($batch, 'id', 'batch_name');
?>

<div class="recruitment-form">
    <div class="panel panel-default">
        <div class="panel-heading text-center" style="font-size:18px;"> Recruitment</div>
        <div class="panel-body">
            <?php
            Modal::begin([
                'header' => '<h4 style="color:#007370;text-align:center">Batch Creation</h4>',
                'id' => 'modalbatch',
            ]);
            echo "<div id='batchContent'></div>";
            Modal::end();
            ?>
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class="row">
				<div class="col-md-4">
					<?= $form->field($model, 'type')->radioList(array('engineer'=>'Engineer','staff'=>'Staff')); ?>
                </div>
                <!--<div class="col-md-2">
                    <?= $form->field($model, 'type')->radio(['label' => 'Engineer', 'value' => 'engineer']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'type')->radio(['label' => 'Staff', 'value' => 'staff']) ?>
                </div>-->
            </div>
            <br>
            <div class="row" id="recruitment_div" style="display: none;">			
                <div class="col-lg-5">	
                    <div class="row" id="batchdiv">
                        <div class="col-md-10">
                            <?= $form->field($model, 'batch_id')->dropDownList($batchData, ['prompt' => 'Select...']) ?> </div>                        
                    </div>
					
					<div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'register_no')->textInput(['maxlength' => true]) ?> </div>
                    </div>
					
                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'qualification')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">                         
						 <?= $form->field($model, 'specialization')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'year_of_passing')->textInput() ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'selection_mode')->dropDownList([ 'Referred by' => 'Referred by', 'Direct' => 'Direct', 'Campus' => 'Campus', 'Naukri' => 'Naukri', 'Other' => 'Other',], ['prompt' => '']) ?></div>
                    </div>		
					
					<div class="row">
                        <div class="col-md-10">
                        <?= $form->field($model, 'referred_by')->textInput(['maxlength' => true]) ?> </div>
                    </div>
					
                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'other_selection_mode')->textInput(['maxlength' => true]) ?> </div>
                    </div>					
                </div>
				
				
				<div class="col-lg-1">
                    <div class="col-md-1"> 
                    <?= Html::button('', ['value' => Url::to('batchcreate'), 'class' => 'glyphicon glyphicon-plus-sign btn btn-default btn-sm', 'id' => 'BatchButton']) ?>  </div> 
                </div>
                <div class="col-lg-6">
                    
									

                    
                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?> </div>
                    </div>
					
					
					<div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?> </div>
                    </div>
					
					<div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'community')->textInput(['maxlength' => true]) ?> </div>
                    </div>
					
					<div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'caste')->textInput(['maxlength' => true]) ?> </div>
                    </div>
					
					<div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?> </div>
                    </div>
					
                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'status')->dropDownList([ 'selected' => 'Selected', 'Direct Joining' => 'Direct Joining', 'Rejoined' => 'Rejoined', 'Rejected' => 'Rejected', 'Interview' => 'Interview', 'Others' => 'Others',], ['prompt' => '']) ?> </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'rejected_reason')->textarea(['rows' => 6]) ?> </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'resume')->fileInput() ?> </div>
                    </div>	
                    <br>  
                </div>
				
                
            </div>
            <br>
                <div class="row" id="recruitment_submit" style="display: none;">
					<div class="col-md-2"></div>
					<div class="col-md-4" style="right:15px;">
						<?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?>
					</div>
				</div>
				<?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
<?php
$script = <<< JS

	$(".field-recruitment-rejected_reason").hide();
	$(".field-recruitment-referred_by").hide();	
	//$(".field-recruitment-collage_name").hide();	
	$(".field-recruitment-other_selection_mode").hide();
		
	$('#recruitment-status').change(function(event){ 
	  var val = $('#recruitment-status').val();
	  if(val == 'Rejected'){
		$(".field-recruitment-rejected_reason").show();
	  }else {
	   $(".field-recruitment-rejected_reason").show();
	   //$(".field-recruitment-rejected_reason").hide();
	  }
	});

	$('#recruitment-selection_mode').change(function(event){ 
	  var mode = $('#recruitment-selection_mode').val();
	  if(mode == 'Referred by' || mode == 'Campus'){
		$(".field-recruitment-referred_by").show();
		//$(".field-recruitment-collage_name").show();
	  }else {
	   $(".field-recruitment-referred_by").hide();
	   //$(".field-recruitment-collage_name").hide();
	  }  
	});
	
	$('#recruitment-selection_mode').change(function(event){ 
	
	  var mode = $('#recruitment-selection_mode').val();
	  if(mode == 'Other'){
		$(".field-recruitment-other_selection_mode").show();
	  }else {
	   $(".field-recruitment-other_selection_mode").hide();
	  }  
	});
	
	$("input[name='Recruitment[type]']").on('change', function() {
		//alert($(this).val());
		$("#recruitment_div").show();
		$("#recruitment_submit").show();
		if ($(this).val() == 'engineer') {
			$("#recruitment-batch_id").prop('required',true);
			$("#batchdiv").show();
			$('#recruitment-batch_id').show();
		}
		if ($(this).val() == 'staff') {			
			$("#batchdiv").hide();
			$('#recruitment-batch_id').val('');			
			$('#recruitment-batch_id').hide();
		}		
	});
	
JS;
$this->registerJs($script);
?>

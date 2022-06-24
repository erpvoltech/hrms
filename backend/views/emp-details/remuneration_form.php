<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\EmpDetails;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;

$employeeid = Yii::$app->request->getQueryParam('id');
$Emp = EmpDetails::findOne($employeeid);

$PayScale = EmpStaffPayScale::find()->select('salarystructure')->all();
$structure = EmpSalarystructure::find()->select('salarystructure')->distinct()->all();
$listData = ArrayHelper::map($structure, 'salarystructure', 'salarystructure');
$listData1 = ArrayHelper::map($PayScale, 'salarystructure', 'salarystructure');
?>
<style>
   .file-preview {  
      height: 175px;
	  }
   .file-drop-zone { 
      margin: 5px 5px 5px 5px;

   }
   .file-drop-zone-title {
      color: #aaa;
      font-size: 1em;
      padding: 30px 10px;
      cursor: default;
   }
   .text-divider{margin: 2em 0; line-height: 0; text-align: center;}
.text-divider span{background-color: #f5f5f5; padding: 1em;}
.text-divider:before{ content: " "; display: block; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #f7f7f7;}
</style>
<div class="wizard">
   <ul class="steps" >
      <?php if (!$model->isNewRecord) : ?>
         <li><?= Html::a('List', ['index']) ?><span class="chevron"></span></li>
         <?php if (!$model->isNewRecord) : ?>
            <li><?= Html::a('Employee', ['update', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Employee', ['create', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>  

         <?php if (!empty($model->remuneration)) : ?>
            <li class="active" ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li class="active" >Remuneration<span class="chevron"></span></li>
         <?php endif; ?>
		 
		 <?php if (!empty($model->employeeStatutoryDetail)) : ?>
            <li><?= Html::a('Statutory', ['statutory-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Statutory', ['statutory-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>
		 
		 <?php if (!empty($model->employeeBankDetail)) : ?>
        <li ><?= Html::a('Bank', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Bank', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>	

         <?php if (!empty($model->employeePersonalDetail)) : ?>
            <li><?= Html::a('Personal', ['personal-details', 'id' => $model->employeePersonalDetail->empid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>

         <?php if (!empty($model->employeeEducationDetail)) : ?>
            <li><?= Html::a('Education', ['education-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Education', ['education-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>

         <?php if (!empty($model->employeeCertificatesDetail)) : ?>
            <li><?= Html::a('Certificates', ['certificates-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Certificates', ['certificates-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
			<?php endif; ?>

         <?php if (!empty($model->employment)) : ?>
            <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>

      <?php else : ?>
         <li><?= Html::a('List', 'index') ?><span class="chevron"></span></li>
         <li ><?= Html::a('Employee', ['update', 'id' => $employeeid]) ?><span class="chevron"></span></li>
         <li class="active">Remuneration<span class="chevron"></span></li>
         <li ><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
         <li ><?= Html::a('Education', ['education-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
         <li ><?= Html::a('Certificates', ['certificates-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
         <li ><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
         <li ><?= Html::a('Statutory', ['statutory-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <li > <?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>

      <?php endif; ?>
   </ul>
</div>
<div class="emp-details-remuneration_form control-group">
   <h2><?= Html::encode($this->title) ?></h2>
   <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
</div>
<div class="panel panel-default">
   <div class="panel-heading"><i class="fa fa-envelope"> Remuneration details</i></div>
   <div class="panel-body">
    <div class="row">
	<div class="col-lg-2" >&nbsp;&nbsp;&nbsp;&nbsp;E-Code</div>
		<div class="col-lg-2"> <b><?= $Emp->empcode ?></b> </div>
		<div class="col-lg-2">&nbsp;&nbsp;&nbsp;&nbsp;Employee Name</div>
		<div class="col-lg-2"> <b><?= $Emp->empname ?></b> </div>
         </div> 
		 <br>

      <div class="row">

         <div class="form-group col-lg-4 input-block-level">

            <?=
            $form->field($model, 'salary_structure')->dropDownList($listData + ['Consolidated pay' => 'Consolidated pay', 'Contract' => 'Contract'] + $listData1, ['prompt' => '',
                'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('emp-details/worklevel?id=') . '"+$(this).val(), function( data ) {
				  $( "#empremunerationdetails-work_level" ).html( data );
				});
			']);
            ?>

         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'work_level')->dropDownList(['WL5' => 'WL5', 'WL4C' => 'WL4C', 'WL4B' => 'WL4B', 'WL4A' => 'WL4A', 'WL3B' => 'WL3B', 'WL3A' => 'WL3A','WL4' => 'WL4','WL3' => 'WL3','WL2' => 'WL2','WL1' => 'WL1'], ['prompt' => ' ']) ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'grade')->dropDownList(['AA'=>'AA','A'=>'A','A1' => 'A1', 'B' => 'B','B1' => 'B1', 'C' => 'C','C1' => 'C1', 'D' => 'D','E' => 'E'], ['prompt' => ' ']) ?>
         </div>
      </div> 
      <div class="row">
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'attendance_type')->dropDownList(['Permanent' => 'Permanent', 'Contract' => 'Contract',], ['prompt' => ' ']) ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'esi_applicability')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => ' ']) ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'pf_applicablity')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => ' ']) ?>
         </div> 
      </div> 
      <div class="row">
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'restrict_pf')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => ' ']) ?>
         </div> 
           <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'pli')->dropDownList(['8.33'=>'8.33%','8.62'=>'8.62%','16.67'=>'16.67%','NA'=>'N/A'],['options' => [ $model->pli=>['Selected'=>'selected']],'prompt'=>'']) ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'basic') ?>
         </div> 
        
      </div> 
      <div class="row">
          <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'hra') ?>
         </div>        
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'dearness_allowance') ?>
         </div> 
		   <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'personpay') ?>
         </div>        
      </div> 

      <div class="row">         
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'conveyance') ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'lta') ?>
         </div> 
		  <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'medical') ?>
         </div>        
      </div> 

      <div class="row">         
		   <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'washing_allowance') ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'dust_allowance') ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'guaranteed_benefit') ?>
         </div> 
         
      </div> 

      <div class="row"> 
	   <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'misc') ?>
         </div> 
          <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'other_allowance') ?>
         </div> 
        
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'gross_salary') ?>
         </div> 
      </div> 
	  
	  <div class="row"> 
		  <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'food_allowance')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => ' ']) ?>
         </div>
      </div> 
	  
   <!-- <h5 class="text-divider"><span>Employer Contribution</span></h5>
     
       <div class="row">  
          <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'employer_pf_contribution')->textInput(['readonly' => true]) ?>
         </div> 
        
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'employer_esi_contribution')->textInput(['readonly' => true]) ?>
         </div> 
        
           <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'employer_pli_contribution')->textInput(['readonly' => true]) ?>
         </div> 
      </div> 
    
     <div class="row">  
          <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'employer_lta_contribution')->textInput(['readonly' => true]) ?>
         </div> 
        
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'employer_medical_contribution')->textInput(['readonly' => true]) ?>
         </div> 
        
           <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'ctc')->textInput(['readonly' => true]) ?>
         </div> 
      </div> -->
     <div class="row"> 
		<div class="col-lg-1"></div>
		 <div class="form-group col-lg-4">
         <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
      </div><div class="form-group col-lg-4" style="text-align:right;color:Blue;font-size:11px">
	   <?= $form->field($model, 'ctcgross')->textInput() ?>
	  </div>
	   <div class="pull-right col-lg-3" style="text-align:right;color:red;font-size:11px">
	  <i> * Optional</i><br>
	   <i> ** This field not calculated for PF and ESI.</i>
	  </div>
	   </div>
	    <div class="row"> 
		<div class="col-lg-5"></div>
		<div class="form-group col-lg-4" style="text-align:right;color:Blue;font-weight:bold" id="optional_gross">
		
	    </div>	   
	   </div>
	   
      <?php ActiveForm::end(); ?>
   </div>  
<?php 
$script = <<< JS

	  var empm_type;
	  var ssaltype = $('#empremunerationdetails-salary_structure').val();
	  
	  if(ssaltype =='Conventional' || ssaltype =='Modern' ){
	  $('#empremunerationdetails-gross_salary').prop("readonly", false); 
	   $('#empremunerationdetails-ctcgross').prop("readonly", true);
	  } else {
	  $('#empremunerationdetails-gross_salary').prop("readonly", true);
	   $('#empremunerationdetails-ctcgross').prop("readonly", true);
	  }
		  
		$('#empremunerationdetails-basic').prop("readonly", true);
		$('#empremunerationdetails-hra').prop("readonly", true);
		$('#empremunerationdetails-splallowance').prop("readonly", true);
		$('#empremunerationdetails-dearness_allowance').prop("readonly", true);
		$('#empremunerationdetails-personpay').prop("readonly", true);
		$('#empremunerationdetails-dust_allowance').prop("readonly", true);
		$('#empremunerationdetails-washing_allowance').prop("readonly", true);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", true);
		$('#empremunerationdetails-conveyance').prop("readonly", true);
		$('#empremunerationdetails-lta').prop("readonly", true);
		$('#empremunerationdetails-medical').prop("readonly", true);
		$('#empremunerationdetails-pli').prop("readonly", true);
		$('#empremunerationdetails-other_allowance').prop("readonly", true);
		$('#empremunerationdetails-misc').prop("readonly", true);
		
		if(ssaltype =='Consolidated pay'){
		$('#empremunerationdetails-basic').prop("readonly", false);
		$('#empremunerationdetails-hra').prop("readonly", true);		
		$('#empremunerationdetails-dearness_allowance').prop("readonly", true);
		$('#empremunerationdetails-personpay').prop("readonly", true);
		$('#empremunerationdetails-dust_allowance').prop("readonly", true);
		$('#empremunerationdetails-washing_allowance').prop("readonly", true);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", true);
		
		$('#empremunerationdetails-basic,#empremunerationdetails-other_allowance').keyup(function(event){
		var bssic = $('#empremunerationdetails-basic').val();
		var others = $('#empremunerationdetails-other_allowance').val();
		$('#empremunerationdetails-gross_salary').val(+bssic + +others);
		});
		
		}else if(ssaltype =='Contract'){
		$('#empremunerationdetails-hra').prop("readonly", false);		
		$('#empremunerationdetails-dearness_allowance').prop("readonly", false);
		$('#empremunerationdetails-personpay').prop("readonly", false);
		$('#empremunerationdetails-dust_allowance').prop("readonly", false);
		$('#empremunerationdetails-washing_allowance').prop("readonly", false);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", false);
		$('#empremunerationdetails-other_allowance').prop("readonly", false);
		$('#empremunerationdetails-misc').prop("readonly", false);
		} 		
		
		$('#empremunerationdetails-gross_salary').keyup(function(event){   
		 var amt = $('#empremunerationdetails-gross_salary').val();
		 var ssaltype = $('#empremunerationdetails-salary_structure').val();
                  $.ajax({
                     type: "POST",
                     url: 'salarystructure',
                     data: {sla_structure:ssaltype, empmtype: 'Staff',amount:amt},
                             dataType : 'json',
                     success: function (data) {
				
					$('#empremunerationdetails-basic').val(data.basic);
					$('#empremunerationdetails-hra').val(data.hra);
					$('#empremunerationdetails-other_allowance').val(data.other_allowance);
					$('#empremunerationdetails-dearness_allowance').val(data.da);
					$('#empremunerationdetails-conveyance').val(data.ca);					
					$('#empremunerationdetails-lta').val(data.lta);
					$('#empremunerationdetails-medical').val(data.medical);
					$('#empremunerationdetails-other_allowance').val(data.other);
					
                },
                error: function (exception) {                   
					alert('Something Error');
                }
            });
		 });  
	
	$('#empremunerationdetails-grade').change(function(event){ 
	   var ss = $('#empremunerationdetails-salary_structure').val();
	   var wl = $('#empremunerationdetails-work_level').val();
	   var grade = $('#empremunerationdetails-grade').val();
	  if(ss !='Consolidated pay' && ss !='Contract' && ss !='Conventional' && ss !='Modern'){	  
		
           empm_type = 'Engineer';		   
		$('#empremunerationdetails-basic').prop("readonly", true);
		$('#empremunerationdetails-hra').prop("readonly", true);		
		$('#empremunerationdetails-dearness_allowance').prop("readonly", true);
		$('#empremunerationdetails-personpay').prop("readonly", true);
		$('#empremunerationdetails-dust_allowance').prop("readonly", true);
		$('#empremunerationdetails-washing_allowance').prop("readonly", true);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", true);
		$('#empremunerationdetails-conveyance').prop("readonly", true);
		$('#empremunerationdetails-lta').prop("readonly", true);
		$('#empremunerationdetails-medical').prop("readonly", true);		
		$('#empremunerationdetails-other_allowance').prop("readonly", true);
		$('#empremunerationdetails-gross_salary').prop("readonly", true);
		$('#empremunerationdetails-ctcgross').prop("readonly", true);
            $.ajax({
			type: "POST",
                url: 'salarystructure',
                data: {sla_structure:ss, worklevel:wl, grade: grade,empmtype: empm_type},
				dataType : 'json',
                success: function (data) {				
				   $('#empremunerationdetails-basic').val(data.basic);
				   $('#empremunerationdetails-hra').val(data.hra);
				   $('#empremunerationdetails-other_allowance').val(data.other_allowance);
				   $('#empremunerationdetails-dearness_allowance').val(data.dapermonth);
				    $('#empremunerationdetails-gross_salary').val(data.gross);
                },
                error: function (exception) {
                   alert('Salary Structure Doesn\'t match');
                }
            });
         }
	});	
            
            
		$('#empremunerationdetails-salary_structure').change(function(event){ 
		var ss = $('#empremunerationdetails-salary_structure').val();
				
		$('#empremunerationdetails-basic').val('');
		$('#empremunerationdetails-hra').val('');
		$('#empremunerationdetails-gross_salary').val('');
		$('#empremunerationdetails-splallowance').val('');
		$('#empremunerationdetails-dearness_allowance').val('');
		$('#empremunerationdetails-personpay').val('');
		$('#empremunerationdetails-dust_allowance').val('');
		$('#empremunerationdetails-washing_allowance').val('');
		$('#empremunerationdetails-guaranteed_benefit').val('');
		$('#empremunerationdetails-other_allowance').val('');
		$('#empremunerationdetails-conveyance').val('');
		$('#empremunerationdetails-pli').val('');
		$('#empremunerationdetails-lta').val('');
		$('#empremunerationdetails-medical').val('');
		
		if(ss =='Consolidated pay'){
		$('#empremunerationdetails-basic').prop("readonly", false);
		$('#empremunerationdetails-hra').prop("readonly", true);		
		$('#empremunerationdetails-dearness_allowance').prop("readonly", true);
		$('#empremunerationdetails-personpay').prop("readonly", true);
		$('#empremunerationdetails-dust_allowance').prop("readonly", true);
		$('#empremunerationdetails-washing_allowance').prop("readonly", true);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", true);	
		$('#empremunerationdetails-gross_salary').prop("readonly", true);
		$('#empremunerationdetails-ctcgross').prop("readonly", true);
		$('#empremunerationdetails-other_allowance').prop("readonly", true);	
		$('#empremunerationdetails-misc').prop("readonly", true);
		
		$('#empremunerationdetails-basic,#empremunerationdetails-other_allowance').keyup(function(event){
		var bssic = $('#empremunerationdetails-basic').val();
		var others = $('#empremunerationdetails-other_allowance').val();
		$('#empremunerationdetails-gross_salary').val(+bssic + +others);
		});
		
		
		$('#empremunerationdetails-hra').val('');
		$('#empremunerationdetails-splallowance').val('');
		$('#empremunerationdetails-dearness_allowance').val('');
		$('#empremunerationdetails-personpay').val('');
		$('#empremunerationdetails-dust_allowance').val('');
		$('#empremunerationdetails-washing_allowance').val('');
		$('#empremunerationdetails-guaranteed_benefit').val('');
		$('#empremunerationdetails-other_allowance').val('');
		$('#empremunerationdetails-conveyance').val('');
		$('#empremunerationdetails-pli').val('');
		$('#empremunerationdetails-lta').val('');
		$('#empremunerationdetails-medical').val('');
		
				
		}else if(ss =='Contract'){
		$('#empremunerationdetails-basic').prop("readonly", false);
		$('#empremunerationdetails-hra').prop("readonly", false);		
		$('#empremunerationdetails-dearness_allowance').prop("readonly", false);
		$('#empremunerationdetails-personpay').prop("readonly", false);
		$('#empremunerationdetails-dust_allowance').prop("readonly", false);
		$('#empremunerationdetails-washing_allowance').prop("readonly", false);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", false);
		$('#empremunerationdetails-other_allowance').prop("readonly", false);
		$('#empremunerationdetails-misc').prop("readonly", false);
		
		$('#empremunerationdetails-misc,#empremunerationdetails-basic,#empremunerationdetails-hra,#empremunerationdetails-splallowance,#empremunerationdetails-dearness_allowance,#empremunerationdetails-personpay,#empremunerationdetails-dust_allowance,#empremunerationdetails-washing_allowance,#empremunerationdetails-guaranteed_benefit,#empremunerationdetails-other_allowance').keyup(function(event){
				
		var bssic = $('#empremunerationdetails-basic').val();
		var hra = $('#empremunerationdetails-hra').val();
		var spl = $('#empremunerationdetails-splallowance').val();
		var da = $('#empremunerationdetails-dearness_allowance').val();
		var pp = $('#empremunerationdetails-personpay').val();
		var dust = $('#empremunerationdetails-dust_allowance').val();
		var washing = $('#empremunerationdetails-washing_allowance').val();
		var gb = $('#empremunerationdetails-guaranteed_benefit').val();
		var others = $('#empremunerationdetails-other_allowance').val();
		var misc = $('#empremunerationdetails-misc').val();
		
		$('#empremunerationdetails-gross_salary').val(+bssic + +hra + +da + +pp + +dust  + +gb + +others + +misc + +washing);
		});
            
		$('#empremunerationdetails-basic').val('');
		$('#empremunerationdetails-hra').val('');
		$('#empremunerationdetails-splallowance').val('');
		$('#empremunerationdetails-dearness_allowance').val('');
		$('#empremunerationdetails-personpay').val('');
		$('#empremunerationdetails-dust_allowance').val('');
		$('#empremunerationdetails-washing_allowance').val('');
		$('#empremunerationdetails-guaranteed_benefit').val('');
		$('#empremunerationdetails-other_allowance').val('');
		$('#empremunerationdetails-conveyance').val('');
		$('#empremunerationdetails-lta').val('');
		$('#empremunerationdetails-medical').val('');
		
            } else if(ss =='Conventional' || ss =='Modern' ){
			
		$('#empremunerationdetails-basic').prop("readonly", true);
		$('#empremunerationdetails-hra').prop("readonly", true);		
		$('#empremunerationdetails-dearness_allowance').prop("readonly", true);
		$('#empremunerationdetails-personpay').prop("readonly", true);
		$('#empremunerationdetails-dust_allowance').prop("readonly", true);
		$('#empremunerationdetails-washing_allowance').prop("readonly", true);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", true);	
		$('#empremunerationdetails-gross_salary').prop("readonly", false);
		$('#empremunerationdetails-ctcgross').prop("readonly", false);
		$('#empremunerationdetails-other_allowance').prop("readonly", true);
		
             
        } else if(ss !='Consolidated pay' && ss !='Contract' && ss !='Conventional' && ss !='Modern'){
		$('#empremunerationdetails-basic').prop("readonly", true);
		$('#empremunerationdetails-hra').prop("readonly", true);		
		$('#empremunerationdetails-dearness_allowance').prop("readonly", true);
		$('#empremunerationdetails-personpay').prop("readonly", true);
		$('#empremunerationdetails-dust_allowance').prop("readonly", true);
		$('#empremunerationdetails-washing_allowance').prop("readonly", true);
		$('#empremunerationdetails-guaranteed_benefit').prop("readonly", true);
		$('#empremunerationdetails-conveyance').prop("readonly", true);
		$('#empremunerationdetails-lta').prop("readonly", true);
		$('#empremunerationdetails-medical').prop("readonly", true);		
		$('#empremunerationdetails-other_allowance').prop("readonly", true);
		$('#empremunerationdetails-gross_salary').prop("readonly", true);
		$('#empremunerationdetails-ctcgross').prop("readonly", true);
		}
		});		
		$('#empremunerationdetails-ctcgross').keyup(function(event){
		var ctcgross = $('#empremunerationdetails-ctcgross').val();
		var opt_basic = +ctcgross *.4;
		var opt_pli = +opt_basic *.0833;
		var opt_gross = +ctcgross - +opt_pli;
		$('#optional_gross').html('Gross Salary :'+ Math.round(opt_gross)+',('+ Math.round(opt_pli)+'-Reduced amt),Add PLI is 8.33%');
		});
		
JS;
$this->registerJs($script); 
?>

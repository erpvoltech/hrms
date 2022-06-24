<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpDetails;


$employeeid = Yii::$app->request->getQueryParam('id');
$Emp = EmpDetails::findOne($employeeid);
?>

<div class="wizard">
    <ul class="steps" >
        <?php if (!$model->isNewRecord) : ?>
        <li><?= Html::a('List', ['index'])?><span class="chevron"></span></li>
        <?php if (!$model->isNewRecord) : ?>
            <li><?= Html::a('Employee', ['update', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Employee', ['create', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?> 
		
        <?php if (!empty($model->remuneration)) : ?>
        <li ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li  ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		<?php if (!empty($model->employeeStatutoryDetail)) : ?>
        <li class="active"><?= Html::a('Statutory', ['statutory-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li class="active">Statutory/Insurance<span class="chevron"></span></li>
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
        <li><?= Html::a('Education', ['education-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li><?= Html::a('Education', ['education-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		<?php if (!empty($model->employeeCertificatesDetail)) : ?>
        <li ><?= Html::a('Certificates', ['certificates-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Certificates', ['certificates-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		<?php if (!empty($model->employment)) : ?>
        <li ><?= Html::a('Prev. Employment', ['previous_employment', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Prev. Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
        <?php else : ?>
      <li><?= Html::a('List', 'index') ?><span class="chevron"></span></li>
      <li ><?= Html::a('Employee', ['update', 'id' => $employeeid]) ?><span class="chevron"></span></li>
	  <li ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid])?><span class="chevron"></span></li>
      <li ><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
      <li ><?= Html::a('Education', ['education-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
      <li ><?= Html::a('Certificates', ['certificates-details', 'id' =>$employeeid])?><span class="chevron"></span></li>
      <li ><?= Html::a('Bank', ['bank-details', 'id' => $employeeid])?><span class="chevron"></span></li>
      <li class="active" > Statutory<span class="chevron"></span></li>
	  <li > <?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
    <?php endif; ?>
  </ul>
</div>

<br>
<div class="emp-details-statutory_form control-group ">
<h2><?= Html::encode($this->title) ?></h2>
   <?php $form = ActiveForm::begin(['id'=>'dynamic-form','layout'=>'horizontal']); ?>
  
  
  <div class="panel panel-default">
     <div class="panel-heading"><i class="fa fa-envelope"> Statutory / Insurance details</i></div>
  <div class="panel-body">
  <div class="row">
   <div class="col-lg-1" >
   </div>
	<div class="col-lg-2" >E-Code</div>
		<div class="col-lg-2"><b> <?= $Emp->empcode ?></b> </div>
		<div class="col-lg-1" >
	</div>
		<div class="col-lg-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employee Name</div>
		<div class="col-lg-2"> <b><?= $Emp->empname ?></b> </div>
         </div> 
		 <br>
     <div class="row">
   
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'esino') ?>
    </div>
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'esidispensary') ?>
    </div>
     </div>
     <div class="row">
     
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'epfno') ?>
    </div>
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'epfuanno') ?>
    </div>
     </div>	
     <div class="row">
	 
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'zeropension')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'professionaltax')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
	 </div>
       <div class="row">
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'pmrpybeneficiary')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
           <div class="form-group col-lg-6">
      <?= $form->field($model, 'lin_no')?>
    </div>
       </div>
	   	
	   
	     <div class="row">
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'gpa_applicability')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
           <div class="form-group col-lg-6">
      <?= $form->field($model, 'gpa_no')?>
    </div>
       </div>
	   
	   <div class="row">
    <div class="form-group col-lg-6">
      <?= $form->field($model, 'gmc_applicability')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
           <div class="form-group col-lg-6">
      <?= $form->field($model, 'gmc_no')?>
    </div>
       </div>
	   
	   
	    <div class="row">
		<div class="form-group col-lg-6">
			<?= $form->field($model, 'gpa_sum_insured')?>
		</div>   
		<div class="form-group col-lg-6">
			<?= $form->field($model, 'gmc_sum_insured')?>
		</div>
		
		</div>
		
		<div class="row">
		<div class="form-group col-lg-6">
			<?= $form->field($model, 'gpa_premium')?>
		</div> 
		<div class="form-group col-lg-6">
			<?= $form->field($model, 'gmc_premium')?>
		</div>				
		</div>
		
		
	    <div class="row">		
		<div class="form-group col-lg-6">
			<?= $form->field($model, 'age_group')->dropDownList(['0-35' => '0-35', '36-45' => '36-45', '46-50' => '46-50','51-55' => '51-55','56-60' => '56-60','61-65' => '61-65','66-70' => '66-70'], ['prompt' => '']) ?>
		</div>   
		</div>
		
		 <div class="row">
                <div class="form-group col-lg-6">
                    <?= $form->field($model, 'wc_applicability')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => 'Select...']) ?>
                </div>
                <div class="form-group col-lg-6">
                    <?= $form->field($model, 'wc_no') ?>
                </div>
            </div>

	   
    <br>
	 <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2 p-l-20 form-group" style="left:35px;">
            <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
        </div>
     </div>
  </div>
    <?php ActiveForm::end(); ?>
</div>
</div></div>

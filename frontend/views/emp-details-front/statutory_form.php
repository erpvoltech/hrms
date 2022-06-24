<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$employeeid = Yii::$app->request->getQueryParam('id');
?>

<div class="wizard">
    <ul class="steps" >
        <?php if (!$model->isNewRecord) : ?>
        <li><?= Html::a('List', ['index'])?><span class="chevron"></span></li>
        <li >Employee<span class="chevron"></span></li>
		
        <?php if (!empty($model->remuneration)) : ?>
        <li ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li  ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
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
		
		<?php if (!empty($model->employeeBankDetail)) : ?>
        <li ><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		<?php if (!empty($model->employeeStatutoryDetail)) : ?>
        <li class="active"><?= Html::a('Statutory', ['statutory-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li class="active">Statutory<span class="chevron"></span></li>
        <?php endif; ?>
		<?php if (!empty($model->employment)) : ?>
        <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
        <?php else : ?>
      <li><?= Html::a('List', 'index') ?><span class="chevron"></span></li>
      <li ><?= Html::a('Employee', ['update', 'id' => $employeeid]) ?><span class="chevron"></span></li>
	  <li ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid])?><span class="chevron"></span></li>
      <li ><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
      <li ><?= Html::a('Education', ['education-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
      <li ><?= Html::a('Certificates', ['certificates-details', 'id' =>$employeeid])?><span class="chevron"></span></li>
      <li ><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid])?><span class="chevron"></span></li>
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
     <div class="panel-heading"><i class="fa fa-envelope"> Statutory details</i></div>
  <div class="panel-body">
     <div class="row">
   
    <div class="form-group col-lg-4">
      <?= $form->field($model, 'esino') ?>
    </div>
    <div class="form-group col-lg-4">
      <?= $form->field($model, 'esidispensary') ?>
    </div>
     </div>
     <div class="row">
     
    <div class="form-group col-lg-4">
      <?= $form->field($model, 'epfno') ?>
    </div>
    <div class="form-group col-lg-4">
      <?= $form->field($model, 'epfuanno') ?>
    </div>
     </div>	
     <div class="row">
	 
    <div class="form-group col-lg-4">
      <?= $form->field($model, 'zeropension')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
    <div class="form-group col-lg-4">
      <?= $form->field($model, 'professionaltax')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
	 </div>
       <div class="row">
    <div class="form-group col-lg-4">
      <?= $form->field($model, 'pmrpybeneficiary')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => '']) ?>
    </div>
           <div class="form-group col-lg-4">
      <?= $form->field($model, 'lin_no')?>
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

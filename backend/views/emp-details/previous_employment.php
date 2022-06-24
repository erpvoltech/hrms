<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\EmpDetails;


$employeeid = Yii::$app->request->getQueryParam('id');
$Emp = EmpDetails::findOne($employeeid);
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
		
			<?php if (!empty($model->employeeBankDetail)) : ?>
        <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		<?php if (!empty($model->employeeStatutoryDetail)) : ?>
        <li><?= Html::a('Statutory', ['statutory-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li><?= Html::a('Statutory', ['statutory-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
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
        <li><?= Html::a('Certificates', ['certificates-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li><?= Html::a('Certificates', ['certificates-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
	
		
		<?php if (!empty($model->employment)) : ?>
        <li class="active"><?= Html::a('Previous Employment', ['previous_employment', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li class="active"><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
       <?php else : ?>
      <li><?= Html::a('List', 'index') ?><span class="chevron"></span></li>
      <li ><?= Html::a('Employee', ['update', 'id' => $employeeid]) ?><span class="chevron"></span></li>
	  <li ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid])?><span class="chevron"></span></li>
	  <li ><?= Html::a('Statutory', ['statutory-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
	  <li ><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>     
      <li ><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
      <li ><?= Html::a('Education', ['education-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
      <li ><?= Html::a('Certificates', ['certificates-details', 'id' =>$employeeid])?><span class="chevron"></span></li>
     
	  <li class="active"> Previous Employment<span class="chevron"></span></li>
    <?php endif; ?>
    </ul>
</div>
<div class="previous_employment">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>
	
	<?php
  DynamicFormWidget::begin([
      'widgetContainer' => 'dynamicform_wrapper',
      'widgetBody' => '.container-siblings',
      'widgetItem' => '.siblingsitem',
      'limit' => 5,
      'min' => 1,
      'insertButton' => '.siblingsadd-item',
      'deleteButton' => '.siblingsremove-item',
      'model' => $modelEmployment[0],
      'formId' => 'dynamic-form',
      'formFields' => [
          'company',
          'company_address',
          'designation',
          'job_type',
		  'last_drawn_salary',
		  'work_from',
		  'work_to',
		  'reason_for_leaving',
      ],
  ]);
  ?>
  <br>
  <div class="panel panel-default">   
    <div class="panel-heading">
      <i class="fa fa-envelope"></i> Previous Employment Details 
      <button type="button" class="pull-right siblingsadd-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add </button>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body container-siblings">			
          <?php foreach ($modelEmployment as $index => $model): ?>                  
        <div class="siblingsitem panel" style="padding:0px">                   
          <div class="panel-body" style="padding:0px">
            <?php
            if (!$model->isNewRecord) {
              echo Html::activeHiddenInput($model, "[{$index}]id");
            }
            ?>
			<div class="row">
   
	<div class="col-lg-2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-Code</div>
		<div class="col-lg-2"> <b><?= $Emp->empcode ?></b> </div>
		
		<div class="col-lg-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employee Name</div>
		<div class="col-lg-2"> <b><?= $Emp->empname ?></b> </div>
         </div> 
		 <br>
			 <div class="row">
              <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]company")->textInput(['maxlength' => true]) ?>
              </div>      
              <div class="col-sm-4">
				<?= $form->field($model, "[{$index}]company_address")->textInput(['style'=>'width:350px']) ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]designation")->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-sm-4">
				<?= $form->field($model, "[{$index}]job_type")->textInput(['maxlength' => true]) ?>
              </div>  
			  <div class="col-sm-4">
				<?= $form->field($model, "[{$index}]last_drawn_salary")->textInput() ?>
				</div> 			  
            </div>  
			 <div class="row">
              <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]work_from")->textInput()->widget(\yii\jui\DatePicker::class, [    
				 'options' => ['class' => 'form-control'],
					 'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
				]) ?> 
				 <?= $form->field($model, "[{$index}]work_to")->textInput()->widget(\yii\jui\DatePicker::class, [    
				 'options' => ['class' => 'form-control'],
					 'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
				]) ?>
              </div>
              <div class="col-sm-4">
				<?= $form->field($model, "[{$index}]reason_for_leaving")->textarea(['style'=>'width:350px']) ?>
              </div>  
			  <div class="col-sm-3">
			  <button type="button" class="pull-right siblingsremove-item btn btn-danger btn-xs"> Delete</button>
			 </div> 
            </div>  
          </div> 
        </div>               
  <?php endforeach; ?>
  
    <?php DynamicFormWidget::end(); ?>
 <div class="row">
  <div class="col-md-2"></div>
        <div class="col-md-2 p-l-20 form-group" style="right:25px;">
  <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
  </div>
 </div>
<?php ActiveForm::end(); ?>
  </div>
  </div>
</div>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

$employeeid = Yii::$app->request->getQueryParam('id');
?>
<div class="wizard">
    <ul class="steps" >
        <?php if (!$model->isNewRecord) : ?>        
        <li >Employee<span class="chevron"></span></li>
		
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
		
				
		<?php if (!empty($model->employeeBankDetail)) : ?>
        <li class="active"><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li class="active"><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
				
		<?php if (!empty($model->employment)) : ?>
        <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
        <?php else : ?>     
		  <li ><?= Html::a('Employee', ['update', 'id' => $employeeid]) ?><span class="chevron"></span></li>		  
		  <li ><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
		  <li ><?= Html::a('Education', ['education-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>		  
		  <li class="active">Bank Details<span class="chevron"></span></li>		  
		  <li > <?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
		<?php endif; ?>
  </ul>
</div>
<div class="emp-details-bank_form">

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
      'model' => $modelBank[0],
      'formId' => 'dynamic-form',
      'formFields' => [
          'bankname',
          'acnumber',
          'branch',
          'ifsc',
      ],
  ]);
  ?>
  <br>
  <div class="panel panel-default">   
    <div class="panel-heading">
      <i class="fa fa-envelope"></i> Bank Details 
      <button type="button" class="pull-right siblingsadd-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add </button>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body container-siblings">			
          <?php foreach ($modelBank as $index => $model): ?>                  
        <div class="siblingsitem panel" style="padding:0px">                   
          <div class="panel-body" style="padding:0px">
            <?php
            if (!$model->isNewRecord) {
              echo Html::activeHiddenInput($model, "[{$index}]id");
            }
            ?>

            <div class="row">
              <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]bankname")->textInput(['maxlength' => true]) ?>
              </div>      
              <div class="col-sm-4">
  <?= $form->field($model, "[{$index}]acnumber")->textInput(['maxlength' => true]) ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]branch")->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-sm-4">
  <?= $form->field($model, "[{$index}]ifsc")->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-1">
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
</div><!-- emp-details-certificate_form -->

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use common\models\Course;
use common\models\College;
use common\models\Qualification ;
$employeeid = Yii::$app->request->getQueryParam('id');

$major=ArrayHelper::map(Course::find()->all(),'id','coursename');
$college=ArrayHelper::map(College::find()->all(),'id','collegename');
$degree=ArrayHelper::map(Qualification::find()->all(),'id','qualification_name'); 
?>
<div class="wizard">
  <ul class="steps">   
   <?php if (!$model->isNewRecord) : ?>      
	  
		<?php if (!$model->isNewRecord) : ?>
        <li><?= Html::a('Employee', ['update', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li><?= Html::a('Employee', ['create', 'id' => $employeeid]); ?><span class="chevron"></span></li>
		<?php endif; ?>
		
		
		
		<?php if (!empty($model->employeePersonalDetail)) : ?>
        <li ><?= Html::a('Personal', ['personal-details', 'id' => $model->employeePersonalDetail->empid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		<?php if (!empty($model->employeeEducationDetail)) : ?>
        <li class="active"><?= Html::a('Education', ['education-details', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li class="active"><?= Html::a('Education', ['education-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		
		
		<?php if (!empty($model->employeeBankDetail)) : ?>
        <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
		<?php if (!empty($model->employment)) : ?>
        <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' =>$employeeid]); ?><span class="chevron"></span></li>
        <?php else : ?>
        <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
        <?php endif; ?>
		
    <?php else : ?>
      
      <li ><?= Html::a('Employee', ['update', 'id' => $employeeid]) ?><span class="chevron"></span></li>
	  
      <li ><?= Html::a('Personal', ['personal-details', 'id' => $employeeid]) ?><span class="chevron"></span></li>
      <li class="active">Education<span class="chevron"></span></li>
      
      <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
      
	  <li >Previous Employment<span class="chevron"></span></li>
    <?php endif; ?>
  </ul>
</div>
   
<div class="emp-details-education_form">

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
      'model' => $modelEducation[0],
      'formId' => 'dynamic-form',
      'formFields' => [
          'qualification',
          'course',
          'institute',
          'yop',
          'board',
      ],
  ]);
  ?>
  <br>
  <div class="panel panel-default">   
    <div class="panel-heading">
      <i class="fa fa-envelope"></i> Education Details Front 
      <button type="button" class="pull-right siblingsadd-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add </button>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body container-siblings">			
          <?php foreach ($modelEducation as $index => $modelEdu): ?>                  
        <div class="siblingsitem panel" style="padding:0px">                   
          <div class="panel-body" style="padding:0px">
            <?php
            if (!$modelEdu->isNewRecord) {
              echo Html::activeHiddenInput($modelEdu, "[{$index}]id");
            }
            ?>

            <div class="row">
              <div class="col-sm-4">
                <?= $form->field($modelEdu, "[{$index}]qualification")->dropDownList($degree,
        ['prompt'=>'Select...']) ?>
              </div>
              <div class="col-sm-4">
  <?= $form->field($modelEdu, "[{$index}]course")->dropDownList($major,
        ['prompt'=>'Select...']) ?>
              </div>
                 <div class="col-sm-4">
                <?= $form->field($modelEdu, "[{$index}]board")?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <!--<?= $form->field($modelEdu, "[{$index}]institute")->dropDownList($college,
        ['prompt'=>'Select...']) ?>-->
		<?= $form->field($modelEdu, "[{$index}]institute")?>
              </div>
              <div class="col-sm-4">
  <?= $form->field($modelEdu, "[{$index}]yop")?>
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
</div><!-- emp-details-education_form -->

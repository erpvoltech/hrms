<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;
use common\models\Unit;
use common\models\Department;
use common\models\Designation;
use common\models\Division;
use yii\helpers\ArrayHelper;

$employeeid = Yii::$app->request->getQueryParam('id');

#echo "</br> division id: ".$model->designation;
#exit;
if($model->department_id != '')
$deptData 		= Department::find()->where(['id' => $model->department_id])->one();
if($model->designation != '')
$designation 	= Designation::find()->where(['id' => $model->designation])->one();
if($model->unit_id != '')
$unitData 		= Unit::find()->where(['id' => $model->unit_id])->one();
if($model->division_id != '')
$divData		= Division::find()->where(['id' => $model->division_id])->one();
#echo $divData->division_name;
#echo "<pre>";print_r($divData);echo "</pre>";
#exit;
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
</style>
<div class="wizard">
   <ul class="steps" >
      <?php if (!$model->isNewRecord) : ?>         
	  
         <li class="active">Employee<span class="chevron"></span></li>	 

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
         

         <?php if (!empty($model->employeeBankDetail)) : ?>
            <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>
         
         <?php if (!empty($model->employment)) : ?>
            <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li ><?= Html::a('Previous Employment', ['previous_employment', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>

      <?php else : ?>         
         <li class="active">Employee<span class="chevron"></span></li>         
         <li>Personal<span class="chevron"></span></li>
         <li>Education<span class="chevron"></span></li>         
         <li>Bank Details<span class="chevron"></span></li>         
         <li >Previous Employment<span class="chevron"></span></li>
      <?php endif; ?>
   </ul>
</div>
<div class="emp-details-form control-group ">
   <h2><?= Html::encode($this->title) ?></h2>
   <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data']]); ?>

   <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-envelope"> Employee details</i></div>
      <div class="panel-body">
         <div class="row">
            <div class="form-group col-lg-4 ">
				<div class="form-group field-empdetailsfront-empcode col-sg-4">
					<label class="control-label col-sm-4">Emp Code</label>				
					<div class="form-group col-sm-4 ">	
						<?php echo $model->empcode; ?>
					</div>
				</div>
			</div>
            <div class="form-group col-lg-4 ">
				<div class="form-group field-empdetailsfront-empcode col-sg-4">
					<label class="control-label col-sm-4">Emp Code</label>				
					<div class="form-group col-sm-4 ">	
						<?php echo $model->empname; ?>
					</div>
				</div>
			</div>           
         </div>

         <div class="row"> 
			<div class="form-group col-lg-4 ">
				<div class="form-group field-empdetailsfront-empcode col-sg-4">
					<label class="control-label col-sm-4">Designation</label>				
					<div class="form-group col-sm-4 ">			
						<?php if($model->designation != '') echo $designation->designation;  ?>
					</div>
				</div>
            </div>
			
			<div class="form-group col-lg-4 ">
				<div class="form-group field-empdetailsfront-empcode col-sg-4">
					<label class="control-label col-sm-4">Category</label>
					<div class="form-group col-sm-4 ">
						<?php echo $model->category; ?>
					</div>
				</div>
			</div>
         <div class="row">
			<div class="form-group col-lg-4 ">
				<div class="form-group field-empdetailsfront-empcode col-sg-4">
					<label class="control-label col-sm-4">Unit</label>
					<div class="form-group col-sm-4 ">
						<?php if($model->unit_id != '') echo $unitData->name; ?>
					</div>
				</div>
			</div>
            <div class="form-group col-lg-4 ">
				<div class="form-group field-empdetailsfront-empcode col-sg-4">
					<label class="control-label col-sm-4">Division</label>
					<div class="form-group col-sm-4 ">
					<?php if($model->division_id != '') echo $divData->division_name; ?>
					</div>
				</div>
            </div>
            <div class="form-group col-lg-4 ">
				<div class="form-group field-empdetailsfront-empcode col-sg-4">
					<label class="control-label col-sm-4">Department</label>
					<div class="form-group col-sm-4 ">
						<?php if($model->department_id != '') echo $deptData->name; ?>
					</div>
				</div>
			</div>
           
         </div>
         <div class="row">
            <div class="form-group col-lg-4">
               <?= $form->field($model, 'mobileno')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="form-group col-lg-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
                    
            <div class="col-lg-2"></div>
            <div class="col-lg-4">
               <?php
               echo $form->field($model, 'photo')->widget(FileInput::classname(), [
                   'options' => ['accept' => 'image/*'],
                   'pluginOptions' => [
                       'showCaption' => false,
                       'showRemove' => false,
                       'showUpload' => false,
                       'browseClass' => 'btn btn-primary btn-block',
                       'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                       'browseLabel' => 'Select Photo',
                       'maxFileSize' => 1024
                   ],
               ]);
               ?>

            </div>
         </div>
         <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2 p-l-20 form-group" style="left:35px;">
            <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
            </div>
         </div>
         <?php ActiveForm::end(); ?>

      </div>
   </div>
</div>


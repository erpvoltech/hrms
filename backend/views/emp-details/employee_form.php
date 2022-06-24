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
use kartik\select2\Select2;

error_reporting(0);

//header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); 
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Cache-Control: no-cache");
header("Pragma: no-cache");


$employeeid = Yii::$app->request->getQueryParam('id');

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
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
   .krajee-default.file-preview-frame .kv-file-content{
	   width: 183px;
height: 81px;
   }
   .krajee-default.file-preview-frame{
	  width: 142px; 
   }
   .img-responsive{
	 display: block;
    max-width: 60%;
    height: auto;  
	   
   }
</style>
<div class="wizard">
   <ul class="steps" >
      <?php if (!$model->isNewRecord) : ?>
         <li><?= Html::a('List', ['index']) ?><span class="chevron"></span></li>
         <li class="active">Employee<span class="chevron"></span></li>

         <?php if (!empty($model->remuneration)) : ?>
            <li ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li  ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
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
         <li class="active">Employee<span class="chevron"></span></li>
         <li >Remuneration<span class="chevron"></span></li>
         <li>Personal<span class="chevron"></span></li>
         <li>Education<span class="chevron"></span></li>
         <li>Certificates<span class="chevron"></span></li>
         <li>Bank Details<span class="chevron"></span></li>
         <li>Statutory<span class="chevron"></span></li>
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
               <?= $form->field($model, 'empcode')->textInput(['maxlength' => true])->label('Engg/Staff Code') ?>
            </div>
            <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'empname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="form-group col-lg-4 ">
               <?=
               $form->field($model, 'doj')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>
         </div>

         <div class="row">


            <div class="form-group col-lg-4 ">
               <?=
               $form->field($model, 'confirmation_date')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>

            <div class="form-group col-lg-4 ">
			   <?=
                                $form->field($model, "designation_id")->widget(Select2::classname(), [
                                    'data' => $designation,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
               ?>
            </div>
            <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'category')->dropDownList([ 'HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'], ['prompt' => 'Select...']) ?>
            </div>
         </div>
         <div class="row">


            <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...'])
               ?>
            </div>
             <div class="form-group col-lg-4 ">
               <?=
                                $form->field($model, "division_id")->widget(Select2::classname(), [
                                    'data' => $divData,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
               ?>
            </div>
            <div class="form-group col-lg-4 ">
			   <?=
                                $form->field($model, "department_id")->widget(Select2::classname(), [
                                    'data' => $deptData,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
               ?>
            </div>
           
         </div>
         <div class="row">
            <div class="form-group col-lg-4">
               <?= $form->field($model, 'mobileno')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="form-group col-lg-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
             <div class="form-group col-lg-4">
               <?= $form->field($model, 'referedby')->textInput(['maxlength' => true]) ?>
            </div>
            
         </div>
         <div class="row">
            <div class="form-group col-lg-4">
            <?= $form->field($model, 'probation')->textInput() ?>
            </div>

            <div class="form-group col-lg-4">
               <?= $form->field($model, 'appraisalmonth')->dropDownList([ 'January' => 'January', 'February' => 'February', 'March' => 'March', 'April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July', 'August' => 'August', 'September' => 'September', 'October' => 'October', 'November' => 'November', 'December' => 'December'], ['prompt' => 'Select...']) ?>
            </div>

            <div class="form-group col-lg-4">
               <?=
               $form->field($model, 'recentdop')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>
           

         </div>
         <div class="row">
             <div class="form-group col-lg-4">
               <?= $form->field($model, 'joining_status')->dropDownList([ 'Experienced' => 'Experienced', 'Fresher' => 'Fresher'], ['prompt' => ' ']) ?>
            </div>
            <div class="form-group col-lg-4  ">
               <?= $form->field($model, 'experience') ?>
            </div>
            <div class="form-group col-lg-4">
               <?=
               $form->field($model, 'last_working_date')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>

         </div>
		  <div class="row">
             <div class="form-group col-lg-4">
             <?=
               $form->field($model, 'resignation_date')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>
            <div class="form-group col-lg-4  ">
              <?=
               $form->field($model, 'dateofleaving')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>     
			  <div class="form-group col-lg-4 ">
			 <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Non-paid Leave' => 'Non-paid Leave', 'Paid and Relieved' => 'Paid and Relieved','Relieved' => 'Relieved','Transferred' => 'Transferred','Notice Period' => 'Notice Period','Exit Formality Inprocess'=>'Exit Formality Inprocess','Termination'=>'Termination'], ['prompt' => 'Select...']) ?>	
			</div> 

         </div>

         <div class="row">
            <div class="form-group col-lg-4  " style="margin-right:130px;">
               <?= $form->field($model, 'reasonforleaving')->textarea(['rows' => 6, 'cols' => 82]) ?>
            </div>
			 <div class="col-lg-2"></div>
			  <div class="form-group col-lg-4 ">                 
               <?= $form->field($model, 'photo')->widget(FileInput::classname(), [
                   'options' => ['accept' => 'image/*'],
                   'pluginOptions' => [
                       'showCaption' => false,
                       'showRemove' => false,
                       'showUpload' => false,
					    'initialPreview' => [
						Html::img('@web/emp_photo/' . $model->photo, ['class' => 'img-responsive']),
            //Html::img("/images/earth.jpg", ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth']),?rand=<?php echo rand();
						],
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
		 <div class="col-lg-2"></div>
		<div class="col-lg-5">
		 <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
		 </div>
         
         </div>
		 
         <div class="row"> 
            <div class="col-md-1"></div>
            <div class="col-md-2 p-l-20 form-group" style="left:35px;">
           <!-- <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?> -->
            </div>
         </div>
         <?php ActiveForm::end(); ?>

      </div>
   </div>
</div>


<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\EmpDetails;

$employeeid = Yii::$app->request->getQueryParam('id');
$Emp = EmpDetails::findOne($employeeid);
?>
<div class="wizard">
   <ul class="steps">
      <?php if (!$model->isNewRecord) : ?>
         <li><?= Html::a('List', ['index']) ?><span class="chevron"></span></li>

         <?php if (!$model->isNewRecord) : ?>
            <li><?= Html::a('Employee', ['update', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Employee', ['create', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>

         <?php if (!empty($model->remuneration)) : ?>
            <li  ><?= Html::a('Remuneration', ['remuneration', 'id' => $model->employeePersonalDetail->empid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li ><?= Html::a('Remuneration', ['remuneration', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>

		  <?php if (!empty($model->employeeStatutoryDetail)) : ?>
            <li><?= Html::a('Statutory', ['statutory-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Statutory', ['statutory-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>
		 
		  <?php if (!empty($model->employeeBankDetail)) : ?>
            <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li><?= Html::a('Bank Details', ['bank-details', 'id' => $employeeid]); ?><span class="chevron"></span></li>
         <?php endif; ?>
		 
         <?php if (!empty($model->employeePersonalDetail)) : ?>
            <li class="active"><?= Html::a('Personal', ['personal-details', 'id' => $model->employeePersonalDetail->empid]); ?><span class="chevron"></span></li>
         <?php else : ?>
            <li class="active"> Personal <span class="chevron"></span></li>
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
         <li><?= Html::a('List Emp', 'index') ?><span class="chevron"></span></li>
         <li ><?= Html::a('Employee', ['update', 'id' => $employeeid]) ?><span class="chevron"></span></li>
		  <li>Bank Details<span class="chevron"></span></li>
         <li>Statutory<span class="chevron"></span></li>
         <li class="active">Personal<span class="chevron"></span></li>
         <li>Education<span class="chevron"></span></li>
         <li>Certificates<span class="chevron"></span></li>        
         <li >Previous Employment<span class="chevron"></span></li>
      <?php endif; ?>
   </ul>
</div>

<div class="emp-details-personaldetails_form control-group ">
	
   <h2><?= Html::encode($this->title) ?></h2>

   <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>

   <div class="panel panel-default">
      <div class="panel-heading"><i class="fa fa-user"> Personal details</i></div>
      <div class="panel-body" >
	  <div class="row">
   
	<div class="col-lg-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-Code</div>
		<div class="col-lg-2"> <b><?= $Emp->empcode ?></b> </div>
		
		<div class="col-lg-2">Employee Name</div>
		<div class="col-lg-2"> <b><?= $Emp->empname ?></b> </div>
         </div> 
		 <br>
         <div class="row">
            <div class="form-group col-lg-4">
               <?=
               $form->field($model, 'dob')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>
            <div class="form-group col-lg-4">
               <?=
               $form->field($model, 'birthday')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
            </div>
            <div class="form-group col-lg-4" >  <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', 'Others' => 'Others'], ['prompt' => ' ']) ?></div>

         </div>
		 
		  <div class="row">
            <div class="form-group col-lg-4">
               <?= $form->field($model, 'mobile_no') ?>
            </div>
            <div class="form-group col-lg-4">
               <?= $form->field($model, 'email') ?>
            </div>
           <div class="form-group col-lg-4">
               <?= $form->field($model, 'caste')->dropDownList([ 'FC' => 'FC', 'BC' => 'BC', 'MBC' => 'MBC', 'OBC' => 'OBC', 'SC' => 'SC', 'ST' => 'ST'], ['prompt' => ' ']) ?>
            </div>

         </div>
		 
         <div class="row">
            
            <div class="form-group col-lg-4">
               <?= $form->field($model, 'community') ?>
            </div>
            <div class="form-group col-lg-4">  <?= $form->field($model, 'blood_group') ?></div>
			 <div class="form-group col-lg-4">
               <?= $form->field($model, 'martialstatus')->dropDownList([ 'Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed'], ['prompt' => ' ']) ?>
            </div>
         </div>
         <div class="row">           
            <div class="form-group col-lg-4">  <?= $form->field($model, 'panno')->textInput(['maxlength' => true]) ?> </div>
            <div class="form-group col-lg-4">  <?= $form->field($model, 'aadhaarno')->textInput(['maxlength' => true]) ?></div>
			<div class="form-group col-lg-4">   <?=
               $form->field($model, 'year_of_marriage')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?>
         </div> </div>
         <div class="row">
           
            <div class="form-group col-lg-4">  <?= $form->field($model, 'passportno') ?></div>
            <div class="form-group col-lg-4">  <?=
               $form->field($model, 'passportvalid')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])
               ?></div>
			    <div class="form-group col-lg-4">  <?= $form->field($model, 'voteridno') ?></div>
         </div>
         <div class="row">
            <div class="form-group col-lg-4">  <?= $form->field($model, 'drivinglicenceno')->textInput(['maxlength' => true]) ?> </div>
            <div class="form-group col-lg-4">  <?= $form->field($model, 'passport_remark')->textarea(['style' => 'width:350px']) ?></div>

         </div>

         <div class="row">
            <div class="form-group col-lg-4">  <?=
               $form->field($model, 'licence_categories')->dropDownList([ 'MC With Gear' => 'Motorcycle With Gear', 'MC Without Gear' => 'Motorcycle Without Gear', 'LMV-NT' => 'Light Motor Vehicle—Non Transport',
                   'LMV-TR' => 'Light Motor Vehicle—Transport', 'HPMV' => 'Heavy Passenger Motor Vehicle', 'HTV' => 'Heavy Transport Vehicle', 'LDRXCV' => 'Loader, Excavator, Hydraulic Equipments', 'TRANS' => 'Heavy Goods Motor Vehicle',], ['prompt' => ' '])
               ?></div>
            <div class="form-group col-lg-4" >  <?= $form->field($model, 'licence_remark')->textarea(['style' => 'width:360px']) ?></div>
         </div>
         <h6  style="text-decoration: underline;font-size:16px;">Permanent Address</h6>
         <div class="row">
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'addfield1') ?> </div>
            <div class="form-group col-lg-4"><?= $form->field($addressModel, 'addfield2') ?></div>
            <div class="form-group col-lg-4"><?= $form->field($addressModel, 'addfield3') ?></div>
         </div>
         <div class="row">
            <div class="form-group col-lg-4"><?= $form->field($addressModel, 'addfield4') ?></div>
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'addfield5') ?></div>
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'district') ?></div>
         </div>  <div class="row">
            <div class="form-group col-lg-4"><?= $form->field($addressModel, 'state') ?></div>
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'pincode') ?>  </div>
			 <div class="form-group col-lg-2">
			 </div>
			
         </div>
         <h6  style="text-decoration: underline;font-size:16px;">Temporary Address &nbsp;<?= Html::Button('Same As Permanent Address', ['class' => 'siblingsadd-item btn btn-success btn-xs','id'=>'copy']) ?></h6>
         <div class="row">
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'addfieldtwo1') ?></div>
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'addfieldtwo2') ?></div>
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'addfieldtwo3') ?></div>
         </div>
         <div class="row">
            <div class="form-group col-lg-4"> <?= $form->field($addressModel, 'addfieldtwo4') ?></div>
            <div class="form-group col-lg-4">  <?= $form->field($addressModel, 'addfieldtwo5') ?></div>
            <div class="form-group col-lg-4">  <?= $form->field($addressModel, 'districttwo') ?></div>
         </div>
         <div class="row">
            <div class="form-group col-lg-4">    <?= $form->field($addressModel, 'statetwo') ?></div>
            <div class="form-group col-lg-4">  <?= $form->field($addressModel, 'pincodetwo') ?></div>
         </div>

         <?php
         DynamicFormWidget::begin([
             'widgetContainer' => 'dynamicform_wrapper',
             'widgetBody' => '.container-siblings',
             'widgetItem' => '.siblingsitem',
             'limit' => 5,
             'min' => 1,
             'insertButton' => '.siblingsadd-item',
             'deleteButton' => '.siblingsremove-item',
             'model' => $modelSibling[0],
             'formId' => 'dynamic-form',
             'formFields' => [
                 'name',
                 'ralationship',
                 'mobileno',
                 'aadhaarno',
                 'nominee',
                 'birthdate',
				 'gmc_no',
				 'sum_insured',
				 'age_group',
             ],
         ]);
         ?>
         <br>
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="fa fa-users"></i> Family Details
               <button type="button" class="pull-right siblingsadd-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add </button>
               <div class="clearfix"></div>
            </div>
            <div class="panel-body container-siblings">
               <?php foreach ($modelSibling as $index => $modelsib): ?>
                  <div class="siblingsitem" style="padding:0px">
                     <div class="panel-body" style="padding:0px">
                        <?php
                        if (!$modelsib->isNewRecord) {
                           echo Html::activeHiddenInput($modelsib, "[{$index}]id");
                        }
                        ?>

                        <div class="row">
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]name")->textInput(['maxlength' => true]) ?>
                           </div>
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]relationship")->textInput(['maxlength' => true]) ?>
                           </div>
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]mobileno")->textInput(['maxlength' => true]) ?>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]aadhaarno")->textInput(['maxlength' => true]) ?>
                           </div>
                           <div class="col-sm-4">
                              
                             <?= $form->field($modelsib, "[{$index}]birthdate")->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                    'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ]) ?>
                            
                           </div>
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]nominee")->dropDownList([ 'Yes' => 'Yes', 'No' => 'No'], ['prompt' => ' ']) ?>
                           </div>

                        </div>
						
						 <div class="row">
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]gmc_no")->textInput(['maxlength' => true]) ?>
                           </div>
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]sum_insured")->textInput(['maxlength' => true]) ?>
                           </div>
                           <div class="col-sm-4">
                              <?= $form->field($modelsib, "[{$index}]age_group")->dropDownList(['0-35' => '0-35', '36-45' => '36-45', '46-50' => '46-50','51-55' => '51-55','56-60' => '56-60','61-65' => '61-65','66-70' => '66-70'], ['prompt' => '']) ?>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <button type="button" class="pull-right siblingsremove-item btn btn-danger btn-xs"> Delete</button>
                           </div>
                        </div>
                     <?php endforeach; ?>

                  </div>
               </div>
            </div>
         </div>
         <?php DynamicFormWidget::end(); ?>
         <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2 p-l-20 form-group" style="right:25px;">
               <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
            </div>
         </div>
      </div>
   </div>
   <?php ActiveForm::end(); ?>
</div>
</div>
<?php
$script = <<< JS
	$("#copy").click(function(){
	 var text1 = document.getElementById("empaddress-addfield1");
    var text2 = document.getElementById("empaddress-addfield2");
	 var text3 = document.getElementById("empaddress-addfield3");
	  var text4 = document.getElementById("empaddress-addfield4");
	  var text5 = document.getElementById("empaddress-addfield5");
	  var text6 = document.getElementById("empaddress-district");
	  var text7 = document.getElementById("empaddress-state");
	  var text8 = document.getElementById("empaddress-pincode");
	   var text11 = document.getElementById("empaddress-addfieldtwo1");
	    var text12 = document.getElementById("empaddress-addfieldtwo2");
		 var text13 = document.getElementById("empaddress-addfieldtwo3");
		  var text14 = document.getElementById("empaddress-addfieldtwo4");
		  var text15 = document.getElementById("empaddress-addfieldtwo5");
		  var text16 = document.getElementById("empaddress-districttwo");
		  var text17 = document.getElementById("empaddress-statetwo");
		  var text18 = document.getElementById("empaddress-pincodetwo");
    text11.value = text1.value;
	 text12.value = text2.value;
	  text13.value = text3.value;
	   text14.value = text4.value;
	    text15.value = text5.value;
		 text16.value = text6.value;
		  text17.value = text7.value;
		  text18.value = text8.value;
	
	});
JS;
$this->registerJs($script);
?>






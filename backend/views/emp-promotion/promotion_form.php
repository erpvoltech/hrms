<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use yii\helpers\ArrayHelper;
use common\models\EmpRemunerationDetails;
use common\models\EmpDetails;
use common\models\Designation;

$PayScale = EmpStaffPayScale::find()->select('salarystructure')->all();
$structure = EmpSalarystructure::find()->select('salarystructure')->distinct()->all();
$designation = Designation::find()->all();
$listData = ArrayHelper::map($structure, 'salarystructure', 'salarystructure');
$listData1 = ArrayHelper::map($PayScale, 'salarystructure', 'salarystructure');
$design = ArrayHelper::map($designation, 'id', 'designation');
$user = '';
$flag = 0;

if (Yii::$app->getRequest()->getQueryParam('id')) {
   $empid = Yii::$app->getRequest()->getQueryParam('id');
   $user = Yii::$app->getRequest()->getQueryParam('user');
   $ModelEmp = EmpDetails::find()->where(['id' => $empid])
           ->one();
   $flag = 1;
} else if (Yii::$app->getRequest()->getQueryParam('user')) {
   Yii::$app->session->addFlash("error", 'User ' . Yii::$app->getRequest()->getQueryParam('user') . ' does not found');
}
?>

<div class="emp-promotion-form">
   <?php echo $this->render('empsearch', ['model' => $model, 'user' => $user]); ?>
   <?php
   if ($flag == 1) {

      $form = ActiveForm::begin(['layout' => 'horizontal']);
      ?>
      <?= $form->field($model, 'empid')->hiddenInput(['value' => $empid])->label(false) ?> 
      <div class="row">
         <div class="form-group col-lg-10"><b> Current Details</b></div>
      </div>
      <div class="row">
         <div class="form-group col-lg-4"> Emp. Code: <?= $ModelEmp->empcode ?>   </div>
         <div class="form-group col-lg-4"> Name: <?= $ModelEmp->empname ?>   </div>
         <div class="form-group col-lg-4"> Designation : <?= $ModelEmp->designation->designation ?>   </div>

      </div>
      <div class="row">
         <div class="form-group col-lg-4"> Unit : <?= $ModelEmp->units->name ?>   </div>
         <div class="form-group col-lg-4"> Department: <?= $ModelEmp->department->name ?>   </div>
         <div class="form-group col-lg-4"> Work Level : <?= $ModelEmp->designation->designation ?>   </div>
      </div>

      <div class="row">
         <div class="form-group col-lg-4"> Salary Structure : <?= $ModelEmp->remuneration->salary_structure ?>   </div>
         <div class="form-group col-lg-4"> Work Level: <?= $ModelEmp->remuneration->work_level ?>   </div>
         <div class="form-group col-lg-4"> Grade : <?= $ModelEmp->remuneration->grade ?>   </div>
      </div>
	  
	   <div class="row">
         <div class="form-group col-lg-4"> PLI : <?= $ModelEmp->remuneration->pli ?>   </div>
       
      </div>
      <div class="row">
         <div class="form-group col-lg-10"> <b>Promotion Details</b></div>
      </div>
      <div class="row">
         <div class="form-group col-lg-4">       
            <?=
            $form->field($model, 'effectdate')->widget(\yii\jui\DatePicker::class, [
                'options' => ['class' => 'form-control'],
                'dateFormat' => 'MM-yyyy',
                'clientOptions' => [
                    'dateFormat' => 'MM-yyyy',
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
            ])
            ?>
         </div> 
         <div class="form-group col-lg-4">
            <?= $form->field($model, 'designation_to')->dropDownList($design, ['prompt' => ' ']) ?>
         </div>
         <div class="form-group col-lg-4">
            <?=
            $form->field($model, 'ss_to')->dropDownList($listData + ['Consolidated pay' => 'Consolidated pay', 'Contract' => 'Contract'] + $listData1, ['prompt' => '',
                'onchange' => '$.post( "' . Yii::$app->urlManager->createUrl('emp-details/worklevel?id=') . '"+$(this).val(), function( data ) {
				  $( "#emppromotion-wl_to" ).html( data );
				});
			']);
            ?>
         </div></div> <div class="row">
         <div class="form-group col-lg-4">
            <?= $form->field($model, 'wl_to')->dropDownList(['WL5' => 'WL5', 'WL4C' => 'WL4C', 'WL4B' => 'WL4B', 'WL4A' => 'WL4A', 'WL3B' => 'WL3B', 'WL3A' => 'WL3A'], ['prompt' => ' ']) ?>                
         </div>  <div class="form-group col-lg-4">
            <?= $form->field($model, 'grade_to')->dropDownList(['AA' => 'AA','A' => 'A','A1' => 'A1', 'B' => 'B','B1' => 'B1', 'C' => 'C','C1' => 'C1', 'D' => 'D','E' => 'E'], ['prompt' => ' ']) ?>
         </div>
		  <div class="form-group col-lg-4" >
         <?= $form->field($model, 'type')->dropDownList([2 => 'Increment', 1 => 'Promotion', 3 => 'Confirmation'], ['prompt' => ' ']) ?>
      </div>
		 </div>

      <div class="row">
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'basic') ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'hra') ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'other_allowance') ?>
         </div> 
      </div> 

      <div class="row">
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'dearness_allowance') ?>
         </div>         
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'conveyance') ?>
         </div> 
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'lta') ?>
         </div> 
      </div>

      <div class="row">        
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'medical') ?>
         </div>         
         <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'gross_to') ?>
         </div> 
		  <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'pli_to')->dropDownList(['8.33' => '8.33', '16.67' => '16.67'], ['prompt' => ' ']) ?>
         </div> 
      </div> 

      <div class="row">

      </div> 
	  
      <div class="form-group">
         <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
      </div>

      <?php
      ActiveForm::end();
   }
   ?>

</div>
<?php
$script = <<<JS
          var empm_type;
		$('#emppromotion-basic').prop("readonly", true);
		$('#emppromotion-hra').prop("readonly", true);
		$('#emppromotion-other_allowance').prop("readonly", true);
		$('#emppromotion-dearness_allowance').prop("readonly", true);		
		$('#emppromotion-conveyance').prop("readonly", true);
		$('#emppromotion-lta').prop("readonly", true);
		$('#emppromotion-medical').prop("readonly", true);		
		$('#emppromotion-gross_to').prop("readonly", true);  
        
        
        $('#emppromotion-grade_to').change(function(event){ 
		$('#emppromotion-basic').val("");
		$('#emppromotion-hra').val("");
		$('#emppromotion-other_allowance').val("");
		$('#emppromotion-dearness_allowance').val("");		
		$('#emppromotion-conveyance').val("");
		$('#emppromotion-lta').val("");
		$('#emppromotion-medical').val("");
		$('#emppromotion-gross_to').val("");  
	   var ss = $('#emppromotion-ss_to').val();
	   var wl = $('#emppromotion-wl_to').val();
	   var grade = $('#emppromotion-grade_to').val();
	  if(ss !='Consolidated pay' && ss !='Contract' && ss !='Conventional' && ss !='Modern'){
           empm_type = 'Engineer';
            $.ajax({
                type: "POST",
                url: '../emp-details/salarystructure',
                data: {sla_structure:ss, worklevel:wl, grade: grade,empmtype: empm_type},
				dataType : 'json',
                success: function (data) {				
				   $('#emppromotion-basic').val(data.basic);
				   $('#emppromotion-hra').val(data.hra);
				   $('#emppromotion-other_allowance').val(data.other_allowance);
				   $('#emppromotion-dearness_allowance').val(data.dapermonth);
				    $('#emppromotion-gross_to').val(data.gross);
                },
                error: function (exception) {
                   alert('Salary Structure Doesn\'t match');
                }
            });
         }
	});
	
      $('#emppromotion-ss_to').change(function(event){
		$('#emppromotion-basic').val("");
		$('#emppromotion-hra').val("");
		$('#emppromotion-other_allowance').val("");
		$('#emppromotion-dearness_allowance').val("");		
		$('#emppromotion-conveyance').val("");
		$('#emppromotion-lta').val("");
		$('#emppromotion-medical').val("");
		$('#emppromotion-gross_to').val("");  
         var ss = $('#emppromotion-ss_to').val();		
         if(ss =='Conventional' || ss =='Modern'){
        $('#emppromotion-gross_to').prop("readonly", false);   
         } else if(ss =='Consolidated pay'){
        $('#emppromotion-basic').prop("readonly", false);
        }
      });	
      
JS;
$this->registerJs($script);
?>

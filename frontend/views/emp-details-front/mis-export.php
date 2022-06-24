<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\EmpDetails;
use common\models\Unit;
use common\models\Department;
use common\models\Designation;
use common\models\Division;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
error_reporting(0);
$model= new EmpDetails();
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>

<style>
   .glyphicon {
      padding-right:10px;
   } table{
      background-color:#DFDFDF;

   }
   .btn-default {
   background-color: #fafafa;
    color: #444;
   border-color: #fafafa;
   width : 250px;
   padding:12px;
   text-align:left;
}
</style>
<br>
<?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
<div class="form-group col-lg-4 ">
               <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...'])
               ?>
            </div>
             <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'division_id')->dropDownList($divData, ['prompt' => 'Select...'])
               ?>
            </div>
            <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'department_id')->dropDownList($deptData, ['prompt' => 'Select...'])
               ?>
            </div>
			</div> <div class="row">
			  <div class="form-group col-lg-4 ">
            <?= $form->field($model, 'category')->dropDownList([ 'HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'], ['prompt' => 'Select...']) ?>
            </div>
			 <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'designation_id')->dropDownList($designation, ['prompt' => 'Select...'])
               ?>
            </div>
			 <div class="form-group col-lg-2 "></div>
			 <div class="form-group col-lg-2 ">
			  <?= Html::a('Clear', ['mis-export'], ['class' => 'btn  btn-warning','style'=> 'width : 90px']) ?>
			</div></div>
		 <?php ActiveForm::end(); ?>
</br><br><br>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-4"> Select Export Type :
	<input type="radio" name="datavalue" value="2"> Without data
	<input type="radio" name="datavalue" value="1"> With data
	<div id="selecterror" style="color:red"> </div>
	<br><br>
	<br><br>
  <button class="btn btn-default " type="button" id="exportemp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Emp Details</button> <br>
	 <button class="btn btn-default " type="button" id="familyexport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Family Details</button><br>
	 <button class="btn btn-default " type="button" id="eduexport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Education Details</button><br>
	 <button class="btn btn-default " type="button" id="certificateexport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Certificates Details</button><br>
	 <button class="btn btn-default " type="button" id="bankexport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Bank Details</button>
  
</div>
</div>


<?php
           $script = <<<JS
		   
			 $("#exportemp").click(function() {
			 var unit = $('#empdetails-unit_id').val();
			 var design = $('#empdetails-designation_id').val();
			 var categ = $('#empdetails-category').val();
			 var dept = $('#empdetails-department_id').val();
			 var div = $('#empdetails-division_id').val();
			 var exporttype = $('input[name=datavalue]:checked').val();
			 if(exporttype) {
				var printWindow = window.open('export-emp?unit='+unit+'&design='+design+'&dept='+dept+'&division='+div+'&categ='+categ+'&type='+exporttype, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
				printWindow.document.title = "Downloading";
				printWindow.addEventListener('load', function () {
				}, true);
			 } else {
			 $('#selecterror').html('Select Export Type');			
			 }
			});
			 $("#familyexport").click(function() {
			 var unit = $('#empdetails-unit_id').val();
			 var design = $('#empdetails-designation_id').val();
			 var categ = $('#empdetails-category').val();
			 var dept = $('#empdetails-department_id').val();
			 var div = $('#empdetails-division_id').val();
			 var exporttype = $('input[name=datavalue]:checked').val();
			  if(exporttype) {
				var printWindow = window.open('export-family?unit='+unit+'&design='+design+'&dept='+dept+'&division='+div+'&categ='+categ+'&type='+exporttype, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
				printWindow.document.title = "Downloading";
								printWindow.addEventListener('load', function () {
								}, true);
			 } else {
			 $('#selecterror').html('Select Export Type');			
			 }
			});
			 $("#certificateexport").click(function() {
			 var unit = $('#empdetails-unit_id').val();
			 var design = $('#empdetails-designation_id').val();
			 var categ = $('#empdetails-category').val();
			 var dept = $('#empdetails-department_id').val();
			 var div = $('#empdetails-division_id').val();
			 var exporttype = $('input[name=datavalue]:checked').val();
			  if(exporttype) {
				var printWindow = window.open('export-certificate?unit='+unit+'&design='+design+'&dept='+dept+'&division='+div+'&categ='+categ+'&type='+exporttype, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
				printWindow.document.title = "Downloading";
								printWindow.addEventListener('load', function () {
								}, true);
				 } else {
			 $('#selecterror').html('Select Export Type');			
			 }
			});
			 $("#eduexport").click(function() {
			 var unit = $('#empdetails-unit_id').val();
			 var design = $('#empdetails-designation_id').val();
			 var categ = $('#empdetails-category').val();
			 var dept = $('#empdetails-department_id').val();
			 var div = $('#empdetails-division_id').val();
			 var exporttype = $('input[name=datavalue]:checked').val();
			  if(exporttype) {
				var printWindow = window.open('export-edu?unit='+unit+'&design='+design+'&dept='+dept+'&division='+div+'&categ='+categ+'&type='+exporttype, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
				printWindow.document.title = "Downloading";
								printWindow.addEventListener('load', function () {
								}, true);
				 } else {
			 $('#selecterror').html('Select Export Type');			
			 }
			});
			 $("#bankexport").click(function() {
			 var unit = $('#empdetails-unit_id').val();
			 var design = $('#empdetails-designation_id').val();
			 var categ = $('#empdetails-category').val();
			 var dept = $('#empdetails-department_id').val();
			 var div = $('#empdetails-division_id').val();
			 var exporttype = $('input[name=datavalue]:checked').val();
			  if(exporttype) {
				var printWindow = window.open('export-bank?unit='+unit+'&design='+design+'&dept='+dept+'&division='+div+'&categ='+categ+'&type='+exporttype, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
				printWindow.document.title = "Downloading";
								printWindow.addEventListener('load', function () {
								}, true);
				 } else {
			 $('#selecterror').html('Select Export Type');			
			 }
			});
JS;
           $this->registerJs($script);
           ?>
</div>
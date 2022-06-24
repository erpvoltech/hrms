<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use yii\helpers\ArrayHelper;
use common\models\EmpDetails;
use dosamigos\multiselect\MultiSelect;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');

?>
<style>
   .alert {
      padding: 5px;
      margin-bottom: 8px;
   }
</style>
<div class="emp-salary-form">
   <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size:18px;">Statutory IR - Attendance Upload</div>
      <div class="panel-body"> 
         <?php
         $form = ActiveForm::begin();
         ?>
         <br> 
				<div class="row">					
					<div class="form-group col-lg-12 ">
					   <?= $form->field($model, 'file')->fileInput() ?>
					</div>
				</div>
				<div class="row">					
					<div class="form-group col-lg-12 ">
					   <?= $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
						   'options' => ['class' => 'form-control'],
						   'dateFormat' => 'MM-yyyy',
					   ]) ?>
					</div>
				</div>
				<div class="row">			
				 <div class="form-group col-lg-5 "></div>
					<div class="form-group col-lg-7" >
					   <?= Html::submitButton('Submit', ['class' => 'btn-sm btn-success']) ?>
				    </div>
				</div>
         <?php ActiveForm::end(); ?>
		    </div>
         </div>
     
</div>
<?php
$script = <<<JS
   $("#dropdownMenuButton").click(function() {
    var categ = $('#empsalaryupload-category').val();
	var unit = $('#empsalaryupload-unitgroup').val();	
    var printWindow = window.open('salary-template-engg?id=1&unit='+unit+'&catg='+categ, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
     printWindow.document.title = "Downloading";

     printWindow.addEventListener('load', function () {
     //printWindow.close();
     }, true); 
     });
JS;
$this->registerJs($script);
?>
 

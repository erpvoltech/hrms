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
      <div class="panel-heading text-center" style="font-size:18px;">Attendance upload/Download Template</div>
      <div class="panel-body"> 
         <?php
         $form = ActiveForm::begin([                   
                     'layout' => 'horizontal',
         ]);
         ?>
         <br>  
		 <div class="row">	
		        <div class="form-group col-md-2"></div>
				<div class="form-group col-lg-4 ">
				  <h4> Data Sheet Upload</h4>
				</div>
				 <div class="form-group col-md-1"></div>
				<div class="form-group col-lg-4">
				  <h4> Data Sheet Download</h4>
				</div>
		 </div>	
         <div class="row">
            <div class="form-group col-lg-5 ">				
				<div class="row">
				 <div class="form-group col-lg-12 ">
				   <?=
					   $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
						   'options' => ['class' => 'form-control'],
						   'dateFormat' => 'MM-yyyy',
					   ])
					?> 
				 </div>
				</div>
				<div class="row">					
					<div class="form-group col-lg-12 ">
					   <?= $form->field($model, 'file')->fileInput() ?>
					</div>
				</div>
				<div class="row">			
				 <div class="form-group col-lg-5 "></div>
					<div class="form-group col-lg-7" >
					   <?= Html::submitButton('Submit', ['class' => 'btn-sm btn-success']) ?>
				    </div>
				</div>
				
			</div>
            <div class="form-group col-lg-7 ">  
				<div class="row">
				<div class="form-group col-lg-6 ">
                <?= $form->field($model, 'unitgroup')->widget(MultiSelect::className(),[
					'data' =>  $unitData, 
					'options' => ['multiple'=>"multiple"],
							 "clientOptions" => 
								[
									"includeSelectAllOption" => true,
									'numberDisplayed' => 3
								], 
					]) ?>
				</div>
				  <div class="form-group col-lg-6 ">
				<?= $form->field($model, 'category')->widget(MultiSelect::className(),[
					 'data' => ['HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'],
								'options' => ['multiple'=>"multiple"],
								 "clientOptions" => 
									[
										"includeSelectAllOption" => true,
										'numberDisplayed' => 3
									], 
					]) ?>
              </div>	
           
			</div> 
						
				<div class="row">				
				<div class="form-group col-lg-2"></div>
				   <div class="col-lg-4 dropdown" style="padding-left:35px">
					  <button class="btn btn-default dropdown-toggle" id="dropdownMenuButton" data-toggle ="dropdown" aria-haspopup ="true" aria-expanded="false" title="Export data"><i class="glyphicon glyphicon-export"></i> <span class="caret"></span>
						 Template download</button>
				   </div>
				</div>
            </div>
            
            </div>
         </div>
        
         <?php ActiveForm::end(); ?>
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
 

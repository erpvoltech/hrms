<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use common\models\Department;
use common\models\Division;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$divData = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>
<style>
   .alert {
      padding: 5px;
      margin-bottom: 8px;
   }
</style>
<div class="emp-salary-form">
   <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size:18px;">PF / ESI Download </div>
      <div class="panel-body"> 
         <?php  $form = ActiveForm::begin([ 'layout' => 'horizontal']);?>
         <br> 
		 <div class="row">
                <div class="form-group col-lg-5 "></div>
                <div class="form-group col-lg-4 ">
                    <?= $form->field($model, 'pfesi')->inline()->radioList(['pf' => 'PF', 'esi' => 'ESI'])->label(false); ?>
                </div>
            </div>
		  <div class="row">
            <div class="form-group col-lg-3 "></div>
			 <div class="form-group col-lg-4 ">
			 <?= $form->field($model, 'unit')->widget(MultiSelect::className(),[
					'data' => $unitData,
					'options' => ['multiple'=>"multiple"],
					 "clientOptions" => 
						[
							"includeSelectAllOption" => true,
							'numberDisplayed' => 4
						], 
				]) ?>
		  </div>
		   <div class="form-group col-lg-4 ">
			 <?= $form->field($model, 'division')->widget(MultiSelect::className(),[
				 'data' => $divData,
					'options' => ['multiple'=>"multiple"],
					 "clientOptions" => 
						[
							"includeSelectAllOption" => true,
							'numberDisplayed' => 2
						], 
				]) ?>
		  </div>
		   </div>
		  
		    <div class="row">
            <div class="form-group col-lg-3 "></div>
			 <div class="form-group col-lg-4 ">			
					<?= $form->field($model, 'category')->widget(MultiSelect::className(),[
					 'data' => ['HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'],
								'options' => ['multiple'=>"multiple"],
								 "clientOptions" => 
									[
										"includeSelectAllOption" => true,
										'numberDisplayed' => 2
									], 
					])->label('Category') ?>
		    </div>
		   </div>
         <div class="row">
            <div class="form-group col-lg-3 "></div>
            <div class="form-group col-lg-4 ">
               <?=
               $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
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
            <!--<div class="form-group col-lg-2 "><input type="checkbox" id="PF" > &nbsp; PF &nbsp;&nbsp;&nbsp; <input type="checkbox" id="ESI" > &nbsp;ESI</div>-->
            <div class="form-group col-lg-2 ">
			 <button class="btn btn-primary dropdown-toggle" type="button" id="download" data-toggle="dropdown">Download &nbsp;<span class="caret"></span></button>
		   </div>
         </div>  
		  <div class="row">
            <div class="form-group col-lg-3 "></div>
            <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'file')->fileInput() ?>
            </div>
         </div>
		  <div class="row">
            <div class="form-group col-lg-5" ></div>
            <div class="form-group col-lg-3" >
               <?= Html::submitButton('Upload', ['class' => 'btn-sm btn-success','name'=>'upload', 'value'=>'upload']) ?>
            </div>
         </div>
         <br>
         <?php ActiveForm::end(); ?>
      </div>
   </div>
</div>
<?php
$script = <<<JS
   $("#download").click(function() {
   var datedata = $("#statutoryhr-month").val();
   var unitdata = $("#statutoryhr-unit").val();
   var divdata = $("#statutoryhr-division").val();
   var catdata = $("#statutoryhr-category").val();
   
   var pfesidata = $('input:radio[name="StatutoryHr[pfesi]"]:checked').val();
   
   if(pfesidata == 'pf'){
     var printWindow = window.open('download?month=' + datedata +'&unit='+unitdata+'&div='+divdata+'&categ='+catdata, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
     printWindow.document.title = "Downloading";
     printWindow.addEventListener('load', function () {
     //printWindow.close();
     }, true);
   }
    else if(pfesidata == 'esi'){
     var printWindow = window.open('exportesi?month=' + datedata +'&unit='+unitdata+'&div='+divdata+'&categ='+catdata, 'Print', 'left=200, top=200, width=500, height=150, toolbar=0, resizable=0');
     printWindow.document.title = "Downloading";
     printWindow.addEventListener('load', function () {
     // printWindow.close();
     }, true);
   }
     });
JS;
$this->registerJs($script); 
?>
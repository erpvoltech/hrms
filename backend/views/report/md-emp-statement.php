<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Vgunit;
use common\models\Division;
use app\models\SalaryStatementsearch;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;
use kartik\select2\Select2;
//$unitGroupData = ArrayHelper::map(Vgunit::find()->all(), 'id', 'unit_group');
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$model = new SalaryStatementsearch();
?>
<br><br>
<div class="salary-search">

   <?php
   $form = ActiveForm::begin([
               'id' => 'form-reload',
               'layout' => 'horizontal',
               'action' => ['md-emp-statement'],
   ]);
   ?>

  
   <div class="row">
		<div class="col-sm-4">	
	 <?= $form->field($model, 'unit_group')->widget(MultiSelect::className(),[
		 'data' => ['HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'],
					'options' => ['multiple'=>"multiple"],
					 "clientOptions" => 
						[
							"includeSelectAllOption" => true,
							'numberDisplayed' => 3
						], 
				])->label('Category') ?>
	
	</div>
     <div class="col-lg-4">
         <?= $form->field($model, 'unit_id')->widget(MultiSelect::className(),[
			'data' =>  $unitData, 
			'options' => ['multiple'=>"multiple"],
					 "clientOptions" => 
						[
							"includeSelectAllOption" => true,
							'numberDisplayed' => 3
						], 
			]) ?>
	</div>
   </div> 
   <br>
   <div class="row">
      <div class=" col-lg-3">
	 
	 
			</div>
      <div class=" col-lg-2"> <?= Html::submitButton('Export', ['class' => 'btn btn-primary', 'name' => 'statement', 'value' => 'submit']) ?></div>
      <div class="form-group col-lg-2">  <?= Html::submitButton('Reset', ['class' => 'btn btn-default', 'name' => 'statement', 'value' => 'reset']) ?>
      </div>
   </div>
   <?php ActiveForm::end(); ?>
</div>




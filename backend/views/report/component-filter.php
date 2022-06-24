<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Vgunit;
use app\models\SalaryStatementsearch;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;

//$unitGroupData = ArrayHelper::map(Vgunit::find()->all(), 'id', 'unit_group');
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');

$model->unit_group=$group;
$model->salarymonth=$month;
$model->unit_id=$unit;
?>

<div class="salary-search">

   <?php
   $form = ActiveForm::begin([
               'id' => 'form-reload',
               'layout' => 'horizontal',
               'action' => ['bankfilter'],
   ]);
   ?>

  
   <div class="row">
      <div class=" col-lg-4">
        <?=
         $form->field($model, 'salarymonth')->widget(\yii\jui\DatePicker::class, [
             'options' => ['class' => 'form-control'],
              'dateFormat' => 'MM-yyyy',
               'clientOptions' => [
                       'dateFormat' => 'MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
         ])
         ?></div>
		 
		<div class="col-sm-4">	
	 <?= $form->field($model, 'unit_group')->widget(MultiSelect::className(),[
		 'data' => ['HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'],
					'options' => ['multiple'=>"multiple"],
					 "clientOptions" => 
						[
							"includeSelectAllOption" => true,
							'numberDisplayed' => 3
						], 
				]) ?>
	
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
   
   <?= $form->field($model, 'components[]')->checkboxList(
			['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C']
   );
?>
   <div class="row">
      <div class=" col-lg-3"></div>
      <div class=" col-lg-2"> <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'bankfilter', 'value' => 'submit']) ?></div>
      <div class="form-group col-lg-2">  <?= Html::submitButton('Reset', ['class' => 'btn btn-default', 'name' => 'bankfilter', 'value' => 'reset']) ?>
      </div>
   </div>
   <?php ActiveForm::end(); ?>
</div>




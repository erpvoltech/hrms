<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelect;
use kartik\select2\Select2;

$unitData=ArrayHelper::map(Unit::find()->all(),'id','name');
$deptData=ArrayHelper::map(Department::find()->all(),'id','name');
$designation=ArrayHelper::map(Designation::find()->all(),'id','designation');
$divData=ArrayHelper::map(Division::find()->all(),'id','division_name');
?>

<div class="emp-salary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['salarygenerate'],
        'method' => 'get',
         'layout' => 'horizontal',
    ]); ?>

 
  <div class="col-sm-4">
    <?= $form->field($model, 'empcode')->label('Ecode') ?>
    </div> 
     <div class=" col-lg-4"> <?= $form->field($model, 'empname') ?></div>
	 <div class="col-sm-4">
       <?= $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
          'options' => ['class' => 'form-control'],
          'dateFormat' => 'MM-yyyy',
      ])  ?>
       </div>
       
	<div class="col-sm-4">
		<?=
            $form->field($model, "department")->widget(Select2::classname(), [
					'data' => $deptData,
                    'options' => ['placeholder' => 'Select...'],
                    'pluginOptions' => [
                    'width' => '200px'
                    ],
                ]);
		?>
	</div>
    <div class="col-sm-4">
	<?= $form->field($model, 'unit') ->dropDownList($unitData,
        ['prompt'=>'Select...']) ?>
   </div>
    
	<div class="col-sm-4">
		<?=
            $form->field($model, "division")->widget(Select2::classname(), [
					'data' => $divData,
                    'options' => ['placeholder' => 'Select...'],
                    'pluginOptions' => [
                    'width' => '200px'
                    ],
                ]);
		?>
	</div>
   
	<div class="col-sm-4">	
	 <?= $form->field($model, 'category')->widget(MultiSelect::className(),[
		 'data' => ['HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'],
					'options' => ['multiple'=>"multiple"],
					 "clientOptions" => 
						[
							"includeSelectAllOption" => true,
							'numberDisplayed' => 10
						], 
				]) ?>
	
	</div>
 
       <div class="col-sm-4"> <?= Html::submitButton('Search', ['class' => ' btn btn-xs btn-primary']) ?></div>
       <div class="col-lg4">  <?= Html::a('Clear', ['salarygenerate'], ['class'=>'btn btn-xs btn-warning']) ?></div>
    

    <?php ActiveForm::end(); ?>

</div>

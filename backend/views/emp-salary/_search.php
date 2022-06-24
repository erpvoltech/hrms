<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$unitData=ArrayHelper::map(Unit::find()->all(),'id','name');
$deptData=ArrayHelper::map(Department::find()->all(),'id','name');
$designation=ArrayHelper::map(Designation::find()->all(),'id','designation');	
$division = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>

<div class="emp-salary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
    ]); ?>
  
	 <div class=" col-lg-4"> <?= $form->field($model, 'empcode') ?></div>
      <div class=" col-lg-4"> <?= $form->field($model, 'empname') ?></div>
	  <div class=" col-lg-4"> 
		  <?=
                                $form->field($model, "division_id")->widget(Select2::classname(), [
                                    'data' => $division,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
       ?>	
		  </div>

	
	<div class=" col-lg-4">  
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
	<div class=" col-lg-4">  
	<?=
	 $form->field($model, 'monthto')->widget(\yii\jui\DatePicker::class, [
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
	<div class=" col-lg-4">
	<?=
                                $form->field($model, "designation")->widget(Select2::classname(), [
                                    'data' => $designation,
                                    'options' => ['placeholder' => 'Select...'],
                                    'pluginOptions' => [
                                        'width' => '200px'
                                    ],
                                ]);
       ?>	
	</div>
	<div class=" col-lg-4">
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
	
	<div class=" col-lg-4">
	<?= $form->field($model, 'unit_id') ->dropDownList($unitData,
        ['prompt'=>'Select...']) ?>
   </div> 
<div class=" col-lg-4">  <?= $form->field($model, 'category')->dropDownList([ 'HO Staff'=>'HO Staff','BO Staff'=>'BO Staff','International Engineer'=>'International Engineer','Domestic Engineer'=>'Domestic Engineer'], ['prompt' => 'Select...']) ?></div>
      
	  <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn btn-xs btn-primary']) ?> </div>
    <div class="col-lg-2">  <?= Html::a('Clear', ['index'], ['class'=>'btn btn-xs btn-warning']) ?> </div>
	
	 <?php ActiveForm::end(); ?>
</div>
</br></br>
<br></br></br></br>



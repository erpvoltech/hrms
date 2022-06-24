<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use yii\helpers\ArrayHelper;

$unitData=ArrayHelper::map(Unit::find()->all(),'id','name');
$deptData=ArrayHelper::map(Department::find()->all(),'id','name');
$designation=ArrayHelper::map(Designation::find()->all(),'id','designation');	
$division = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
?>

<div class="emp-salary-search">

    <?php $form = ActiveForm::begin([
        'action' => ['show-cause-all'],
        'method' => 'get',
        'layout' => 'horizontal',
    ]); ?>
  
	 <div class=" col-lg-4"> <?= $form->field($model, 'empcode') ?></div>
      <div class=" col-lg-4"> <?= $form->field($model, 'empname') ?></div>
	  <div class=" col-lg-4"> <?= $form->field($model, 'division')->dropDownList($division, ['prompt' => 'Select...'])?></div>

	
	<div class=" col-lg-4">  
	<?=
	 $form->field($model, 'lastwork')->widget(\yii\jui\DatePicker::class, [
          'options' => ['class' => 'form-control'],
          'dateFormat' => 'dd-MM-yyyy',
      ])
	  ?>
	</div>
	<div class=" col-lg-4">
	<?= $form->field($model, 'department')->dropDownList($deptData,
        ['prompt'=>'Select...']) ?>
	</div>
	
	<div class=" col-lg-4">
	<?= $form->field($model, 'unit') ->dropDownList($unitData,
        ['prompt'=>'Select...']) ?>
   </div> 
  <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn btn-xs btn-primary']) ?> </div>
    <div class="col-lg-2">  <?= Html::a('Clear', ['show-cause-all'], ['class'=>'btn btn-xs btn-warning']) ?> </div>
	
	 <?php ActiveForm::end(); ?>
</div>
   
<br></br></br></br>



<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use app\models\RecruitmentBatch;
use yii\helpers\ArrayHelper;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$deptData = ArrayHelper::map(Department::find()->all(), 'id', 'name');
$designation = ArrayHelper::map(Designation::find()->all(), 'id', 'designation');
$batchData = ArrayHelper::map(RecruitmentBatch::find()->all(), 'id', 'batch_name');
?>

<div class="emp-details-search">

   <?php
   $form = ActiveForm::begin([
               'action' => ['sendcallletter'],
               'method' => 'get',
               'layout' => 'horizontal',
   ]);
   ?>

   <div class="row">
	  <div class=" col-lg-4"> <?= $form->field($model, 'Search') ?></div>   
      <div class=" col-lg-4"> <?= $form->field($model, 'batch_id')->dropDownList($batchData, ['prompt' => 'Select...']) ?></div>
	  <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
      <div class="form-group col-lg-2">  <?= Html::a('Clear', ['sendcallletter'], ['class' => 'btn btn-xs btn-warning']) ?>
      </div>
      <!--<div class=" col-lg-4"> <?= $form->field($model, 'name') ?></div>-->
   </div>
	   
   
	</div>
   <?php ActiveForm::end(); ?>

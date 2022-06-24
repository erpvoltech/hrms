<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\RecruitmentBatch;
use yii\helpers\ArrayHelper;

$batchData = ArrayHelper::map(RecruitmentBatch::find()->all(), 'id', 'batch_name');
?>

<div class="emp-details-search">

   <?php
   $form = ActiveForm::begin([
               'action' => ['recruitmentprocess'],
               'method' => 'get',
               'layout' => 'horizontal',
   ]);
   ?>

    <div class="row"> 
	  <div class="col-lg-4"> <?= $form->field($model, 'Search') ?></div>   
      <div class="col-lg-4"> <?= $form->field($model, 'batch_id')->dropDownList($batchData, ['prompt' => 'Select...']) ?></div>
	  <div class="col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
      <div class="form-group col-lg-2">  <?= Html::a('Clear', ['recruitmentprocess'], ['class' => 'btn btn-xs btn-warning']) ?>
      </div>
      <!--<div class=" col-lg-4"> <?= $form->field($model, 'name') ?></div>-->
    </div>	
   
	</div>
   <?php ActiveForm::end(); ?>
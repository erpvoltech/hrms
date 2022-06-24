<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Bonus;
use yii\helpers\ArrayHelper;

?>
<style>
   .alert {
      padding: 5px;
      margin-bottom: 8px;
   }
</style>
<div class="emp-salary-form">
   <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size:18px;"> Import </div>
      <div class="panel-body"> 
         <?php  $form = ActiveForm::begin([ 'layout' => 'horizontal']);?>
         <br>  
		 
		  <div class="row">
            <div class="form-group col-lg-3 "></div>
            <div class="form-group col-lg-4 ">
               <?= $form->field($model, 'file')->fileInput() ?>
            </div>
         </div>
		  <div class="row">
            <div class="form-group col-lg-5" ></div>
            <div class="form-group col-lg-3" >
               <?= Html::submitButton('Upload', ['class' => 'btn-sm btn-success','name'=>'bonus-import', 'value'=>'bonus-import']) ?>
            </div>
         </div>
         <br>
         <?php ActiveForm::end(); ?>
      </div>
   </div>
</div>

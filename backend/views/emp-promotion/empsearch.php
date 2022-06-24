<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="employee-promotion-search">
 <div class="panel panel-default">
      <div class="panel-heading text-center">Create Employee Promotion</div>
      <div class="panel-body">
   <?php
   $form = ActiveForm::begin([
               'layout' => 'horizontal',
               'action' => ['employee'],
   ]);
   ?>
        <br>
   <?= $form->field($model, 'searchuser')->textInput(['value' => $user]) ?>
   <div class="form-group">
     <div class="row">
       <br>
       <div class="col-lg-4"></div>
       <div class="col-lg-2" style="padding-left:40px;"> <?= Html::submitButton('Search', ['class' => 'btn-sm btn-success']) ?></div>
      <div class="col-lg-2"> <?= Html::a('Clear', ['promotion'], ['class' => 'btn btn-sm btn-warning']) ?></div>
     </div>
   </div>

   <?php ActiveForm::end(); ?>

</div>
 </div>
</div>

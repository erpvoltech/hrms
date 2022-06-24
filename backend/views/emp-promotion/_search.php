<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmpPromotionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-promotion-search">
 
      <div class="panel-body">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' =>'horizontal',
    ]); ?>


   
 <div class="form-group">
   <div class="row">
     <div class="col-lg-4"> </div>
       <div class="col-lg-2">  <?= $form->field($model, 'searchuser') ?></div>
     </div>
   
     <div class="row">
       <br>
       <div class="col-lg-4"></div>
       <div class="col-lg-2" style="padding-left:85px;"> <?= Html::submitButton('Search', ['class' => 'btn-sm btn-success']) ?></div>
      <div class="col-lg-2"> <?= Html::a('Clear', ['promotion'], ['class' => 'btn btn-sm btn-warning']) ?></div>
     </div>
   </div>
    <?php ActiveForm::end(); ?>

</div>


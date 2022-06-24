<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
    ]); ?>

   
       <div class="row">
    <div class="form-group col-lg-8 "> <?= $form->field($model, 'coursename')->textInput(['maxlength' => true]) ?>
    </div>
       </div>
  <br>
    <div class="row">
    <div class="form-group col-lg-4 "></div>
    <div class="form-group col-lg-2 " >
       <br>
        <?= Html::submitButton('Save', ['class' => 'btn-xs btn-success']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\College */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="college-form">

    <?php $form = ActiveForm::begin([
          'layout' => 'horizontal',
    ]); ?>

       <div class="row">
    <div class="form-group col-lg-8 "> <?= $form->field($model, 'collegename')->textInput(['maxlength' => true]) ?>
    </div>
       </div>
  <div class="row">
    <div class="form-group col-lg-2 "></div>
    <div class="form-group col-lg-4 " style="right:22px;">
        <br>
        <?= Html::submitButton('Save', ['class' => 'btn-xs btn-success']) ?>
    </div>
</div>

    <?php ActiveForm::end(); ?>

</div>

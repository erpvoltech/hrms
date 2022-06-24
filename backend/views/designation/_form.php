<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Designation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="designation-form">

    <?php $form = ActiveForm::begin([
          'layout' => 'horizontal',
            ]); ?>

  <div class="row">
    <div class="form-group col-lg-4 ">  <?= $form->field($model, 'designation')->textInput() ?>
    </div></div>
	<div class="row">
	<div class="form-group col-lg-4">	
	<?= $form->field($model, 'salary_slot')->dropDownList(['slot1'=>'slot1','slot2'=>'slot2','slot3'=>'slot3'],['prompt'=>''])->label(True);?>
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

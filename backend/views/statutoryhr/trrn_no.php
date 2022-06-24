<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
?>

<div class="trrnno-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>	
   
	 
    <?= $form->field($model, 'trrn_no')->textInput() ?>
    <br>
    <div class="row">
        <div class="col-lg-4"></div>
     <div class="col-lg-4" style="left:10px;">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn-sm btn-primary' : 'btn btn-primary','id'=>'AddTrnnNo']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


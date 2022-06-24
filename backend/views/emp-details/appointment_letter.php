<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

?>
<div class="emp-details-appointment_letter">

    <?php $form = ActiveForm::begin(); ?>
       <?= $form->field($model, 'letter')->widget(CKEditor::className(), [
        'options' => ['rows' => 10],		
        'preset' => 'full',		
    ]) ?>     
  
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn-sm btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

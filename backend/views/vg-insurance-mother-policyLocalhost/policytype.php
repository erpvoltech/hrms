<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
?>

<div class="company-form">
    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'policy_for')->dropDownList([ 'Employee' => 'Employee', 'Assets' => 'Assets',], ['prompt' => 'Select...']) ?>
    <?= $form->field($model, 'policy_type')->textInput(['maxlength' => true]) ?>
    <br>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4" style="left:10px;">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn-sm btn-primary' : 'btn btn-primary', 'id' => 'Policytype']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS

$('#Policytype').click(function(event){        
	 event.preventDefault();
    $('#insurancepolicy').modal('hide'); 
        var policyfor = $('#vginsurancepolicy-policy_for').val();
        var policycategory = $('#vginsurancepolicy-policy_type').val();
        $.get('policystore',{ policyfor : policyfor, policycategory : policycategory },function(data){
		$('#vginsurancemotherpolicy-policy_for_id').html(data);
	});
        
});   
        
JS;
$this->registerJs($script);
?>    

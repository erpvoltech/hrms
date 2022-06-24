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

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
    <br>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4" style="left:10px;">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn-sm btn-primary' : 'btn btn-primary', 'id' => 'CreateCompany']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS

$('#CreateCompany').click(function(event){        
	 event.preventDefault();
    $('#insurancecompany').modal('hide'); 
        var name = $('#vginsurancecompany-company_name').val();
        $.get('companystore',{ name : name },function(data){
		$('#vginsuranceagents-company_id').html(data);
	});
        
});   
        
JS;
$this->registerJs($script);
?>    

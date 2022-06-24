<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\VgPolicyClaim */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="vg-policy-claim-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"><?= $model->insurance_type ?> Claim Form</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'insurance_type')->dropDownList(['GPA' => 'GPA', 'GMC' => 'GMC', 'WC' => 'WC', 'Building' => 'Building', 'Equipment' => 'Equipment', 'Vehicle' => 'Vehicle',], ['prompt' => 'Select...']) ?> 
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'policy_no')->textInput(['maxlength' => true]) ?>
                   
                </div>
            </div>
            <?php if($model->insurance_type == 'GPA' || $model->insurance_type == 'GMC' || $model->insurance_type == 'WC' ){ ?>
            <div class="row">
                <div class="col-sm-6">
                   <?= $form->field($model, 'employee_code')->textInput(['maxlength' => true]) ?> 
                </div>
                <div class="col-sm-6">
                   <?= $form->field($model, 'employee_name')->textInput(['maxlength' => true]) ?> 
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'policy_serial_no')->textInput(['maxlength' => true]) ?> 
                    
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
                   
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>  
                   
                </div>
                <div class="col-sm-6">
                     <?= $form->field($model, 'nature_of_accident')->textInput(['maxlength' => true]) ?> 
                   
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'loss_type')->dropDownList(['Fatal/Non Repairable' => 'Fatal/Non Repairable', 'Partial/Repairable' => 'Partial/Repairable',], ['prompt' => 'Select...']) ?> 
                    
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'injury_detail')->textInput(['maxlength' => true]) ?>
                   
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'accident_place_address')->textInput(['maxlength' => true]) ?>
                    
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'accident_time')->textInput(['maxlength' => true]) ?> 
                   
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'accident_notes')->textarea(['rows' => 3, 'style' => 'resize: none; width: 100%;']) ?> 
                    
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'settlement_notes')->textarea(['rows' => 3, 'style' => 'resize: none; width: 100%;']) ?>
                   
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'settlement_amount')->textInput() ?>  
                    
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'claim_estimate')->textInput() ?> 
                   
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'claim_status')->dropDownList(['Pending' => 'Pending', 'Settled' => 'Settled',], ['prompt' => 'Select...']) ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="form-group col-lg-5">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS
var status = $('#vgpolicyclaim-claim_status').val();
        if( status == 'Pending') {
        $('#vgpolicyclaim-settlement_notes').attr( "disabled", true );
        $('#vgpolicyclaim-settlement_amount').attr( "disabled", true );
        $('#vgpolicyclaim-settlement_notes').val('');
   }
       
        
$('#vgpolicyclaim-claim_status').change(function() {
    if( $(this).val() == 'Pending') {
        $('#vgpolicyclaim-settlement_notes').attr( "disabled", true );
        $('#vgpolicyclaim-settlement_amount').attr( "disabled", true );
        $('#vgpolicyclaim-settlement_notes').val('');
        $('#vgpolicyclaim-settlement_amount').val('');
   }
   else if( $(this).val() == 'Settled') {
        $('#vgpolicyclaim-settlement_notes').attr( "disabled", false );
        $('#vgpolicyclaim-settlement_amount').attr( "disabled", false );
   }
}); 

JS;
$this->registerJs($script);
?>        
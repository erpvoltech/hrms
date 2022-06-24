<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceProperty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-property-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> PIS Form</i></div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'property_type')->dropDownList(['Building' => 'Building', 'Equipment' => 'Equipment', 'Vehicle' => 'Vehicle',], ['prompt' => 'Select...']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'property_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'property_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'user_division')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'equipment_service')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="form-group col-lg-5">
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS
              
$(document).ready(function () {
        
        $(document.body).on('change', '#vginsuranceproperty-property_type', function () {
        var val = $('#vginsuranceproperty-property_type').val();
        if(val != "Equipment") {
            $('#vginsuranceproperty-equipment_service').val('');
            $('#vginsuranceproperty-equipment_service').prop("disabled", true);
        } else {
          $('#vginsuranceproperty-equipment_service').prop("disabled", false);
        }
    });
});
         
JS;
$this->registerJs($script);
?>
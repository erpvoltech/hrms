<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use common\models\Division;
use common\models\Customer;
use common\models\ProjectDetails;
use common\models\State;
use common\models\District;
use common\models\CustomerContact;
use yii\helpers\ArrayHelper;
//use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use dosamigos\multiselect\MultiSelect;
use kartik\select2\Select2;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$custData = ArrayHelper::map(Customer::find()->where(['type'=>'Customer'])->all(), 'id', 'customer_name');
$consData = ArrayHelper::map(customerContact::find()->all(), 'id', 'contact_person');
$stateData = ArrayHelper::map(State::find()->all(), 'id', 'state_name');
$districtData = ArrayHelper::map(District::find()->all(), 'id', 'district_name');
?>
<style>
.form-control {
    border-radius: 0;
    box-shadow: none;
    border-color: #d2d6de;
    height: 31px; 
    width: 100%;
    width: 200px;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 0;
    padding-right: 0;
    height: auto;
    margin-top: 0px;
}
th{
	text-align:center;
}
</style>

<div class="po-create-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
	
	<div class="row">
	<div class="col-md-2">Project Code </div>
		<div class="col-md-3">
			 <?= $form->field($model, 'project_id')->widget(Select2::classname(), [
				'data' =>ArrayHelper::map(ProjectDetails::find()->all(), 'id', 'project_code'),
				'pluginOptions' => [                    
                    'placeholder' => 'Select...',
                   'width' => '200px',
                ]
				])->label(False);?>
		</div>
	</div>
	<div class="row">
	<div class="col-md-2">Po Number </div>
		<div class="col-md-3">
			<?= $form->field($model,'po_number')->textInput(['maxlength'=> true])->label(False); ?>
		</div>
	</div>
	<div class="row">
	<div class="col-md-2">Po Date </div>
		<div class="col-md-3">
			<?= $form->field($model, 'po_date')->widget(yii\jui\DatePicker::className(), [
            'dateFormat' => 'dd-MM-yyyy',			
        ])->label(False); ?> 
		</div>
	</div>
	<div class="row">
	<div class="col-md-2"> Po Delivery Date </div>
		<div class="col-md-3">
			<?= $form->field($model, 'po_delivery_date')->widget(yii\jui\DatePicker::className(), [
            'dateFormat' => 'dd-MM-yyyy',			
        ])->label(False); ?> 
		</div>
	</div>
	<div class="row">
	<div class="col-md-2"> Po Value </div>
		<div class="col-md-3">
			<?= $form->field($model,'po_value')->textInput(['maxlength'=> true])->label(False); ?>
		</div>
	</div>
	<div class="row">
	<div class="col-md-2">Po Details </div>
		<div class="col-md-3">
			<?= $form->field($model, 'po_details')->textarea(['rows' => 4])->label(False); ?>
		</div>
	</div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
<?php
$script = <<< JS
	var cons = $('#projectdetails-consultant').val();

	if(cons == 'Yes'){
	$('#consult').show();
	} else {
	$('#consult').hide();
	}
	
	$('#projectdetails-consultant').change(function(event){ 
		if($(this).val() == 'Yes'){
		$('#consult').show();
		} else {
		$('#consult').hide();
		}
	});
JS;
$this->registerJs($script);
?>

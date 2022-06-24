<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Unit;
use common\models\Division;
use common\models\Customer;
use common\models\CustomerContact;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$divData=ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$custData = ArrayHelper::map(Customer::find()->where(['type'=>'Customer'])->all(), 'id', 'customer_name');
$consData = ArrayHelper::map(customerContact::find()->all(), 'id', 'contact_person');
?>

<div class="project-details-form">

 <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?> 
 <div class="row">
	<div class="col-lg-6">
		<?= $form->field($model, 'project_code')->textInput(['maxlength' => true]) ?>
	</div><div class="col-lg-6">
		<?= $form->field($model, 'location_code')->textInput(['maxlength' => true]) ?>
	</div></div>
	
	 <div class="row">
        <div class="col-sm-6">
            
			 <?= $form->field($model, 'principal_employer')->widget(Select2::classname(), [
				'data' => ArrayHelper::map(Customer::find()->where(['type'=>'Customer'])->all(), 'id', 'customer_name'),
				'pluginOptions' => [                    
                    'placeholder' => 'Select...',
                   'width' => '200px',
                ]
				])?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $form->field($model, 'employer_contact')->widget(DepDrop::classname(), [
                'options' => ['employer_contact' => 'id'],
                'pluginOptions' => [
                    'depends' => ['projectdetails-principal_employer'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['contacts'])
                ]
            ]);
            ?>                    
        </div>
    </div>
	
	 <div class="row">
        <div class="col-sm-6">
            
			 <?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
				'data' => ArrayHelper::map(Customer::find()->where(['type'=>'Customer'])->all(), 'id', 'customer_name'),
				'pluginOptions' => [                    
                    'placeholder' => 'Select...',
                   'width' => '200px',
                ]
				])?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $form->field($model, 'customer_contact')->widget(DepDrop::classname(), [
                'options' => ['customer_contact' => 'id'],
                'pluginOptions' => [
                    'depends' => ['projectdetails-customer_id'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['contacts'])
                ]
            ]);
            ?>                    
        </div>
    </div>
	
	<div class="row">
	<div class="col-lg-6">
		<?= $form->field($model, 'job_details')->textarea(['rows' => 4]) ?>
	</div><div class="col-lg-6">
		<?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
	</div></div>
	<div class="row">
	<div class="col-lg-6">
		<?= $form->field($model, 'compliance_required')->dropDownList([ 'EPF' => 'EPF', 'ESI' => 'ESI', 'WC' => 'WC', 'CLRA(S)'=>'CLRA(S)','CLRA(C)'=>'CLRA(C)','ISMW'=>'ISMW','Factories Act'=>'Factories Act','GPA'=>'GPA'], ['prompt' => '']) ?>
	</div><div class="col-lg-6">
		<?= $form->field($model, 'consultant')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>
	</div></div>
	
	
	 <div class="row" id="consult">
        <div class="col-sm-6">
            
			 <?= $form->field($model, 'consultant_id')->widget(Select2::classname(), [
				'data' => ArrayHelper::map(Customer::find()->where(['type'=>'Consultant'])->all(), 'id', 'customer_name'),
				'pluginOptions' => [                    
                    'placeholder' => 'Select...',
                   'width' => '200px',
                ]
				])?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $form->field($model, 'consultant_contact')->widget(DepDrop::classname(), [
                'options' => ['consultant_id' => 'id'],
                'pluginOptions' => [
                    'depends' => ['projectdetails-consultant_id'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['contacts'])
                ]
            ]);
            ?>                    
        </div>
    </div>
	<div class="row">
	<div class="col-lg-6">
		 <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => 'Select...'])  ?>
	</div><div class="col-lg-6">
		  <?=$form->field($model, "division_id")->widget(Select2::classname(), [
					'data' => $divData,
					'options' => ['placeholder' => 'Select...'],
					'pluginOptions' => [
						'width' => '200px'
					],
				]);
           ?>
	</div></div>
	<div class="row">
	<div class="col-lg-6">
		<?= $form->field($model, 'remark')->textarea(['rows' => 4]) ?>
	</div><div class="col-lg-6">	
	<?= $form->field($model, 'project_status')->dropDownList([ 'Active' => 'Active', 'Hold' => 'Hold', 'Closed' => 'Closed', ], ['prompt' => '']) ?>	
	</div></div>
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
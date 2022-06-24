<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceCompany;
use app\models\VgInsuranceAgents;
use app\models\VgInsurancePolicy;
use app\models\VgInsuranceMotherPolicy;
use app\models\VgInsuranceHierarchy;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

$compName = ArrayHelper::map(VgInsuranceCompany::find()->all(), 'id', 'company_name');
$agentName = ArrayHelper::map(VgInsuranceAgents::find()->all(), 'id', 'agent_name');

$policyType = VgInsurancePolicy::find()->all();
$policyName = ArrayHelper::map($policyType, 'id', 'policy_type');
?>

<div class="vg-insurance-agents-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> Asset Insurance Form</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['autocomplete' => 'off'],]); ?>
         
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'insurance_comp_id')->dropDownList($compName, ['prompt' => 'Select...']) ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo $form->field($assetPolicy, 'insurance_agents_id')->widget(DepDrop::classname(), [
                        'options' => ['insurance_comp_id' => 'id'],
                        'pluginOptions' => [
                            'depends' => ['vginsurancemotherpolicy-insurance_comp_id'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['loadagents'])
                        ]
                    ]);
                    ?>                    
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'policy_no')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-sm-6">
                    <?=
                    $form->field($assetPolicy, 'from_date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?=
                    $form->field($assetPolicy, 'to_date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>

                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'premium_paid')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'insured_to')->textInput(['title' => 'Enter Insured Company Name', 'maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo $form->field($assetPolicy, 'asset_type')->dropDownList(
                            ['Building' => 'Building', 'Equipment' => 'Equipment', 'Vehicle' => 'Vehicle'], ['prompt' => 'Select...']
                    );
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'building_name')->textInput(['title' => 'Enter Insured Building Name', 'maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo $form->field($assetPolicy, 'equipment_service')->dropDownList(
                            ['with service' => 'with service', 'without service' => 'without service'], ['prompt' => 'Select...']
                    );
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'asset_sum_insured')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'location')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($assetPolicy, 'remarks')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6"></div>
                <div class="form-group col-lg-5">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$script = <<< JS
       
//vginsurancehierarchy-0-age_group        
//vginsurancemotherpolicy-building_name   
//vginsurancemotherpolicy-asset_type
//vginsurancemotherpolicy-asset_sum_insured        
        
$('#vginsurancemotherpolicy-asset_type').change(function() {
    if( $(this).val() == 'Building') {
        $('#vginsurancemotherpolicy-building_name').prop( "disabled", false );
        $('#vginsurancemotherpolicy-equipment_service').prop( "disabled", true );
        $('#vginsurancemotherpolicy-equipment_service').val('');
    } 
    else if( $(this).val() == 'Equipment') {
        $('#vginsurancemotherpolicy-equipment_service').prop( "disabled", false );
        $('#vginsurancemotherpolicy-building_name').prop( "disabled", true );
        $('#vginsurancemotherpolicy-building_name').val('');
    }     
    else if( $(this).val() == 'Vehicle') {
        $('#vginsurancemotherpolicy-equipment_service').prop( "disabled", true );
        $('#vginsurancemotherpolicy-building_name').prop( "disabled", true );
        $('#vginsurancemotherpolicy-building_name').val('');
        $('#vginsurancemotherpolicy-equipment_service').val('');
    }     
});           
    
JS;
$this->registerJs($script);
?>


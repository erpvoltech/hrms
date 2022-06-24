<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceCompany;
use app\models\VgInsuranceAgents;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceEquipment */
/* @var $form yii\widgets\ActiveForm */
$compName = ArrayHelper::map(VgInsuranceCompany::find()->all(), 'id', 'company_name');
$agentName = ArrayHelper::map(VgInsuranceAgents::find()->all(), 'id', 'agent_name');
?>

<div class="vg-insurance-equipment-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> Equipment Insurance Form</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'icn_id')->dropDownList($compName, ['prompt' => 'Select...']) ?>
                </div>
                <div class="col-sm-4">  
                    <?php
                    echo $form->field($model, 'insurance_agent_id')->widget(DepDrop::classname(), [
                        'options' => ['icn_id' => 'id'],
                        'pluginOptions' => [
                            'depends' => ['vginsuranceequipment-icn_id'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['loadagents'])
                        ]
                    ]);
                    ?>  
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'property_type')->dropDownList(['Equipment' => 'Equipment',], ['prompt' => 'Select...']) ?>   
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'insurance_no')->textInput(['maxlength' => true]) ?>  
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'property_name')->textInput(['maxlength' => true]) ?> 
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'property_no')->textInput(['maxlength' => true]) ?> 
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'property_value')->textInput() ?> 
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'sum_insured')->textInput() ?>  
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'premium_paid')->textInput() ?> 
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'valid_from')->widget(DatePicker::className(), [
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
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'valid_to')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
                <div class="col-sm-4">
					<?= $form->field($model, 'financial_year')->dropDownList(['2019-2020' => '2019-2020', '2020-2021' => '2020-2021', '2021-2022' => '2021-2022', '2022-2023' => '2022-2023'],['prompt'=>'Select Year']); ?>	
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
					<?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?> 
                </div>
                <div class="col-sm-4">
					<?= $form->field($model, 'user_division')->textInput(['maxlength' => true]) ?>  
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
					<?= $form->field($model, 'insured_to')->textInput(['maxlength' => true]) ?> 
                </div>
                <div class="col-sm-4">
					<?= $form->field($model, 'equipment_service')->dropDownList(['Yes' => 'Yes', 'No' => 'No',], ['prompt' => 'Select...']) ?>  
                </div>
            </div>
			<div class="row">
				<div class="col-sm-4">
					<?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>  		
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

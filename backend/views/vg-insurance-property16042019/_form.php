<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\VgInsuranceCompany;
use app\models\VgInsuranceAgents;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceProperty */
/* @var $form yii\widgets\ActiveForm */

$companyData = ArrayHelper::map(VgInsuranceCompany::find()->all(), 'id', 'company_name');
$agentData = ArrayHelper::map(VgInsuranceAgents::find()->all(), 'id', 'agent_name');
?>

<div class="vg-insurance-property-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> Stationary/Printing Material</i></div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'property_type')->textInput(['maxlength' => true]) ?>
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
                    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'user_division')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'equipment_service')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'icn_id')->dropDownList($companyData, ['prompt' => 'Select...']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'insurance_agent_id')->dropDownList($agentData, ['prompt' => 'Select...']) ?>
                </div>
                <div class="col-sm-4">
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

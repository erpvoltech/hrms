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
use wbraganca\dynamicform\DynamicFormWidget;

$compName = ArrayHelper::map(VgInsuranceCompany::find()->all(), 'id', 'company_name');
$agentName = ArrayHelper::map(VgInsuranceAgents::find()->all(), 'id', 'agent_name');


$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Hierarchy: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Hierarchy: " + (index + 1))
    });
});
';

$this->registerJs($js);
?>

<div class="vg-insurance-agents-form">
    
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'policy_name')->dropDownList([ 'GPA' => 'GPA', ], ['prompt' => 'Select....']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'insurance_comp_id')->dropDownList($compName, ['prompt' => 'Select...']) ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $form->field($vitalPolicy, 'insurance_agents_id')->widget(DepDrop::classname(), [
                'options' => ['insurance_comp_id' => 'id'],
                'pluginOptions' => [
                    'depends' => ['vggpapolicy-insurance_comp_id'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['loadagents'])
                ]
            ]);
            ?>                    
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'policy_no')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-6">
            <?=
            $form->field($vitalPolicy, 'from_date')->widget(DatePicker::className(), [
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
            $form->field($vitalPolicy, 'to_date')->widget(DatePicker::className(), [
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
            <?= $form->field($vitalPolicy, 'premium_paid')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'remarks')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'gpa_type')->dropDownList([ 'Named' => 'Named', 'Unnamed' => 'Unnamed'], ['prompt' => 'Select....']) ?>
        </div>
    </div>

    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelHierarchy[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'sum_insured',
            'fellow_share',
        ],
    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> VG GPA Hierarchy
            <button type="button" id="buttonId" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Item</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelHierarchy as $index => $hierarchyAmt): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">Hierarchy : <?= ($index + 1) ?></span>
                        <button type="button" class="deleteRow pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="order-list panel-body">
                        <?php
                        // necessary for update action.
                        if (!$hierarchyAmt->isNewRecord) {
                            echo Html::activeHiddenInput($hierarchyAmt, "[{$index}]id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($hierarchyAmt, "[{$index}]sum_insured")->textInput(['title' => 'Enter Sum Insured Amount Like(Rs.500000/800000/1000000)']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($hierarchyAmt, "[{$index}]fellow_share")->textInput(['title' => 'Enter Fellow Share for Rs.500000-1500/800000-1800/1000000-2000']) ?>
                            </div>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton($vitalPolicy->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>





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
use wbraganca\dynamicform\DynamicFormWidget;

$compName = ArrayHelper::map(VgInsuranceCompany::find()->all(), 'id', 'company_name');
$agentName = ArrayHelper::map(VgInsuranceAgents::find()->all(), 'id', 'agent_name');

$policyType = VgInsurancePolicy::find()->all();
$policyName = ArrayHelper::map($policyType, 'id', 'policy_type');

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
    <?php
    Modal::begin([
        'header' => '<h4 style="color:#007370;text-align:center">Create Policy Type</h4>',
        'id' => 'insurancepolicy',
    ]);
    echo "<div id='PolicyContent'></div>";
    Modal::end();
    ?>
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'policy_for_id')->dropDownList($policyName, ['options'=>['3'=>['disabled'=>true]]], ['prompt' => 'Select...']); ?>
        </div>

        <div class="col-sm-6">
            <?= Html::button('', ['value' => Url::to('policytype'), 'class' => 'glyphicon glyphicon-plus-sign btn btn-default btn-sm', 'id' => 'PolicyButton', 'title' => 'Add Policy Type']) ?>  
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
                    'depends' => ['vginsurancemotherpolicy-insurance_comp_id'],
                    'placeholder' => 'Select...',
                    'url' => Url::to(['loadagents'])
                ]
            ]);
            ?>                    
            <!--= $form->field($model, 'insurance_agents_id')->dropDownList($agentName, ['prompt' => 'Select...']) ?>-->
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
            <?= $form->field($vitalPolicy, 'insured_to')->textInput(['title' => 'Enter Insured Company Name', 'maxlength' => true]) ?>
        </div>
        
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'location')->textInput(['maxlength' => true]) ?>
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($vitalPolicy, 'remarks')->textInput(['maxlength' => true]) ?>
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
            <i class="fa fa-envelope"></i> VG Insurance Hierarchy
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

                            <div class="col-sm-4 mydiv" id="ag">
                                <?php
                                echo $form->field($hierarchyAmt, "[{$index}]age_group")->dropDownList(
                                        ['0-1' => '0-1', '2-5' => '2-5', '6-15' => '6-15', '16-25' => '16-25', '26-40' => '26-40', '41-45' => '41-45', '46-50' => '46-50', '51-55' => '51-55', '56-60' => '56-60', '61-65' => '61-65', '66-70' => '66-70'], ['prompt' => 'Select...']);
                                ?>
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


<?php
$script = <<< JS

 $('#PolicyButton').click(function () {
      $('#insurancepolicy').modal('show')
              .find('#PolicyContent')
              .load($(this).attr('value'));
   });
               
$(document).ready(function () {
        $('#ag').hide();
        $(document.body).on('change', '#vginsurancemotherpolicy-policy_for_id', function () {
        var val = $('#vginsurancemotherpolicy-policy_for_id').val();
        if(val == 2 ) {
          $('.mydiv').show();
        } else {
          $('.mydiv').hide();
        }
    });
});
        
$("#buttonId").click(function() {
        var val = $('#vginsurancemotherpolicy-policy_for_id').val();
        //alert(val);
        if(val == 2){
            $('.mydiv').show();
        }else if(val != 2){
          $('.mydiv').hide();
        }
});        
    
JS;
$this->registerJs($script);
?>


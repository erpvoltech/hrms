<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
use app\models\VgGmcPolicy;
use app\models\VgInsuranceCompany;
use wbraganca\dynamicform\DynamicFormWidget;

$motherpolicyno = VgGmcPolicy::findone($_GET['id']);
$endorsmentPolicy->gmc_mother_policy_id = $motherpolicyno->policy_no;

$isp = $_GET['ispid'];


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

<div class="vg-insurance-endorsement-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>

    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($endorsmentPolicy, 'gmc_mother_policy_id')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-sm-5">
            <?= $form->field($endorsmentPolicy, 'endorsement_no')->textInput() ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-5">
            <?=
            $form->field($endorsmentPolicy, 'start_date')->widget(DatePicker::className(), [
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'dateFormat' => 'dd-MM-yyyy',
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
            ])
            ?>
        </div>
        <div class="col-sm-5">
            <?=
            $form->field($endorsmentPolicy, 'end_date')->widget(DatePicker::className(), [
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
        <div class="col-sm-5">
            <?= $form->field($endorsmentPolicy, 'endorsement_premium_paid')->textInput() ?>
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
        'limit' => 25, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $endorsmentHierarchy[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'endorsement_sum_insured',
            'endorsement_fellow_share',
            'endorsement_age_group',
        ],
    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> VG GMC Endorsement Hierarchy
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Item</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($endorsmentHierarchy as $index => $hierarchyAmt): ?>
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
                                <?= $form->field($hierarchyAmt, "[{$index}]endorsement_sum_insured")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($hierarchyAmt, "[{$index}]endorsement_fellow_share")->textInput() ?>
                            </div>
                           
                            <div class="col-sm-4">
                                <?php
                                if($isp == 1){
                                echo $form->field($hierarchyAmt, "[{$index}]endorsement_age_group")->dropDownList(
                                        ['0-1' => '0-1', '2-5' => '2-5', '6-15' => '6-15', '16-25' => '16-25', '26-40' => '26-40', '41-45' => '41-45', '46-50' => '46-50', '51-55' => '51-55', '56-60' => '56-60', '61-65' => '61-65', '66-70' => '66-70'], ['prompt' => 'Select...']);
                                }
                                if($isp == 2 || $isp == 3){
                                    echo $form->field($hierarchyAmt, "[{$index}]endorsement_age_group")->dropDownList(
                                        ['0-35' => '0-35', '36-45' => '36-45', '46-50' => '46-50', '51-55' => '51-55', '56-60' => '56-60', '61-65' => '61-65', '66-70' => '66-70', '76-80' => '76-80'], ['prompt' => 'Select...']);
                                }
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
        <?= Html::submitButton($endorsmentPolicy->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

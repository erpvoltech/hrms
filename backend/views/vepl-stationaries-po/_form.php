<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\VeplSupplier;
use app\models\VeplStationaries;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;

$supplierData = ArrayHelper::map(VeplSupplier::find()->all(), 'id', 'supplier_name');
$stationaryData = ArrayHelper::map(VeplStationaries::find()->all(), 'id', 'item_name');

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesPo */
/* @var $form yii\widgets\ActiveForm */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("GRN: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("GRN: " + (index + 1))
    });
});
';

$this->registerJs($js);
?>

<div class="vepl-stationaries-grn-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>
    <div class="row">
        <div class="col-sm-4">
            <?=
            $form->field($modelGrn, 'last_purchase_date')->widget(DatePicker::className(), [
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
            <?=
            $form->field($modelGrn, 'po_date')->widget(DatePicker::className(), [
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
            <?= $form->field($modelGrn, 'po_no')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($modelGrn, 'po_supplier_id')->dropDownList($supplierData, ['prompt' => 'Select...']) ?>
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
        'limit' => 50, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsGrnItem[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'po_item_id',
            'po_qty',
            'po_rate',
            'po_amount',
        ],
    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Vepl Stationaries PO
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Item</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelsGrnItem as $index => $modelGrnItem): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">PO : <?= ($index + 1) ?></span>
                        <button type="button" class="deleteRow pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="order-list panel-body">
                        <?php
                        // necessary for update action.
                        if (!$modelGrnItem->isNewRecord) {
                            echo Html::activeHiddenInput($modelGrnItem, "[{$index}]id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelGrnItem, "[{$index}]po_item_id")->dropDownList($stationaryData, ['prompt' => 'Select...']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelGrnItem, "[{$index}]po_qty")->textInput(['onkeyup' => 'totales($(this))']) ?>
                            </div>
                        </div><!-- end:row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelGrnItem, "[{$index}]po_rate")->textInput(['onkeyup' => 'totales($(this))']) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelGrnItem, "[{$index}]po_amount")->textInput(['class' => 'txt form-control', 'readonly' => true]) ?>
                            </div>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($modelGrn, 'po_sgst')->textInput(['maxlength' => true]) ?> 
        </div>
        <div class="col-sm-4">
            <?= $form->field($modelGrn, 'po_cgst')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>

    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton($modelGrn->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    function totales(item) {
        var index = item.attr("id").replace(/[^0-9.]/g, "");
        var quantity = $('#veplstationariesposub-' + index + '-po_qty').val();
        quantity = quantity == "" ? 0 : Number(quantity.split(",").join(""));
        var rate = $('#veplstationariesposub-' + index + '-po_rate').val();
        rate = rate == "" ? 0 : Number(rate.split(",").join(""));
        $('#veplstationariesposub-' + index + '-po_amount').val(quantity * rate);
    }
</script>

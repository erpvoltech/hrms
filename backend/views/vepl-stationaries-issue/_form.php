<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\VeplSupplier;
use app\models\VeplStationaries;
use app\models\VeplStationariesStock;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;

$stocks = VeplStationariesStock::find()->all();
foreach ($stocks as $stock) {
    $sationaryName[] = VeplStationaries::find()->where(['id' => $stock->item_id])->one();
}

$stationaryData = ArrayHelper::map($sationaryName, 'id', 'item_name');
//$stockData = ArrayHelper::map(VeplStationariesStock::find()->all(), 'item_id', 'item_name');

/* @var $this yii\web\View */
/* @var $modelCustomer app\modules\yii2extensions\models\Customer */
/* @var $modelsAddress app\modules\yii2extensions\models\Address */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
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
            $form->field($modelGrn, 'issue_date')->widget(DatePicker::className(), [
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
            <?= $form->field($modelGrn, 'issued_to')->textInput(['maxlength' => true]) ?>
        </div>
		</div>
		<div class="row">
        <div class="col-sm-4">
            <?= $form->field($modelGrn, 'remarks')->textInput(['maxlength' => true]) ?>
        </div>
		<div class="col-sm-4">
            <?= $form->field($modelGrn, 'division_name')->textInput(['maxlength' => true]) ?>
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
            'item_id',
            'quantity',
            'rate',
            'amount',
            'unit',
        ],
    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Vepl Stationaries Issuing 
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Item</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelsGrnItem as $index => $modelGrnItem): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">Item : <?= ($index + 1) ?></span>                        
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$modelGrnItem->isNewRecord) {
                            echo Html::activeHiddenInput($modelGrnItem, "[{$index}]id");
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($modelGrnItem, "[{$index}]stationaries_id")->dropDownList($stationaryData, ['prompt' => 'Select...','onchange' => 'totales($(this))']) ?>
                                <?php /*
                                $form->field($modelGrnItem, "[{$index}]stationaries_id")->widget(Select2::classname(), [
                                    'data' => $stationaryData,
                                    'options' => ['onchange' => 'totales($(this))', 'placeholder' => 'Select...'],
                                ]);
                                */ ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($modelGrnItem, "[{$index}]stock_qty")->textInput(['readonly' => true]) ?>
                            </div>
                            <div class="col-sm-3">
                                <?= $form->field($modelGrnItem, "[{$index}]issued_qty")->textInput() ?>
                            </div>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
            <input type="hidden" id="indexno" value="<?= $index ?>">
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton($modelGrn->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function codeAddress() {

        var iq = $('#veplstationariesissuesub-0-issued_qty').val();
        var indexid = $('#indexno').val();
        var i;
        if (iq != '') {
            for (i = 0; i <= indexid; i++) {
                var item = $('#veplstationariesissuesub-' + i + '-stationaries_id').val();
                $.ajax({
                    type: "GET",
                    url: 'stockqty?id=' + item + '&index=' + i,
                    dataType: 'json',
                    success: function (data) {
                        $('#veplstationariesissuesub-' + data.index + '-stock_qty').val(data.qty);
                    },
                    error: function (exception) {
                        alert('Error');
                    }
                });
            }
        }
    }
    window.onload = codeAddress;
</script>
<script>
    function totales(item) {
        var index = item.attr("id").replace(/[^0-9.]/g, "");
        var item = $('#veplstationariesissuesub-' + index + '-stationaries_id').val();

        $.ajax({
            type: "POST",
            url: 'stockqtycreate?id=' + item,
            dataType: 'json',
            success: function (data) {
                $('#veplstationariesissuesub-' + index + '-stock_qty').val(data);
            },
            error: function (exception) {
                alert('error');
            }
        });
    }
</script>

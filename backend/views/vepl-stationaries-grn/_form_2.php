<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\VeplStationaries;
use app\models\VeplSupplier;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;

$stationaryData = ArrayHelper::map(VeplStationaries::find()->all(), 'id', 'item_name');
$supplierData = ArrayHelper::map(VeplSupplier::find()->all(), 'id', 'supplier_name');
?>

<div class="vepl-stationaries-grn-form">
<?php
         DynamicFormWidget::begin([
             'widgetContainer' => 'dynamicform_wrapper',
             'widgetBody' => '.container-siblings',
             'widgetItem' => '.siblingsitem',
             'limit' => 10,
             'min' => 1,
             'insertButton' => '.siblingsadd-item',
             'deleteButton' => '.siblingsremove-item',
             'model' => $modelsGrn[0],
             'formId' => 'dynamic-form',
             'formFields' => [
                 'itemid',
                 'quantity',
                 'amount',
                 'unit',
             ],
         ]);
         ?>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book">GRN Entry Form</i>
        <button type="button" class="pull-right siblingsadd-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add </button>
         <div class="clearfix"></div>
        </div>
        <div class="panel-body container-siblings">			
      <?php foreach ($modelsGrn as $index => $modelsGrn): ?>                  
        <div class="siblingsitem panel" style="padding:0px">                   
          <div class="panel-body" style="padding:0px">
            <?php
            if (!$modelsGrn->isNewRecord) {
              echo Html::activeHiddenInput($modelsGrn, "[{$index}]id");
            }
            ?>
              
              <div class="row">
              <div class="col-sm-4">
                <?= $form->field($modelsGrn, "[{$index}]itemid")->textInput(['maxlength' => true]) ?>
              </div>  
			   <div class="col-sm-2">
                <?= $form->field($modelsGrn, "[{$index}]quantity")->textInput(['maxlength' => true]) ?>
              </div> 
			   <div class="col-sm-2">
                <?= $form->field($modelsGrn, "[{$index}]amount")->textInput(['maxlength' => true]) ?>
              </div> 
                  <div class="col-sm-4">
                <?= $form->field($modelsGrn, "[{$index}]unit")->textInput(['maxlength' => true]) ?>
              </div> 
              <div class="col-sm-1">
                <button type="button" class="pull-right siblingsremove-item btn btn-danger btn-xs"> Delete</button>
              </div>
            </div>   
          </div>
        </div>
             <?php endforeach; ?>
             <?php DynamicFormWidget::end(); ?>
            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($modelsGrn, 'grn_date')->widget(DatePicker::className(), [
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
                    <?= $form->field($modelsGrn, 'item_id')->dropDownList($stationaryData, ['prompt' => 'Select...']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($modelsGrn, 'supplier_id')->dropDownList($supplierData, ['prompt' => 'Select...']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($modelsGrn, 'bill_no')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($modelsGrn, 'quantity')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($modelsGrn, 'amount')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($modelsGrn, 'unit')->textInput() ?>
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

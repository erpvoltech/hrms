<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\VeplStationaries;
use app\models\VeplStationariesGrn;
use yii\helpers\ArrayHelper;

$stationaryData = ArrayHelper::map(VeplStationaries::find()->all(), 'id', 'item_name');
//$grnData = ArrayHelper::map(VeplStationariesGrn::find()->all(), 'id', 'item_id');
?>

<div class="vepl-stationaries-issue-form">

    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book">Stationary Issue Form</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'issue_date')->widget(DatePicker::className(), [
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
                    <?= $form->field($model, 'issue_item_id')->dropDownList(['prompt' => 'Select...']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'issued_to')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'issued_qty')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'remarks')->textInput() ?>
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

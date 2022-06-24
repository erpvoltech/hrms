<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgPolicyClaim */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-policy-claim-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book">Policy Claim Form</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'employee_code')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'employee_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'insurance_type')->dropDownList(['GPA' => 'GPA', 'GMC' => 'GMC', 'WC' => 'WC', 'Building' => 'Building', 'Equipment' => 'Equipment', 'Vehicle' => 'Vehicle',], ['prompt' => '']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'policy_no')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'policy_serial_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'nature_of_accident')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'loss_type')->dropDownList(['Fatal/Non Repairable' => 'Fatal/Non Repairable', 'Partial/Repairable' => 'Partial/Repairable',], ['prompt' => '']) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'injury_detail')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'accident_place_address')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'accident_time')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'accident_notes')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'settlement_notes')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'settlement_amount')->textInput() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'claim_estimate')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                     <?= $form->field($model, 'claim_status')->hiddenInput(['value'=>'Pending'])->label(false); ?>
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

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\VgInsuranceCompany;
use yii\helpers\ArrayHelper;

$ispData = ArrayHelper::map(VgInsuranceCompany::find()->all(), 'id', 'company_name');
?>

<div class="vg-insurance-agents-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> ISP Agent</i></div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'company_id')->dropDownList($ispData, ['prompt' => 'Select...']) ?>
                </div>
                <div class="col-sm-4">         
                    <?= $form->field($model, 'agent_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'official_contact_no')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'personal_contact_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>
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

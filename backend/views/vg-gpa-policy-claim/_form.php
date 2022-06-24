<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\EmpDetails;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\VgGpaPolicyClaim */
/* @var $form yii\widgets\ActiveForm */

$employeeNo = EmpDetails::find()->all();//, 'id', 'empcode');
foreach($employeeNo as $employee){
    $empData[] = $employee->empname.'-'.$employee->empcode;
}
$employee = ArrayHelper::index($empData, null, 'id');
?>

<div class="vg-gpa-policy-claim-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> GPA Claim Form</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'employee_id')->widget(Select2::classname(), [
                        'data' => $employee,
                        'options' => ['placeholder' => 'Select...'],
                        'pluginOptions' => [
                            'width' => '200px'
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-4">
                   
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'policy_serial_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'nature_of_accident')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'injury_detail')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'accident_place_address')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'accident_time')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'accident_notes')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'total_bill_amount')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'claim_status')->dropDownList(['New' => 'New', 'Pending' => 'Pending', 'Settled' => 'Settled',], ['prompt' => 'Select...']) ?>
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
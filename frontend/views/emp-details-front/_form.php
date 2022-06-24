<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employment_type')->dropDownList([ 'Engineer' => 'Engineer', 'Staff' => 'Staff', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'empcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'empname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doj')->textInput() ?>

    <?= $form->field($model, 'confirmation_date')->textInput() ?>

    <?= $form->field($model, 'designation_id')->textInput() ?>

    <?= $form->field($model, 'division')->dropDownList([ 'International' => 'International', 'Domestic' => 'Domestic', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'unit_id')->textInput() ?>

    <?= $form->field($model, 'department_id')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobileno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'referedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'probation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appraisalmonth')->dropDownList([ 'January' => 'January', 'February' => 'February', 'March' => 'March', 'April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July', 'August' => 'August', 'September' => 'September', 'October' => 'October', 'November' => 'November', 'December' => 'December', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'recentdop')->textInput() ?>

    <?= $form->field($model, 'joining_status')->dropDownList([ 'Experience' => 'Experience', 'Fresher' => 'Fresher', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'experience')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateofleaving')->textInput() ?>

    <?= $form->field($model, 'reasonforleaving')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

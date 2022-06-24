<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmployeeLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'updatedate')->textInput() ?>

    <?= $form->field($model, 'designation_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'designation_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attendance_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attendance_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'esi_from')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'esi_to')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pf_from')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pf_to')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pf_ restrict_from')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pf_ restrict_to')->dropDownList([ 'Yes' => 'Yes', 'No' => 'No', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pli_from')->textInput() ?>

    <?= $form->field($model, 'pli_to')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

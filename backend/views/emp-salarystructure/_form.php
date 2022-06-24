<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmpSalarystructure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-salarystructure-form">

      <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'layout' => 'horizontal',
                
                ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading text-center"  >Update Employee Salary Structure</div>
        <div class="panel-body">
          <br>
 <div class="form-group col-lg-2"></div>
 
            <div class="row">
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'salarystructure')->dropDownList([ 'Manager' => 'Manager', 'Assistant Manager' => 'Assistant Manager', 'Sr. Engineer - I' => 'Sr. Engineer - I', 'Sr. Engineer - II' => 'Sr. Engineer - II', 'Engineer' => 'Engineer', 'Trainee' => 'Trainee',], ['prompt' => '']) ?>
                </div>                
            </div>
			<div class="form-group col-lg-2"></div>
			<div class="row">
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'worklevel')->dropDownList([ 'WL5' => 'WL5', 'WL4C' => 'WL4C', 'WL4B' => 'WL4B', 'WL4A' => 'WL4A', 'WL3B' => 'WL3B', 'WL3A' => 'WL3A',], ['prompt' => '']) ?>
                </div>
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'grade')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D',], ['prompt' => '']) ?>
                </div>
            </div>
 <div class="form-group col-lg-2"></div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'basic')->textInput() ?>
                </div>
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'hra')->textInput() ?>
                </div>
            </div>
 <div class="form-group col-lg-2"></div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'other_allowance')->textInput() ?>
                </div>
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'gross')->textInput() ?>
                </div>
            </div>
 <div class="form-group col-lg-2"></div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'daperday')->textInput() ?>
                </div>
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'dapermonth')->textInput() ?>
                </div>
            </div>
 <div class="form-group col-lg-2"></div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'payableallowance')->textInput() ?>
                </div>
                <div class="form-group col-lg-4">
                    <?= $form->field($model, 'netsalary')->textInput() ?>
                </div>
            </div>
 <br>
 <div class="row">
   <div class="form-group col-lg-3"></div>
            <div class="col-lg-4 form-group" style="left:50px;">
                <?= Html::submitButton('Save', ['class' => 'btn btn-sm btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
 </div>
 <br>
        </div>
    </div>
</div>

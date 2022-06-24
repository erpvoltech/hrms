<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalarySatementsearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="emp-salarystatement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['salary-statement'],
        'method' => 'get',
    ]); ?>

  

    <?php  echo $form->field($model, 'unit_id') ?>

    <?php  echo $form->field($model, 'department_id') ?>

    <?php // echo $form->field($model, 'work_level') ?>

    <?php // echo $form->field($model, 'grade') ?>

    <?php // echo $form->field($model, 'salary_structure') ?>

    <?php // echo $form->field($model, 'earnedgross') ?>

    <?php  echo $form->field($model, 'month') ?>

    <?php // echo $form->field($model, 'paiddays') ?>

    <?php // echo $form->field($model, 'forced_lop') ?>

    <?php // echo $form->field($model, 'paidallowance') ?>

    <?php // echo $form->field($model, 'statutoryrate') ?>

    <?php // echo $form->field($model, 'basic') ?>

    <?php // echo $form->field($model, 'hra') ?>

    <?php // echo $form->field($model, 'spl_allowance') ?>

    <?php // echo $form->field($model, 'dearness_allowance') ?>

    <?php // echo $form->field($model, 'conveyance_allowance') ?>

    <?php // echo $form->field($model, 'over_time') ?>

    <?php // echo $form->field($model, 'arrear') ?>

    <?php // echo $form->field($model, 'advance_arrear_tes') ?>

    <?php // echo $form->field($model, 'lta_earning') ?>

    <?php // echo $form->field($model, 'medical_earning') ?>

    <?php // echo $form->field($model, 'guaranted_benefit') ?>

    <?php // echo $form->field($model, 'holiday_pay') ?>

    <?php // echo $form->field($model, 'washing_allowance') ?>

    <?php // echo $form->field($model, 'dust_allowance') ?>

    <?php // echo $form->field($model, 'performance_pay') ?>

    <?php // echo $form->field($model, 'other_allowance') ?>

    <?php // echo $form->field($model, 'total_earning') ?>

    <?php // echo $form->field($model, 'pf') ?>

    <?php // echo $form->field($model, 'insurance') ?>

    <?php // echo $form->field($model, 'professional_tax') ?>

    <?php // echo $form->field($model, 'esi') ?>

    <?php // echo $form->field($model, 'advance') ?>

    <?php // echo $form->field($model, 'tes') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'loan') ?>

    <?php // echo $form->field($model, 'rent') ?>

    <?php // echo $form->field($model, 'tds') ?>

    <?php // echo $form->field($model, 'lwf') ?>

    <?php // echo $form->field($model, 'other_deduction') ?>

    <?php // echo $form->field($model, 'total_deduction') ?>

    <?php // echo $form->field($model, 'net_amount') ?>

    <?php // echo $form->field($model, 'pf_employer_contribution') ?>

    <?php // echo $form->field($model, 'esi_employer_contribution') ?>

    <?php // echo $form->field($model, 'pli_employer_contribution') ?>

    <?php // echo $form->field($model, 'lta_employer_contribution') ?>

    <?php // echo $form->field($model, 'med_employer_contribution') ?>

    <?php // echo $form->field($model, 'earned_ctc') ?>

    <?php // echo $form->field($model, 'revised') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
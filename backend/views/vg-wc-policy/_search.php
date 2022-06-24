<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgWcPolicySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-wc-policy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
    ]); ?>
    
    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'policy_no') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'employer_name_address') ?></div>
        
    </div>
    
    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'project_address') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'wc_type') ?></div>
    </div>

    

    <?php // echo $form->field($model, 'project_address') ?>

    <?php // echo $form->field($model, 'wc_coverage_days') ?>

    <div class="row">      
        <div class=" col-lg-2"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VgPolicyClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-policy-claim-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'layout' => 'horizontal',
    ]);
    ?>
    
    <?php /* <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'employee_code') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'employee_name') ?></div>
    </div> */ ?>
    
    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'insurance_type') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'claim_status') ?></div>
    </div>

    <?php // echo $form->field($model, 'policy_serial_no') ?>

    <?php // echo $form->field($model, 'contact_person') ?>

    <?php // echo $form->field($model, 'contact_no') ?>

    <?php // echo $form->field($model, 'nature_of_accident') ?>

    <?php // echo $form->field($model, 'loss_type') ?>

    <?php // echo $form->field($model, 'injury_detail') ?>

    <?php // echo $form->field($model, 'accident_place_address') ?>

    <?php // echo $form->field($model, 'accident_time') ?>

    <?php // echo $form->field($model, 'accident_notes') ?>

    <?php // echo $form->field($model, 'settlement_notes') ?>

    <?php // echo $form->field($model, 'settlement_amount') ?>

    <?php // echo $form->field($model, 'claim_estimate') ?>

    <?php // echo $form->field($model, 'claim_status') ?>

    <div class="row">      
        <div class=" col-lg-2"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>	  

    <?php ActiveForm::end(); ?>

</div>

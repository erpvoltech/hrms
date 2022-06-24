<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsurancePropertySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-property-search">
    
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
    ]); ?>
    
    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'property_type')?></div>
        <div class="col-lg-4"><?= $form->field($model, 'property_name')?></div>
        <div class="col-lg-4"><?= $form->field($model, 'location')?></div>
     </div>
    
    
    <?php // echo $form->field($model, 'property_no') ?>

    <?php // echo $form->field($model, 'property_value') ?>

    <?php // echo $form->field($model, 'sum_insured') ?>

    <?php // echo $form->field($model, 'premium_paid') ?>

    <?php // echo $form->field($model, 'valid_from') ?>

    <?php // echo $form->field($model, 'valid_to') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'user_division') ?>

    <?php // echo $form->field($model, 'equipment_service') ?>

    <?php // echo $form->field($model, 'icn_id') ?>

    <?php // echo $form->field($model, 'insurance_agent_id') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="row">      
        <div class=" col-lg-4"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

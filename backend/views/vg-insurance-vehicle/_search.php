<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\VgInsuranceVehicle;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceVehicleSearch */
/* @var $form yii\widgets\ActiveForm */

$years= VgInsuranceVehicle::find()->where(['<>', 'financial_year', ''])
								->groupBy('financial_year')
								->all();
$listData=ArrayHelper::map($years,'financial_year','financial_year');
?>

<div class="vg-insurance-vehicle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal',
    ]); ?>
    
    <div class="row">
        <!--<div class="col-lg-4"> $form->field($model, 'insurance_no') </div>-->
        <div class=" col-lg-4"><?= $form->field($model, 'property_name') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'vehicle_type') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'property_no') ?></div>
    </div>
    
    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'location') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'user') ?></div>
	</div>
	
	<div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'financial_year')->dropDownList(
        $listData,
        ['prompt'=>'Select Year...']
        ); ?></div>
        <div class="col-lg-4"><?= $form->field($model, 'insurance_status')->dropDownList(['Live' => 'Live', 'Expired' => 'Expired', 'Vehicle Sold' => 'Vehicle Sold'],['prompt'=>'Select Status']); ?></div>
	</div>

    
    <?php // echo $form->field($model, 'property_name') ?>

    <?php // echo $form->field($model, 'property_no') ?>

    <?php // echo $form->field($model, 'property_value') ?>

    <?php // echo $form->field($model, 'sum_insured') ?>

    <?php // echo $form->field($model, 'premium_paid') ?>

    <?php // echo $form->field($model, 'valid_from') ?>

    <?php // echo $form->field($model, 'valid_to') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'user_division') ?>

    <?php // echo $form->field($model, 'insured_to') ?>

    <?php // echo $form->field($model, 'remarks') ?>

     <div class="row">      
        <div class=" col-lg-2"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

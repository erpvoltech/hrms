<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceEquipmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-equipment-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'layout' => 'horizontal',
    ]);
    ?>
    
    <div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'insurance_no') ?></div>
        <div class=" col-lg-4"><?= $form->field($model, 'insured_to') ?></div>
	</div>
	<div class="row">
        <div class="col-lg-4"><?= $form->field($model, 'location') ?></div>
		<div class="col-lg-4"><?= $form->field($model, 'financial_year')->dropDownList(['2019-2020' => '2019-2020', '2020-2021' => '2020-2021', '2021-2022' => '2021-2022'],['prompt'=>'Select Year']); ?></div>
    </div>
    
    
    <?php //$form->field($model, 'id') ?>

    <?php //$form->field($model, 'icn_id') ?>

    <?php //$form->field($model, 'insurance_agent_id') ?>

    <?php //$form->field($model, 'property_type') ?>

    <?php //$form->field($model, 'insurance_no') ?>

    <?php // echo $form->field($model, 'property_name') ?>

    <?php // echo $form->field($model, 'property_no') ?>

    <?php // echo $form->field($model, 'property_value') ?>

    <?php // echo $form->field($model, 'sum_insured') ?>

    <?php // echo $form->field($model, 'premium_paid') ?>

    <?php // echo $form->field($model, 'valid_from') ?>

    <?php // echo $form->field($model, 'valid_to') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'user_division') ?>

    <?php // echo $form->field($model, 'insured_to') ?>

    <?php // echo $form->field($model, 'equipment_service') ?>

    <?php // echo $form->field($model, 'remarks') ?>

   <div class="row">      
        <div class=" col-lg-2"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>	 

    <?php ActiveForm::end(); ?>

</div>

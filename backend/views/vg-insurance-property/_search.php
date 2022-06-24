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
             
    <?php // echo $form->field($model, 'equipment_service') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="row">      
        <div class=" col-lg-4"></div>
        <div class=" col-lg-2"> <?= Html::submitButton('Search', ['class' => 'btn-xs btn-primary']) ?></div>
        <div class=" col-lg-2">  <?= Html::a('Clear', ['index'], ['class' => 'btn btn-xs btn-warning']) ?> </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
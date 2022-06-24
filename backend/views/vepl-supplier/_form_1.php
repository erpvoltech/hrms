<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplSupplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'supplier_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supplier_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'supplier_contact_no')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

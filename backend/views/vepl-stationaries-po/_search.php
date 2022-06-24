<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VeplStationariesPoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-po-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'po_no') ?>

    <?= $form->field($model, 'po_date') ?>

    <?= $form->field($model, 'last_purchase_date') ?>

    <?= $form->field($model, 'po_supplier_id') ?>

    <?php // echo $form->field($model, 'po_prepared_by') ?>

    <?php // echo $form->field($model, 'po_apporoved_by') ?>

    <?php // echo $form->field($model, 'po_approval_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VeplStationariesGrn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-grn-form">

    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book">GRN Entry Form</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'grn_date')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'item_id')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'supplier_id')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'bill_no')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'quantity')->textInput() ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'amount')->textInput() ?>
                </div>
            </div>
            <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'unit')->textInput() ?>
            </div>
            </div>
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="form-group col-lg-5">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

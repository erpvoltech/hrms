<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VeplStationaries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vepl-stationaries-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> Stationary/Printing Material</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <!--<= $form->field($model, 'item_category')->textInput(['maxlength' => true]) ?>-->
                    <?= $form->field($model, 'item_category')->dropDownList([ 'Stationary' => 'Stationary', 'Printing Material' => 'Printing Material',], ['prompt' => 'Select Category']) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>
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

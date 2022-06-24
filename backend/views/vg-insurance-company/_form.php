<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceCompany */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-company-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-book"> ISP</i></div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6"></div>
                <div class="form-group col-lg-5">
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>

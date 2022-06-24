<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgWcPolicy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-wc-policy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employer_name_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'contractor_name_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nature_of_work')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'policy_holder_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'project_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'wc_coverage_days')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

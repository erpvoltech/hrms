<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgInsuranceAgentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-insurance-agents-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'agent_name') ?>

    <?= $form->field($model, 'official_contact_no') ?>

    <?= $form->field($model, 'personal_contact_no') ?>

    <?php // echo $form->field($model, 'email_address') ?>

    <?php // echo $form->field($model, 'company_logo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

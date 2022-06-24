<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VgGmcPolicySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vg-gmc-policy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'policy_name') ?>

    <?= $form->field($model, 'insurance_comp_id') ?>

    <?= $form->field($model, 'insurance_agents_id') ?>

    <?= $form->field($model, 'policy_no') ?>

    <?php // echo $form->field($model, 'from_date') ?>

    <?php // echo $form->field($model, 'to_date') ?>

    <?php // echo $form->field($model, 'premium_paid') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

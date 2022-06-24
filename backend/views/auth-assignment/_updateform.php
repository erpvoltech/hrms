<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

if($model->view_rights == 1)
$model->view_rights = 1;
else
	$model->view_rights = 0;

if($model->create_rights == 1)
$model->create_rights = 1;
else
	$model->create_rights = 0;

if($model->update_rights == 1)
$model->update_rights = 1;
else
	$model->update_rights = 0;

	if($model->delete_rights == 1)
	$model->delete_rights = 1;
	else
	$model->delete_rights = 0;
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

	<?=$model->user->username?>
	<?=strtoupper($model->module)?>
   <?= $form->field($model, 'view_rights')->checkbox() ?>
   <?= $form->field($model, 'create_rights')->checkbox() ?>
   <?= $form->field($model, 'update_rights')->checkbox() ?>
	<?= $form->field($model, 'delete_rights')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

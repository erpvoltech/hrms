<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="project-details-assign-emp">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'project_emp_id') ?>
		
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-assign-emp -->

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\EmpDetails;

$Emp = EmpDetails::find()->Where(['id'=>$model->emp_id])->one();
$model->emp_id = $Emp->empcode;
?>
<div class="project-details-assign-emp">

    <?php $form = ActiveForm::begin(); ?>
       
		<?= $form->field($model, 'month')->widget(\yii\jui\DatePicker::class, [
                   'options' => ['class' => 'form-control'],
                   'clientOptions' => [
                       'dateFormat' => 'dd-MM-yyyy',
                       'changeMonth' => true,
                       'changeYear' => true,
                   ],
               ])?>
        <?= $form->field($model, 'emp_id')->label('Emp Code') ?>
		<?= $form->field($model, 'category')->dropDownList([ 'highly_skilled' => 'Highly skilled', 'skilled' => 'Skilled', 'semi_skilled' => 'Semi Skilled','un_skilled' => 'Un Skilled', ], ['prompt' => '']) ?> 
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- project-details-assign-emp -->


<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use common\models\User;
use yii\helpers\ArrayHelper;

$empData = ArrayHelper::map(User::find()->all(), 'id', 'username');
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
	<?= $form->field($model, 'userid')->dropDownList(
    $empData,   
    ['prompt'=>'Select...']
)?>

    <?= $form->field($model, 'module')->dropDownList(['mis' => 'MIS', 'payroll' => 'Payroll', 'leave' => 'Leave', 'statutoryir' => 'Statutory IR','statutoryhr' => 'Statutory HR','recruitment' => 'Recruitment','post recruitment' => 'Post Recruitment','cmd family policy' => 'Cmd Family Policy','authentication' => 'Authentication','finance'=>'Finance', 'insurance' => 'Insurance'], ['prompt'=>'Select...']) ?>

    <?= $form->field($model, 'rights')->checkboxList(
			['v' => 'View', 'c' => 'Create', 'u' => 'Update','d' => 'Delete']
   ); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

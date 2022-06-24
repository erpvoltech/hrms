<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\EmpDetails */

$this->title = 'Login Employee';
#$this->params['breadcrumbs'][] = ['label' => 'Login Employee', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emp-details-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>    

    <?= $form->field($model, 'empcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emp_password')->passwordInput(['maxlength' => true]) ?>
	
	<div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

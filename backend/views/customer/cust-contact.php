<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Customer;
use kartik\select2\Select2;
use yii\helpers\Url;
?>

<div class="customer-contact-form">

    <?php $form = ActiveForm::begin(); ?>
	
			 <?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
				'data' => ArrayHelper::map(Customer::find()->all(), 'id', 'customer_name'),
				'pluginOptions' => [                    
                    'placeholder' => 'Select...',
                   'width' => '200px',
                ]
				])?>  
	
    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
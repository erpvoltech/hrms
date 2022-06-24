<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrainingTopics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-topics-form">

    <?php $form = ActiveForm::begin([
        
        'layout' => 'horizontal',
    ]);
    
	$created_by		=	Yii::$app->user->identity->username;
	$created_date	=	date("Y-m-d");	
	?>
		
    <?= $form->field($model, 'topic_name')->textInput(['maxlength' => true]) ?>
	<!--<?= $form->field($model, 'created_by')->hiddenInput(['value'=> $created_by])->label(false) ?>
	<?= $form->field($model, 'created_date')->hiddenInput(['value'=> $created_date])->label(false) ?>
	<?= $form->field($model, 'updated_by')->hiddenInput(['value'=> $created_by])->label(false) ?>
	<?= $form->field($model, 'updated_date')->hiddenInput(['value'=> $created_date])->label(false) ?>-->
   
	<!--<?= $form->field($model, 'created_by')->hiddenInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_date')->hiddenInput() ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>-->
    <Br>
    <div class="form-group">
      <div class="col-lg-5"></div>
      <div class="col-lg-3">  <?= Html::submitButton('Save', ['class' => 'btn-sm btn-success']) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
  
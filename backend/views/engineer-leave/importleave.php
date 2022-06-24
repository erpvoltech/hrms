<?php 
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\ActiveForm;
	
	
	
	$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="panel panel-default">
        <div class="panel-heading text-center" style="font-size:18px;"> Engineer Leave Import</div>
        <div class="panel-body"> 
    <?= $form->field($model, 'file')->fileInput() ?>
          <br>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
        </div></div>
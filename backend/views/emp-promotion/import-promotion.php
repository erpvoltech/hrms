<?php 
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\ActiveForm;
	
	
	
	$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'layout'=>'horizontal']); ?>
	<div class="panel panel-default">
        <div class="panel-heading text-center" style="font-size:18px;">import </div>
        <div class="panel-body"> 
          <br>
			<?= $form->field($model, 'file')->fileInput() ?>	
		<div class="row">
		<div class="form-group col-md-4" style="margin-left:50px;"></div>
        <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
		</div>	
        </div></div>
	<?php ActiveForm::end(); ?>
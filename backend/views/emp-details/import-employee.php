<?php 
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\ActiveForm;
	
	
	
	$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'layout'=>'horizontal']); ?>
	<div class="panel panel-default">
        <div class="panel-heading text-center" style="font-size:18px;">import / Export</div>
        <div class="panel-body"> 
          <br>
			<?= $form->field($model, 'file')->fileInput() ?>
			<?= $form->field($model, 'uploadtype')->radioList(array(1=>'New',2=>'Update')); ?>
			<?= $form->field($model, 'uploaddata')->radioList(array(1=>'Permanent Emp. Details',6=>'Contract Emp. Details',2=>'Family Details',3=>'Education Details',4=>'Certificates Details',5=>'Bank Details')); ?>
          <br>
		<div class="row">
		<div class="form-group col-md-4" style="margin-left:50px;"></div>
        <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
		</div>	
        </div></div>
	<?php ActiveForm::end(); ?>
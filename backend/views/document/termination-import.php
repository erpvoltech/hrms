<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\ActiveForm;



$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'layout'=>'horizontal']); ?>
<div class="panel panel-default">
	<div class="panel-heading text-center" style="font-size:18px;">import </div>
	<div class="panel-body">
		<br>

		<div class="row">
			<div class="form-group col-md-1" style="margin-left:50px;"></div>
				<div class="form-group col-md-6">
					<?= $form->field($model, 'file')->fileInput() ?>
				</div>
					<div class="form-group col-md-3" ><a href="../doc_file/scn_template.xlsx" class='btn btn-xs btn-primary'>Template link</a></div>
			</div>

			<div class="row">
				<div class="form-group col-md-3" style="margin-left:50px;"></div>
					<div class="form-group col-md-2">
					<?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
					</div>

				</div>


	</div></div>
	<?php ActiveForm::end(); ?>

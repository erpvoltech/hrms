<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Division;
use common\models\unit;
use yii\helpers\ArrayHelper;
use dosamigos\multiselect\MultiSelectListBox;

$divisionData = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$unitData = ArrayHelper::map(Unit::find()->all(), 'id', 'name');
?>
<div class="unit-group-form">
 <?php  $form = ActiveForm::begin([ 'layout' => 'horizontal']);?>
 <div class="row">
	<div class="form-group col-lg-4">
	   <?= $form->field($model, 'unit_id')->dropDownList($unitData, ['prompt' => ' ']) ?>
	</div>
	<div class="form-group col-lg-4">
		<?= MultiSelectListBox::widget([
    'options' => [
        'multiple' => 'multiple',
    ],	
    'data' => $divisionData,
    'model' => $model,
    'attribute' => 'division_id',
]) ?>
</div>
</div>
 <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2 p-l-20 form-group" style="left:35px;">
            <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
            </div>
         </div>
         <?php ActiveForm::end(); ?>
		 
		 </div>
	

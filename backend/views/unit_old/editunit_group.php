<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Vgunit;
use common\models\unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use common\models\UnitGroup;
use dosamigos\multiselect\MultiSelectListBox;

$unitGroupData = ArrayHelper::map(Vgunit::find()->all(), 'id', 'unit_group');
$unitData = ArrayHelper::map(Division::find()->all(), 'id', 'division_name');
$unit_array=[];
	$unitgroupid =  Yii::$app->getRequest()->getQueryParam('id');
	$unit_group = UnitGroup::find()->Where(['vgunit_id'=>$unitgroupid])->all();
	foreach($unit_group as $units){
		$unit_array[] = $units->unit_id;
		}
	$model->unit_id = $unit_array;
?>
<div class="unit-group-form">
 <?php  $form = ActiveForm::begin([ 'layout' => 'horizontal']);?>
 <div class="row">

	<?= MultiSelectListBox::widget([
    'options' => [
        'multiple' => 'multiple',
    ],	
    'data' => $unitData,
    'model' => $model,
    'attribute' => 'unit_id',
]) ?>
	<div class="form-group col-lg-4">
	
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
	

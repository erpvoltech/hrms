<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Vgunit;
use common\models\unit;
use common\models\Division;
use yii\helpers\ArrayHelper;
use common\models\UnitGroup;	

$this->params['breadcrumbs'][] = 'Set Priority';
?>
<div class="set-priority-form">
 <?php  $form = ActiveForm::begin([ 'layout' => 'horizontal']);?>
 
 
	 <?php $Unitgroup = UnitGroup::find()->where(['unit_id'=>$id])->orderBy(['id'=>SORT_ASC])->all();
		foreach($Unitgroup as $group){ ?>
		<div class="row">
		<div class="form-group col-lg-3"> <?php
		$unit = Division::find()->where(['id'=>$group->division_id])->one();
		echo $unit->division_name;
		?>
		</div>
		<div class="form-group col-lg-1">
		<?=$group->priority?>
		</div>
		
		<div class="form-group col-lg-2">
		<?php 
		echo $form->field($model, 'priority[]')->textInput()->label(false);
		?>
		</div>
		</div>
		<?php
		}
		?>
		<div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2 p-l-20 form-group" style="left:35px;">
            <?= Html::submitButton('Submit', ['class' => 'btn-xs btn-success']) ?>
            </div>
			<div class="col-md-2 p-l-20 form-group" style="left:35px;">
           <?= Html::a('<span class="btn btn-xs btn-warning"> Cancel</span>',['priority-cancel']) ?>
            </div>
			
        </div>
         <?php ActiveForm::end(); ?>
		 
		 </div>
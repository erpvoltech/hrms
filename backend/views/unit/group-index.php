<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Unit;
use common\models\UnitGroup;
use common\models\Vgunit;
use common\models\Division;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	table, tr, th, td {
    border: 0px;
    border-collapse: collapse;
}
</style>
<div class="unit-index">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Units</div>
  <div class="panel-body">
  
	 <div class="row">
		
		 <div class="form-group col-lg-12">
		 <p>Units Group Specially used for Report</p>
		<p>		
		<?= Html::a('Create UnitGroup', ['create-group'], ['class' => 'btn-sm btn-success']) ?>
		</p>
		<br><br>
		<table class="table table-striped table-bordered">
		<thead> <tr><th>#</th><th>Unit </a></th><th > Division </th><th> Priority</th><th>Action</th></tr> </thead>
		<tbody>
		<?php
		$i = 1;
		$UnitModel = Unit::find()->all();
		foreach($UnitModel as $model){
		?>
		<tr><td><?=$i?></td><td>
		<?=$model->name?>
		<br>
		<?php $unitgroupmodel = UnitGroup::find()->where(['unit_id'=>$model->id])->all();
		if($unitgroupmodel)
			echo Html::a('<i>Set Priority</i>', ['set-priority','id'=>$model->id]); 
		?>
		</td><td>
		<?php $Unitgroup = UnitGroup::find()->where(['unit_id'=>$model->id])->all();
		foreach($Unitgroup as $group){
		$unit = Division::find()->where(['id'=>$group->division_id])->one();
		echo $unit->division_name ;//$group->priority		
		echo '<br>';
		}
		?>
		</td>	
		<td>
		<?php $Unitgroup = UnitGroup::find()->where(['unit_id'=>$model->id])->all();
		foreach($Unitgroup as $group){
		echo $group->priority;		
		echo '<br>';
		}
		?>
		</td>	
		<td>
		<?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['group-update','id'=>$model->id]) ?>&nbsp;
		<?= Html::a('<i class="glyphicon glyphicon-trash"></i>', ['group-delete','id'=>$model->id],[ 'data' => [
            'confirm' =>( 'Are you sure you want to delete this Group?'),
            'method' => 'post',
        ],]) ?>
		</td></tr>
		<?php $i++;} ?>
		</tbody>
		</table>
		</div>
	</div>
</div>
</div>
</div>

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
<div class="unit-index">
<div class="panel panel-default">
   <div class="panel-heading text-center"> Units</div>
  <div class="panel-body">
  
	 <div class="row">
		
		 <div class="form-group col-lg-6">
		 <p>Units Group Specially used for Report</p>
		<p>		
		<?= Html::a('Create UnitGroup', ['create-group'], ['class' => 'btn-sm btn-success']) ?>
		</p>
		<br><br>
		<table class="table table-striped table-bordered">
		<thead> <tr><th>#</th><th>Unit Group</a></th><th > Division</th><th>Action</th></tr> </thead>
		<tbody>
		<?php
		$i = 1;
		$VGgroup = Vgunit::find()->all();
		foreach($VGgroup as $vgunit){
		?>
		<tr><td><?=$i?></td><td>
		<?=$vgunit->unit_group?>
		</td><td>
		<?php $Unitgroup = UnitGroup::find()->where(['vgunit_id'=>$vgunit->id])->all();
		foreach($Unitgroup as $group){
		$unit = Division::find()->where(['id'=>$group->unit_id])->one();
		echo $unit->division_name;
		echo '<br>';
		}
		?>
		</td><td>
		<?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['group-update','id'=>$vgunit->id]) ?>&nbsp;
		<?= Html::a('<i class="glyphicon glyphicon-trash"></i>', ['group-delete','id'=>$vgunit->id],[ 'data' => [
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

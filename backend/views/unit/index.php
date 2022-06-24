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
   <div class="panel-heading text-center"> Units & Division</div>
  <div class="panel-body">
  
	 <div class="row">
		 <div class="form-group col-lg-6">
		
		<p>
		<?= Html::a('Create Unit', ['create'], ['class' => 'btn-sm btn-success']) ?>
		  <?= Html::a('Unit Push to App', '../../../push/importUnit.php', ['class' => 'btn-sm btn-primary', 'target' => '_blank']) ?>
		</p>
		<br>
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'name',
				['class' => 'yii\grid\ActionColumn',
				 'template' => '{update} &nbsp; {delete}',
				],
			],
		]); ?>
		</div>
		
		
		
		 <div class="form-group col-lg-6">		
		<p>		
		<?= Html::a('Create Division', ['create-division'], ['class' => 'btn-sm btn-success']) ?>
		  <?= Html::a('Division Push to App', '../../../push/importDivision.php', ['class' => 'btn-sm btn-primary', 'target' => '_blank']) ?>
		</p>
		<br><br>
		<table class="table table-striped table-bordered">
		<thead> <tr><th>#</th><th>Division</th><th> Action</th></tr> </thead>
		<tbody>
		<?php
		$i = 1;
		$VGDivision = Division::find()->all();
		foreach($VGDivision as $division){
		?>
		<tr><td><?=$i?></td><td>
		<?=$division->division_name?>
		</td><td>
		<?= Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['division-update','id'=>$division->id]) ?>
		<?= Html::a('<i class="glyphicon glyphicon-trash"></i>', ['division-delete','id'=>$division->id],[ 'data' => [
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

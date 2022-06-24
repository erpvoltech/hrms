<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\ProjectDetails;
use common\models\CustomerContact;

 $this->title = 'Project Salary';

 $dataProvider = new ActiveDataProvider([
            'query' => $model,
 ]);
 
?>
<!--
<div class="project-details-index">
	<div class="row">
		<div class="col-md-8"><h4 style="margin-top:2px">Project Details</h4></div>
	</div>
		<div class="row">
			<div class="col-md-2" align="right">
			Project Code :
			</div>
			<div class="col-md-2">
			<?//$project->project_code?>
			</div>			
			<div class="col-md-2" align="right">
			Location Code :
			</div>
			<div class="col-md-2">
			<?//$project->location_code?>
			</div>
			<div class="col-md-2" align="right">
			Customer :
			</div>
			<div class="col-md-2">
			<?//$project->customer->customer_name?>
			</div>
		
		</div>
		-->
		
	<div class="row">
		<div class="col-md-8"><h4 >Project Salary</h4></div>
		
	</div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider, 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'month',
			[
			   'header' => 'Code',
               'attribute' => 'project_id',
               'value' => 'project.project_code',
            ],
			
			[
			'header' => 'Salary',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} ',
                'buttons' => [                    
					  'view' => function ($model,$key) {
                     return Html::a('view', ['salary-view', 'id' => $key->project_id,'month' => $key->month], [ 'class' => 'btn-xs btn-info','style'=> 'color: #fff;padding:5px 20px']);                  
                     },
					
                ],
            ],
			
			[
			'header' => 'Attendance',
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {view} ',
                'buttons' => [                    
					  'view' => function ($model,$key) {
                     return Html::a('view', ['att-view', 'id' => $key->project_id,'month' => $key->month], [ 'class' => 'btn-xs btn-primary','style'=> 'color: #fff;padding:5px 20px']);                  
                     },
                ],
            ],
			
			[
			'header' => 'Export',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{export}',
                'buttons' => [                    
					
					  'export' => function ($model,$key) {
                     return Html::a('Export',['export','id' => $key->project_id,'month' => $key->month], [ 'class' => 'btn-xs btn-danger','style'=> 'color: #fff;padding:5px 20px']);                   
                     },
					 
                ],
            ],
        ],
    ]); ?>
</div>

 <?php
 
 /**/
			
			
			?>

<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\ProjectDetails;
use common\models\CustomerContact;

 $this->title = 'Project Tracking';

 $dataProvider = new ActiveDataProvider([
            'query' => $model,
 ]);
 
 $project = ProjectDetails::findOne($_GET['id']);
?>
<div class="project-details-index">
	<div class="row">
		<div class="col-md-8"><h4 style="margin-top:2px">Project Details</h4></div>
	</div>
		<div class="row">
			<div class="col-md-2" align="right">
			Project Code :
			</div>
			<div class="col-md-2">
			<?=$project->project_code?>
			</div>			
			<div class="col-md-2" align="right">
			Location Code :
			</div>
			<div class="col-md-2">
			<?=$project->location_code?>
			</div>
			<div class="col-md-2" align="right">
			Customer :
			</div>
			<div class="col-md-2">
			<?=$project->customer->customer_name?>
			</div>
		
		</div>
		
		
	<div class="row">
		<div class="col-md-8"><h4 >Project Tracking</h4></div>
		
	</div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider, 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'month',
			'attendance_division',
			'attendance_send',
			'prs_received',
			'prs_send_division',
			'docs_division',
			'docs_send',
			'invoice_no',
			'clearance_status',
			'remark',
			
			[
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update} {delete} ',
                'buttons' => [                    
					  'update' => function ($model,$key) {
                     return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['tracking-edit','id' => $key->id]);                   
                     },
					  'delete' => function ($model,$key) {
                     return Html::a('<span class="glyphicon glyphicon-trash"></span>',['tracking-delete','id' => $key->id,'proj' => $key->project_id]);                   
                     },
                ],
            ],
        ],
    ]); ?>
</div>

  <div class="pull-left" style="padding-left: 50px">
         <?= Html::a('Create', ['project-tracking','id'=>$project->id], ['class' => 'btn btn-warning']) ?>

      </div>

<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\ProjectDetails;
use common\models\CustomerContact;
use common\models\ProjectTracking;
 $this->title = 'Project Tracking';

 $model = ProjectTracking::find();
 
 $dataProvider = new ActiveDataProvider([
            'query' => $model,
 ]);
 
 
?>
<div class="project-details-index">
	
		
		
	<div class="row">
		<div class="col-md-8"><h4 >Project Tracking</h4></div>
		
	</div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider, 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
			   'label' => 'Project code',
               'attribute' => 'principal_id',
               'value' => 'project.project_code',
            ],
			['attribute' => 'month',
			'format' => ['date', 'php:d-m-Y'],
								'value' => 'month'
			],
			
			['attribute' => 'attendance_division',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'attendance_division'
			],
			
			['attribute' => 'attendance_send',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'attendance_send'
			],
			
			['attribute' => 'prs_received',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'prs_received'
			],
			
			['attribute' => 'prs_send_division',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'prs_send_division'
			],
			
			['attribute' => 'docs_division',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'docs_division'
			],
			
			['attribute' => 'docs_send',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'docs_send'
			],
			
			
			'invoice_no',
			'clearance_status',
			'remark',	
        ],
    ]); ?>
</div>

  

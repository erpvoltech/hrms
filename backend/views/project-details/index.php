<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Details';
?>
<div class="project-details-index">

<div class="row">
	<div class="col-md-8"><h1 style="margin-top:2px"><?= Html::encode($this->title) ?></h1></div>
	
</div>
    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
		'toolbar' =>  [
        [
            'content' =>
               Html::a('New Project', ['create'], ['class' => 'btn btn-danger']),
            'options' => ['class' => 'btn-group mr-2']
        ],
        '{export}',
        '{toggleData}',
    ],
       'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Project Details</h3>',
       ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
          
           
			[          'label' => 'Project code',
                        'format' => 'raw',
                        'value' => function ($model) {                          
                            return Html::a($model->project_code,['track-index','id'=>$model->id],
							['target' => '_blank',  'data-pjax'=>"0"]);							
                        },
            ],
               
            'location_code',  
			'location',
			[
               'attribute' => 'principal_employer',
               'value' => 'employer.customer_name',
            ],
			[
               'attribute' => 'customer_id',
               'value' => 'customer.customer_name',
            ],
			/*[
               'attribute' => 'consultant_id',
               'value' => 'consultant.customer_name',
            ],*/
            //'job_details:ntext',
            //'state',
            //'compliance_required',
            //'consultant',
            //'consultant_id',
          
			[
               'attribute' => 'unit_id',
               'value' => 'units.name',
            ],           
            [
               'attribute' => 'division_id',
               'value' => 'division.division_name',
            ],
			'project_status',
            [          'label' => 'Salary/Att',
                        'format' => 'raw',
                        'value' => function ($model) {                          
                            return Html::a('View',['salary-index','id'=>$model->id],
							['target' => '_blank',  'data-pjax'=>"0"]);							
                        },
            ],
			

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

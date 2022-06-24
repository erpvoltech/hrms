<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Details';
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.table a {
    color: #000;
	
</style>
<div class="project-details-index">
<?php //if(Yii::$app->user->identity->role=='project admin'){?>

    <h3><?= Html::encode($this->title) ?></h3>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= Html::a('Create Project Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->
	
	<?php
	
	$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'project_code',
    'project_name',
	'pono',
	'po_deliverydate',
	'location_code',
    [
        'attribute' => 'principal_employer',
        'value' => 'employer.customer_name',
    ],
    'pehr_contact',
	'pehr_email',
    'petech_contact',
	'petech_email',
	[
         'attribute' => 'customer_id',
         'value' => 'customer.customer_name',
            ],
	'conhr_contact',
	'conhr_email',
    'contech_contact',
	'contech_email',
	'job_details',
	'state',
	'district',
	'compliance_required',
	'consultant',
	[
	'attribute' => 'consultant_id',
	'value' => 'consultants.customer_name',
            ],
    'consulthr_contact',
    'consulthr_email',
    'consultech_contact',
	'consultech_email',
    'project_status',
	'remark',
];
$fullexport =  ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-secondary'
    ]
]);
?>
	

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'toolbar' =>  [
         [
            'content' =>
               Html::a('Export Without Data', ['export'], ['class' => 'btn btn-success']),
            'options' => ['class' => 'btn-group mr-2']
        ],
		
		[
            'content' =>
               Html::a('New Project', ['create'], ['class' => 'btn btn-danger']),
            'options' => ['class' => 'btn-group mr-2']
        ],
		$fullexport,
        //'{export}',
        //'{toggleData}',
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
            'project_name',   
            'location_code',  
            
			[
               'attribute' => 'principal_employer',
               'value' => 'employer.customer_name',
            ],
			
			
			[
               'attribute' => 'customer_id',
               'value' => 'customer.customer_name',
            ],
			
			//'job_details',
			[
               'attribute' => 'state',
               'value' => 'states.state_name',
            ],
			
			[
               'attribute' => 'district',
               'value' => 'districts.district_name',
            ],
			
			'compliance_required',
			'consultant',
			
            'project_status',
			//'remark',
			//'unit_id',
			//'division_id',
			
           /* [          'label' => 'Salary/Att',
                        'format' => 'raw',
                        'value' => function ($model) {                          
                            return Html::a('View',['salary-index','id'=>$model->id],
                            ['target' => '_blank',  'data-pjax'=>"0"]);                         
                        },
            ],*/
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
]); // }else{
	//echo"User is Not a Valid User";
//} ?>
</div>

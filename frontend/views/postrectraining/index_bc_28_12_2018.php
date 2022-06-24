<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PorecTrainingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Post Recruitment Training';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
/*tbody{
	display: none;
}*/
</style>

<div class="porec-training-index">
<div class="panel panel-info">
   <div class="panel-heading text-center" style="font-size:18px;">Post Recruitment Training</div>
   <div class="panel-body">
   <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<?php if((isset($searchModel['batch_id']) && $searchModel['batch_id'] != '') || (isset($searchModel['trainig_topic_id']) && $searchModel['trainig_topic_id'] != '')) { ?>
    
	<?php echo $this->render('_faculty'); ?>
	
	<div style="margin-top:-45px;">
	
	<?php #echo "<pre>";print_r($searchModel['batch_id']);echo "</pre>"; ?>
	
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        #'filterModel' => $searchModel,		
        /*'rowOptions'=>function($model)
         {
          if($model->status == '1')
          {
              return ['class'=>'info'];
          }
          else
          {
              return ['class'=>'default'];
          }		  
        },*/		
		
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
			'attribute'=>'batch_id',
			'value'=>'recruitmentBatch.batch_name',
			],
			[
			'attribute'=>'Name',
			'value'=>'recruitment.name',
			],
            #'recruitment.name',
			[
			'attribute'=>'trainig_topic_id',
			'value'=>'trainingTopics.topic_name',
			],
            
            //'department_id',
            //'ecode',
            //'training_startdate',
            //'training_enddate',
            //'trainig_topic_id',
            //'batch_id',
            //'created_date',
            //'created_by',

            #['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>  
	
	
	</div>
	<?php } ?>
</div>
</div>
</div>
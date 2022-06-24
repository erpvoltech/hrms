<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PorecTrainingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use common\models\Unit;
use common\models\Department;
use app\models\RecruitmentBatch;
use yii\helpers\ArrayHelper;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="porec-training-index">
  <div class="panel panel-default">
   <div class="panel-heading text-center"> Post Recruitment Trainings</div>
    <div class="panel-body">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post Recruitment Training', ['create'], ['class' => 'btn-sm btn-success']) ?>
    </p>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],            
            'training_type',
			#'name',
			'ecode',
            //'division',			
			/*[
			'attribute'=>'unit_id',
			'value'=>'unit.name',
			],*/
			[
			'attribute'=>'department_id',
			'value'=>'department.name',
			],	
			
			[
			'attribute'=>'training_batch_id',
			'value'=>'trainingBatch.training_batch_name',
			],
			
			/*[
			'attribute'=>'batch_id',
			'value'=>'recruitmentBatch.batch_name',
			],*/
			
			
            //'training_startdate',
            //'training_enddate',
            //'trainig_topic',
            //'batch',
            //'created_date',
            //'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
   </div>
  </div>
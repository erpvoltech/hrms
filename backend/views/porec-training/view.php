<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PorecTraining */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Porec Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
  .b{
    color:#fff;
    visibility: hidden
  }
  .text{
    color: #009933 ;
    font-weight:bold;
    font-size:16px;

  }   
  .addrline {   
    border-bottom: 1px solid;
    color: #942509;
    font-weight: normal;
    font-size: 14px;   
    margin-bottom: 1em;
    padding-bottom: 2px;   
  }
  .table{
    margin-bottom:-5px;
  }
  .table-striped {
    font-size:12px;

  }
  .table-striped > tbody > tr:nth-of-type(2n+1){
    background-color: #fff  ;
    border:1px solid #fff;

  }
  .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td{
    border:1px solid #fff;  

  }
</style>
<div class="porec-training-view">
  
  <div class="panel panel-default">
    <div class="panel-heading text-center" style="font-size:18px;">Post Recruitment view</div>
    <div class="row" >
      <div class="col-lg-1"></div>

    </div>  <div class="row" style="width:100%">
      <div class="col-lg-4 b" style="width:10%">l</div>
      <div class="col-lg-8" style="width:80%"> 
        <br>
        <table class="table  table-condense" style="font-size:14px;"> 

          <div class="addrline"><span class="text" > <h1><?= Html::encode($this->title) ?></h1></span> </div>





    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'training_type',
			#'name',
			//'ecode',
            //'division',
            //'unit->name',
			/*[
                'attribute'=>'unit_id',
                'value'=> $model->unit->name,
            ],
			
			[
                'attribute'=>'department_id',
                'value'=> $model->department->name,
            ],*/
			
           
            'training_startdate',
            'training_enddate',
			
			/*[
                'attribute'=>'trainig_topic_id',
                'value'=> $model->trainingTopics->topic_name,
            ],*/
			
			/*[
                'attribute'=>'batch_id',
                'value'=> $model->recruitmentBatch->batch_name,
            ],*/
            
            'created_date',
            'created_by',
        ],
    ]) ?>
 </table>
      </div> 
    </div>
    <br> <br>
    <div class="row">
      <div class="col-lg-1"></div>
      <!--<div class="col-lg-2">   <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) ?></div>
      <div class="col-lg-2">  <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn-sm btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
      </div>-->
    </div>
	
    <br>   

  </div>
  <div class="col-lg-2 b" style="width:10%">r</div>
</div>

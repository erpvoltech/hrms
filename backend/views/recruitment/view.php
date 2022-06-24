<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Recruitment */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recruitments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recruitment-view">

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
     // clear: both;
     border-bottom: 1px solid;
     color: #942509;
     font-weight: normal;
     font-size: 14px;
     //line-height: 1.5;
     margin-bottom: 1em;
     padding-bottom: 2px;
     // font-weight:700;
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

<div class="recruitment-view ">




    <div class="panel panel-default">
        <div class="panel-heading text-center" style="font-size:18px;">Recruitment View</div>
      
        <div class="row" >
          <div class="col-lg-1"></div>
          
        </div>  <div class="row" style="width:100%">
            <div class="col-lg-4 b" style="width:10%">l</div>
            <div class="col-lg-8" style="width:80%"> 
              <br>
              <table class="table  table-condense" style="font-size:14px;"> 
                 <div class="addrline"><span class="text" ><?= Html::encode($this->title) ?></span></div>
       
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'register_no',
                                    'name',
                                    'qualification',
                                    'year_of_passing',
                                    'selection_mode',
                                    'position',
                                    'contact_no',
                                    'status',
                                    'rejected_reason:ntext',
                                    'resume',
                                ],
                            ])
                            ?>

  <div class="col-lg-1"></div> <br>
     <!--<div class="col-lg-2">  <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) ?></div>
        <div class="col-lg-2">  <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn-sm btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
            ]) ?></div>-->
     <br>
</div>
  <br>
  </div>
  </div>
 </div>

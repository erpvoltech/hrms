<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EmpPromotion */

$this->title = $model->employee->empcode;
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index']];
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
<div class="emp-promotion-view">

   <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size:18px;"> employee promotion view</div>
       <div class="panel-body">
      <div class="row" >
         <div class="col-lg-1"></div>

      </div>  <div class="row" style="width:100%">
         <div class="col-lg-4 b" style="width:10%">l</div>
         <div class="col-lg-8" style="width:80%"> 
            <br>
            <table class="table  table-condense" style="font-size:14px;"> 

               <div class="addrline"><span class="text" ><?= Html::encode($this->title) ?></span> </div>
   <table>
      <tr> 
        <th>Entry User </th>
        <td><?= $model->userdetails->username ?></td> 
        <th>Emp. Code</th><td><?= $model->employee->empcode ?></td> 
      </tr>
      <tr>
        <th>Emp. Name </th>
        <td><?= $model->employee->empname ?></td>
        <th>Effect Date</th>
        <td><?= Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy") ?></td> 
      </tr>  
      <tr> 
        <th>Salary Structure From </th>
        <td><?= $model->ss_from ?></td>  
        <th>Salary Structure To</th><td><?= $model->ss_to ?></td>
      </tr>  
      <tr>
        <th>Work Level From </th>
        <td><?= $model->wl_from ?></td>  
        <th>Work Level To</th><td><?= $model->wl_to ?></td> 
      </tr>  
      <tr> 
        <th>Grade From </th>
        <td><?= $model->grade_from ?></td> 
        <th>Grade To</th><td><?= $model->grade_to ?></td>
      </tr>  
      <tr> 
        <th>Gross From </th>
        <td><?= $model->gross_from ?></td>  
        <th>Gross To</th><td><?= $model->gross_to ?></td> 
      </tr>  

     </table>
         </div> 
      </div>
      <br> <br>
      
   <div class="row">
         <div class="col-lg-1"></div>
         <div class="col-lg-2">  <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn-sm btn-primary']) ?></div>
      <div class="col-lg-2">  <?=
      Html::a('Delete', ['delete', 'id' => $model->id], [
          'class' => 'btn-sm btn-danger',
          'data' => [
              'confirm' => 'Are you sure you want to delete this item?',
              'method' => 'post',
          ],
      ])
        ?> 
      </div>
      </div>
       </div>

      <br>   

   </div>
   <div class="col-lg-2 b" style="width:10%">r</div>
</div>


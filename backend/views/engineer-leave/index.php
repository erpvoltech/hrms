<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\grid\GridView;

$gridColumns = [
    [
        'attribute' => 'empcode',
        'label' => 'EmpCode',
        'value' => 'employee.empcode',
    ],
    [
        'label' => 'Name',
        'value' => 'employee.empname',
    ],
    [
        'label' => 'Designation',
        'value' => 'designations.designation',
    ],
    [
        'label' => 'Unit',
        'value' => 'units.name',
    ],
    [
        'label' => 'Department',
        'value' => 'department.name',
    ],
    'eligible_first_half',
    'eligible_second_half',
    'leave_taken_first_half',
    'leave_taken_second_half',
    'remaining_leave_first_half',
    'remaining_leave_second_half',
];


$this->params['breadcrumbs'][] = $this->title;
?>
<style>
   .table > thead > tr > th {
      padding: 4px;
      font-size: 11px;
   }	
</style>
<div class="emp-leave-index">
   <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size: 18px;"> Employee Leaves - Site Engineer</div>
      <div class="panel-body">
         <!--  <?=
         ExportMenu::widget([
             'dataProvider' => $dataProvider,
             'columns' => $gridColumns,
             'fontAwesome' => true,
             'dropdownOptions' => [
                 'label' => 'Export All',
                 'class' => 'btn btn-default'
             ]
         ]);
         ?> 
         <br>  <br> 
         <p>
         <?= Html::a('Create Emp Leave', ['create'], ['class' => 'btn-sm btn-primary']) ?>
         </p>
         <br>-->
         <?=
         GridView::widget([
             'dataProvider' => $dataProvider,
             'columns' => [
                 ['class' => 'yii\grid\SerialColumn'],
                 [
                     'attribute' => 'empcode',
                     'value' => 'employee.empcode',
                 ],
                 'employee.empname',
                 'eligible_first_half',
                 'eligible_second_half',
                 'leave_taken_first_half',
                 'leave_taken_second_half',
                 'remaining_leave_first_half',
                 'remaining_leave_second_half',
                 ['class' => 'yii\grid\ActionColumn',
                     'template' => '{update}',
                 ],
             ],
         ]);
         ?>
      </div>
   </div>
</div>

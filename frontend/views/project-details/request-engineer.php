<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Unit;
use app\models\Department;
use app\models\Designation;
use yii\helpers\ArrayHelper;

use yii\bootstrap\ActiveForm;
error_reporting(0);
/*
if (Yii::$app->request->queryParams['EmpDetailsSearch']["unit_id"])
		   $unit = Yii::$app->request->queryParams['EmpDetailsSearch']["unit_id"];
		else
		   $unit = NULL; 

if (Yii::$app->request->queryParams['EmpDetailsSearch']["designation_id"])
		   $design = Yii::$app->request->queryParams['EmpDetailsSearch']["designation_id"];
		else
		   $design = NULL; 
	   
if (Yii::$app->request->queryParams['EmpDetailsSearch']["department_id"])
		   $dept = Yii::$app->request->queryParams['EmpDetailsSearch']["department_id"];
		else
		   $dept = NULL; */

?>

<style>
   .glyphicon {
      padding-right:10px;
   } table{
      background-color:#DFDFDF;

   }

</style>
<?php  echo $this->render('_empsearch', ['model' => $searchModel]); ?>
<div class="emp-details-index" >
   <?php 
   $gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
		   'empcode',
		   'empname',          
           [
               'attribute' => 'designation_id',
               'value' => 'designation.designation',
           ],
		   [
               'attribute' => 'department_id',
               'value' => 'department.name',
           ],		   
		   [
               'attribute' => 'unit_id',
               'value' => 'units.name',
           ],
		    [
               'attribute' => 'division_id',
               'value' => 'division.division_name',
           ], 
		   [
                       'class' => 'yii\grid\ActionColumn',
                       'template' => '{request} {change}',
                   'buttons' => [
                     'request' => function ($model,$key) {
                     return Html::a(
                     'Req. Engg',
                     ['eng-req','id' => $key->id],[ 'target'=>'_blank','data-pjax' => 0]);                   
                     },
					  'change' => function ($model,$key) {

                     return Html::a(
                     'ChangeDivision',
                     ['engineer-transfer','id' => $key->id],['data-pjax' => 0]);                   
                     },
                     ],
                   ],
		  
]; 
/*
$gridColumnsdisplay = [
			['class' => 'yii\grid\SerialColumn'],
		   'empcode',
		   'empname',
           'doj',
           [
               'attribute' => 'designation_id',
               'value' => 'designation.designation',
           ],
		   [
               'attribute' => 'department_id',
               'value' => 'department.name',
           ],		   
		   [
               'attribute' => 'unit_id',
               'value' => 'units.name',
           ],
		    [
               'attribute' => 'division_id',
               'value' => 'division.division_name',
           ], 
		  'remuneration.gross_salary',
		  'status',
		   [
                       'class' => 'yii\grid\ActionColumn',
                       'template' => '{view} {update}   {delete} {file}',
                   'buttons' => [
                     'file' => function ($model,$key) {

                     return Html::a(
                     '<span class="glyphicon glyphicon-list-alt"></span>',
                     ['user-files','id' => $key->empcode],[ 'target'=>'_blank','data-pjax' => 0]);                   
                     },
                     ],
                   ],
];*/
?>
  <?= GridView::widget([
       'dataProvider' => $dataProvider,       
       'columns' => $gridColumns,
           ]);
           ?>


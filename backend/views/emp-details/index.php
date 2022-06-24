<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use app\models\Unit;
use app\models\Department;
use app\models\Designation;
use app\models\EmpAddress;
use app\models\AppointmentLetter;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use yii\bootstrap\ActiveForm;
error_reporting(0);

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
		   $dept = NULL; 

?>

<style>
   .glyphicon {
      padding-right:10px;
   } table{
      background-color:#DFDFDF;

   }

</style>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="emp-details-index" >

   <div class="row">  



      <div class="pull-left" style="padding-left: 50px">
         <?= Html::a('Create Emp Details', ['create'], ['class' => ' btn-sm btn-success']) ?>

      </div>
	   <div class="pull-left" style="padding-left: 40px">
	   
	   <?= Html::a('Emp Push', '../../../push/importEngineer.php', ['class' => 'btn-sm btn-primary', 'target' => '_blank']) ?>
	   </div>
   </div>
   <br><br></br>
   <?php 
   $gridColumns = [
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
]; 

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
]; ?>

  <?= GridView::widget([
       'dataProvider' => $dataProvider,
       'toolbar' =>  [        
       ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'options' => ['id'=>'expMenu1'], // optional to set but must be unique
    'target' => ExportMenu::TARGET_BLANK
	]), 
    ],
       'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Employee Details</h3>',
       ],
       'columns' => $gridColumnsdisplay,
           ]);
           ?>


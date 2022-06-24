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
use yii\data\ActiveDataProvider;
error_reporting(0);

echo $this->render('newjoin_search', ['model' => $searchModel]); 


 /*$dataProvider = new ActiveDataProvider([
            'query' => $model,
			'pagination' => [ 'pageSize' => 20 ],
 ]); */
		
		
		$gridColumnsdisplay = [
		   ['class' => 'yii\grid\SerialColumn'],
		   'empcode',
		   'empname',
           'doj',
           [
               'attribute' => 'designation_id',
               'value' => 'designation.designation',
           ],          
          /// 'remuneration.work_level',
		   [
               'attribute' => 'department_id',
               'value' => 'department.name',
           ],		   
		   ['label' => 'Unit/Division',
                        'format' => 'raw',
                        'value' => function ($model) {                           
                            return $model->units->name .' / '. $model->division->division_name;
                        },
           ], 	
		   'mobileno',
          // 'dateofleaving',
		  // 'last_working_date',
		  // 'resignation_date',            
];

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
   'empcode',
		   'empname',
           'doj',
           [
               'attribute' => 'designation_id',
               'value' => 'designation.designation',
           ],          
          /// 'remuneration.work_level',
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
           
		  // 'remuneration.gross_salary',
          
           //'worktype',
           //'email:email',
           //'alternativeemail:email',
           'mobileno',
           //'alternativemobileno',
           //'referedby',
           //'probation',
           //'appraisalmonth',
           //'recentdop',
           //'dateofleaving',
		  // 'last_working_date',
		  // 'resignation_date',
          // 'reasonforleaving:ntext',
           //'photo',   
];

?>
<div class="emp-details-index" >

   <?=
   GridView::widget([
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
          
</div>

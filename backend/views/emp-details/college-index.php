<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use app\models\Unit;
use app\models\Department;
use app\models\Designation;
use app\models\EmpAddress;
use common\models\College;
use yii\helpers\ArrayHelper;
use kartik\spinner\Spinner;
use common\models\EmpEducationdetails;
use common\models\EmpDetails;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
error_reporting(0);

		$query = EmpDetails::find();
        $query->joinWith(['units','division','employeeEducationDetail']);

		$query->FilterWhere(['emp_educationdetails.institute' => $_GET['id']]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		$collegequery = College::find()->where(['id'=>$_GET['id']])->one();
?>
<div class="emp-details-index" >
   <br><br></br>
   <?php Pjax::begin(); ?>
   <?=
   GridView::widget([
       'dataProvider' => $dataProvider,
      'toolbar' => [
                        '{toggleData}',
                        ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'showConfirmAlert' => false,
                            'exportConfig' => [
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_HTML => false,
                                ExportMenu::FORMAT_EXCEL => false,
                                ExportMenu::FORMAT_CSV => false,
                               
                            ],
                            'dropdownOptions' => [
                                'label' => 'Export All',
                                'class' => 'btn btn-secondary'
                            ]
                        ]),
                    ],
       'panel' => [
           'type' => 'info',
           'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-education"></i> '.$collegequery->collegename.'</h3>',
       ],
       'columns' => [
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
		   'remuneration.gross_salary',   
                  
               ],
           ]);
           ?>
           <?php Pjax::end(); ?>
         
</div>

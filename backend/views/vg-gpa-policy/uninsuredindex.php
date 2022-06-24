<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Division;
use common\models\EmpStatutorydetails;
use common\models\EmpPersonaldetails;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveQuery;
use yii\base\Model;
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

</style>
<div class="vg-insurance-agents-view">
    <div class="panel-heading">
        <h3 class="panel-title" style="text-align: center;">

        </h3>
    </div>
    <?php
    $query = new Query;
    $query = EmpDetails::find()->joinWith(['employeeStatutoryDetail'])
           ->where(['emp_details.status' => 'Active'])
		   ->andWhere(['<>','emp_statutorydetails.gpa_applicability' , 'No'])
           ->andWhere(['or',
				
				['emp_statutorydetails.gpa_no'=>NULL],
				['emp_statutorydetails.gpa_no'=>'']
			]);
            


    $dataProvider = new ActiveDataProvider([
        'query' => $query,
            /*   'pagination' => [
              'pageSize' => 5,
              ], */
    ]);
    ?>
    
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'autoXlFormat'=>true,
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    'export'=>[
        'showConfirmAlert'=>false
    ],
        
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> GPA Uninsured List </h3>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'empcode',
            'empname',
            [
                'attribute' => 'designation_id',
                'value' => 'designation.designation',
            ],
            [
                'attribute' => 'division_id',
                'value' => 'division.division_name',
            ],
            [
                'attribute' => 'unit_id',
                'value' => 'units.name',
            ],
            [   'attribute' => 'Date of Join',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'doj'
            ],
            [
                'attribute' => 'Date of Birth',
                'format' => ['date', 'php:d-m-Y'],
                'value' => 'employeePersonalDetail.dob',
            ],
        //['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>



<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Division;
use common\models\EmpStatutorydetails;
use common\models\EmpRemunerationDetails;
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
    /*SELECT A.id FROM `emp_details` AS A JOIN emp_remuneration_details AS B JOIN emp_statutorydetails AS C 
    ON A.id=B.empid AND A.id=C.empid WHERE A.status='Active' AND B.gross_salary >= 21000 AND 
    C.gmc_no IS NULL OR C.gmc_no=''*/
    $query = new Query;
    $query = EmpDetails::find()->joinWith(['remuneration', 'employeeStatutoryDetail'])
            ->where(['IN', 'emp_statutorydetails.gmc_no', ['']])
            ->orWhere(['IS', 'emp_statutorydetails.gmc_no', NULL])
            ->andOnCondition(['<>','emp_statutorydetails.gmc_applicability', 'No'])
			->andOnCondition(['IN','emp_details.status', ['Active','']]);
            
            //->andWhere('emp_remuneration_details.gross_salary >= :gross_salary',[':gross_salary' => 21000])
            
             
    
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
            /*   'pagination' => [
              'pageSize' => 5,
              ], */
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'autoXlFormat'=>true,
    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
    'export'=>[
        'showConfirmAlert'=>false
    ],
        'panel' => [
            'type' => 'info',
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> GMC Uninsured List </h3>',
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
    ]); ?>
</div>



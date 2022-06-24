<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use common\models\EmpDetails;

$query = new Query;
$query = EmpDetails::find()->joinWith(['employeeStatutoryDetail'])
        ->where(['IS NOT', 'emp_statutorydetails.gmc_no', NULL])
        ->andWhere(['NOT IN', 'emp_statutorydetails.gmc_no', ['']])
        ->andOnCondition(['<>', 'emp_details.status', 'Active']);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
        ]);

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'attribute' => 'Policy No',
        'value' => 'employeeStatutoryDetail.gmc_no',
    ],
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
    'status',
    [
        'attribute' => 'Resignation Date',
        'format' => ['date', 'php:d-m-Y'],
        'value' => 'resignation_date',
    ],
    [
        'attribute' => 'Last Working Date',
        'format' => ['date', 'php:d-m-Y'],
        'value' => 'last_working_date',
    ],
    [
        'attribute' => 'Date of Leaving',
        'format' => ['date', 'php:d-m-Y'],
        'value' => 'dateofleaving',
    ],
    /*['class' => 'kartik\grid\ActionColumn', 'urlCreator' => function() {
            return '#';
        }]*/
];


 
 echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'panel' => [
            'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Employee Relieved List - GMC</h5>',
            'type' => 'info',
    ],
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
        ExportMenu::FORMAT_PDF => false,
    ],
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-secondary'
    ]
]),
    ], 
]);

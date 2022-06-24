<?php

use common\models\EmpDetails;
use common\models\EmpRemunerationDetails;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;

/*
$query = EmpDetails::find()->orderBy(['unit_id' => SORT_ASC]);
$query->joinWith(['department', 'units']);
$dataProvider = new ActiveDataProvider([
    'query' => $query,
        ]); */
echo $this->render('_search', ['model' => $searchModel]); 
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'empcode',
    'empname',
    [
        'attribute' => 'designation_id',
        'value' => 'designation.designation',
    ],
    'doj',
    'recentdop',
    'remuneration.work_level',
    'remuneration.grade',
    'remuneration.gross_salary',
    [
        'attribute' => 'unit_id',
        'value' => 'units.name',
    ],
    [
        'attribute' => 'department_id',
        'value' => 'department.name',
    ],   
    'email:email',   
    'mobileno',  
    'employeeEducationDetail.qualification',
    'employeeEducationDetail.yop',
    'referedby',
    'probation',
    'appraisalmonth',
    'recentdop',
    'dateofleaving',
    'reasonforleaving:ntext',
];
echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-secondary'
    ]
]);
?>
<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'empcode',
        'empname',
        [
            'attribute' => 'designation_id',
            'value' => 'designation.designation',
        ],
        'doj',
        'recentdop',
        'remuneration.work_level',
        'remuneration.grade',
        'remuneration.gross_salary',
        [
            'attribute' => 'unit_id',
            'value' => 'units.name',
        ],
        [
            'attribute' => 'department_id',
            'value' => 'department.name',
        ],
        'email:email',
        'mobileno',
    ],
]);
?>

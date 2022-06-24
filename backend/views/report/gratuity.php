<?php

use common\models\EmpDetails;
use common\models\EmpRemunerationDetails;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;

echo $this->render('_gratuitysearch', ['model' => $searchModel]); 
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'empcode',
    'empname',
    [
        'attribute' => 'designation_id',
        'value' => 'designation.designation',
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
		'attribute' => 'doj',
		'format' => ['date', 'php:d-m-Y'],
		'value' => 'doj',
	],
	
	[
		'attribute' => 'birthday',
		'format' => ['date', 'php:d-m-Y'],
		'value' => 'employeePersonalDetail.birthday',
	],
  'remuneration.basic',
  [
        'header' => 'DA',		
		'value' => 'remuneration.dearness_allowance',
		
  ],
 
  
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
     'columns' => $gridColumns,
]);
?>

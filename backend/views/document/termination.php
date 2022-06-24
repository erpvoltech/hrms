<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use common\models\Document;
use common\models\EmpDetails;
use common\models\Division;
use common\models\EmpAddress;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use yii\widgets\Pjax;


$this->title = 'All Termination Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">
  <h1><?= Html::encode($this->title) ?></h1>
 <?php echo $this->render('termination-search', ['model' => $searchModel]); ?>  
<br></br>
  <?php
  Pjax::begin(['id' => 'pjax-showcause']);
	
  $gridColumns = [
	[
			'label' =>'Issued Date',
			'attribute' => 'date',
			'format' => ['date', 'php:d-m-Y'],
			'value' => 'date',
		],
       'employee.empcode',     
       'employee.empname',
	    [
				'attribute' => 'last_working_date',
				'format' => ['date', 'php:d-m-Y'],
				'value' => 'last_working_date',
		],   
      [
        'header' => 'Unit',
        'value' => 'employee.units.name',
      ],
	  [									
			'header' => 'Division',
			'value' => 'employee.division.division_name',
		],
		[	
			'header' => 'Department',
			'value' => 'employee.department.name',
		],
	   
      
      
	];
	
  echo GridView::widget([
    'dataProvider' => $dataProvider,
					 'panel' => [
								'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Termination </h5>',
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
                               
                            ],
                            'dropdownOptions' => [
                                'label' => 'Export All',
                                'class' => 'btn btn-secondary'
                            ]
                        ]),
                    ],
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
		[
			'label' =>'Issued Date',
			'attribute' => 'date',
			'format' => ['date', 'php:d-m-Y'],
			'value' => 'date',
		],
       'employee.empcode',     
       'employee.empname',  
	   [
				'attribute' => 'last_working_date',
				'format' => ['date', 'php:d-m-Y'],
				'value' => 'last_working_date',
		],
       [
        'header' => 'Unit',
        'value' => 'employee.units.name',	

      ],
	  [									
			'header' => 'Division',
			'value' => 'employee.division.division_name',
		],
		[	
			'header' => 'Department',
			'value' => 'employee.department.name',
		],
      
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update}',
        'buttons' => [
          'update' => function ($url,$model) {
            return Html::a(
              '<span class="glyphicon glyphicon-eye-open"></span>',
              $url, ['target' => '_blank']);
            },
          ],
        ],
      ],
    ]);
    ?>
    <?php Pjax::end(); ?>

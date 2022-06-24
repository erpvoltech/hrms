<?php
error_reporting(0);
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use common\models\EmpDetails;
use common\models\Bonus;
use yii\jui\DatePicker;
use yii\data\ActiveDataProvider;
use yii\db\Query;


 $query = new Query;
 
 
	$query = Bonus::find()->joinWith(['employee']);												
						
						
    $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 50, 
                    ],
                ]);
				
	$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],							
							[
								'header' => 'Emp. Code',
								'value' => 'employee.empcode',
							],
							[
								'header' => 'Emp. Name',
								'value' => 'employee.empname',
							],
							[							
								'header' => 'Unit',
								'value' => 'employee.units.name'
							],
							[
								'header' => 'Department',
								'value' => 'employee.department.name',
							],
							'amount',
							 [ 'label' => 'Send Mail',
							   'format' => 'raw',
							   'value' => function ($model) {
							   if($model->mail_status == 0){
									return Html::a('<span class="glyphicon glyphicon-envelope"> Send </span>', ['bonus-mail', 'id' => $model->id]);              
								   } else {
									return Html::a('<span class="glyphicon glyphicon-envelope"> Re-send </span>', ['bonus-mail', 'id' => $model->id]);        
								   }                 
							   },
						    ],
						];
						
						  echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'panel' => [
                        'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Bonus Report </h5>',
                        'type' => 'info',
                    ],
                    'toolbar' => [
					Html::a('Send All Mail', ['bonus-allmail'], ['class'=>'btn btn-md btn-default','style'=>'margin-right:30px']),
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
                ]);
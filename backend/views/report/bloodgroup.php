<?php
error_reporting(0);
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use yii\jui\DatePicker;
use yii\data\ActiveDataProvider;
use yii\db\Query;

echo $this->render('_bgsearch', ['model' => $searchModel]); 
?>


    <div class="panel panel-default">
      
       
                <?php
				
				
              /*  $query = new Query;
				
				$query = EmpDetails::find()->joinWith(['employeePersonalDetail'])												
						->Where(['in', 'emp_details.status', ['Active','Notice Period']]);
						
				

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 50, 
                    ],
                ]); */
			
						$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
							'empcode',
							'empname',
							[
								'attribute' => 'designation_id',
								'value' => 'designation.designation',
							],
							[							
								'attribute' => 'unit_id',
								'value' => 'units.name'
							],
							[
								'attribute' => 'department_id',
								'value' => 'department.name',
							],							
							'category',
							[
								'attribute' => 'blood_group',
								'value' => 'employeePersonalDetail.blood_group',
							],
							['attribute' => 'Date of Join',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'doj'
							],
							'email',
							'mobileno',
							[
								'attribute' => 'mobile_no',								
								'value' => 'employeePersonalDetail.mobile_no',
							],
							
						];
				
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'panel' => [
                        'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i> Blood Group Report </h5>',
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
                ]);
                ?>
            </div>       




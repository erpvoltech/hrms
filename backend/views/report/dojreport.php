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

if ($_GET['doj'] != '') {
    $model->doj = $_GET['doj'];
    $fd = Yii::$app->formatter->asDate($_GET['doj'], "yyyy-MM-dd");
}
if ($_GET['dojto'] != '') {
    $model->dojto = $_GET['dojto'];
    $td = Yii::$app->formatter->asDate($_GET['dojto'], "yyyy-MM-dd");
}


if($_GET['type'] != '') {
	if($_GET['type'] =='birthday' || $_GET['type'] =='dob' || $_GET['type'] =='marriage'){
		$model->report_type = $_GET['type'];
		$type = $_GET['type'];
		 $fd = Yii::$app->formatter->asDate($_GET['doj'], "dd");
		 $td = Yii::$app->formatter->asDate($_GET['dojto'], "dd");
		 
		 $fm = Yii::$app->formatter->asDate($_GET['doj'], "MM");
		 $tm = Yii::$app->formatter->asDate($_GET['dojto'], "MM");
		 
	} else if($_GET['type'] =='yop'){
		 $model->report_type = $_GET['type'];
		 $type = $_GET['type'];
		 $fy = Yii::$app->formatter->asDate($_GET['doj'], "yyyy");
		 $ty = Yii::$app->formatter->asDate($_GET['dojto'], "yyyy");
	} else {
		$model->report_type = $_GET['type'];
		$type = $_GET['type'];
	}
    
}
?>

<div class="emp-details-form">
    <div class="panel panel-default">
        <div class="panel-heading"><i class="fa fa-calendar"> Date Based Report</i></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'doj')->label('From Date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
                <div class="col-sm-4">
                    <?=
                    $form->field($model, 'dojto')->label('To Date')->widget(DatePicker::className(), [
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
                        'clientOptions' => [
                            'dateFormat' => 'dd-MM-yyyy',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                    ])
                    ?>
                </div>
				
				<div class="col-sm-4"> 
                    <?=
                    $form->field($model, 'report_type')->label('Report')->dropDownList(['dob'=>'Birthday (as per document)','birthday'=>'Birthday', 'doj' => 'Date of Joining','confirmation_date' => 'Confirmation Date','recentdop' => 'Last Promotion Date','last_working_date' => 'Last Working Date','resignation_date'=>'Resignation Date','dateofleaving' => 'Date of Leaving','marriage'=>'Marriage Date','yop'=>'Year of Passing'], ['prompt' => ' '])
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4"></div>
                <div class="form-group col-lg-4">
                    <?= Html::submitButton('Go', ['class' => 'btn btn-primary']) ?>
                </div>
				 <div class="form-group col-lg-4" style="text-align:right;color:blue;font-size:11px;padding-top:15px">
                   Birthday and Marriage Date Report Based on Month Only.<br>
				   Year of passing based on Year Only.
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

        <?php if (isset($_GET['doj']) && isset($_GET['dojto'])) { ?>
            <div>
                <?php
                $query = new Query;
								
				if($type == 'birthday') {
					 $query = EmpDetails::find()->joinWith(['employeePersonalDetail'])
						->where(["between",'MONTH(emp_personaldetails.birthday)',$fm,$tm])
						//->andWhere(["between",'DAY(emp_personaldetails.birthday)',$fd,$td])						
						->andWhere(['in', 'emp_details.status', ['Active','Notice Period']])
						->orderBy(['DAY(emp_personaldetails.birthday)'=>SORT_ASC]);
					} else if($type == 'dob') {
					 $query = EmpDetails::find()->joinWith(['employeePersonalDetail'])
						->where(["between",'MONTH(emp_personaldetails.dob)',$fm,$tm])
						//->orWhere(["between",'DAY(emp_personaldetails.dob)',$fd,$td])
						->andWhere(['in', 'emp_details.status', ['Active','Notice Period']])
						->orderBy(['DAY(emp_personaldetails.dob)'=>SORT_ASC]); 
					} else if($type == 'marriage') {
					 $query = EmpDetails::find()->joinWith(['employeePersonalDetail'])
						->where(["between",'MONTH(emp_personaldetails.year_of_marriage)',$fm,$tm])
						//->orWhere(["between",'DAY(emp_personaldetails.year_of_marriage)',$fd,$td])
						->andWhere(['in', 'emp_details.status', ['Active','Notice Period']])
						->orderBy(['DAY(emp_personaldetails.year_of_marriage)'=>SORT_ASC]); 
					} else if($type == 'yop'){
						 $query = EmpDetails::find()->joinWith(['employeeEducationDetail'])
						->where(["between",'emp_educationdetails.yop',$fy,$ty])						
						->andWhere(['in', 'emp_details.status', ['Active','Notice Period']])
						->orderBy(['emp_educationdetails.yop'=>SORT_ASC]); 
					}else {
					 $query = EmpDetails::find() ->where(["between", $type, $fd, $td])
						->orderBy(['doj'=>SORT_ASC,]);					
					}
               
				//MONTH

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 50, 
                    ],
                ]);
				if($type == 'doj'){
						$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
							'empcode',
							'empname',
							[
								'attribute' => 'designation_id',
								'value' => 'designation.designation',
							],
							[
							'header'=>'Unit / Division',
								'attribute' => 'division_id',
								'value' => 'division.division_name',
							],
							[
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',
							['attribute' => 'Date of Join',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'doj'
							],
							['attribute' => 'Last Working Date',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'last_working_date'
							],
							
							'email',
							'mobileno',
							'status',
						];
				} else if($type == 'confirmation_date'){
					$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
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
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',
							['attribute' => 'Date of Join',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'doj'
							],
							
							['attribute' => 'Date of Confirm',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'confirmation_date'
							],
							'email',
							'mobileno',
						];
				} else if($type == 'recentdop'){
					$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
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
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',
							['attribute' => 'Date of Join',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'doj'
							],							
							['attribute' => 'Latest Promotion Date',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'recentdop'
							],
							'email',
							'mobileno',
						];
				} else if($type == 'last_working_date'){
						$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
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
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',
							['attribute' => 'Date of Join',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'doj'
							],
							['attribute' => 'Last Working Date',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'last_working_date'
							],							
							'email',
							'mobileno',
						];
				} else if($type == 'resignation_date'){
						$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
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
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',
							['attribute' => 'Date of Join',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'doj'
							],
							['attribute' => 'Date of Resignation',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'resignation_date'
							],
							'email',
							'mobileno',
						];
				} else if($type == 'dateofleaving'){				
						$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
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
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',
							['attribute' => 'Date of Join',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'doj'
							],
							['attribute' => 'Date of Leaving',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'dateofleaving'
							],							
							'email',
							'mobileno',							
							[
								'attribute' => 'reasonforleaving',
								'value' => function ($model) { 
									return str_replace(array("\r\n"), ' ', $model->reasonforleaving); 
									},
							],	
							
						];
				} else if($type == 'birthday'){
					$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
							'empcode',
							'empname',
							[
								'attribute' => 'designation_id',
								'value' => function ($model) {   
								  if($model->units->name == 'VG'){
									  $unit ='VEPL';
									  } else {
									   $unit =$model->units->name;
									  }
									return $model->designation->designation.' ('. $unit.')';
									},
							],
							[
								'attribute' => 'birthday',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'employeePersonalDetail.birthday',
							],
							[   'label'=>'Day',
							    'attribute' => 'birthday',
								'format' => ['date', 'php:d'],
								'value' => 'employeePersonalDetail.birthday'
							],	
							[									
								'attribute' => 'division_id',
								'value' => 'division.division_name',
							],
							[	
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',							
							'email',
							'mobileno',
						];
				}  else if($type == 'dob'){
					$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
							'empcode',
							'empname',
							[
								'attribute' => 'designation_id',
								'value' => function ($model) {   
								  if($model->units->name == 'VG'){
									  $unit ='VEPL';
									  } else {
									   $unit =$model->units->name;
									  }
									return $model->designation->designation.' ('. $unit.')';
									},
							],
							[
								'attribute' => 'dob',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'employeePersonalDetail.dob',
							],
								
							[									
								'attribute' => 'division_id',
								'value' => 'division.division_name',
							],
							[	
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',							
							'email',
							'mobileno',
						];
				} else if($type == 'marriage'){
					$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
							'empcode',
							'empname',
							[
								'attribute' => 'designation_id',
								'value' => function ($model) {   
								  if($model->units->name == 'VG'){
									  $unit ='VEPL';
									  } else {
									   $unit =$model->units->name;
									  }
									return $model->designation->designation.' ('. $unit.')';
									},
							],
							[
								'attribute' => 'birthday',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'employeePersonalDetail.birthday',
							],
							[
								'attribute' => 'year_of_marriage',
								'format' => ['date', 'php:d-m-Y'],
								'value' => 'employeePersonalDetail.year_of_marriage',
							],
								
							[									
								'attribute' => 'division_id',
								'value' => 'division.division_name',
							],
							[	
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],
							'category',							
							'email',
							'mobileno',
						];
				} else if($type == 'yop'){
					$gridColumns = [
							['class' => 'kartik\grid\SerialColumn'],
							'empcode',
							'empname',
							[
								'attribute' => 'designation_id',
								'value' => function ($model) {   
								  if($model->units->name == 'VG'){
									  $unit ='VEPL';
									  } else {
									   $unit =$model->units->name;
									  }
									return $model->designation->designation.' ('. $unit.')';
									},
							],							
								
							[									
								'attribute' => 'division_id',
								'value' => 'division.division_name',
							],
							[	
								'attribute' => 'department_id',
								'value' => 'department.name',
							],
							[
								'attribute' => 'unit_id',
								'value' => 'units.name',
							],							
							[
								'attribute' => 'course',
								'value' => function ($model) { 
								if($model->employeeEducationDetail->courses->coursename != ''){
									return $model->employeeEducationDetail->qualifications->qualification_name .'('.$model->employeeEducationDetail->courses->coursename.')';
									} else {
									return $model->employeeEducationDetail->qualifications->qualification_name;
									}
								},
							],	
							[
								'attribute' => 'institute',
								'value' => 'employeeEducationDetail.college.collegename',
							],
							[
								'attribute' => 'yop',
								'value' => 'employeeEducationDetail.yop',
							],
							'category',							
							'email',
							'mobileno',
						];
				}
				
				if($_GET['type'] =='birthday' || $_GET['type'] =='dob'){
					$title = ' Birthday List'; 
				} else if($_GET['type'] =='marriage'){
					$title = 'Marriage List'; 
				} else {				
					$title = $type. ' List' . ' From ' . date('d-M-Y', strtotime($fd)) . ' To ' . date('d-M-Y', strtotime($td)); 
				}
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'panel' => [
                        'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>' . $title . '</h5>',
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
        <?php } ?>
    </div>
</div>


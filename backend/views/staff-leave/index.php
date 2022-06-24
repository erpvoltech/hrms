<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use common\models\EmpLeaveCounter;

$gridColumns = [
    [
        'attribute' => 'empid',
        'label' => 'EmpCode',
        'value' => 'employee.empcode',
    ],
    [
	'label' => 'Name',
        'value' => 'employee.empname',
    ],
    [
        'label' => 'Designation',
        'value' => 'designations.designation',
    ],
    [
        'label' => 'Unit',
        'value' => 'units.name',
    ],
    [
        'label' => 'Department',
        'value' => 'department.name',
    ],
    'eligible_first_quarter',
    'eligible_second_quarter',
    'eligible_third_quarter',
    'eligible_fourth_quarter',
    'leave_taken_first_quarter',
    'leave_taken_second_quarter',
    'leave_taken_third_quarter',
    'leave_taken_fourth_quarter',
    'remaining_leave_first_quarter',
    'remaining_leave_second_quarter',
    'remaining_leave_third_quarter',
    'remaining_leave_fourth_quarter',
];

$this->params['breadcrumbs'][] = $this->title;


?>
<style>
	

</style>
<div class="emp-leave-staff-index">
  
        <?=
         ExportMenu::widget([
             'dataProvider' => $dataProvider,
             'columns' => $gridColumns,
             'fontAwesome' => true,
             'dropdownOptions' => [
                 'label' => 'Export All',
                 'class' => 'btn btn-default'
             ]
         ]);
         ?> 

         <br>  <br>  
        <!-- <p>
         <?= Html::a('Create Leave', ['create'], ['class' => 'btn btn-success']) ?>
         </p>  -->

         <?=
         GridView::widget([
             'dataProvider' => $dataProvider,
			
             'columns' => [
                
                 [
                     'attribute' => 'empid',
                     'value' => 'employee.empcode',
                 ],
				 'employee.empname',
				/* [					
					'label'=>'April',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-04-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],[					
					'label'=>'May',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-05-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				 [					
					'label'=>'June',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-06-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				 [					
					'label'=>'July',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-07-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'Aug',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-08-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'Sep',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-09-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'Oct',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-10-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'Nov',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-11-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'Dec',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y-1;
							  } else {
							  $year = $y;
							  }
							$month = $year.'-12-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'Jan',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y;
							  } else {
							  $year = $y + 1;
							  }
							$month = $year.'-01-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'Feb',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y;
							  } else {
							  $year = $y + 1;
							  }
							$month = $year.'-02-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ],
				  [					
					'label'=>'March',
					'format'=>'raw',					
					'content'=>function($model){
							 $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));
						  $y = date("Y", strtotime($created_at));
						  if($m<4){
							  $year = $y;
							  } else {
							  $year = $y + 1;
							  }
							$month = $year.'-03-01';
						$counter = EmpLeaveCounter::find()->where(['empid'=>$model->empid,'month'=>$month])->one();						
						return $counter['leave_days'];
					}
				 ], */
				 [					
					'label'=>'Q1 Leave',
					'format'=>'raw',					
					'content'=>function($model){						
							    return $model->leave_taken_first_quarter;
							   }						
				 ],
				 [					
					'label'=>'Q2 Leave',
					'format'=>'raw',					
					'content'=>function($model){						
							    return $model->	leave_taken_second_quarter;
							   }						
				 ],
				 [					
					'label'=>'Q3 Leave',
					'format'=>'raw',					
					'content'=>function($model){						
							    return  $model->leave_taken_third_quarter;
							   }						
				 ],
				 [					
					'label'=>'Q4 Leave',
					'format'=>'raw',					
					'content'=>function($model){						
							    return  $model->leave_taken_fourth_quarter;
							   }						
				 ],
				 [					
					'label'=>'Total Leave',
					'format'=>'raw',					
					'content'=>function($model){						
							    return $model->leave_taken_first_quarter + $model->	leave_taken_second_quarter + $model->leave_taken_third_quarter + $model->leave_taken_fourth_quarter;
							   }						
				 ],
				 [					
					'label'=>'Q1 Remaining',
					'format'=>'raw',					
					'content'=>function($model){						
							    return $model->remaining_leave_first_quarter;
							   }						
				 ],
				 [					
					'label'=>'Q2 Remaining',
					'format'=>'raw',					
					'content'=>function($model){						
							    return $model->	remaining_leave_second_quarter;
							   }						
				 ],
				 [					
					'label'=>'Q3 Remaining',
					'format'=>'raw',					
					'content'=>function($model){						
							    return  $model->remaining_leave_third_quarter;
							   }						
				 ],
				 [					
					'label'=>'Q4 Remaining',
					'format'=>'raw',					
					'content'=>function($model){						
							    return  $model->remaining_leave_fourth_quarter;
							   }						
				 ],
				 [					
					'label'=>'Current Balance',
					'format'=>'raw',					
					'content'=>function($model){
						  $created_at = date('Y-m-d H:i:s');
						  $m = date("m", strtotime($created_at));						
							   if ($m > 3 && $m <= 6) {
							     return $model->remaining_leave_first_quarter;
							   } else  if ($m > 6 && $m <= 9) {
										if( $model->remaining_leave_first_quarter > 0){
											 return $model->remaining_leave_first_quarter + $model->remaining_leave_second_quarter;
										  } else {
											 return $model->remaining_leave_second_quarter;
										  }
							 
							   } else  if ($m > 9 && $m <= 12) {							   
									 										
										if( $model->remaining_leave_first_quarter > 0){
											 $q3_one = $model->remaining_leave_first_quarter + $model->remaining_leave_second_quarter;
										  }  else {
											 $q3_one = $model->remaining_leave_second_quarter;
										  }										  
										if($q3_one > 0){
											return $model->remaining_leave_third_quarter + $q3_one;
										 } else {
											return $model->remaining_leave_third_quarter; 
										 }															 
							   } else {							   
										if( $model->remaining_leave_first_quarter > 0){
											 $q4_one = $model->remaining_leave_first_quarter + $model->remaining_leave_second_quarter;
										} else {
											$q4_one =  $model->remaining_leave_second_quarter;
										}
										
										if($q4_one > 0){
											 $q4_two = $model->remaining_leave_third_quarter + $q4_one;
										} else {
											 $q4_two = $model->remaining_leave_third_quarter;
										}
										
										if($q4_two > 0){
											return $model->remaining_leave_fourth_quarter + $q4_two;
											} else {
											return $model->remaining_leave_fourth_quarter;
											}
							   }							
						}
				 ],
				 [					
					'label'=>'Year Balance',
					'format'=>'raw',					
					'content'=>function($model){						
							   $yb = 0;
							     if( $model->remaining_leave_first_quarter > 0){
									 $yb += $model->remaining_leave_first_quarter;
									 }
								  if( $model->remaining_leave_second_quarter > 0){
									 $yb += $model->remaining_leave_second_quarter;
									 }
								  if( $model->remaining_leave_third_quarter > 0){
									 $yb += $model->remaining_leave_third_quarter;
									 }
									 if( $model->remaining_leave_fourth_quarter > 0){
									 $yb += $model->remaining_leave_fourth_quarter;
									 }
							    return $yb;	
					}						
				 ],
             ],
         ]);
         ?>
     
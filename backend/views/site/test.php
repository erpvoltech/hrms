<?php

use common\models\EmpDetails;
use common\models\EmpSalary;
use common\models\EmpLeaveCounter;
use common\models\EmpPersonaldetails;
use common\models\SalaryMonth;
use app\models\VgInsuranceVehicle;
use app\models\VgInsuranceBuilding;
use app\models\VgInsuranceEquipment;
use yii\bootstrap\Modal;

 Yii::$app->hrcomponent->promotion();
 Yii::$app->hrcomponent->leave_assign();
 error_reporting(0);
$this->title = 'HRMS';

$sal = EmpSalary::find()->orderBy(['id'=> SORT_DESC])->one();

?>
 
<div class="site-index" >

   <div class="body-content">
      <section class="content-header">
         <h1>
            Dashboard          
         </h1>        
      </section>
     <style>
       table {
    border-collapse: collapse;
    border-spacing: 0;
}
/* Addition */
/* Apply a natural box layout model to all elements */
/* Read this post by Paul Irish: http://paulirish.com/2012/box-sizing-border-box-ftw/ */
 * { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; }
.ch-item {
	width: 100%;
	height: 100%;
	border-radius: 50%;
	position: relative;
	cursor: default;
	box-shadow: 
		inset 0 0 0 0 rgba(200,95,66, 0.4),
		inset 0 0 0 16px rgba(255,255,255,0.6),
		0 1px 2px rgba(0,0,0,0.1);
		
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;
}

.ch-info {
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	opacity: 0;
	
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
	-o-transition: all 0.4s ease-in-out;
	-ms-transition: all 0.4s ease-in-out;
	transition: all 0.4s ease-in-out;
	
	-webkit-transform: scale(0);
	-moz-transform: scale(0);
	-o-transform: scale(0);
	-ms-transform: scale(0);
	transform: scale(0);
	
	-webkit-backface-visibility: hidden; /*for a smooth font */

}

.ch-info h3 {
	color: #fff;
    font-weight:bold;
	text-transform: uppercase;
	position: relative;
	letter-spacing: 2px;
	font-size: 18px;
	margin: 0 30px;
	padding: 90px 0 0 0;
	height: 110px;
	font-family: 'Open Sans', Arial, sans-serif;
	text-shadow: 
		0 0 1px #fff, 
		0 1px 2px rgba(0,0,0,0.3);
}

.ch-info p {
	color: #fff;
	padding: 10px 5px;
	font-style: italic;
	margin: 0 30px;
	font-size: 12px;
	border-top: 1px solid rgba(255,255,255,0.5);
}

.ch-info p a {
	display: block;
	color: #fff;
	color: rgba(255,255,255,0.7);
	font-style: normal;
	font-weight: 700;
	text-transform: uppercase;
	font-size: 9px;
	letter-spacing: 1px;
	padding-top: 4px;
	font-family: 'Open Sans', Arial, sans-serif;
}

.ch-info p a:hover {
	color: #fff222;
	color: rgba(255,242,34, 0.8);
}

.ch-item:hover {
	box-shadow: 
	inset 0 0 0 110px rgba(200,95,66, 0.4),
		inset 0 0 0 16px rgba(255,255,255,0.8),
		0 1px 2px rgba(0,0,0,0.1);
}

.ch-item:hover .ch-info {
	opacity: 1;
	
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-o-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);	
}

.ch-grid {
	margin: 20px 0 0 0;
	padding: 0;
	list-style: none;
	display: block;
	text-align: center;
	width: 100%;
}

.ch-grid:after,
.ch-item:before {
	content: '';
    display: table;
}

.ch-grid:after {
	clear: both;
}

.ch-grid li {
	width: 220px;
	height: 220px;
	display: inline-block;
	margin: 20px;
}



     </style>
   
      <div class="row">
         <div class="col-md-4">
            <div class="box box-primary">
               <div class="box-header with-border">
               <center>  <h3 class="box-title ">Man Power</h3></center>
                  <div class="box-tools pull-right">
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>-->
                  </div>
               </div>
               <!-- /.box-header -->
               <div class="box-body">   
                 	<ul class="ch-grid" >
					<li>
                      <div class="ch-item ch-img-1" >
							<div class="ch-info" >
								<a href="emp-details/index?EmpDetailsSearch%5Bstatus%5D=Active"><h3 >Total Employee <?= $model = EmpDetails::find()->where(['Status'=>'Active'])->count(); ?></h3> </a>
								
							</div>
						</div>
					</li>
                    </ul>
               </div>
               <!-- /.box-body -->
               <div class="box-footer text-center">
                  <a href="emp-details/index?EmpDetailsSearch%5Bstatus%5D=Active" class="uppercase">View All Employee</a>
               </div>
               <!-- /.box-footer -->
            </div>
         </div>

         <div class="col-md-4">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <center>  <h3 class="box-title">New Joining</h3> </center> 

                  <div class="box-tools pull-right">
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>-->
                  </div>
               </div>
               <!-- /.box-header -->
               <div class="box-body"> 
                 <ul class="ch-grid">
					<li>  
                      <div class="ch-item ch-img-2">
							<div class="ch-info">
							<?php $salmonth = SalaryMonth::find()->orderBy(['id' => SORT_DESC])->one();
								$currentdate = date('Y-m-d');
								?>
								<a href="emp-details/newjoin-index"><h3> New Joining <?= EmpDetails::find()
									->where(['between', 'doj', $salmonth->month , $currentdate])->count() ?></h3> </a>
								
							</div>
						</div> 
					</li>
                    </ul>
                 <!-- <div class="info-box">
                     <span class="info-box-icon bg-green-gradient"><i class="fa fa-address-card"></i></span>

                     <div class="info-box-content">                       
                        <span class="info-box-number">
                         
                        </span>
                     </div>
                    
                  </div>-->
               </div>
               <!-- /.box-body -->
               <div class="box-footer text-center">
                  <a href="emp-details/newjoin-index" class="uppercase">View Employee</a>
               </div>
               <!-- /.box-footer -->
            </div>
         </div>
         <div class="col-md-4">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <center>  <h3 class="box-title"> Resigned</h3> </center> 
                  <div class="box-tools pull-right">
                 <!--    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>-->
                  </div>
               </div>
               <!-- /.box-header -->
               <div class="box-body">    
                   <ul class="ch-grid">
					<li>
					
					
                      <div class="ch-item ch-img-3">
							<div class="ch-info">
							<?php $salmonth = SalaryMonth::find()->orderBy(['id' => SORT_DESC])->one();
								$currentdate = date('Y-m-d');
								?>
								 <a href="emp-details/resigned-index" ><h3>  Resigned <br> <?= EmpDetails::find()
									->where(['between', 'last_working_date', $salmonth->month , $currentdate])->count() ?></h3> </a>
								
							</div>
						</div> 
					</li>
                    </ul>
                 <!-- <div class="info-box">
                     <span class="info-box-icon bg-yellow-gradient"><i class="fa fa-user-times"></i></span>

                     <div class="info-box-content">                       
                        <span class="info-box-number">
                           <?= EmpDetails::find()->where('last_working_date between(CURDATE() - INTERVAL 1 MONTH) AND CURDATE()')->count() ?>
                        </span>
                     </div>
                     
                  </div>-->
               </div>
               <!-- /.box-body -->
               <div class="box-footer text-center">
                  <a href="emp-details/resigned-index" class="uppercase">View Employee</a>
               </div>
               <!-- /.box-footer -->
            </div>
         </div>
      </div>

      <?php /* <div class="row">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header with-border">
                    <center>  <h3 class="box-title">Man Days Power Report</h3></center>

                  <div class="box-tools pull-right">
                     <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>
                  </div>
               </div>
               <!-- /.box-header -->
			    <?php
                        $model = EmpSalary::find()->where(['revised'=>0])
                                ->orderBy([
                                    'month' => SORT_DESC,
                                ])
                                ->one();
						
                        $dayPresent = EmpSalary::find()->where(['month' => $model->month,'revised'=>0])
                                ->andWhere(['NOT IN', 'salary_structure', ['Consolidated pay, Modern, Conventional']])
                                ->all();
								
                        $dayLeave = 0;
                        $totalPresent = 0;
                        foreach ($dayPresent as $day) {						
                           $leaveDay = EmpLeaveCounter::find()->where(['month' => $day->month, 'empid' => $day->empid])->one();
                           $dayLeave += $leaveDay->leave_days;
                           $totalPresent += $day->paiddays;
                        }
						 $firstmonth =  date('m', strtotime('0 month'));
						 $secondmonth =  date('m', strtotime('-1 month'));
						 $thirdmonth =  date('m', strtotime('-2 month'));
						 
						
						 $secondYear =  date('Y', strtotime('-1 month'));
						 $thirdYear =  date('Y', strtotime('-2 month'));
						 $seconddate = $secondYear.'-'. $secondmonth .'- 01';
						 $thirddate =  $thirdYear.'-'. $thirdmonth .'- 01';
                        ?>
               <div class="box-body">
                  <div class="row">
                     <div class="col-md-8">
                        <p class="">						
                     <strong>Monthly Man Days Report</strong>
                        </p>                       
                        <br><br>
                        <span class="info-box-number ">
                           <?=
                                   EmpSalary::find()->where(['month' => $model->month,'revised'=>0])
                                   ->andWhere(['NOT IN', 'salary_structure', ['Consolidated pay, Modern, Conventional']])
                                   ->count();
                           ?> ENGINEER,
                           <?= $totalPresent - $dayLeave ?> Man Days,

                        </span>
                     </div>
                     <!-- /.col -->
                     <div class="col-md-4">
                        <p class="text-center">
                           <strong>Month Wise </strong>
                        </p>

                        <div class="progress-group">
                           <span class="progress-text"><?= date('M',$model->month).'-'.date('Y', $model->month)?></span>
                           <span class="progress-number"><?=
                                   EmpSalary::find()->where(['month' => $model->month,'revised'=>0])
                                   ->andWhere(['NOT IN', 'salary_structure', ['Consolidated pay, Modern, Conventional']])
                                   ->count();
                           ?> ENGINEER,
                           <?= $totalPresent - $dayLeave ?> Man Days</span>
							<?php if(($totalPresent - $dayLeave)== 0){
								$width = '3%';
								} else if(($totalPresent - $dayLeave) >10000){
								$width = '100%';
								}else if(($totalPresent - $dayLeave) >5000){
								$width = '50%';
								} else if(($totalPresent - $dayLeave) <5000){
								$width = '30%';
								} ?>
                           <div class="progress sm">
                              <div class="progress-bar progress-bar-green" style="width: <?=$width?>"></div>
                           </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">						
                           <span class="progress-text"><?=date('M', strtotime($model->month,'-1 month')).'-'.date('Y', strtotime('-1 month'))?></span>
                           <span class="progress-number"> <?=
                                   EmpSalary::find()->where(['month' => $seconddate,'revised'=>0])
                                   ->andWhere(['NOT IN', 'salary_structure', ['Consolidated pay, Modern, Conventional']])
                                   ->count();
                           ?> ENGINEER,
						   <?php
						      $dayPresent = EmpSalary::find()->where(['month' => $seconddate,'revised'=>0])
                                ->andWhere(['NOT IN', 'salary_structure', ['Consolidated pay, Modern, Conventional']])
                                ->all();
								
                        $dayLeave = 0;
                        $totalPresent = 0;
                        foreach ($dayPresent as $day) {						
                           $leaveDay = EmpLeaveCounter::find()->where(['month' => $day->month, 'empid' => $day->empid])->one();
                           $dayLeave += $leaveDay->leave_days;
                           $totalPresent += $day->paiddays;
                        }
						?>
                           <?= $totalPresent - $dayLeave ?> Man Days</span>
							<?php if(($totalPresent - $dayLeave)== 0){
								$width = '3%';
								} else if(($totalPresent - $dayLeave) >10000){
								$width = '100%';
								}else if(($totalPresent - $dayLeave) >5000){
								$width = '50%';
								} else if(($totalPresent - $dayLeave) <5000){
								$width = '30%';
								} ?>
                           <div class="progress sm">
                              <div class="progress-bar progress-bar-red" style="width: <?=$width?>"></div>
                           </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                           <span class="progress-text"><?=date('M', strtotime('-2 month')).'-'.date('Y', strtotime('-2 month'))?></span>
                           <span class="progress-number"> <?=
                                   EmpSalary::find()->where(['month' => $thirddate,'revised'=>0])
                                   ->andWhere(['NOT IN', 'salary_structure', ['Consolidated pay, Modern, Conventional']])
                                   ->count();
                           ?> ENGINEER,
						   <?php
						      $dayPresent = EmpSalary::find()->where(['month' => $thirddate,'revised'=>0])
                                ->andWhere(['NOT IN', 'salary_structure', ['Consolidated pay, Modern, Conventional']])
                                ->all();
								
                        $dayLeave = 0;
                        $totalPresent = 0;
                        foreach ($dayPresent as $day) {						
                           $leaveDay = EmpLeaveCounter::find()->where(['month' => $day->month, 'empid' => $day->empid])->one();
                           $dayLeave += $leaveDay->leave_days;
                           $totalPresent += $day->paiddays;
                        }
						?>
                           <?= $totalPresent - $dayLeave ?> Man Days</span>
							<?php if(($totalPresent - $dayLeave)== 0){
								$width = '3%';
								} else if(($totalPresent - $dayLeave) >10000){
								$width = '100%';
								}else if(($totalPresent - $dayLeave) >5000){
								$width = '50%';
								} else if(($totalPresent - $dayLeave) <5000){
								$width = '30%';
								} ?>
                           <div class="progress sm">
                              <div class="progress-bar progress-bar-yellow" style="width: <?=$width?>"></div>
                           </div>
                        </div>
                        <!-- /.progress-group -->
                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->
               </div>             
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div> */ ?>
      <!-- /.row -->
      <div class="row">
         <div class="col-md-6">
            <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Today's Birthday</h3>

                  <div class="box-tools pull-right">
                     <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                     </button>
                  </div>
               </div> 
               <!-- /.box-header -->
               <div class="box-body">                  
                  <div class="info-box">
                     <span class="info-box-icon bg-yellow"><i class="fa fa-birthday-cake"></i></span>

                     <div class="info-box-content">                       

                        <?php
						
						$birthday = EmpDetails::find()->joinWith(['employeePersonalDetail'])
						->where('DAY(emp_personaldetails.birthday) = DAY(CURDATE()) AND MONTH(emp_personaldetails.birthday)=MONTH(CURDATE())')											
						->andWhere(['in', 'emp_details.status', ['Active','Notice Period']])
						->orderBy(['DAY(emp_personaldetails.birthday)'=>SORT_ASC])->all();
						
                        $now = date('Y-m-d H:i:s');
                        $m = date("m", strtotime($now));
						echo '<div class="row">';
                        //$birthday = EmpPersonaldetails::find()->where('DAY(birthday) = DAY(CURDATE()) AND MONTH(birthday)=MONTH(CURDATE())')->all();
						 echo '<table>';
                                echo '<tr><th>Name</th><th>Designation</th><th>Unit</th><th>Department</th></tr>';
                        foreach ($birthday as $bday) {					
						echo '<div class="col-md-10">';
						  echo '<tr><td>'. $bday->empname . '</td><td>'. $bday->designation->designation . '</td><td>' . $bday->units->name.'</td><td>' . $bday->department->name.'</td></tr>';
						echo '</div>';						
                        }
						 echo '</table>';
						echo '</div>';
                        ?>


                     </div>
                     <!-- /.info-box-content -->
                  </div>
               </div>
               <!-- /.box-body -->

               <!-- /.box-footer -->
            </div>
         </div>
		 
		 <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Probationary Periods</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div> 
                    <!-- /.box-header -->
                    <div class="box-body">                  
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-list"></i></span>

                            <div class="info-box-content">                       

                                <?php
                                //$noofdays = Yii::$app->db->createCommand("SELECT empcode,empname,doj,probation FROM emp_details WHERE datediff(current_date,date(doj)) BETWEEN 0 AND 45 AND probation IS NOT NULL AND probation <> ''");
                                //SELECT empcode,empname,doj,DATEDIFF(CURDATE(), doj) AS days,probation FROM `emp_details` WHERE probation IS NOT NULL AND probation <> '' AND probation='Nine Months'
                                echo '<div class="row">';
                                $connection = \Yii::$app->db;
                                $command = $connection->createCommand("SELECT empcode,empname,doj,DATEDIFF(CURDATE(), doj) AS days,probation FROM emp_details WHERE probation IS NOT NULL AND probation <> '' AND status='Active' ORDER BY doj ASC");
                                $result = $command->queryAll();
                                #echo '<pre>';
                                #echo print_r($result);
                                #echo '</pre>';
                                /* $probation_thirty = EmpDetails::find()->where('doj')
                                  ->andOnCondition(['IS NOT', 'probation', NULL])
                                  ->andOnCondition(['<>', 'probation', ''])->all(); */
                                //->groupBy('probation')->all();
                                echo '<table>';
                                echo '<tr><th>ECode</th><th>Name</th><th>DoJ</th><th>Days</th><th>Probation</th></tr>';
                                foreach ($result as $duration) {
                                    $probationMonths = strtolower(str_replace(' ', '', $duration['probation']));
                                    if ($probationMonths == 'oneyear' || $probationMonths == '1year') {
                                        if ($duration['days'] >= 335 && $duration['days'] <= 365) {
                                            echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            echo '</div>';
                                        }
                                    } else if ($probationMonths == 'ninemonths') {
                                        if ($duration['days'] >= 240 && $duration['days'] <= 270) {
                                            echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            echo '</div>';
                                        }
                                    } else if ($probationMonths == 'sixmonths' || $probationMonths == '6months') {
                                        if ($duration['days'] >= 150 && $duration['days'] <= 180) {
                                            echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            echo '</div>';
                                        }
                                    } else if ($probationMonths == 'fourmonths') {
                                        if ($duration['days'] >= 90 && $duration['days'] <= 120) {
                                            echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            echo '</div>';
                                        }
                                    } else if ($probationMonths == 'threemonths') {
                                        if ($duration['days'] >= 60 && $duration['days'] <= 90) {
                                            echo '<div class="col-md-10">';
                                            echo '<tr><td>' . $duration['empcode'] . '</td><td>' . $duration['empname'] . '</td><td>' . date('d.m.Y', strtotime($duration['doj'])) . '</td><td>' . $duration['days'] . '</td><td>' . $duration['probation'] . '</td></tr>';
                                            echo '</div>';
                                        }
                                    }
                                }
                                echo '</table>';
                                echo '</div>';
                                ?>

                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <!-- /.box-footer -->
                </div>
            </div>
		 
      </div>

   </div>
</div>
<?php 
$vehicleReminder = VgInsuranceVehicle::find()->where('valid_to BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)')->orderBy(['valid_to' => SORT_ASC])->all();
$buildingReminder = VgInsuranceBuilding::find()->where('valid_to BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)')->orderBy(['valid_to' => SORT_ASC])->all();
$equipmentReminder = VgInsuranceEquipment::find()->where('valid_to BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)')->orderBy(['valid_to' => SORT_ASC])->all();

$vehicleExpired = VgInsuranceVehicle::find()->where('valid_to < DATE(NOW())')->all();
$buildingExpired = VgInsuranceBuilding::find()->where('valid_to < DATE(NOW())')->all();
$equipmentExpired = VgInsuranceEquipment::find()->where('valid_to < DATE(NOW())')->all();

Modal::begin([
    'header' => '<h5>Vehicle/Building/Equipment Policy Reminder</h5>',
    'id' => 'vehiclePR',
    'size' => 'modal-lg',
]);

echo '<div class="modal-content">
    <table style="font-size:11px;" >
    <caption style="text-align: center; font-weight: bold;">VEHICLE</caption>
                        <tr>
                            <th>Policy No</th>
                            <th>Vehicle Name</th>
                            <th>Reg.No</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                            <th>Location</th>
                            <th>User</th>
                            <th>User Division</th>
                        </tr>';
foreach ($vehicleReminder as $data) {
    ?>
    <tr>
        <td> <?= $data->insurance_no ?> </td>
        <td><?= $data->property_name ?></td>
        <td><?= $data->property_no ?></td>
        <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
        <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
        <td style="text-align: right;"><?= $data->sum_insured ?></td>
        <td style="text-align: right;"><?= $data->premium_paid ?></td>
        <td><?= $data->insured_to ?></td>
        <td><?= $data->location ?></td>
        <td><?= $data->user ?></td>
        <td><?= $data->user_division ?></td>
    </tr>
    <?php
}

echo '</table>';
echo '</div>';

echo '<div class="modal-content">
    <table style="font-size:11px;" >
    <caption style="text-align: center; font-weight: bold;">BUILDING</caption>
                        <tr>
                            <th>Policy No</th>
                            <th>Building Name</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Property Value</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                        </tr>';
foreach ($buildingReminder as $data) {
    ?>
    <tr>
        <td> <?= $data->insurance_no ?> </td>
        <td><?= $data->property_name ?></td>
        <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
        <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
        <td style="text-align: right;"><?= $data->property_value ?></td>
        <td style="text-align: right;"><?= $data->sum_insured ?></td>
        <td style="text-align: right;"><?= $data->premium_paid ?></td>
        <td><?= $data->insured_to ?></td>
    </tr>
    <?php
}

echo '</table>';
echo '</div>';


echo '<div class="modal-content">
    <table style="font-size:11px;" >
    <caption style="text-align: center; font-weight: bold;">EQUIPMENT</caption>
                        <tr>
                            <th>Policy No</th>
                            <th>Equipment Name</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                        </tr>';
foreach ($equipmentReminder as $data) {
    ?>
    <tr>
        <td> <?= $data->insurance_no ?> </td>
        <td><?= $data->property_name ?></td>
        <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
        <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
        <td style="text-align: right;"><?= $data->sum_insured ?></td>
        <td style="text-align: right;"><?= $data->premium_paid ?></td>
        <td><?= $data->insured_to ?></td>
    </tr>
    <?php
}

echo '</table>';
echo '</div>';

echo '<div class="modal-content">
    <table style="font-size:11px;" >
    <caption style="text-align: center; font-weight: bold;">Building Policy Expired List</caption>
                        <tr>
                            <th>Policy No</th>
                            <th>Equipment Name</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                        </tr>';
foreach ($buildingExpired as $data) {
    ?>
    <tr>
        <td> <?= $data->insurance_no ?> </td>
        <td><?= $data->property_name ?></td>
        <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
        <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
        <td style="text-align: right;"><?= $data->sum_insured ?></td>
        <td style="text-align: right;"><?= $data->premium_paid ?></td>
        <td><?= $data->insured_to ?></td>
    </tr>
    <?php
}

echo '</table>';
echo '</div>';

echo '<div class="modal-content">
    <table style="font-size:11px;" >
    <caption style="text-align: center; font-weight: bold;">Vehicle Policy Expired List</caption>
                        <tr>
                            <th>Policy No</th>
                            <th>Equipment Name</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                        </tr>';
foreach ($vehicleExpired as $data) {
    ?>
    <tr>
        <td> <?= $data->insurance_no ?> </td>
        <td><?= $data->property_name ?></td>
        <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
        <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
        <td style="text-align: right;"><?= $data->sum_insured ?></td>
        <td style="text-align: right;"><?= $data->premium_paid ?></td>
        <td><?= $data->insured_to ?></td>
    </tr>
    <?php
}

echo '</table>';
echo '</div>';

echo '<div class="modal-content">
    <table style="font-size:11px;" >
    <caption style="text-align: center; font-weight: bold;">Equipment Policy Expired List</caption>
                        <tr>
                            <th>Policy No</th>
                            <th>Equipment Name</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th>Sum Insured</th>
                            <th>Premium Paid</th>
                            <th>Insured To</th>
                        </tr>';
foreach ($equipmentExpired as $data) {
    ?>
    <tr>
        <td> <?= $data->insurance_no ?> </td>
        <td><?= $data->property_name ?></td>
        <td> <?= date('d.m.Y', strtotime($data->valid_from)) ?> </td>
        <td style="color: red;font-weight: bold;"> <?= date('d.m.Y', strtotime($data->valid_to)) ?> </td>
        <td style="text-align: right;"><?= $data->sum_insured ?></td>
        <td style="text-align: right;"><?= $data->premium_paid ?></td>
        <td><?= $data->insured_to ?></td>
    </tr>
    <?php
}

echo '</table>';
echo '</div>';

Modal::end();

/*$script = <<< JS
                   
$(document).ready(function(){
        $("#vehiclePR").modal('show'); 
    });
                  
JS;
$this->registerJs($script); */
?>
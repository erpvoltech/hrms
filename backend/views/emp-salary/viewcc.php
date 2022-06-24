<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;

error_reporting(0);
/* @var $this yii\web\View */
/* @var $model common\models\EmpSalary */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Emp Salaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$Salstructure = EmpRemunerationDetails::find()->where(['empid' => $model->employee->id])->one();
//print_r(Salstructure);
?>
<div class="emp-salary-view">




  <div class="emp-salary-index">

    <div class="panel panel-default">
      <div class="panel-heading text-center" style="font-size:18px;">payslip</div>
      <div class="panel-body">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
        <style>
          *, *:after, *::before {   -webkit-box-sizing: border-box;  -moz-box-sizing: border-box;   box-sizing: border-box;padding: 0;    margin: 0;}
          body{font-family: 'Roboto', sans-serif;font-size:14px;color:282828;}
          .clearfix {    display: block;}
          .clearfix:after { visibility: hidden;display: block; font-size: 0; content: " "; clear: both; height: 0;}
          .pay_container{max-width: 800px;width:100%;margin: auto;}
          .pay_wraper{    padding: 20px;}
          .row_section{width:100%;display: block;}
          .emp_info_col{width:50%;}
          .emp_info_col1{float:left;}
          .emp_info_col2{float: right;}
          .emp_info_col1 .table{width:80%;}
          .emp_info_col2 .table{width:100%;float: right;}			
          table {    border-spacing: 0;    border-collapse: collapse;}
          table {width: 100%;}
          .emp_info table th {font-weight:500;background-color:#09408a; color:#fff}
          .emp_info table th, .emp_info table td { padding:4px;}
          .emp_info table td { background-color:#fff}
          .table_line td{padding: 5px;    border: 1px solid #ccc;}
          .pay_container h3{margin-bottom: 15px;font-size:20px;}
          .pay_container h4{margin-bottom: 10px;font-size: 18px;}
          .pay_container h5{margin-bottom: 10px;font-size: 16px;}
          .pay_container h3, .pay_container h4, .pay_container h5{text-align:center;font-weight:500;}
          .center{text-align:center;}
          .emp_deatils {margin: 15px 0;}
          .pay_container strong{font-weight: 500;}
        </style>
        </head>

        <body>
          <div class="pay_wraper">
            <div class="pay_container" >
              <h3><b>VOLTECH ENGINEERS PRIVATE LIMITED</b></h3>
              <h4><b>No.2/429, Mount Poonamalle Road, Ayyappanthangal, Chennai - 600056</b></h4>
              <h5><b>Payslip for the month of  <?= Yii::$app->formatter->asDate($model->month, "php:F / Y") ?></b></h5>
              <div class="emp_info row_section clearfix">
                <div class="emp_info_col emp_info_col1">
                  <style>

                    .table > thead > tr > th,
                    .table > tbody > tr > th, 
                    .table > tfoot > tr > th,
                    .table > thead > tr > td, 
                    .table > tbody > tr > td,
                    .table > tfoot > tr > td {
                      padding: 5px;}

                  </style>
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Emp ID</td>
                        <td>:</td>
                        <td><?= $model->employee->empcode ?></td>
                      </tr>
                      <tr>
                        <td>PF No</td>
                        <td>:</td>
                        <td><?= $model->statutory->epfno ?></td>
                      </tr>
                      <tr>
                        <td>Paid Days</td>
                        <td>:</td>
                        <td><?= $model->paiddays ?></td>
                      </tr>
                      <tr>
                        <td>Designation</td>
                        <td>:</td>
                        <td><?= $model->designations->designation ?></td>
                      </tr>
                      <tr>
                        <td>Units</td>
                        <td>:</td>
                        <td><?= $model->employee->units->name ?></td>
                      </tr>
                      <tr>
                        <td>WL</td>
                        <td>:</td>
                        <td><?= $model->work_level ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="emp_info_col emp_info_col2">
                  <table class="table ">
                    <tbody>
                      <tr>
                        <td>Employee Name</td>
                        <td>:</td>
                        <td><?= $model->employee->empname ?></td>
                      </tr>
                      <tr>
                        <td>ESI No</td>
                        <td>:</td>
                        <td><?= $model->statutory->esino ?></td>
                      </tr>
                      <tr>
                        <td>Date of Joining</td>
                        <td>:</td>
                        <td><?= Yii::$app->formatter->asDate($model->employee->doj, "php:d/m/Y") ?></td>
                      </tr>
                      <tr>
                        <td>Department</td>
                        <td>:</td>
                        <td><?= $model->employee->department->name ?></td>
                      </tr>
                      <tr>
                        <td>UAN</td>	
                        <td>:</td>
                        <td><?= $model->statutory->epfuanno ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--table new-->
              <div class="emp_info emp_deatils row_section clearfix">

                <div class="row">
                  <div class="col-md-6">
                    <table class="table table_line">
                      <thead>
                        <tr>
                          <th>Earnings</th>
                          <th>Actual</th>
                          <th>Amount</th>

                        </tr>

                      </thead>
                      <tbody>
                        <tr>
                          <td>Basic</td>
                          <?php
                          if ($Salstructure->basic) {
                            echo '<td>' . $Salstructure->basic . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td><?= $model->basic ?></td>	
                        </tr>
                        <tr>
                          <td>HR Allowance</td>
                          <?php
                          if ($Salstructure->hra) {
                            echo '<td>' . $Salstructure->hra . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td><?= $model->hra ?></td>
                        </tr>
                        <tr>
                          <td>Spl. Allowance</td>
                          <?php
                          if ($Salstructure->splallowance) {
                            echo '<td>' . $Salstructure->splallowance . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td> <?= $model->spl_allowance ?></td>
                        </tr>
                        <tr>
                          <td>DA</td>
                          <?php
                          if ($Salstructure->dearness_allowance) {
                            echo '<td>' . $Salstructure->dearness_allowance . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>

                          <td> <?= $model->dearness_allowance ?></td>

                        </tr>
                        <tr><td> Adv/Arrear TES</td>																
                          <td></td>
                          <td><?= $model->advance_arrear_tes ?></td>
                        </tr>
                        <tr>
                          <td>Over Time</td>
                          <td></td>
                          <td> <?= $model->over_time ?></td>
                        </tr>
                        <tr>
                          <td>Conveyance Allowance</td>
                          <?php
                          if ($Salstructure->conveyance) {
                            echo '<td>' . $Salstructure->conveyance . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td><?= $model->conveyance_allowance ?></td>
                        </tr>
                        <tr>
                          <td>Arrear	</td>
                          <td></td>
                          <td><?= $model->arrear ?></td>
                        </tr>
                        <tr>
                          <td>guaranted_benefit</td>
                          <?php
                          if ($Salstructure->guaranteed_benefit) {
                            echo '<td>' . $Salstructure->guaranteed_benefit . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td><?= $model->guaranted_benefit ?></td>
                        </tr>
                        <tr>
                          <td>Holiday Pay</td>
                          <td></td>
                          <td><?= $model->holiday_pay ?></td>
                        </tr>
                        <tr>
                          <td>washing_allowance</td>
                          <td></td>
                          <td><?= $model->washing_allowance ?></td>
                        </tr>
                        <tr>
                          <td>dust_allowance</td>
                          <?php
                          if ($Salstructure->dust_allowance) {
                            echo '<td>' . $Salstructure->dust_allowance . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td><?= $model->dust_allowance ?></td>
                        </tr>
                        <tr>
                          <td>Person Pay</td>
                          <?php
                          if ($Salstructure->personpay) {
                            echo '<td>' . $Salstructure->personpay . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td><?= $model->performance_pay ?></td>
                        </tr>
                        <tr>
                          <td>other_allowance</td>
                          <?php
                          if ($Salstructure->other_allowance) {
                            echo '<td>' . $Salstructure->other_allowance . '</td>';
                          } else {
                            echo '<td></td>';
                          }
                          ?>
                          <td><?= $model->other_allowance ?></td>
                        </tr>




                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6" style="margin-left:-35px;">


                    <table class="table table_line">
                      <thead>
                        <tr>
                          <th>Deductions</th>
                          <th>Amount</th>
                        </tr>

                      </thead>
                      <tbody>
                        <tr>
                          <td>PF</td>
                          <td><?= $model->pf ?></td>

                        </tr>
                        <tr>
                          <td>Insurance.</td>
                          <td> <?= $model->insurance ?></td>
                        </tr>
                        <tr>
                          <td>TES</td>
                          <td> <?= $model->tes ?></td>
                        </tr>

                        <tr>
                          <td>professional_tax</td>
                          <td> <?= $model->professional_tax ?></td>
                        </tr>

                        <tr>
                          <td>ESI</td>
                          <td> <?= $model->esi ?></td>
                        </tr>

                        <tr>
                          <td>advance</td>
                          <td> <?= $model->advance ?></td>
                        </tr>

                        <tr>
                          <td>Mobile</td>
                          <td> <?= $model->mobile ?></td>
                        </tr>

                        <tr>
                          <td>Loan</td>
                          <td> <?= $model->loan ?></td>
                        </tr>

                        <tr>
                          <td>Rent</td>
                          <td> <?= $model->rent ?></td>
                        </tr>


                        <tr>
                          <td>TDS</td>
                          <td> <?= $model->tds ?></td>
                        </tr>

                        <tr>
                          <td>LWF</td>
                          <td> <?= $model->lwf ?></td>
                        </tr>

                        <tr>
                          <td>Others</td>
                          <td> <?= $model->other_deduction ?></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>

                        </tr>




                      </tbody>
                    </table>
                  </div>
                </div> 
                <div class="row" >
                  <div class="col-md-12">
                    <table >

                      <tbody>
                        <tr>
                          <td><b>Total </b></td>
                          <td><b><?= $Salstructure->gross_salary ?></b></td>
                          <td><b><?= $model->total_earning ?></b></td>
                          <td><b>Total</b></td>
                          <td><b><?= $model->total_deduction ?></b></td>

                        </tr>
                        <tr> 
                          <td colspan="4"><b>Net Pay</b></td>
                          <td ><b><?= $model->net_amount ?></b></td>
                        </tr>

                        <tr>
                          <td colspan="6">
                            <p><b>In Words <?= $model->employee->getIndianCurrency($model->net_amount) ?> Only</b></p>
                          </td> 

                        </tr>
                        <tr>
                          <td colspan="6" align="right">
                            <p class="center">This is a system generated payslip. Hence signature not required.</p>
                          </td>

                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--table new-->
              <!-- old table     <div class="emp_info emp_deatils row_section clearfix">
                     <table class="table table_line">
                       <thead>
                         <tr>
                           <th>Earnings</th>
                           <th>Actual</th>
                           <th>Amount</th>
                           <th>Deductions</th>
                           <th>Amount</th>
                         </tr>
                       </thead>
                       <tbody>
                         <tr>
                           <td>Basic</td>
              <?php
              if ($Salstructure->basic) {
                echo '<td>' . $Salstructure->basic . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td><?= $model->basic ?></td>								
                           <td>PF</td>
                           <td><?= $model->pf ?></td>
                         </tr>
                         <tr>
                           <td>HR Allowance</td>
              <?php
              if ($Salstructure->hra) {
                echo '<td>' . $Salstructure->hra . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td><?= $model->hra ?></td>								
                           <td>Insurance.</td>
                           <td> <?= $model->insurance ?></td>
                         </tr>
                         <tr>
                           <td>Spl. Allowance</td>
              <?php
              if ($Salstructure->splallowance) {
                echo '<td>' . $Salstructure->splallowance . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td> <?= $model->spl_allowance ?></td>
                           <td>TES</td>
                           <td> <?= $model->tes ?></td>
                         </tr>
                         <tr>
                           <td>DA</td>
              <?php
              if ($Salstructure->dearness_allowance) {
                echo '<td>' . $Salstructure->dearness_allowance . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
     
                           <td> <?= $model->dearness_allowance ?></td>
     
                           <td>professional_tax</td>
                           <td> <?= $model->professional_tax ?></td>
     
                         </tr>
     
                         <tr>
                           <td> Adv/Arrear TES</td>																
                           <td></td>
                           <td><?= $model->advance_arrear_tes ?></td>
                           <td>ESI</td>
                           <td> <?= $model->esi ?></td>
                         </tr>
     
                         <tr>
                           <td>Over Time</td>
                           <td></td>
                           <td> <?= $model->over_time ?></td>
                           <td>advance</td>
                           <td> <?= $model->advance ?></td>
                         </tr>
                         <tr>
                           <td>Conveyance Allowance</td>
              <?php
              if ($Salstructure->conveyance) {
                echo '<td>' . $Salstructure->conveyance . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td><?= $model->conveyance_allowance ?></td>
                           <td>Mobile</td>
                           <td> <?= $model->mobile ?></td>
                         </tr>
                         <tr>
                           <td>Arrear	</td>
                           <td></td>
                           <td><?= $model->arrear ?></td>
                           <td>Loan</td>
                           <td> <?= $model->loan ?></td>
                         </tr>
     
                         <tr>
                           <td>guaranted_benefit</td>
              <?php
              if ($Salstructure->guaranteed_benefit) {
                echo '<td>' . $Salstructure->guaranteed_benefit . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td><?= $model->guaranted_benefit ?></td>
                           <td>Rent</td>
                           <td> <?= $model->rent ?></td>
                         </tr>
     
     
                         <tr>
                           <td>Holiday Pay</td>
                           <td></td>
                           <td><?= $model->holiday_pay ?></td>
                           <td>TDS</td>
                           <td> <?= $model->tds ?></td>
                         </tr>
     
     
                         <tr>
                           <td>washing_allowance</td>
                           <td></td>
                           <td><?= $model->washing_allowance ?></td>
                           <td>LWF</td>
                           <td> <?= $model->lwf ?></td>
                         </tr>
     
     
                         <tr>
                           <td>dust_allowance</td>
              <?php
              if ($Salstructure->dust_allowance) {
                echo '<td>' . $Salstructure->dust_allowance . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td><?= $model->dust_allowance ?></td>
                           <td>Others</td>
                           <td> <?= $model->other_deduction ?></td>
                         </tr>
                         <tr>
                           <td>Person Pay</td>
              <?php
              if ($Salstructure->personpay) {
                echo '<td>' . $Salstructure->personpay . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td><?= $model->performance_pay ?></td>
                           <td></td>
                           <td></td>
                         </tr>
                         <tr>
                           <td>other_allowance</td>
              <?php
              if ($Salstructure->other_allowance) {
                echo '<td>' . $Salstructure->other_allowance . '</td>';
              } else {
                echo '<td></td>';
              }
              ?>
                           <td><?= $model->other_allowance ?></td>
                           <td></td>
                           <td></td>
                         </tr>
     
     
                         <tr>
                           <td><b>Total </b></td>
                           <td><b><?= $Salstructure->gross_salary ?></b></td>
                           <td><b><?= $model->total_earning ?></b></td>
                           <td><b>Total</b></td>
                           <td><b><?= $model->total_deduction ?></b></td>
                         </tr>
                       </tbody>
                       <tfoot>
                         <tr>
                           <td><b>Net Pay</b></td>
                           <td colspan="4"><b><?= $model->net_amount ?></b></td>
                         </tr>
                         <tr>
                           <td colspan="6">
                             <p><b>In Words <?= $model->employee->getIndianCurrency($model->net_amount) ?> Only</b></p>
                           </td>
                         </tr>
                         <!--<tr>
                             <td colspan="6" align="right">
                                 <b>Signature</b>
                             </td>
                         </tr>-->  
                      <!--   <tr>
                           <td colspan="6" align="right">
                             <p class="center">This is a system generated payslip. Hence signature not required.</p>
                           </td>
                         </tr>
                       </tfoot>
                     </table>
     
     
                   </div>    old table-->

            </div>
          </div>
      </div>
    </div>
  </div>

</div>


<?php
        
//print_r(Salstructure);
/*
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">

      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
      Remove this if you use the .htaccess -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

      <title>HTML</title>
      <meta name="description" content="">
      <meta name="author" content="INTS-137">

      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
      <style>
         *, *:after, *::before {   -webkit-box-sizing: border-box;  -moz-box-sizing: border-box;   box-sizing: border-box;padding: 0;    margin: 0;}
         body{font-family: 'Roboto', sans-serif;font-size:12px;color:282828;}
         .clearfix {    display: block;}
         .clearfix:after { visibility: hidden;display: block; font-size: 0; content: " "; clear: both; height: 0;}
         .pay_container{max-width: 800px;width:100%;margin: auto;border: 1px solid #000;}
         .pay_wraper{    padding: 20px;}
         .row_section{width:100%;display: block;}
         .emp_info_col{width:100%;}
         

         table {    border-spacing: 0;    border-collapse: collapse;}
         table {width: 100%;}
         .emp_info table th {font-weight:500; color:#000;text-align: left;}
         .emp_info table th, .emp_info table td { padding:5px;border: 1px solid #000;}
         .emp_info table td { background-color:#fff}
         .table_line td{padding: 5px;    border: 1px solid #ccc;}
         .pay_container h3{margin-bottom: 15px;font-size:20px;}
         .pay_container h4{margin-bottom: 10px;font-size: 18px;}
         .pay_container h5{margin-bottom: 10px;font-size: 16px;}
         .pay_container h3, .pay_container h4, .pay_container h5{text-align:center;font-weight:500;}
         .center{text-align:center;}			
         .pay_container strong{font-weight: 500;}
         .table.table_mar_bt_0{margin-bottom:0;}
         .table_last_td_bor tr td:last-child, .table_last_td_bor tr th:last-child{border-right: 0;}
         .table.table_td_bor_tp_1 tr td{border-top: 1px solid #000;}
         .table.table_bot_td_bor_0 td{border-bottom: 0;}
      </style>
   </head>

   <body>
      <div class="pay_wraper">

         <div class="panel panel-default">
            <div class="panel-heading text-center" style="font-size:18px;">Pay Slip</div>
            <div class="panel-body">
               <div class="pay_container">
                  <div class="emp_info row_section clearfix">

                     <div class="row" >
                        <div class="col-md-12">
                           <table class="table table_line">
                              <thead >
                                 <tr>
                                    <td colspan="4"> <h3><b>VOLTECH ENGINEERS PRIVATE LIMITED</b></h3>
                                       <h4><b>No.2/429, Mount Poonamalle Road, Ayyappanthangal, Chennai - 600056</b></h4>
                                       <h5><b>Payslip for the month of  <?= Yii::$app->formatter->asDate($model->month, "php:F / Y") ?></b></h5> </td>

                                 </tr>
                                 
                                 <tr>
                                   <td><b>Emp ID</b></td>
                                    <td><?= $model->employee->empcode ?></td>
                                    <td><b>Employee Name</b></td>
                                    <td><?= $model->employee->empname ?></td>
                                 </tr>

                                 <tr >
                                    <td><b>PF No</b></td>
                                    <td><?= $model->statutory->epfno ?></td>
                                    <td><b>ESI No</b></td>
                                    <td><?= $model->statutory->esino ?></td>
                                 </tr>
                                 
                                 <tr>
                                    <td><b>Paid Days</b></td>
                                    <td><?= $model->paiddays ?></td>
                                    <td><b>Date of Joining</b></td>
                                    <td><?= Yii::$app->formatter->asDate($model->employee->doj, "php:d/m/Y") ?></td>
                                 </tr>
                                 
                                 <tr>
                                    <td><b>Designation</b></td>
                                    <td><?= $model->designations->designation ?></td>
                                    <td><b>Department</b></td>
                                    <td><?= $model->employee->department->name ?></td>
                                 </tr>
                                 
                                 <tr>
                                    <td><b>Unit</b></td>
                                    <td><?= $model->employee->units->name ?></td>
                                    <td><b>UAN</b></td>
                                    <td><?= $model->statutory->epfuanno ?></td>
                                 </tr>

                              </thead>
                           </table>
                        </div>
                     </div>

                  </div>
                 <style>
                   


                 </style>
                  <div class="emp_info emp_deatils row_section clearfix" >
                     <div class="row" >

                       <div class="col-md-6" style="padding-right: 0;">
                           <table class="table table_line table_last_td_bor table_mar_bt_0 table_bot_td_bor_0">
                              <thead>
                                 <tr>
                                    <th>Earnings</th>
                                    <th>Actual</th>
                                    <th>Amount</th>

                                 </tr>

                              </thead>
                              <tbody>
                                 <tr>
                                    <td>Basic</td>
                                    <?php
                                    if ($Salstructure->basic) {
                                       echo '<td>' . $Salstructure->basic . '</td>';
                                    } else {
                                       echo '<td></td>';
                                    }
                                    ?>
                                    <td><?= $model->basic ?></td>	
                                 </tr>
                                 <tr>
                                    <td>HR Allowance</td>
                                    <?php
                                    if ($Salstructure->hra) {
                                       echo '<td>' . $Salstructure->hra . '</td>';
                                    } else {
                                       echo '<td></td>';
                                    }
                                    ?>
                                    <td><?= $model->hra ?></td>
                                 </tr>
                                 <?php if ($model->spl_allowance) { ?>
                                    <tr>
                                       <td>Spl. Allowance</td>
                                       <?php
                                       if ($Salstructure->splallowance) {
                                          echo '<td>' . $Salstructure->splallowance . '</td>';
                                       } else {
                                          echo '<td></td>';
                                       }
                                       ?>
                                       <td> <?= $model->spl_allowance ?></td>
                                    </tr> <?php } ?>
                                 <tr>
                                    <td>DA</td>
                                    <?php
                                    if ($Salstructure->dapermonth) {
                                       echo '<td>' . $Salstructure->dapermonth . '</td>';
                                    } else {
                                       echo '<td></td>';
                                    }
                                    ?>
                                    <td> <?= $model->dearness_allowance ?></td>
                                 </tr>

                                 <?php if ($model->advance_arrear_tes) { ?>
                                    <tr><td> Adv/Arrear TES</td>																
                                       <td></td>
                                       <td><?= $model->advance_arrear_tes ?></td>
                                    </tr> <?php } ?>
                                 <?php if ($model->over_time) { ?>
                                    <tr>
                                       <td>Over Time</td>
                                       <td></td>
                                       <td> <?= $model->over_time ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->conveyance_allowance) { ?>
                                    <tr>
                                       <td>convey Allowance</td>
                                       <?php
                                       if ($Salstructure->conveyance) {
                                          echo '<td>' . $Salstructure->conveyance . '</td>';
                                       } else {
                                          echo '<td></td>';
                                       }
                                       ?>
                                       <td><?= $model->conveyance_allowance ?></td>
                                    </tr>  <?php } ?>
									
									 <?php if ($model->lta_earning) { ?>
                                    <tr>
                                       <td>LTA Allowance</td>
                                     <td></td>
                                       <td> <?= $model->lta_earning ?></td>
                                    </tr> <?php } ?>
									
									 <?php if ($model->medical_earning) { ?>
                                    <tr>
                                       <td>Medical Allowance</td>
                                      <td></td>
                                       <td> <?= $model->medical_earning ?></td>
                                    </tr> <?php } ?>
									
                                 <?php if ($model->arrear) { ?>
                                    <tr>
                                       <td>Arrear	</td>
                                       <td></td>
                                       <td><?= $model->arrear ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->guaranted_benefit) { ?>
                                    <tr>
                                       <td>guaranted_benefit</td>
                                       <?php
                                       if ($Salstructure->guaranteed_benefit) {
                                          echo '<td>' . $Salstructure->guaranteed_benefit . '</td>';
                                       } else {
                                          echo '<td></td>';
                                       }
                                       ?>
                                       <td><?= $model->guaranted_benefit ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->holiday_pay) { ?>
                                    <tr>
                                       <td>Holiday Pay</td>
                                       <td></td>
                                       <td><?= $model->holiday_pay ?></td>
                                    </tr><?php } ?>
                                 <?php if ($model->washing_allowance) { ?>
                                    <tr>
                                       <td>washing_allowance</td>
                                       <td></td>
                                       <td><?= $model->washing_allowance ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->dust_allowance) { ?>
                                    <tr>
                                       <td>dust_allowance</td>
                                       <?php
                                       if ($Salstructure->dust_allowance) {
                                          echo '<td>' . $Salstructure->dust_allowance . '</td>';
                                       } else {
                                          echo '<td></td>';
                                       }
                                       ?>
                                       <td><?= $model->dust_allowance ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->performance_pay) { ?>
                                    <tr>
                                       <td>Person Pay</td>
                                       <?php
                                       if ($Salstructure->personpay) {
                                          echo '<td>' . $Salstructure->personpay . '</td>';
                                       } else {
                                          echo '<td></td>';
                                       }
                                       ?>
                                       <td><?= $model->performance_pay ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->other_allowance) { ?>
                                    <tr>
                                       <td>other_allowance</td>
                                       <td></td>
                                       <td><?= $model->other_allowance ?></td>
                                    </tr>  <?php } ?>
                               
                              </tbody>
                           </table>

                        </div>
                        <div class="col-md-6" style="padding-left: 0px;">


                           <table class="table table_line table_mar_bt_0 table_bot_td_bor_0" >
                              <thead>
                                 <tr>
                                    <th>Deductions</th>
                                    <th>Amount</th>
                                 </tr>

                              </thead>
                              <tbody>
                                 <?php if ($model->pf) { ?>
                                    <tr>
                                       <td>PF</td>
                                       <td><?= $model->pf ?></td>

                                    </tr>  <?php } ?>
                                 <?php if ($model->insurance) { ?>
                                    <tr>
                                       <td>Insurance.</td>
                                       <td> <?= $model->insurance ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->tes) { ?>
                                    <tr>
                                       <td>TES</td>
                                       <td> <?= $model->tes ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->professional_tax) { ?>
                                    <tr>
                                       <td>professional_tax</td>
                                       <td> <?= $model->professional_tax ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->esi) { ?>
                                    <tr>
                                       <td>ESI</td>
                                       <td> <?= $model->esi ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->advance) { ?>
                                    <tr>
                                       <td>advance</td>
                                       <td> <?= $model->advance ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->mobile) { ?>
                                    <tr>
                                       <td>Mobile</td>
                                       <td> <?= $model->mobile ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->loan) { ?>
                                    <tr>
                                       <td>Loan</td>
                                       <td> <?= $model->loan ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->rent) { ?>
                                    <tr>
                                       <td>Rent</td>
                                       <td> <?= $model->rent ?></td>
                                    </tr>  <?php } ?>

                                 <?php if ($model->tds) { ?>
                                    <tr>
                                       <td>TDS</td>
                                       <td> <?= $model->tds ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->lwf) { ?>
                                    <tr>
                                       <td>LWF</td>
                                       <td> <?= $model->lwf ?></td>
                                    </tr>  <?php } ?>
                                 <?php if ($model->other_deduction) { ?>
                                    <tr>
                                       <td>Others</td>
                                       <td> <?= $model->other_deduction ?></td>
                                    </tr>  <?php } ?>
                              
                              </tbody>
                           </table>
                        </div>
                     </div>
                      <div class="row" >

                        <div class="col-md-6" style="padding-right: 0px;">
                          <table class="table table_line table_last_td_bor table_mar_bt_0 table_td_bor_tp_1">
                            <tbody>
                                <tr>
                                  
                                 <td style="width:140px"><b>Total </b></td>
                                    <td><b><?= $Salstructure->netsalary ?></b></td>
                                    <td><b><?= $model->total_earning ?></b></td>
                                   
                                </tr>
                              </tbody>
                            
                          </table>
                        </div>
                          <div class="col-md-6" style="padding-left: 0px;">
                          <table class="table table_line table_mar_bt_0">
                            
                            <tr>
                             
                                     <td style="width:140px;"><b>Total</b></td>
                                    <td style="width:140px;;"><b><?= $model->total_deduction ?></b></td>
                                </tr>
                          </table>
                          </div>
                      </div>
                     <div class="row" >
                        <div class="col-md-12">
                       
                                 <table >

                              <tbody>
                                 <tr> 
                                    <td colspan="4"><b>Net Pay</b></td>
                                    <td ><b><?= $model->net_amount ?></b></td>
                                 </tr>

                                 <tr>
                                    <td colspan="6">
                                       <p><b>In Words <?= $model->employee->getIndianCurrency($model->net_amount) ?> Only</b></p>
                                    </td> 

                                 </tr>
								 <tr><td colspan="6" align="center"><b>Cost to Company( Eemployer Contribution)</b></td></tr>
								 <tr><td colspan="6" ><b>EPF Contribution</b> <?= $model->pf_employer_contribution?>,
								 <b>	ESI Contribution</b> <?= $model->esi_employer_contribution?><br>
								 <b>	Performance Linked Incentive</b> <?= $model->pli_employer_contribution?> ( PLI is distributed before Diwali Only )<br>
								 <b>CTC : <?=$model->earned_ctc?> (<?= $model->employee->getIndianCurrency($model->earned_ctc) ?> Only)</b>
								 </td></tr>
                                 <tr>
                                    <td colspan="6" align="right">
                                       <p class="center">This is a system generated payslip. Hence signature not required.</p>
                                    </td>

                                 </tr>

                              </tbody>
                           </table>
                        </div>
                     </div>


                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html> */?>
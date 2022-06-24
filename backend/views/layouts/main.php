<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
#use common\models\user;

#$id		=	Yii::$app->user->identity->id;

#$userid	=	Yii::app()->user->id;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
<body>
  <?php $this->beginBody() ?>
  <div class="wrap">
    <style>
    .navbar-default{
      background-color: #1E6F66;
      height:60px;
      }.navbar-brand {
        padding: 0px;
      }
      .navbar-default .navbar-nav > li > a {
        color: #fff
      }
      .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
        color:#fff;
        background:none
      }
      .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color:#fff;
        background-color: transparent;
      }

      .footer {
        margin-top:280px;
        position: relative;
        right: 0;
        bottom: 0;
        left: 0;
        text-align: center;
      }
      </style>

      <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= \Yii::$app->homeUrl ?>"><i class="icon-home icon-white"> </i> <img src="<?= \Yii::$app->homeUrl ?>img/logo.png" style="width:160px;height:59px;">					</a>
          </div>
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
              <li class="menu-item "><a href="#">Recruitment<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <!--<li class="menu-item "><a href="#">Batch<b class="caret"></b></a>
                  <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>recruitment-batch">Create/View</a></li>
                  <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>recruitment/index">Upload</a></li>
                </ul>
              </li>-->
              <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>recruitment-batch">Create Batch</a></li>
              <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>recruitment/index">Master</a></li>
              <!--<li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>recruitment/sendcallletter">Call Letter</a></li>
              <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>recruitment/recruitmentprocess">Process</a></li>-->

            </ul>
          </li>
          <li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Post Recruitment<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-details/index"> MIS</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-details/mis-export">MIS Export</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-details/import-employee">MIS Import</a></li>
			  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-details/exportid">ID Export</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-details/engineer-list">Transfer & Status</a></li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="" >Document</a>
                <ul class="dropdown-menu">
                  <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Show Cause</a>
                    <ul class="dropdown-menu">
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>document/show-cause-all">View</a></span></a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>document/show-cause-import">Import</a></span></a>
                        <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>document/show-cause">Send Mail</a></span></a>
                      </li>
                    </ul>
                  </li>
                  <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Termination</a>
                    <ul class="dropdown-menu">
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>document/termination">View</a></span></a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>document/termination-import">Import</a></span></a>
                        <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>document/termination-mail">Send Mail</a></span></a>
                      </li>
                    </ul>
                  </li>
                </ul>

              </li>

              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Setup</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>college">Institute</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>qualification">Qualification</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>course">Course</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>department">Department</a>  </li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>unit">Unit & Division</a>  </li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>designation">Designation</a> </li>
                </ul>
              </li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="" >Training</a>
                <ul class="dropdown-menu">
                  <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Setup</a>
                    <ul class="dropdown-menu">
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>training-topics">Topics</a></span></a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>training-faculty">Training Faculty</a></span></a>

                      </li>
                    </ul>
                  </li>

                  <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Training</a>
                    <ul class="dropdown-menu">
                      <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Training Batch</a>
                        <ul class="dropdown-menu">
                          <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>porec-training">Existing</a></li>
                          <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>porec-training/new">New</a></li>
                        </ul>
                      </li>
                      <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>porec-training/trainingprocess">Process</a></span></a></li>
                      <!--<li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>porec-training/offerletter">Offer</a></span></a></li>-->
                        <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Offer</a>
                            <ul class="dropdown-menu">
                                    <li class="menu-item"><a href="<?= \yii::$app->homeUrl ?>porec-training/offerletter">Engineer</a></li>
                                    <li class="menu-item"><a href="<?= \yii::$app->homeUrl ?>porec-training/staffofferletter">Staff</a></li>										
                            </ul>										
                        </li>
                        <li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>porec-training/joining">Join</a></li>
			<li class="menu-item "><a href="<?= \yii::$app->homeUrl ?>porec-training/joiningecode">Assign Ecode</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/status-report">Status Report</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/dojreport">Date Based Report</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/attrition">Attrition Report</a></li> 
				  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/bloodgroup">Blood Group</a></li>  
				  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/probationreport">Probation Expired Report</a></li>
				    <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/voltech-exp">Voltech Experience Report</a></li></ul>
              </li>
            </ul>
          </li>

          <li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Payroll<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown" >Employee salary</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/salarymonth">Create</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/salary-upload">Data Upload</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/salarygenerate">Generate</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary" >Pay Slip</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/editor" >Edit</a></li>
                </ul>
              </li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/emailindex" >Payslip Mail</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/email-separate" >Payslip Mail Separate</a></li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Employee leave</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>engineer-leave">Engineer</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>staff-leave">Staff</a></li>
                </ul>
              </li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Engineer leave</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>engineer-leave/engineer-leave">Add Eligible</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>engineer-leave/engineer-leave-taken">Engineer Leave Report</a></li>
                   <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>engineer-leave/engineer-leave-month">Engineer Leave MonthWise</a></li>
                </ul>
              </li>
              
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Report</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/salary-statement">Salary Statement</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/bank-statement">Bank Statement</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/md-report">MD Report(Sal)</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/md-emp-statement">MD Report(Emp)</a></li>
				   <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/component-result" >Component Based</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-promotion" >Promotion</a></li>
				  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-promotion/promotion-index" >Promotion Mail</a></li>
				  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-promotion/mail-config" >Mail Configure</a></li>
                  </ul>               
              </li>
			   <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Bonus</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/bonus">View</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/bonus-template">Template Download</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salary/bonus-import">Import</a></li>
                 </ul>               
              </li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Setup</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-salarystructure" >Salary Structure</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>emp-staff-pay-scale" >Pay Scale</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>unit/group-index">Unit Group</a>  </li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>customer">Customer</a>  </li>
                </ul>
              </li>
            </ul>
          </li>

          <li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Statutory<b class="caret"></b></a>
            <ul class="dropdown-menu">

              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Statutory HR</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>statutoryhr">PF List</a></li>
				  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>statutoryhr/esiindex">ESI List</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>statutoryhr/upload">Download/Upload</a>  </li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>statutoryhr/epfreport">EPF Report</a>  </li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>statutoryhr/esireport">ESI Report</a>  </li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>statutoryhr/non-uan">Non UAN List</a>  </li>
                </ul>
              </li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#">Statutory IR</a>
				   <ul class="dropdown-menu">
                   <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>project-details/dashboard-ir">Track Sheet</a></li> 
				   <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>project-details">Project</a></li>	
				   
				   <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Customer</a>
					<ul class="dropdown-menu">
					  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>customer">Customer</a>  </li>					 
					  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>customer/cust-contact">Customer Contact</a>  </li>
					</ul>
                  </li>
                </ul>
			  </li>
            </ul>
          </li>

          <!--Insurance Menu-->

          <!--<li class="menu-item "><a href="<= \Yii::$app->homeUrl ?>vg-insurance-agents">Insurance</a></li>-->


          <li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Insurance<b class="caret"></b></a>
            <ul class="dropdown-menu">
			<?php if(Yii::$app->user->identity->username != 'COC'){ ?>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Human Insurance</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-gpa-policy/index">GPA</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-gmc-policy/index">GMC</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-wc-policy/index">WC</a></li>
                </ul>
              </li>
			<?php } ?>
			
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Property Insurance</a>
                <ul class="dropdown-menu">
				<?php if(Yii::$app->user->identity->username != 'COC'){ ?>	
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-property/index">PIS</a></li>
                  <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Building</a>
                    <ul class="dropdown-menu">
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-building/index">Index</a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-building/importbuilding">Building Import</a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-building/exportbuilding">Building Export</a></li>
                    </ul>
                  </li>
                  <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Equipment</a>
                    <ul class="dropdown-menu">
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-equipment/equipmentindexnew">Index</a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-equipment/importequipment">Equipment Import</a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-equipment/exportequipment">Equipment Export</a></li>
                    </ul>
                  </li>
				<?php } ?>
			 
                  <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Vehicle</a>
                    <ul class="dropdown-menu">
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-vehicle/index">Index</a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-vehicle/importvehicle">Vehicle Import</a></li>
                      <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-vehicle/exportvehicle">Vehicle Export</a></li>
                    </ul>
                  </li>
				  
                </ul>
              </li>
			  <?php if(Yii::$app->user->identity->username != 'COC'){ ?>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Claims</a>
                <ul class="dropdown-menu">
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-policy-claim/index">Claim Form</a></li>
                </ul>
              </li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Uninsured List</a>
                <ul class="dropdown-menu">
                  <li class="menu-item"><a href="<?= \Yii::$app->homeUrl ?>vg-gpa-policy/uninsuredindex ">GPA</a></li>
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-gmc-policy/uninsuredindexgmc">GMC</a></li>
                </ul>
              </li>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Employee Relieved List</a>
                <ul class="dropdown-menu">
                  <li class="menu-item"><a href="<?= \Yii::$app->homeUrl ?>vg-gpa-policy/relievedindexgpa ">GPA</a></li>
                  <li class="menu-item"><a href="<?= \Yii::$app->homeUrl ?>vg-gmc-policy/relievedindexgmc ">GMC</a></li>
                </ul>
              </li>
			  <?php } if(Yii::$app->user->identity->username != 'COC'){ ?>
              <li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Policy Reminder</a>
                <ul class="dropdown-menu">
                  <li class="menu-item"><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-building/policyremainderbuilding">Building</a></li>
                  
					  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-vehicle/policyremaindervehicle">Vehicle</a></li>
				  
                  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-equipment/policyremainderequipment">Equipment</a></li>
                </ul>
              </li>
			  
			  <?php } if(Yii::$app->user->identity->username != 'COC'){ ?>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-insurance-agents/index">ISP/Agents</a></li>
			  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vg-gmc-policy/cmdindex">CMD Family Policy</a></li>
			   <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>report/gratuity">Gratuity</a></li>
			   <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>site/policylog">Policy Log</a></li>
			  <?php } ?>
            </ul>
          </li>
          <!--End of Insurance Menu-->


          <li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>auth-assignment">Authentication</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>profile/resetprofilepassword">Change Password</a></li>
              <!--<li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>user/changepassword/<?php #echo $id; ?>">Change Password</a></li>-->
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl?>../../frontend/web/index.php?r=site%2Fsignup">SignUP</a></li>
               <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>auth-assignment/attendance-access">Attendance Access</a></li>
            </ul>
          </li>
		  
		  <li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Finance<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>finance/hrapproval">Finance</a></li>
			   
            </ul>
          </li>

          <!--Stationary Menu-->
          <li class="menu-item dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Stationary<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vepl-supplier/index">Supplier</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vepl-stationaries/index">Stationary Items</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vepl-stationaries-po/index">Stationary PO</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vepl-stationaries-grn/index">Stationary GRN</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vepl-stationaries-issue/index">Stationary Issuing</a></li>
              <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vepl-stationaries-stock/index">Stationary Stock</a></li>
			  <li class="menu-item "><a href="<?= \Yii::$app->homeUrl ?>vepl-stationaries-issue/issue-report">Issue Statement</a></li>
            </ul>
            <!--End of Stationary Menu-->

          </ul>

          <!-- Right nav -->
          <ul class=" nav navbar-nav navbar-right" style="padding-top:15px;">

            <?php
            if (Yii::$app->user->isGuest) {
              echo '<a href="' . \Yii::$app->homeUrl . 'site/login" style="color:#fff;"> <i class="fa fa-sign-out"></i> <span >Login</span></a>';
            } else {

              echo '<a href="' . \Yii::$app->homeUrl . 'site/logout" style="color:#fff;"> <i class="fa fa-sign-out"></i> <span>Logout(' . Yii::$app->user->identity->username . ')</span></a>';
            }
            ?>
          </form>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="container">
  <?=
  Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ])
  ?>
  <?= Alert::widget() ?>
  <?= $content ?>
</div>
</div>

<footer class="footer">
  <div class="container">
    <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

    <p class="pull-right">Powered by Team ERP</p>
  </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<!--
<li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Setup</a>
<ul class="dropdown-menu">
<li class="menu-item "><a href="#">Page with comments</a></li>
<li class="menu-item "><a href="#">Page with comments disabled</a></li>
<li class="menu-item dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">More</a>
<ul class="dropdown-menu"><li><a href="#">3rd level link more options</a></li><li><a href="#">3rd level link</a></li></ul>
</li>
</ul>
</li>-->

<?php

namespace backend\controllers;

use Yii;
use common\models\EmpDetails;
use app\models\EmpSearch;
use common\models\EmpSalary;
use app\models\EmpSalaryUpload;
use app\models\SalarySearch;
use common\models\Salaryimportclass;
use common\models\EmpLeave;
use common\models\EmpLeaveStaff;
use common\models\EmpPersonaldetails;
use app\models\SalaryUploadSearch;
use common\models\EmpStatutorydetails;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\components\AccessRule;
use common\models\User;
use common\models\Customer;
use common\models\EmpLeaveCounter;
use common\models\EmpRemunerationDetails;
use common\models\StatutoryRates;
use common\models\EmpLeaveCounterLog;
use common\models\EmpPromotion;
use app\models\AuthAssignment;
use kartik\mpdf\Pdf;
use common\models\SalaryMonth;
use common\models\MailForm;
use common\models\EmpSalaryActual;
error_reporting(0);
ini_set('max_execution_time', 0);

class EmpSalaryController extends Controller {

   public function behaviors() {
      return [
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'delete' => ['post'],
              ],
          ],
          'access' => [
              'class' => \yii\filters\AccessControl::className(),
              //'only' => ['create','update','view','delete'],
              'rules' => [
                  // deny all POST requests
                  /* [
                    'allow' => false,
                    'verbs' => ['POST']
                    ], */

                  // allow authenticated users
                  [
                      'allow' => true,
                      'actions' => ['emailindex', 'mailbody', 'bulk-mail', 'month-delete', 'salarymonth', 'generate-all', 'add-month', 'set-month', 'index', 'view', 'empindex', 'salarypdf'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return AuthAssignment::Rights('payroll', 'view');
                 #return Yii::$app->authAssignment->Rights('recruitment', 'view');
              },
                      'roles' => ['@'],
                  ],
                  [
                      'allow' => true,
                      'actions' => ['month-delete', 'salarymonth', 'generate-all', 'add-month', 'set-month', 'update', 'editor', 'bulkgenerate', 'salarygenerate', 'reload', 'update-attendance', 'salary-upload', 'salary-template-engg', 'generate-salary', 'empindex', 'editor'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return AuthAssignment::Rights('payroll', 'update');
                 #return Yii::$app->authAssignment->Rights('recruitment', 'update');
              },
                      'roles' => ['@'],
                  ],
                  [
                      'allow' => true,
                      'actions' => ['month-delete', 'salarymonth', 'generate-all', 'add-month', 'set-month', 'index', 'salarygenerate', 'salary-upload', 'bulkgenerate', 'salarygenerate', 'reload', 'update-attendance', 'salary-upload', 'salary-template-engg', 'generate-salary', 'empindex', 'editor','salary-refresh','delete-salary-uploaded'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return AuthAssignment::Rights('payroll', 'create');
                 #return Yii::$app->authAssignment->Rights('recruitment', 'create');
              },
                  //'roles' => ['@create'],
                  ],
                  [
                      'allow' => true,
                      'actions' => ['month-delete', 'salarymonth', 'generate-all', 'add-month', 'set-month', 'delete','delete-salary-uploaded'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return AuthAssignment::Rights('payroll', 'delete');
                 #return Yii::$app->authAssignment->Rights('recruitment', 'delete');
              },
                      'roles' => ['@'],
                  ],
                  [
                      'allow' => true,
                      'actions' => ['salarypdf'],
                      'roles' => ['?'],
                  ],
              // everything else is denied
              ],
          ],
      ];
   }

    public function actionSalarypdf($id) {
      $model = EmpSalary::find()->where(['email_hash' => $id])->one();
      $content = $this->renderPartial('salarypdf', [ 'model' => $model,]);
      $pdf = new Pdf([
          // set to use core fonts only
          'mode' => Pdf::MODE_CORE,
          // A4 paper format
          'format' => Pdf::FORMAT_A4,
          // portrait orientation
          'orientation' => Pdf::ORIENT_PORTRAIT,
          // stream to browser inline
          'destination' => Pdf::DEST_BROWSER,
          // your html content input
          'content' => $content,
      ]);
      return $pdf->render();
   }

   public function actionIndex() {
      $searchModel = new SalarySearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionEmailindex() {
      $searchModel = new SalarySearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('emailindex', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionMailbody($id) {
      $model = new MailForm();
      if ($model->load(Yii::$app->request->post())) {
         $Salmodel = EmpSalary::findOne($id);
         $ModelEmp = EmpDetails::find()->where(['id' => $Salmodel->empid])->one();
         $model->from = "payroll@voltechgroup.com";
         $model->fromName = 'VEPL Payroll';
         if ($model->sendEmail($ModelEmp->email)) {
            Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
            $Salmodel->email_status = 1;
            $Salmodel->save(false);
         } else {
            Yii::$app->session->setFlash('error', 'There was an error sending your message.');
         }
         return $this->redirect('emailindex');
      }
      return $this->render('mailbody', [
                  'model' => $model,
      ]);
   }

   public function actionBulkMail($modeldata) {
      $model = new MailForm();
      if ($data = unserialize(urldecode($_GET['modeldata']))) {
         $conditions = [];       
         $designparams = $data['designation'];
         $deptparams = $data['department_id'];       
         $divparams = $data['division_id'];
         $empcode = $data['empcode'];
         $empname = $data['empname'];
		
		 if ($data['unit_id'] != '') {
		$conditions[] = 'a.unit_id IN ('.implode(",",$data['unit_id']).')';
        }
		 if ($data['category'] != '') {
		$conditions[] = "b.category IN ('".implode("','",$data['category'])."')";
        }
		
		if ($empname != '') {
            $conditions[] = "b.empname='$empname'";
         }
         if ($empcode != '') {
            $conditions[] = "b.empcode='$empcode'";
         }
        
         if ($designparams != '') {
            $conditions[] = "a.designation=$designparams";
         }
         if ($deptparams != '') {
            $conditions[] = "a.department_id=$deptparams";
         }
        
         if ($divparams != '') {
            $conditions[] = "a.division_id=$divparams";
         } 

        $query = 'SELECT a.* FROM emp_salary a JOIN emp_details b ON a.empid=b.id';
		
         $query .= " WHERE " . implode(' AND ', $conditions);
		
		 if($data['month']){
		 $month = Yii::$app->formatter->asDate('01-'.$data['month'], "Y-MM-dd");
		  $query .= ' AND month ="'.$month.'"';
		 }
		 
         $ModelSal = EmpSalary::findBySql($query)->all();
      } else {
         $ModelSal = EmpSalary::find()->where(['email_status' => 0])->all();
      }
      foreach ($ModelSal as $Sal) { 	
         $ModelEmp = EmpDetails::find()->where(['id' => $Sal->empid])->one();
		 $EmpPersonal = EmpPersonaldetails::find()->where(['empid' => $Sal->empid])->one();
         $Salmodel = EmpSalary::findOne($Sal->id);
         $model->from = "payroll@voltechgroup.com";
         $model->fromName = 'VEPL Payroll';
         $model->subject = 'Payslip for the Month of ' . Yii::$app->formatter->asDate($Salmodel->month, "php:F Y,");
		
		if($EmpPersonal->gender == 'Male') {
			$salutation ='Mr.'; 
		} elseif($EmpPersonal->gender == 'Female') {
		 $salutation ='Ms.';
		} else {
			$salutation = ''; 
		}
		/*
			Those employees (Permanent-Domestic) who are by designation equal to or greater than Sr. Engineer &ndash; II shall claim their Medical allowances along with the TES statement of March 2019.<br><br>
				Those who were eligible to claim LTA during April 2018 &ndash; September 2018 and failed to claim shall include the same in March 2019 TES claim.<br><br>
				Pictures taken at workplace during Pongal / Holi celebrations are invited. You shall send the picture(s) along with proper descriptions about the members / project of the picture to editorial@voltechgroup.com. After gentle scrutiny, the pictures shall be published in the forthcoming <strong>VOLTECH Vista</strong>.<br><br>

				
		
		*/
		
         $model->body = 'Dear '. $salutation . $ModelEmp->empname . ' (' . $ModelEmp->empcode . '),<br> 
				Your Payslip for the Month of ' . Yii::$app->formatter->asDate($Salmodel->month, "php:F Y,") . ' is available in below link for your kind perusal. <br><br>
				<a href="http://vepl.voltechgroup.com/hrms/backend/web/payslip/salarypdf?id=' . $Salmodel->email_hash . '"> click here to download your payslip</a><br><br>     
				
			
				Please revert us for clarifications (if any). <br><br><br>
				Regards, <br>
				P.Arun Kumar <br>
				Dy. Manager HR (Payroll) <br>
				9600159627';
				
        if($Salmodel->email_status == 0){
			if ($model->sendEmail($ModelEmp->email)) {
            Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
            $Salmodel->email_status = 1;
            $Salmodel->save(false);
         } else {
            Yii::$app->session->setFlash('error', $ModelEmp->empname.'-> Email missing.');
         } 
		} else {
		 Yii::$app->session->setFlash('error', $ModelEmp->empname.'->Already Send');
		} 
      }
     return $this->redirect('emailindex');
   }

   public function actionSalarymonth() {
      $dataProvider = new ActiveDataProvider([
          'query' => SalaryMonth::find(),
      ]);

      return $this->render('salarymonth', [
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionMonthDelete($id) {
      $delmodel = SalaryMonth::findOne($id);
      $model = SalaryMonth::find()->where(['>', 'month', $delmodel->month])->one();
      if ($model) {
         Yii::$app->session->setFlash("error", 'Delete Last Month Only');
      } else {
         $transaction = \Yii::$app->db->beginTransaction();    // Transaction begin
         try {
            $count = 0;
            $SalaryModel = EmpSalary::find()->where(['month' => $delmodel->month])->all();
            foreach ($SalaryModel as $Salary) {
               $m = date("m", strtotime($Salary->month));
               $y = date("Y", strtotime($Salary->month));
               $modelLeave = EmpLeave::find()->where(['empid' => $Salary->empid])->one();
               $modelLeaveStaff = EmpLeaveStaff::find()->where(['empid' => $Salary->empid])->one();
               $leave = EmpLeaveCounter::find()->where(['empid' => $Salary->empid, 'month' => $delmodel->month])->one();

               $remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $Salary->empid])->one();
               $PayScale = EmpStaffPayScale::find()
                       ->where(['salarystructure' => $remunerationmodel->salary_structure])
                       ->one();

               $Salarystructure = EmpSalarystructure::find()
                       ->where(['salarystructure' => $remunerationmodel->salary_structure])
                       ->one();

               $updateleave = $leave->leave_days - $leave->lop_days;
               if ($PayScale && $modelLeaveStaff) {
                  if ($m > 3 && $m <= 6) {
                     $modelLeaveStaff->remaining_leave_first_quarter +=$updateleave;
                     $modelLeaveStaff->leave_taken_first_quarter = $modelLeaveStaff->leave_taken_first_quarter - $leave->leave_days;
                  } else if ($m > 6 && $m <= 9) {
                     $modelLeaveStaff->remaining_leave_second_quarter +=$updateleave;
                     $modelLeaveStaff->leave_taken_second_quarter = $modelLeaveStaff->leave_taken_second_quarter - $leave->leave_days;
                  } else if ($m > 9 && $m <= 12) {
                     $modelLeaveStaff->remaining_leave_third_quarter +=$updateleave;
                     $modelLeaveStaff->leave_taken_third_quarter = $modelLeaveStaff->leave_taken_third_quarter - $leave->leave_days;
                  } else if ($m > 1 && $m <= 3) {
                     $modelLeaveStaff->remaining_leave_fourth_quarter +=$updateleave;
                     $modelLeaveStaff->leave_taken_fourth_quarter = $modelLeaveStaff->leave_taken_fourth_quarter - $leave->leave_days;
                  }
                  $modelLeaveStaff->save(false);
               } else if ($Salarystructure && $modelLeave) {
                  if ($m > 3 && $m <= 9) {
                     $modelLeave->remaining_leave_first_half +=$updateleave;
                     $modelLeave->leave_taken_first_half = $modelLeave->leave_taken_first_half - $leave->leave_days;
                  } else if ($m > 9 && $m <= 12) {
                     $modelLeave->remaining_leave_second_half +=$updateleave;
                     $modelLeave->leave_taken_second_half = $modelLeave->leave_taken_second_half - $leave->leave_days;
                  } else if ($m > 1 && $m <= 3) {
                     $modelLeave->remaining_leave_second_half +=$updateleave;
                     $modelLeave->leave_taken_second_half = $modelLeave->leave_taken_second_half - $leave->leave_days;
                  }
                  $modelLeave->save(false);
               }
               $Salary->delete();
               $count++;
            }
            $delmodel->delete();
            $uploadedmonth = EmpSalaryUpload::deleteAll(['month' => $delmodel->month]);
            $transaction->commit();
         } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
         } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
         }

         Yii::$app->session->setFlash("success", $count . ' Salary Deleted for this Month');
      }
      return $this->redirect('salarymonth');
   }

   public function actionAddMonth() {
      $data = Yii::$app->request->post();
      $month = '01-' . $data['month'];
      $currentmonth = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");	   
	   $salarymonth = Yii::$app->formatter->asDate($currentmonth, "yyyy-MM"); 
      $salmonth = SalaryMonth::find()->where(['month' => $currentmonth])->one();
      if ($salmonth) {
         $jsonData['error'] = 'Already Generated';
      } else {
         $uploadedmonth = EmpSalaryUpload::find()->where(['status' => 'Uploaded'])->one();
         if ($uploadedmonth) {
            $jsonData['error'] = 'uploaded error';
         } else {
            $ModelEmp = EmpDetails::find()->where(['status' => ['Paid and Relieved', 'Active', '']])
                            ->orWhere(['status' => null])->all();
            foreach ($ModelEmp as $emp) {			 
			 $empdojmonth = Yii::$app->formatter->asDate($emp->doj, "yyyy-MM");
			if($empdojmonth <= $salarymonth){
               $modelupload = new EmpSalaryUpload();
               $modelupload->empid = $emp->id;
               $modelupload->month = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");
               $modelupload->status = 'Uploaded';
               $modelupload->save(false);
			}
            }
            $modelmonth = new SalaryMonth();
            $modelmonth->month = $currentmonth;
            $modelmonth->save(false);
            $jsonData['success'] = 'generated';
         }
      }
      return json_encode($jsonData);
   }

   public function actionSetMonth() {
      $model = new EmpSalaryUpload();
      return $this->render('set-month', [
                  'model' => $model,
      ]);
   }

   public function actionSalarygenerate() {
      $promotion = EmpPromotion::find()->where(['flag' => 0])->all();
      foreach ($promotion as $list) {
         Yii::$app->session->addFlash("success", 'User ' . $list->employee->empcode . ' available promotion');
      }

      $searchModel = new SalaryUploadSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('salarygenerate', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionGenerateAll() {
      $data = Yii::$app->request->post();
      echo $data['month'];
      /* $result_success = [];
        $result_failure = [];

        $query = EmpSalaryUpload::find()->where(['emp_salary_upload.status' => 'Uploaded']);
        $query->joinWith(['employee.department', 'employee.units','employee.division']);

        if ($data['month'] != 0) {
        $salarymonth = Yii::$app->formatter->asDate('01-' . $data['month'], "yyyy-MM-dd");
        $query->andFilterWhere(['like', 'month', $salarymonth]);
        }

        $query->andFilterWhere([
        'department_id' => $data['dept'],
        'unit_id' => $data['unit'],
        'division_id' => $data['division'],
        ]);
        $query->all();
        print_r($query); */
   }

   public function actionUpdateAttendance($id) {
      $model = $this->findSalaryUploadModel($id);
      if ($model->load(Yii::$app->request->post())) {
         $model->save(false);
         return $this->redirect('salarygenerate');
      }
      return $this->render('update-attendance', [
                  'model' => $model,
      ]);
   }

   public function actionBulkgenerate() {
      $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
      $data = Yii::$app->request->post();
      $result_success = [];
      $result_failure = [];
      foreach($data['keylist'] as $key) {
		 $advEar =0;
         $model = EmpSalaryUpload::find()->where(['id' => $key])->one();
         $Emp = EmpDetails::find()->where(['id' => $model->empid])->one();
         $sal = EmpSalary::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();
         $remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $Emp->id])->one();
         $statutory = EmpStatutorydetails::find()->where(['empid' => $Emp->id])->one();

         $PayScale = EmpStaffPayScale::find()
                 ->where(['salarystructure' => $remunerationmodel->salary_structure])
                 ->one();

         $Salarystructure = EmpSalarystructure::find()
                 ->where(['salarystructure' => $remunerationmodel->salary_structure])
                 ->one();

         $updateflag = 0;

         $sal = EmpSalary::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();
         if ($sal) {
            $Salary = EmpSalary::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();
            $m = date("m", strtotime($Salary->month));
            $y = date("Y", strtotime($Salary->month));
            $modelLeave = EmpLeave::find()->where(['empid' => $model->empid])->one();
            $modelLeaveStaff = EmpLeaveStaff::find()->where(['empid' => $model->empid])->one();
            $leave = EmpLeaveCounter::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();

            $updateleave = $leave->leave_days - $leave->lop_days;
            if ($PayScale && $modelLeaveStaff) {
               if ($m > 3 && $m <= 6) {
                  $modelLeaveStaff->remaining_leave_first_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_first_quarter = $modelLeaveStaff->leave_taken_first_quarter - $leave->leave_days;
               } else if ($m > 6 && $m <= 9) {
                  $modelLeaveStaff->remaining_leave_second_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_second_quarter = $modelLeaveStaff->leave_taken_second_quarter - $leave->leave_days;
               } else if ($m > 9 && $m <= 12) {
                  $modelLeaveStaff->remaining_leave_third_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_third_quarter = $modelLeaveStaff->leave_taken_third_quarter - $leave->leave_days;
               } else if ($m > 1 && $m <= 3) {
                  $modelLeaveStaff->remaining_leave_fourth_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_fourth_quarter = $modelLeaveStaff->leave_taken_fourth_quarter - $leave->leave_days;
               }
               $modelLeaveStaff->save(false);
            } else if ($Salarystructure && $modelLeave) {
               if ($m > 3 && $m <= 9) {
                  $modelLeave->remaining_leave_first_half +=$updateleave;
                  $modelLeave->leave_taken_first_half = $modelLeave->leave_taken_first_half - $leave->leave_days;
               } else if ($m > 9 && $m <= 12) {
                  $modelLeave->remaining_leave_second_half +=$updateleave;
                  $modelLeave->leave_taken_second_half = $modelLeave->leave_taken_second_half - $leave->leave_days;
               } else if ($m > 1 && $m <= 3) {
                  $modelLeave->remaining_leave_second_half +=$updateleave;
                  $modelLeave->leave_taken_second_half = $modelLeave->leave_taken_second_half - $leave->leave_days;
               }
               $modelLeave->save(false);
            }
            $updateflag = 1;			
         } else {
            $Salary = new EmpSalary();				
         }
		
		$Actualcheck = EmpSalaryActual::find()->Where(['empid' => $model->empid, 'month' => $model->month])->one();
		
		if($Actualcheck){
		$Actual = EmpSalaryActual::find()->Where(['empid' => $model->empid, 'month' => $model->month])->one();
		} else {
		$Actual = new EmpSalaryActual();	
		}
		
         $created_at = date('Y-m-d H:i:s');

         $workstatus = 0;
         $loss_of_pay_days = 0;
         $Earned_Allovance = 0;
         $avance_tes = 0;
         $tes = 0;
		 $pf_wages =0;

         ########################## End Fetch Data ##################	

         $m = date("m", strtotime($model->month));
         $y = date("Y", strtotime($model->month));
         $maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y); // maximum days for month

         $relievemonth = date("m-Y", strtotime($Emp->dateofleaving));
         $dojmonth = date("m-Y", strtotime($Emp->doj));
         $salprocessing = date("m-Y", strtotime($model->month));

         if ($dojmonth == $salprocessing) {
            $doj = date("d", strtotime($Emp->doj));
            $your_date = date("t", strtotime($model->month));
            $workingDays = ($your_date - $doj) + 1;
            $workstatus = 1;
         } else if (($Emp->status == 'Paid and Relieved' || $Emp->status == 'Relieved') && $salprocessing == $relievemonth) {
            $relievedate = strtotime($Emp->dateofleaving);
            $your_date = strtotime($model->month);
            $datediff = $relievedate - $your_date;
            $workingDays = round($datediff / (60 * 60 * 24)) + 1; // maximum days for month	
            $workstatus = 1;
         } else if ($Emp->status == 'Relieved') {
            $workingDays = 0;
            $workstatus = 1;
         }

         $transaction = \Yii::$app->db->beginTransaction();    // Transaction begin
         try {
            $provident_fund = 0;
            $employee_state_insurance = 0;
            $professional_tax = 0;
            $grossamount = 0;
            $present_days = 0;

            //***************************** salary processing begin *************************/			
            $Salary->empid = $Emp->id;
            $Salary->date = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
            // $Salary->attendancetype = $model->staff_type;
            $Salary->month = $model->month;
            $Salary->user = Yii::$app->user->id;
            $Salary->statutoryrate = $model->statutory_rate;

            if ($Salarystructure && $remunerationmodel->attendance_type != 'Contract') {   //// For Site engg 				  			          		  
               /*                * ********************** Leave Update Engineer *************************** */
               $Leave = EmpLeave::find()->where(['empid' => $model->empid])->one();
               if ($Leave)
                  $loss_of_pay_days = $model->LeaveUpdate($m, $model->leavedays, $Leave);
               else
                  $loss_of_pay_days = $model->leavedays;

               if ($workstatus == 1) {
                  $present_days = $workingDays - ($loss_of_pay_days + $model->lop_days);
                  $day_count = $workingDays;
               } else {
                  $present_days = $maxDays - ($loss_of_pay_days + $model->lop_days);
                  $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
               }

               if ($present_days == $maxDays || $present_days >= 30) {
                  $dadays = 30;
               } else {
                  $dadays = $present_days;
               }
               $workdays = 0;

               //loop through all days
               for ($i = 1; $i <= $day_count; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               }

               ##################################  ///TES Calculation  ///#################################
			   if($Emp->unit_id == 12){
				   $Earned_Allovance = round(($remunerationmodel->dearness_allowance / $maxDays) * $present_days);                   
				   $tes =0;				  
				   } else {
               $Earned_Allovance = round(($remunerationmodel->dearness_allowance / 30) * $dadays); /// DA should be fixed as 30day per month;			   
               $tes = $Earned_Allovance - $model->allowance_paid;
               if ($tes > 0) {
                  $tes = $tes;
                  $avance_tes = 0;
               } else {
                  $avance_tes = abs($tes);
                  $tes = 0;
               }
			}
               ############################### Assign Engg Salary #############################

               $Salary->basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
               $Salary->hra = round(($remunerationmodel->hra / $maxDays) * $present_days);
               $Salary->dearness_allowance = $Earned_Allovance;
               $Salary->advance_arrear_tes = $avance_tes;
               $Salary->tes = $tes;
               $Salary->other_allowance = round(($remunerationmodel->other_allowance / $maxDays) * $present_days);
               $Salary->spl_allowance = $model->special_allowance;

               $present_days_for_statutory = $workdays - ($loss_of_pay_days + $model->lop_days);
               $earned_statutory_rate = $model->statutory_rate * $present_days_for_statutory;
               $earned_gross = (((($remunerationmodel->gross_salary - $remunerationmodel->dearness_allowance) / $maxDays) * $present_days) + $Earned_Allovance + $model->arrear + $model->holiday_pay + $model->special_allowance + $model->over_time + $avance_tes);

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($Salary->hra + $model->special_allowance + $model->over_time)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - $model->special_allowance));

               if ($remunerationmodel->pf_applicablity == 'Yes') {
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					    $pf_wages = 15000;
                        $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                        $Salary->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
						$pf_wages = $statutory_rate_pf;
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
					 $pf_wages = $statutory_rate_pf;
                  }
               } else {
			      $pf_wages = 0;
                  $provident_fund = 0;
                  $Salary->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $Salary->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $Salary->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $Salary->esi_employer_contribution = 0;
               }
            } else if ($remunerationmodel->salary_structure == 'Contract') {  // for Contract Employee
               $workdays = 0;
			    $tes = 0;
			   $contract_workdays =0;
			if ($dojmonth == $salprocessing) {
				$doj = date("d", strtotime($Emp->doj));								
				 for ($i = $doj; $i <= $maxDays; $i++) {
					 $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               }				
			} else if (($Emp->status == 'Paid and Relieved' || $Emp->status == 'Relieved') && $salprocessing == $relievemonth) {				
				$end_date = date("t", strtotime($Emp->dateofleaving));	
				 for ($i = 1; $i <= $end_date; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               }				
			} else if ($Emp->status == 'Relieved') {
				$workdays = 0;
			} else {
			  for ($i = 1; $i <= $maxDays; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               }			
			}                 
				  for ($i = 1; $i <= $maxDays; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $contract_workdays += 1;
                  }
               }              

               //loop through all days               

               $joinYear = date('Y', strtotime($Emp->doj));
               $joinMonth = date('m', strtotime($Emp->doj));
               $diff_year = $y - $joinYear;
               if ($diff_year == 0) {
                  if ($joinMonth < 4) {
                     if ($m < 4) {
                        $num_month = 9 + $m;
                     } else {
                        $num_month = $m - 3;
                     }
                  } else {
                     $diff_month = $m - $joinMonth;
                     if ($diff_month == 0) {
                        $num_month = 1;
                     } else {
                        $num_month = $diff_month;
                     }
                  }
               } else if ($diff_year > 1) {
                  if ($m < 4) {
                     $num_month = 9 + $m;
                  } else {
                     $num_month = $m - 3;
                  }
               } else if ($diff_year == 1) {
                  if ($joinMonth < 4 || $m < 4) {
                     $num_month = 9 + $m;
                  } else if ($joinMonth > 3 || $m < 4) {
                     $diffMonth = 12 - $joinMonth;
                     $num_month = $diffMonth + $m;
                  } else if ($m > 3) {
                     $num_month = $m - 3;
                  }
               }


               if ($m < 4) {
                  $year = $y - 1;
                  $start = date('Y-m-d', strtotime('01-04-' . $year));
                  $num_month = 9 + $m;
               } else {
                  $start = date('Y-m-d', strtotime('01-04-' . $y));
                  $num_month = $m - 3;
               }
               $end = date('Y-m-d', strtotime('01-' . $model->month));

               $command = Yii::$app->db->createCommand("SELECT sum(leave_days) FROM emp_leave_counter where empid =" . $Emp->id . " AND month  BETWEEN '$start' AND '$end'");
               $sumLeave = $command->queryScalar();
               $remaing_leave = ($num_month * 2) - $sumLeave;
               $balance_leave = $remaing_leave - $model->leavedays;

               if ($balance_leave >= 0) {
                  $present_days = $workdays - ($model->leavedays + $model->lop_days);
               } else {
                  $present_days = $workdays - (abs($balance_leave) + $model->lop_days);
               }



               $Salary->basic = round(($remunerationmodel->basic / $contract_workdays) * $present_days);
               $Salary->hra = round(($remunerationmodel->hra / $contract_workdays) * $present_days);
              // $Salary->dearness_allowance = round(($remunerationmodel->dearness_allowance / $contract_workdays) * $present_days);

              /* $Earned_Allovance = round(($remunerationmodel->dearness_allowance / $contract_workdays) * $present_days);
               $tes = $Earned_Allovance - $model->allowance_paid;
               if ($tes > 0) {
                  $tes = $tes;
                  $avance_tes = 0;
               } else {
                  $avance_tes = abs($tes);
                  $tes = 0;
               } */
				   if($model->allowance_paid){
						$advEar = $model->allowance_paid;
					} else {
						$advEar = 0;
					}
					
			   $Salary->dearness_allowance = round(($remunerationmodel->dearness_allowance / $contract_workdays) * $present_days);

               $Salary->spl_allowance = $model->special_allowance;
               $Salary->guaranted_benefit = round(($remunerationmodel->guaranteed_benefit / $contract_workdays) * $present_days);
               $Salary->dust_allowance = round(($remunerationmodel->dust_allowance / $contract_workdays) * $present_days);
               $Salary->performance_pay = round(($remunerationmodel->personpay / $contract_workdays) * $present_days);
               $Salary->other_allowance = round(($remunerationmodel->other_allowance / $contract_workdays) * $present_days);
			   $Salary->misc = round(($remunerationmodel->misc / $contract_workdays) * $present_days);
				
               $earned_statutory_rate = $model->statutory_rate * $present_days;
               $earned_gross = round((($remunerationmodel->gross_salary / $contract_workdays) * $present_days) + $model->arrear + $model->holiday_pay + $model->special_allowance + $model->over_time);

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($Salary->hra + $model->special_allowance + $model->over_time + $Salary->misc)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - ($model->special_allowance + $Salary->misc)));


               if ($remunerationmodel->pf_applicablity == 'Yes') {
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					   $pf_wages = 15000;
                        $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                        $Salary->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
						$pf_wages = $statutory_rate_pf;
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
					 $pf_wages = $statutory_rate_pf;
                  }
               } else {
			      $pf_wages = 0;
                  $provident_fund = 0;
                  $Salary->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $Salary->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $Salary->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $Salary->esi_employer_contribution = 0;
               }

               $Salary->advance_arrear_tes = $avance_tes;
               $Salary->over_time = $model->over_time;
               $Salary->tes = $tes;
			   
            } else if ($remunerationmodel->salary_structure == 'Consolidated pay') {     // salary for Consolidated pay
               $max_statutory_rate = 0;
               $tes = 0;
               $avance_tes = 0;
               $gb = 0;
               $dust = 0;
               $perpay = 0;

               if ($workstatus == 1) {
                  $present_days = $workingDays - ($model->leavedays + $model->lop_days);
               } else {
                  $present_days = $maxDays - ($model->leavedays + $model->lop_days);
               }
			   
               $Salary->basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
               // $Salary->other_allowance = round((($remunerationmodel->other_allowance / $maxDays) * $present_days));					
               $Salary->spl_allowance = $model->special_allowance;

               $earned_statutory_rate = $model->statutory_rate * $present_days;
               $earned_gross = (($remunerationmodel->gross_salary / $maxDays) * $present_days) + $model->arrear + $model->holiday_pay + $model->special_allowance + $model->over_time;

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($model->special_allowance + $model->over_time)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - $model->special_allowance));

               if ($remunerationmodel->pf_applicablity == 'Yes') {
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					    $pf_wages = 15000;
                        $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                        $Salary->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = $statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100);
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
						$pf_wages = $statutory_rate_pf;
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
					 $pf_wages = $statutory_rate_pf;
                  }
               } else {
			      $pf_wages = 0;
                  $provident_fund = 0;
                  $Salary->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $Salary->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $Salary->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $Salary->esi_employer_contribution = 0;
               }
            } else if ($PayScale) {   ///// For Staff
			  ######################## Leave Update Staff #####################################
               $LeaveStaff = EmpLeaveStaff::find()->where(['empid' => $model->empid])->one();
               if ($LeaveStaff)
                  $loss_of_pay_days = $model->LeaveUpdateStaff($m, $model->leavedays, $LeaveStaff);
               else
                  $loss_of_pay_days = $model->leavedays;


               if ($workstatus == 1) {
                  $present_days = $workingDays - ($loss_of_pay_days + $model->lop_days);
               } else {
                  $present_days = $maxDays - ($loss_of_pay_days + $model->lop_days);
               }

               ################################ Staff  Salary ##################################
				
			    if($model->allowance_paid){
						$advEar = $model->allowance_paid;
					} else {
						$advEar = 0;
				}
					
               $Salary->basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
               $Salary->hra = round(($remunerationmodel->hra / $maxDays) * $present_days);
               $Salary->dearness_allowance = round(($remunerationmodel->dearness_allowance / $maxDays) * $present_days);
               $Salary->spl_allowance = $model->special_allowance;
               $Salary->conveyance_allowance = round(($remunerationmodel->conveyance / $maxDays) * $present_days);
               $Salary->lta_earning = round($PayScale->lta * $Salary->basic);
               $Salary->medical_earning = round($PayScale->medical * $Salary->basic);
               $Salary->other_allowance = round(($remunerationmodel->other_allowance / $maxDays) * $present_days);
               $earned_gross = (($remunerationmodel->gross_salary / $maxDays) * $present_days) + $model->special_allowance + $model->arrear + $model->holiday_pay + $model->over_time;

               $earned_statutory_rate = $model->statutory_rate * $present_days;

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($Salary->hra + $model->special_allowance + $model->over_time)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - $model->special_allowance));


               ######################## Staff PF ,ESI ,PT calculations ##########################

               if ($remunerationmodel->pf_applicablity == 'Yes') {
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					   $pf_wages = 15000;
                        $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                        $Salary->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
						$pf_wages = $statutory_rate_pf;
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $Salary->pf_employer_contribution = 0;
                        } else {
                           $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $Salary->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
					 $pf_wages = $statutory_rate_pf;
                  }
               } else {
			     $pf_wages = 0;
                  $provident_fund = 0;
                  $Salary->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $Salary->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $Salary->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $Salary->esi_employer_contribution = 0;
               }
            }

            if ($statutory->professionaltax == 'Yes') {

             if ($remunerationmodel->gross_salary > 12500) {
                  $professional_tax = 209;
               } else if ($remunerationmodel->gross_salary <= 12500 && $remunerationmodel->gross_salary > 10000) {
                  $professional_tax = 171;
               } else if ($remunerationmodel->gross_salary <= 10000 && $remunerationmodel->gross_salary > 7500) {
                  $professional_tax = 115;
               } else if ($remunerationmodel->gross_salary <= 7500 && $remunerationmodel->gross_salary > 5000) {
                  $professional_tax = 53;
               } else if ($remunerationmodel->gross_salary <= 5000 && $remunerationmodel->gross_salary > 3500) {
                  $professional_tax = 23;
               } else {
                  $professional_tax = 0;
               } 
			   
			  
            }
			
############################### Assign Engg / Staff Salary #############################

            $Salary->paiddays = $present_days;


            $Salary->paidallowance = $model->allowance_paid;
            $Salary->work_level = $remunerationmodel->work_level;
            $Salary->grade = $remunerationmodel->grade;
            $Salary->designation = $Emp->designation_id;
            $Salary->unit_id = $Emp->unit_id;
            $Salary->department_id = $Emp->department_id;
            $Salary->division_id = $Emp->division_id;
            $Salary->earnedgross = round($earned_gross);
            $Salary->salary_structure = $remunerationmodel->salary_structure;
            $Salary->arrear = $model->arrear;
            $Salary->holiday_pay = $model->holiday_pay;
            $Salary->forced_lop = $model->lop_days;
            $Salary->over_time = $model->over_time;

            $Salary->total_earning = ( $Salary->basic + $Salary->hra + $Salary->dearness_allowance + $Salary->spl_allowance + $Salary->conveyance_allowance +
                    $Salary->lta_earning + $Salary->medical_earning + $Salary->other_allowance + $Salary->arrear + $Salary->guaranted_benefit + $Salary->dust_allowance + $Salary->performance_pay + $Salary->holiday_pay + $Salary->advance_arrear_tes + $Salary->over_time + $Salary->misc);

######### deduction ###########
			$Salary->pf_wages = $pf_wages;
			$Salary->esi_wages = $remunerationmodel->gross_salary <= 21000 ? $statutory_rate_esi : 0;
            $Salary->pf = $provident_fund;
            $Salary->insurance = $model->insurance;
            $Salary->professional_tax = $professional_tax;
            $Salary->mobile = $model->mobile;
            $Salary->esi = $employee_state_insurance;
			if($advEar !=0){
				$Salary->advance = $advEar + $model->advance;
				} else{
				$Salary->advance = $model->advance;
				}            
            $Salary->other_deduction = $model->others;
            $Salary->loan = $model->loan;
            $Salary->rent = $model->rent;
            $Salary->lwf = $model->lwf;
            $Salary->tds = $model->tds;
			$Salary->customer_id = $model->customer_id;
			$Salary->priority = $model->priority;			
			
            // $Salary->total_deduction = ($Salary->pf + $Salary->insurance + $Salary->professional_tax + $Salary->mobile + $Salary->esi + $Salary->advance + $Salary->other_deduction + $Salary->tes);

            $Salary->total_deduction = round($Salary->pf + $Salary->esi + $Salary->insurance + $Salary->professional_tax + $Salary->advance +
                    $Salary->mobile + $Salary->loan + $Salary->rent + $Salary->tds + $Salary->lwf + $Salary->other_deduction + $Salary->tes);
            $Salary->net_amount = $Salary->total_earning - $Salary->total_deduction;

            /*             * **************************************** CTC Caluculation *********************************** */


            $Salary->pli_employer_contribution = round($Salary->basic * ($remunerationmodel->pli / 100));

            if ($remunerationmodel->salary_structure == 'Manager' || $remunerationmodel->salary_structure == 'Assistant Manager' || $remunerationmodel->salary_structure == 'Sr. Engineer - I' || $remunerationmodel->salary_structure == 'Sr. Engineer - II') {
               $Salary->lta_employer_contribution = round($Salary->basic * 0.0833);
               $Salary->med_employer_contribution = round($Salary->basic * 0.0833);
            } else {
               $Salary->lta_employer_contribution = 0;
               $Salary->med_employer_contribution = 0;
            }
            $Salary->earned_ctc = $Salary->total_earning + $Salary->pf_employer_contribution + $Salary->esi_employer_contribution + $Salary->pli_employer_contribution + $Salary->lta_employer_contribution + $Salary->med_employer_contribution;
            $Salary->email_status = 0;
            $Salary->email_hash = hash('ripemd128', $Salary->empid . $Salary->month . $created_at);
            if ($Salary->save(false)) {
				$lastID = Yii::$app->db->getLastInsertID();				
				$Actual->empid = $Emp->id;
				$Actual->month = $model->month;
				$Actual->basic = $remunerationmodel->basic;
				$Actual->hra = $remunerationmodel->hra;
				//$Actual->spl_allowance = $remunerationmodel->
				$Actual->dearness_allowance = $remunerationmodel->dearness_allowance;
				$Actual->conveyance_allowance = $remunerationmodel->conveyance;
				$Actual->lta_earning = $remunerationmodel->lta;
				$Actual->medical_earning = $remunerationmodel->medical;
				$Actual->guaranted_benefit = $remunerationmodel->guaranteed_benefit;
				//$Actual->holiday_pay = $remunerationmodel->
				//$Actual->washing_allowance = $remunerationmodel->
				$Actual->dust_allowance = $remunerationmodel->dust_allowance;
				$Actual->performance_pay = $remunerationmodel->personpay;
				$Actual->misc = $remunerationmodel->misc;
				$Actual->other_allowance = $remunerationmodel->other_allowance;
				$Actual->gross = $remunerationmodel->gross_salary;
				$Actual->save(false);               
               $model->status = 'Salary Generated';
               $model->save(false);
               if ($Emp->status == 'Paid and Relieved' && $salprocessing == $relievemonth) {
                  $EmpModel = EmpDetails::find()->where(['id' => $model->empid])->one();
                  $EmpModel->status = 'Relieved';
                  $EmpModel->save(false);
               }
               if ($updateflag == 1) {
                  $leavecount = EmpLeaveCounter::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();
               } else {
                  $leavecount = new EmpLeaveCounter();
               }
               $leavecount->empid = $model->empid;
               $leavecount->month = $model->month;
               $leavecount->leave_days = $model->leavedays;
               $leavecount->forced_lop = $model->lop_days;
               $leavecount->lop_days = $loss_of_pay_days;
               $leavecount->save(false);
               $transaction->commit();    // Transaction Commit						

               $result_success[] = $Emp->empcode . '-Salary Generated for month < ' . Yii::$app->formatter->asDate($model->month, "MM-yyyy") . '></br>';
            }
         } catch (\Exception $e) {     // Transaction Exception
            $transaction->rollBack();
            throw $e;
         } catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            throw $e;
         } catch (\yii\base\Exception $e) {
            $transaction->rollBack();
            throw $e;
         } catch (\Throwable $e) {
            echo $e->getMessage();
            throw $e;
         }
      }
      $jsonData['success'] = $result_success;
      $jsonData['error'] = $result_failure;
      return json_encode($jsonData);
   }

   public function actionEditor() {
      $searchModel = new SalarySearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('editor', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionEmpindex() {
      $searchModel = new EmpSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('empindex', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionGenerateSalary($id) {

      return $this->render('generate-salary', [
                  'model' => $this->findSalaryUploadModel($id),
      ]);
   }

   public function actionSalaryTemplateEngg($id) {
      return $this->renderpartial('salary-template-engg', ['id' => $id]);
   }

   public function actionSalaryUpload() {
      $model = new EmpSalaryUpload();

      if ($model->load(Yii::$app->request->post())) {
         $model->month = '01-' . $model->month;
         $Uploaded = 'Uploaded';
         $model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
         $salmonth = SalaryMonth::find()->where(['month' => $model->month])->one();
         if ($salmonth) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
               $model->file->saveAs('employee/' . $model->file->baseName . '.' . $model->file->extension);
               $fileName = 'employee/' . $model->file->baseName . '.' . $model->file->extension;
            }

            $data = \moonland\phpexcel\Excel::widget([
                        'mode' => 'import',
                        'fileName' => $fileName,
                        'setFirstRecordAsKeys' => true,
            ]);

           $transaction = \Yii::$app->db->beginTransaction();
            try {
               $startrow = 2;
               $countrow = 0;
               $connection = \Yii::$app->db;
               foreach ($data as $key => $excelrow) {

				 $ModelEmp =EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                  if ($excelrow['Customer'] != '') {

                     $ModelCust = Customer::find()->where(['customer_name' => $excelrow['Customer']])->one();
                     if ($ModelCust) {
                        $cust_id = $ModelCust->id;
                     } else {
                        Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error:Staff Type Mismatch');
                        $startrow++;
                        $countrow +=1;
                        continue;
                     }
                  } else {
                     $cust_id = 'NULL';
                  }
                try {
                     $salaryUploadcount = EmpSalaryUpload::find()->where(['empid' => $ModelEmp->id, 'month' => $model->month])->count();
                     if ($salaryUploadcount >=1) {
						$salaryUpload = EmpSalaryUpload::find()->where(['empid' => $ModelEmp->id, 'month' => $model->month])->one();
                        $salaryUpload->empid = $ModelEmp->id;
                        $salaryUpload->staff_type = $model->staff_type;
                        $salaryUpload->month = $model->month;
                        $salaryUpload->statutory_rate = $excelrow['Statutory Rate'];
                        $salaryUpload->leavedays = $excelrow['Leave'];
                        $salaryUpload->lop_days = $excelrow['LOP'];
                        $salaryUpload->allowance_paid = $excelrow['Allowance'];
                        $salaryUpload->over_time = $excelrow['OT'];
                        $salaryUpload->holiday_pay = $excelrow['Holiday Pay'];
                        $salaryUpload->arrear = $excelrow['Arrear'];
                        $salaryUpload->special_allowance = $excelrow['Special Allowance'];
                        $salaryUpload->advance = $excelrow['Advance'];
                        $salaryUpload->mobile = $excelrow['Mobile Deduction'];
                        $salaryUpload->loan = $excelrow['Loan'];
                        $salaryUpload->insurance = $excelrow['Insurance'];
                        $salaryUpload->rent = $excelrow['Rent'];
                        $salaryUpload->tds = $excelrow['TDS'];
                        $salaryUpload->lwf = $excelrow['LWF'];
                        $salaryUpload->others = $excelrow['Other Deduction'];
                        $salaryUpload->priority = $excelrow['Priority'];
                        $salaryUpload->customer_id = $cust_id;
                        $salaryUpload->status = $Uploaded;
                        $salaryUpload->save(false);
                     } else {
                        $connection->createCommand()->insert('emp_salary_upload', [
                            'empid' => $ModelEmp->id,
                            'staff_type' => $model->staff_type,
                            'month' => $model->month,
                            'statutory_rate' => $excelrow['Statutory Rate'],
                            'leavedays' => $excelrow['Leave'],
                            'lop_days' => $excelrow['LOP'],
                            'allowance_paid' => $excelrow['Allowance'],
                            'over_time' => $excelrow['OT'],
                            'holiday_pay' => $excelrow['Holiday Pay'],
                            'arrear' => $excelrow['Arrear'],
                            'special_allowance' => $excelrow['Special Allowance'],
                            'advance' => $excelrow['Advance'],
                            'mobile' => $excelrow['Mobile Deduction'],
                            'loan' => $excelrow['Loan'],
                            'insurance' => $excelrow['Insurance'],
                            'rent' => $excelrow['Rent'],
                            'tds' => $excelrow['TDS'],
                            'lwf' => $excelrow['LWF'],
                            'others' => $excelrow['Other Deduction'],
                            'priority' => $excelrow['Priority'],
                            'customer_id' => $cust_id,
                            'status' => $Uploaded,
                        ])->execute();
                     }
                  } catch (Exception $e) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error');
                     $countrow +=1;
                     continue;
                  } 
                  /*  } else if ($model->staff_type == 'Staff') {
                    try {
                    $connection->createCommand()->insert('emp_salary_upload', [
                    'empid' => $ModelEmp->id,
                    'staff_type' => $model->staff_type,
                    'month' => $model->month,
                    'leavedays' => $excelrow[$row]['Leave'],
                    'lop_days' => $excelrow['LOP'],
                    'over_time' => $excelrow['OT'],
                    'holiday_pay' => $excelrow['Holiday Pay'],
                    'arrear' => $excelrow['Arrear'],
                    'other_allowance' => $excelrow['Other Allowance'],
                    'advance' => $excelrow['Advance'],
                    'mobile' => $excelrow['Mobile Deduction'],
                    'loan' => $excelrow['Loan'],
                    'insurance' => $excelrow['Insurance'],
                    'rent' => $excelrow['Rent'],
                    'tds' => $excelrow['TDS'],
                    'lwf' => $excelrow['LWF'],
                    'others' => $excelrow['Other Deduction'],
                    'status' => $Uploaded,
                    ])->execute();
                    } catch (Exception $e) {
                    Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error');
                    $countrow +=1;
                    continue;
                    }
                    } */
                 $startrow++;
              }
              if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 2;
				  unlink($fileName);
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been imported');
               } 
            } catch (\Exception $e) {
               $transaction->rollBack();
			    unlink($fileName);
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
			    unlink($fileName);
               throw $e;
            } 
       }  else {
	    Yii::$app->session->setFlash("error", 'Salary Month Not Found');
	   }        
      }
      return $this->render('salary-upload', [
                  'model' => $model,
      ]);
   } 

   public function actionView($id) {
      return $this->render('view', [
                  'model' => $this->findModel($id),
      ]);
   }

   public function actionReload() {
      $model = new EmpSalary();
      if ($post = Yii::$app->request->post()) {
         if (Yii::$app->request->post('reload') == 'submit') {
            $absent = $post['EmpSalary']['absent'];
            $month = $post['EmpSalary']['month'];
            $id = $post['EmpSalary']['empid'];
            $allowance_paid = $post['EmpSalary']['allowance_paid'];
            $lop = $post['EmpSalary']['lop'];
            $statutory_rate = $post['EmpSalary']['statutory_rate'];

            return $this->redirect(['create', 'model' => $model, 'id' => $id, 'allowance_paid' => $allowance_paid, 'statutory_rate' => $statutory_rate, 'absent' => $absent, 'month' => $month, 'lop' => $lop]);
         } else {
            $id = $post['EmpSalary']['empid'];
            return $this->redirect(['create', 'model' => $model, 'id' => $id]);
         }
      }
   }

   public function actionUpdate($id) {
      $model = $this->findModel($id);
      if ($model->load(Yii::$app->request->post())) {
         $transaction = \Yii::$app->db->beginTransaction();    // Transaction begin
         try {
            $uploadmodel = EmpSalaryUpload::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();
            $uploadmodel->statutory_rate = $model->statutoryrate;
            $uploadmodel->leavedays = $model->absent;
            //$uploadmodel->spl_leave = $model->statutoryrate;
            $uploadmodel->lop_days = $model->forced_lop;
            $uploadmodel->allowance_paid = $model->paidallowance;
            $uploadmodel->over_time = $model->over_time;
            $uploadmodel->holiday_pay = $model->holiday_pay;
            $uploadmodel->arrear = $model->arrear;
            $uploadmodel->special_allowance = $model->spl_allowance;
            $uploadmodel->advance = $model->advance;
            $uploadmodel->mobile = $model->mobile;
            $uploadmodel->loan = $model->loan;
            $uploadmodel->insurance = $model->insurance;
            $uploadmodel->rent = $model->rent;
            $uploadmodel->tds = $model->tds;
            $uploadmodel->lwf = $model->lwf;
            $uploadmodel->others = $model->other_deduction;
            $uploadmodel->save(false);

            $Emp = EmpDetails::find()->where(['id' => $model->empid])->one();
            $remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $Emp->id])->one();
            $statutory = EmpStatutorydetails::find()->where(['empid' => $Emp->id])->one();
            $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
			
			$monthmodel = SalaryMonth::find()->where(['>', 'month', $model->month])->one();			
			if($monthmodel){			
			$ActualModel = EmpSalaryActual::find()->Where(['empid' => $model->empid, 'month' => $model->month])->one();			
			 $PayScale = EmpStaffPayScale::find()
                    ->where(['salarystructure' => $model->salary_structure])
                    ->one();

            $Salarystructure = EmpSalarystructure::find()
                    ->where(['salarystructure' => $model->salary_structure])
                    ->one();			
			} else {					
			 $PayScale = EmpStaffPayScale::find()
                    ->where(['salarystructure' => $remunerationmodel->salary_structure])
                    ->one();
            $Salarystructure = EmpSalarystructure::find()
                    ->where(['salarystructure' => $remunerationmodel->salary_structure])
                    ->one();			
			}  

            $m = date("m", strtotime($model->month));
            $y = date("Y", strtotime($model->month));

            $modelLeave = EmpLeave::find()->where(['empid' => $model->empid])->one();
            $modelLeaveStaff = EmpLeaveStaff::find()->where(['empid' => $model->empid])->one();
            $leave = EmpLeaveCounter::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();

            $updateleave = $leave->leave_days - $leave->lop_days;
            if ($PayScale && $modelLeaveStaff) {
               if ($m > 3 && $m <= 6) {
                  $modelLeaveStaff->remaining_leave_first_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_first_quarter = $modelLeaveStaff->leave_taken_first_quarter - $leave->leave_days;
               } else if ($m > 6 && $m <= 9) {
                  $modelLeaveStaff->remaining_leave_second_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_second_quarter = $modelLeaveStaff->leave_taken_second_quarter - $leave->leave_days;
               } else if ($m > 9 && $m <= 12) {
                  $modelLeaveStaff->remaining_leave_third_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_third_quarter = $modelLeaveStaff->leave_taken_third_quarter - $leave->leave_days;
               } else if ($m > 1 && $m <= 3) {
                  $modelLeaveStaff->remaining_leave_fourth_quarter +=$updateleave;
                  $modelLeaveStaff->leave_taken_fourth_quarter = $modelLeaveStaff->leave_taken_fourth_quarter - $leave->leave_days;
               }
               $modelLeaveStaff->save(false);
            } else if ($Salarystructure && $modelLeave) {
               if ($m > 3 && $m <= 9) {
                  $modelLeave->remaining_leave_first_half +=$updateleave;
                  $modelLeave->leave_taken_first_half = $modelLeave->leave_taken_first_half - $leave->leave_days;
               } else if ($m > 9 && $m <= 12) {
                  $modelLeave->remaining_leave_second_half +=$updateleave;
                  $modelLeave->leave_taken_second_half = $modelLeave->leave_taken_second_half - $leave->leave_days;
               } else if ($m > 1 && $m <= 3) {
                  $modelLeave->remaining_leave_second_half +=$updateleave;
                  $modelLeave->leave_taken_second_half = $modelLeave->leave_taken_second_half - $leave->leave_days;
               }
               $modelLeave->save(false);
            }
            $created_at = date('Y-m-d H:i:s');

            $workstatus = 0;
            $loss_of_pay_days = 0;
            $Earned_Allovance = 0;
            $avance_tes = 0;
            $tes = 0;

########################## End Fetch Data ##################	


            $maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y); // maximum days for month

            $relievemonth = date("m-Y", strtotime($Emp->dateofleaving));
            $dojmonth = date("m-Y", strtotime($Emp->doj));
            $salprocessing = date("m-Y", strtotime($model->month));

            if ($dojmonth == $salprocessing) {
               $doj = date("d", strtotime($Emp->doj));
               $your_date = date("t", strtotime($model->month));
               $workingDays = ($your_date - $doj) + 1;
               $workstatus = 1;
            } else if (($Emp->status == 'Paid and Relieved' || $Emp->status == 'Relieved') && $salprocessing == $relievemonth) {
               $relievedate = strtotime($Emp->dateofleaving);
               $your_date = strtotime($model->month);
               $datediff = $relievedate - $your_date;
               $workingDays = round($datediff / (60 * 60 * 24)) + 1; // maximum days for month	
               $workstatus = 1;
            } else if ($Emp->status == 'Relieved') {
               $workingDays = 0;
               $workstatus = 1;
            }


            $provident_fund = 0;
            $employee_state_insurance = 0;
            $professional_tax = 0;
            $grossamount = 0;
            $present_days = 0;
			$pf_wages = 0;
            //***************************** salary processing begin *************************/			

            $model->date = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
            $model->user = Yii::$app->user->id;
            $model->statutoryrate = $model->statutoryrate;

            if ($Salarystructure && $remunerationmodel->attendance_type != 'Contract') {   //// For Site engg 				  			          		  
               /*                * ********************** Leave Update Engineer *************************** */
               $Leave = EmpLeave::find()->where(['empid' => $model->empid])->one();
               if ($Leave)
                  $loss_of_pay_days = $uploadmodel->LeaveUpdate($m, $model->absent, $Leave);
               else
                  $loss_of_pay_days = $model->absent;

               if ($workstatus == 1) {
                  $present_days = $workingDays - ($loss_of_pay_days + $model->forced_lop);
                  $day_count = $workingDays;
               } else {
                  $present_days = $maxDays - ($loss_of_pay_days + $model->forced_lop);
                  $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
               }
			   
			   if ($present_days == $maxDays || $present_days >= 30) {
                  $dadays = 30;
               } else {
                  $dadays = $present_days;
               }
			   
               $workdays = 0;

               //loop through all days
               for ($i = 1; $i <= $day_count; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               }

               ##################################  ///TES Calculation  ///#################################
			   
			 /*   $gross_salary = 0;
			   if($monthmodel){		
			   $ActualModel = EmpSalaryActual::find()->Where(['empid' => $model->empid, 'month' => $model->month])->one();			
			    
				$gross_salary = $ActualModel->gross; */
			   
			   
			   
			   
			    if($model->unit_id == 12){
				   $Earned_Allovance = round(($remunerationmodel->dearness_allowance / $maxDays) * $present_days); 		                  
				   $tes =0;				  
				   } else {
               $Earned_Allovance = round(($remunerationmodel->dearness_allowance / 30) * $dadays); /// DA should be fixed as 30day per month;			   
               $tes = $Earned_Allovance - $model->paidallowance;
				   if ($tes > 0) {
					  $tes = $tes;
					  $avance_tes = 0;
				   } else {
					  $avance_tes = abs($tes);
					  $tes = 0;
				   }
				}
               ############################### Assign Engg Salary #############################

               $model->basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
               $model->hra = round(($remunerationmodel->hra / $maxDays) * $present_days);
               $model->dearness_allowance = $Earned_Allovance;
               $model->advance_arrear_tes = $avance_tes;
               $model->tes = $tes;
               $model->other_allowance = round(($remunerationmodel->other_allowance / $maxDays) * $present_days);
               $model->spl_allowance = $model->spl_allowance;

               $present_days_for_statutory = $workdays - ($loss_of_pay_days + $model->forced_lop);
               $earned_statutory_rate = $model->statutoryrate * $present_days_for_statutory;
               $earned_gross = (((($remunerationmodel->gross_salary - $remunerationmodel->dearness_allowance) / $maxDays) * $present_days) + $Earned_Allovance + $model->arrear + $model->holiday_pay + $model->spl_allowance + $model->over_time + $avance_tes);

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($model->hra + $model->spl_allowance + $model->over_time)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - $model->spl_allowance));

               if ($remunerationmodel->pf_applicablity == 'Yes') {
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					   $pf_wages = 15000;
                        $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                        $model->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $model->pf_employer_contribution = 0;
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
						$pf_wages = $statutory_rate_pf;
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $model->pf_employer_contribution = 0;
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
					 $pf_wages = $statutory_rate_pf;
                  }
               } else {
				  $pf_wages = 0;
                  $provident_fund = 0;
                  $model->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $model->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $model->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $model->esi_employer_contribution = 0;
               }
            } else if ($remunerationmodel->salary_structure == 'Contract') {  // for Contract Employee
              /* $workdays = 0;
               if ($workstatus == 1) {
                  $day_count = $workingDays;
               } else {
                  $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
               }

               //loop through all days
               for ($i = 1; $i <= $day_count; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               } */
			   
			    $workdays = 0;
			    $contract_workdays =0;
					if ($dojmonth == $salprocessing) {
						$doj = date("d", strtotime($Emp->doj));								
						 for ($i = $doj; $i <= $maxDays; $i++) {
							 $date = $y . '/' . $m . '/' . $i; //format date
						  $get_name = date('l', strtotime($date)); //get week day
						  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
						  //if not a weekend add day to array
						  if ($day_name != 'Sun') {
							 $workdays += 1;
						  }
					   }				
					} else if (($Emp->status == 'Paid and Relieved' || $Emp->status == 'Relieved') && $salprocessing == $relievemonth) {				
						$end_date = date("t", strtotime($Emp->dateofleaving));	
						 for ($i = 1; $i <= $end_date; $i++) {
						  $date = $y . '/' . $m . '/' . $i; //format date
						  $get_name = date('l', strtotime($date)); //get week day
						  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
						  //if not a weekend add day to array
						  if ($day_name != 'Sun') {
							 $workdays += 1;
						  }
					   }				
					} else if ($Emp->status == 'Relieved') {
						$workdays = 0;
					} else {
					  for ($i = 1; $i <= $maxDays; $i++) {
						  $date = $y . '/' . $m . '/' . $i; //format date
						  $get_name = date('l', strtotime($date)); //get week day
						  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
						  //if not a weekend add day to array
						  if ($day_name != 'Sun') {
							 $workdays += 1;
						  }
					   }			
					}                 
				  for ($i = 1; $i <= $maxDays; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $contract_workdays += 1;
                  }
               } 

               $joinYear = date('Y', strtotime($Emp->doj));
               $joinMonth = date('m', strtotime($Emp->doj));
               $diff_year = $y - $joinYear;
               if ($diff_year == 0) {
                  if ($joinMonth < 4) {
                     if ($m < 4) {
                        $num_month = 9 + $m;
                     } else {
                        $num_month = $m - 3;
                     }
                  } else {
                     $diff_month = $m - $joinMonth;
                     if ($diff_month == 0) {
                        $num_month = 1;
                     } else {
                        $num_month = $diff_month;
                     }
                  }
               } else if ($diff_year > 1) {
                  if ($m < 4) {
                     $num_month = 9 + $m;
                  } else {
                     $num_month = $m - 3;
                  }
               } else if ($diff_year == 1) {
                  if ($joinMonth < 4 || $m < 4) {
                     $num_month = 9 + $m;
                  } else if ($joinMonth > 3 || $m < 4) {
                     $diffMonth = 12 - $joinMonth;
                     $num_month = $diffMonth + $m;
                  } else if ($m > 3) {
                     $num_month = $m - 3;
                  }
               }


               if ($m < 4) {
                  $year = $y - 1;
                  $start = date('Y-m-d', strtotime('01-04-' . $year));
                  $num_month = 9 + $m;
               } else {
                  $start = date('Y-m-d', strtotime('01-04-' . $y));
                  $num_month = $m - 3;
               }
               $end = date('Y-m-d', strtotime('01-' . $model->month));

               $command = Yii::$app->db->createCommand("SELECT sum(leave_days) FROM emp_leave_counter where empid =" . $Emp->id . " AND month  BETWEEN '$start' AND '$end'");
               $sumLeave = $command->queryScalar();
               $remaing_leave = ($num_month * 2) - $sumLeave;
               $balance_leave = $remaing_leave - $model->absent;

               if ($balance_leave >= 0) {
                  $present_days = $workdays - ($model->absent + $model->forced_lop);
               } else {
                  $present_days = $workdays - (abs($balance_leave) + $model->forced_lop);
               }

               $model->basic = round(($remunerationmodel->basic / $contract_workdays) * $present_days);
               $model->hra = round(($remunerationmodel->hra / $contract_workdays) * $present_days);
               $model->dearness_allowance = round(($remunerationmodel->dearness_allowance / $contract_workdays) * $present_days);
			   $model->misc = round(($remunerationmodel->misc / $contract_workdays) * $present_days);
			   
               $Earned_Allovance = round(($remunerationmodel->dearness_allowance / $contract_workdays) * $present_days);
               $tes = $Earned_Allovance - $model->paidallowance;
               if ($tes > 0) {
                  $tes = $tes;
                  $avance_tes = 0;
               } else {
                  $avance_tes = abs($tes);
                  $tes = 0;
               }


               $model->spl_allowance = $model->spl_allowance;
               $model->guaranted_benefit = round(($remunerationmodel->guaranteed_benefit / $contract_workdays) * $present_days);
               $model->dust_allowance = round(($remunerationmodel->dust_allowance / $contract_workdays) * $present_days);
               $model->performance_pay = round(($remunerationmodel->personpay / $contract_workdays) * $present_days);
               $model->other_allowance = round(($remunerationmodel->other_allowance / $contract_workdays) * $present_days);

               $earned_statutory_rate = $model->statutoryrate * $present_days;
               $earned_gross = round((($remunerationmodel->gross_salary / $contract_workdays) * $present_days) + $model->arrear + $model->holiday_pay + $model->spl_allowance + $model->over_time);

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($model->hra + $model->spl_allowance + $model->over_time + $model->misc)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - ($model->spl_allowance + $model->misc)));


               if ($remunerationmodel->pf_applicablity == 'Yes') {
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					  $pf_wages = 15000;
                        $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                        $model->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
						$pf_wages = $statutory_rate_pf;
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $model->pf_employer_contribution = 0;
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $model->pf_employer_contribution = 0;
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
					 $pf_wages = $statutory_rate_pf;
                  }
               } else {
			      $pf_wages = 0;
                  $provident_fund = 0;
                  $model->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $model->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $model->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $model->esi_employer_contribution = 0;
               }

               $model->advance_arrear_tes = $avance_tes;
               $model->over_time = $model->over_time;
               $model->tes = $tes;
            } else if ($remunerationmodel->salary_structure == 'Consolidated pay') {    // salary process for  Consolidated pay
               $max_statutory_rate = 0;
               $tes = 0;
               $avance_tes = 0;
               $gb = 0;
               $dust = 0;
               $perpay = 0;

               if ($workstatus == 1) {
                  $present_days = $workingDays - ($model->absent + $model->forced_lop);
               } else {
                  $present_days = $maxDays - ($model->absent + $model->forced_lop);
               }
               $model->basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
               $model->spl_allowance = $model->spl_allowance;

               $earned_statutory_rate = $model->statutoryrate * $present_days;
               $earned_gross = (($remunerationmodel->gross_salary / $maxDays) * $present_days) + $model->arrear + $model->holiday_pay + $model->spl_allowance + $model->over_time;

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($model->spl_allowance + $model->over_time)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - $model->spl_allowance));

               if ($remunerationmodel->pf_applicablity == 'Yes') {
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					   $pf_wages = 15000;
                        $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                        $model->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = $statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100);
						$pf_wages = $statutory_rate_pf;
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $model->pf_employer_contribution = 0;
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $model->pf_employer_contribution = 0;
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
                     } else {
                        $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                     }
					 $pf_wages = $statutory_rate_pf;
                  }
               } else {
			      $pf_wages = 0;
                  $provident_fund = 0;
                  $model->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $model->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $model->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $model->esi_employer_contribution = 0;
               }
            } else if ($PayScale) {   ///// For Staff
               ######################## Leave Update Staff #####################################
               $LeaveStaff = EmpLeaveStaff::find()->where(['empid' => $model->empid])->one();
               if ($LeaveStaff)
                  $loss_of_pay_days = $uploadmodel->LeaveUpdateStaff($m, $model->absent, $LeaveStaff);
               else
                  $loss_of_pay_days = $model->absent;

               if ($workstatus == 1) {
                  $present_days = $workingDays - ($loss_of_pay_days + $model->forced_lop);
               } else {
                  $present_days = $maxDays - ($loss_of_pay_days + $model->forced_lop);
               }
			    
				################################ Staff  Salary ##################################
				 $gross_salary = 0;
			   if($monthmodel){		
			   $ActualModel = EmpSalaryActual::find()->Where(['empid' => $model->empid, 'month' => $model->month])->one();			
			    
			   $gross_salary = $ActualModel->gross;
			   
			   $model->basic = round(($ActualModel->basic / $maxDays) * $present_days);
               $model->hra = round(($ActualModel->hra / $maxDays) * $present_days);
               $model->dearness_allowance = round(($ActualModel->dearness_allowance / $maxDays) * $present_days);
               $model->spl_allowance = $model->spl_allowance;
               $model->conveyance_allowance = round(($ActualModel->conveyance_allowance / $maxDays) * $present_days);
               $model->lta_earning = round($PayScale->lta * $model->basic);
               $model->medical_earning = round($PayScale->medical * $model->basic);
               $model->other_allowance = round(($ActualModel->other_allowance / $maxDays) * $present_days);
               $earned_gross = (($ActualModel->gross / $maxDays) * $present_days) + $model->spl_allowance + $model->arrear + $model->holiday_pay + $model->over_time;
               $earned_statutory_rate = $model->statutoryrate * $present_days;
			   
               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($model->hra + $model->spl_allowance + $model->over_time)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - $model->spl_allowance));
			   $model->salary_structure = $model->salary_structure;
			   } else {
			   $gross_salary = $remunerationmodel->gross_salary;
			   $model->basic = round(($remunerationmodel->basic / $maxDays) * $present_days);
               $model->hra = round(($remunerationmodel->hra / $maxDays) * $present_days);
               $model->dearness_allowance = round(($remunerationmodel->dearness_allowance / $maxDays) * $present_days);
               $model->spl_allowance = $model->spl_allowance;
               $model->conveyance_allowance = round(($remunerationmodel->conveyance / $maxDays) * $present_days);
               $model->lta_earning = round($PayScale->lta * $model->basic);
               $model->medical_earning = round($PayScale->medical * $model->basic);
               $model->other_allowance = round(($remunerationmodel->other_allowance / $maxDays) * $present_days);
               $earned_gross = (($remunerationmodel->gross_salary / $maxDays) * $present_days) + $model->spl_allowance + $model->arrear + $model->holiday_pay + $model->over_time;
               $earned_statutory_rate = $model->statutoryrate * $present_days;

               $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($model->hra + $model->spl_allowance + $model->over_time)));
               $statutory_rate_esi = max(($earned_statutory_rate + $model->over_time), ($earned_gross - $model->spl_allowance));
			   $model->salary_structure = $remunerationmodel->salary_structure;
			   }

               ######################## Staff PF ,ESI ,PT calculations ##########################

               if ($remunerationmodel->pf_applicablity == 'Yes') {			   
                  if ($remunerationmodel->restrict_pf == 'Yes') {
                     if ($statutory_rate_pf > 15000) {
					     $pf_wages = 15000;
                         $provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
                         $model->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
                     } else {
                        $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                        if ($statutory->pmrpybeneficiary == 'Yes') {
                           $model->pf_employer_contribution = 0;
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
                        }
						 $pf_wages = $statutory_rate_pf;
                     }
                  } else {
                     $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
                     if ($statutory->pmrpybeneficiary == 'Yes') {
                        if ($statutory_rate_pf < 15000) {
                           $model->pf_employer_contribution = 0;						 
                        } else {
                           $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));						  
                        }
                     } else {
                        $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));						
                     }
					   $pf_wages = $statutory_rate_pf;
                  }
               } else {
				  $pf_wages = 0;
                  $provident_fund = 0;
                  $model->pf_employer_contribution = 0;
               }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $model->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $model->esi_employer_contribution = 0;
                  }
               } else {			    
                  $employee_state_insurance = 0;
                  $model->esi_employer_contribution = 0;
               }
            }

            if ($statutory->professionaltax == 'Yes') {

               if ($remunerationmodel->gross_salary > 12500) {
                  $professional_tax = 209;
               } else if ($remunerationmodel->gross_salary <= 12500 && $remunerationmodel->gross_salary > 10000) {
                  $professional_tax = 171;
               } else if ($remunerationmodel->gross_salary <= 10000 && $remunerationmodel->gross_salary > 7500) {
                  $professional_tax = 115;
               } else if ($remunerationmodel->gross_salary <= 7500 && $remunerationmodel->gross_salary > 5000) {
                  $professional_tax = 53;
               } else if ($remunerationmodel->gross_salary <= 5000 && $remunerationmodel->gross_salary > 3500) {
                  $professional_tax = 23;
               } else {
                  $professional_tax = 0;
               }
            }

############################### Assign Engg / Staff Salary #############################

            $model->paiddays = $present_days;


            $model->paidallowance = $model->paidallowance;
            $model->earnedgross = round($earned_gross);
            $model->salary_structure = $model->salary_structure;
            $model->arrear = $model->arrear;
            $model->holiday_pay = $model->holiday_pay;
            $model->forced_lop = $model->forced_lop;
            $model->over_time = $model->over_time;

            $model->total_earning = ( $model->basic + $model->hra + $model->dearness_allowance + $model->spl_allowance + $model->conveyance_allowance +
                    $model->lta_earning + $model->medical_earning + $model->other_allowance + $model->arrear + $model->guaranted_benefit + $model->dust_allowance + $model->performance_pay + $model->holiday_pay + $model->advance_arrear_tes + $model->over_time + $model->misc);

######### deduction ###########
			
			$model->pf_wages = $pf_wages;
			$model->esi_wages = $remunerationmodel->gross_salary <= 21000 ? $statutory_rate_esi : 0;
			
            $model->pf = $provident_fund;
            $model->insurance = $model->insurance;
            $model->professional_tax = $professional_tax;
            $model->mobile = $model->mobile;
            $model->esi = $employee_state_insurance;
            $model->advance = $model->advance;
            $model->other_deduction = $model->other_deduction;
            $model->loan = $model->loan;
            $model->rent = $model->rent;
            $model->lwf = $model->lwf;
            $model->tds = $model->tds;

            $model->total_deduction = round($model->pf + $model->esi + $model->insurance + $model->professional_tax + $model->advance +
                    $model->mobile + $model->loan + $model->rent + $model->tds + $model->lwf + $model->other_deduction + $model->tes);
            $model->net_amount = $model->total_earning - $model->total_deduction;

            /* **** **************************************** CTC Caluculation *********************************** */


            $model->pli_employer_contribution = round($model->basic * ($remunerationmodel->pli / 100));

            if ($remunerationmodel->salary_structure == 'Manager' || $remunerationmodel->salary_structure == 'Assistant Manager' || $remunerationmodel->salary_structure == 'Sr. Engineer - I' || $remunerationmodel->salary_structure == 'Sr. Engineer - II') {
               $model->lta_employer_contribution = round($model->basic * 0.0833);
               $model->med_employer_contribution = round($model->basic * 0.0833);
            } else {
               $model->lta_employer_contribution = 0;
               $model->med_employer_contribution = 0;
            }
            $model->earned_ctc = $model->total_earning + $model->pf_employer_contribution + $model->esi_employer_contribution + $model->pli_employer_contribution + $model->lta_employer_contribution + $model->med_employer_contribution;

            $model->email_status = 0;
            $model->email_hash = hash('ripemd128', $model->empid . $model->month . $created_at);

            if ($model->save(false)) {
               $lastID = Yii::$app->db->getLastInsertID();
               if ($Emp->status == 'Paid and Relieved' && $salprocessing == $relievemonth) {
                  $EmpModel = EmpDetails::find()->where(['id' => $model->empid])->one();
                  $EmpModel->status = 'Relieved';
                  $EmpModel->save(false);
               }

               $leavecount = EmpLeaveCounter::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();

               $leavecount->empid = $model->empid;
               $leavecount->month = $model->month;
               $leavecount->leave_days = $model->absent;
               $leavecount->forced_lop = $model->forced_lop;
               $leavecount->lop_days = $loss_of_pay_days;
               $leavecount->save(false);
               $transaction->commit();
            }
         } catch (\Exception $e) {     // Transaction Exception
            $transaction->rollBack();
            throw $e;
         } catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            throw $e;
         } catch (\yii\base\Exception $e) {
            $transaction->rollBack();
            throw $e;
         } catch (\Throwable $e) {
            echo $e->getMessage();
            throw $e;
         }
        return $this->redirect(['view', 'id' => $id]);
      }
      return $this->render('update', [
                  'model' => $model,
      ]);
      /*
        $promotion = EmpPromotion::find()->where(['empid' => $findmodel->empid, 'flag' => 1])
        ->andWhere("effectdate <= :eff_date", [':eff_date' => $findmodel->month])
        ->orderBy(['id' => SORT_DESC])->limit(1)->one();

        $remuneration = EmpRemunerationDetails::find()->where(['empid' => $model->empid])->one();

        $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();

        if ($promotion) {
        if ($findmodel->month >= $promotion->effectdate) {
        $ss = $promotion->ss_to;
        $gross = $promotion->gross_to;
        $model->designation = $promotion->designation_to;
        $model->work_level = $promotion->wl_to;
        $model->grade = $promotion->grade_to;
        $model->salary_structure = $promotion->ss_to;
        } else {
        $ss = $promotion->ss_from;
        $gross = $promotion->gross_from;
        $model->designation = $promotion->designation_from;
        $model->work_level = $promotion->wl_from;
        $model->grade = $promotion->grade_from;
        $model->salary_structure = $promotion->ss_from;
        }
        } else {
        $ss = $findmodel->salary_structure;
        $gross = $remuneration->gross_salary;
        $model->designation = $findmodel->designation;
        $model->work_level = $findmodel->work_level;
        $model->grade = $findmodel->grade;
        $model->salary_structure = $findmodel->salary_structure;
        } */
   }

   public function actionDelete($id) {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }

   public function actionDeleteSalaryUploaded($id) {
      $this->findSalaryUploadModel($id)->delete();

      return $this->redirect(['salarygenerate']);
   }

   protected function findModel($id) {
      if (($model = EmpSalary::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }

   protected function findSalaryUploadModel($id) {

      if (($model = EmpSalaryUpload::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }
   
   
   
  public function actionSalaryRefresh() {
	 $Salmonth = SalaryMonth::find()->orderBy(['month'=>SORT_DESC])->one();
	 $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
		$transaction = \Yii::$app->db->beginTransaction();    
         try {		 
		 $m = date("m", strtotime($Salmonth->month));
         $y = date("Y", strtotime($Salmonth->month));
         $maxDays = cal_days_in_month(CAL_GREGORIAN, $m, $y);
		 $checkdate = date($y.'-'.$m.'-'.$maxDays);
		 
			 //$EmpModel = EmpDetails::find()->where(['<=', 'doj', $checkdate])->all();
			 $EmpModel = EmpDetails::find()->where(['status' => ['Paid and Relieved', 'Active', '']])
							->andWhere(['<=', 'doj', $checkdate])
                            ->orWhere(['status' => null])->all();
			foreach($EmpModel as $Emp){
				$remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $Emp->id])->one();
				$statutory = EmpStatutorydetails::find()->where(['empid' => $Emp->id])->one();
				$Salmodel = EmpSalary::find()->where(['empid' => $Emp->id,'month'=>$Salmonth->month])->one();         
				
				if($Salmodel){
				 $EmpDel = EmpDetails::findOne($Emp->id);
				  if($EmpDel->status == 'Relieved'){
					$Salmodel->delete();
				  }
				/*	$relievemonth = date("m", strtotime($Emp->dateofleaving));
					$dojmonth = date("m-Y", strtotime($Emp->doj));
					$salprocessing = date("m-Y", strtotime($model->month));

					if ($dojmonth == $salprocessing) {
					   $doj = date("d", strtotime($Emp->doj));
					   $your_date = date("t", strtotime($model->month));
					   $workingDays = ($your_date - $doj) + 1;
					   $workstatus = 1;
					} else if ($Emp->status == 'Paid and Relieved' && $m == $relievemonth) {
					   $relievedate = strtotime($Emp->dateofleaving);
					   $your_date = strtotime($model->month);
					   $datediff = $relievedate - $your_date;
					   $workingDays = round($datediff / (60 * 60 * 24)) + 1; // maximum days for month	
					   $workstatus = 1;
					} else if ($Emp->status == 'Relieved') {
					   $workingDays = 0;
					   $workstatus = 1;
					}
				 
				 
				if($remunerationmodel->salary_structure == 'Consolidated pay'){
				   $basic = round(($remunerationmodel->basic / $maxDays) * $Salmodel->paiddays);					 
				  
				   $earned_statutory_rate = $Salmodel->statutoryrate * $Salmodel->paiddays;
				   $earned_gross = (($remunerationmodel->gross_salary / $maxDays) * $Salmodel->paiddays) + $Salmodel->arrear + $Salmodel->holiday_pay + $Salmodel->spl_allowance + $Salmodel->over_time;

				   $statutory_rate_pf = max($earned_statutory_rate, ($earned_gross - ($Salmodel->spl_allowance + $Salmodel->over_time)));
				   $statutory_rate_esi = max(($earned_statutory_rate + $Salmodel->over_time), ($earned_gross - $Salmodel->spl_allowance));

				} else {
				if ($Salmodel->paiddays > 30) {
					 $dadays = 30;
				   } else {
					 $dadays = $Salmodel->paiddays;
				   }
            	$Earned_Allovance = round(($remunerationmodel->dearness_allowance / 30) * $dadays);         
				$tes = $Earned_Allovance - $Salmodel->paidallowance;
				   if ($tes > 0) {
					  $tes = $tes;
					  $avance_tes = 0;
				   } else {
					  $avance_tes = abs($tes);
					  $tes = 0;
				   }

				   $Salmodel->basic = round(($remunerationmodel->basic / $maxDays) * $Salmodel->paiddays);
				   $Salmodel->hra = round(($remunerationmodel->hra / $maxDays) * $Salmodel->paiddays);
				   $Salmodel->dearness_allowance = $Earned_Allovance;
				   $Salmodel->advance_arrear_tes = $avance_tes;
				   $Salmodel->tes = $tes;
				   $Salmodel->other_allowance = round(($remunerationmodel->other_allowance / $maxDays) * $Salmodel->paiddays);
				  
				  if($Salmodel->statutoryrate > 0){
					  $earned_statutory_rate = $Salmodel->statutoryrate * $Salmodel->paiddays;
					  }	else {					
					  $earned_statutory_rate =0;	
					}
				
				   $statutory_rate_pf = max($earned_statutory_rate, ($Salmodel->earnedgross - ($Salmodel->hra + $Salmodel->spl_allowance + $Salmodel->over_time)));
				   $statutory_rate_esi = max(($earned_statutory_rate + $Salmodel->over_time), ($Salmodel->earnedgross - $Salmodel->spl_allowance));

				}
				  
				    if ($remunerationmodel->pf_applicablity == 'Yes') {
					  if ($remunerationmodel->restrict_pf == 'Yes') {
						 if ($statutory_rate_pf > 15000) {
							$provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
							$model->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
						 } else {
							$provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
							if ($statutory->pmrpybeneficiary == 'Yes') {
							   $model->pf_employer_contribution = 0;
							} else {
							   $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
							}
						 }
					  } else {
						 $provident_fund = round($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_ee / 100));
						 if ($statutory->pmrpybeneficiary == 'Yes') {
							if ($statutory_rate_pf < 15000) {
							   $model->pf_employer_contribution = 0;
							} else {
							   $model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
							}
						 } else {
							$model->pf_employer_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));
						 }
					  }
				   } else {
					  $provident_fund = 0;
					  $model->pf_employer_contribution = 0;
				   }

               if ($remunerationmodel->esi_applicability == 'Yes') {
                  if ($remunerationmodel->gross_salary <= 21000) {
                     $employee_state_insurance = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
                     $model->esi_employer_contribution = ceil(number_format(($statutory_rate_esi * ($pf_esi_rates->esi_er / 100)), 2, '.', ''));
                  } else {
                     $employee_state_insurance = 0;
                     $model->esi_employer_contribution = 0;
                  }
               } else {
                  $employee_state_insurance = 0;
                  $model->esi_employer_contribution = 0;
               }
            
			
				   if ($statutory->professionaltax == 'Yes') {
					if ($remunerationmodel->gross_salary > 12500) {
						  $professional_tax = 196;
					   } else if ($remunerationmodel->gross_salary <= 12500 && $remunerationmodel->gross_salary > 10000) {
						  $professional_tax = 147;
					   } else if ($remunerationmodel->gross_salary <= 10000 && $remunerationmodel->gross_salary > 7500) {
						  $professional_tax = 98;
					   } else if ($remunerationmodel->gross_salary <= 7500 && $remunerationmodel->gross_salary > 5000) {
						  $professional_tax = 49;
					   } else if ($remunerationmodel->gross_salary <= 5000 && $remunerationmodel->gross_salary > 3500) {
						  $professional_tax = 20;
					   } else {
						  $professional_tax = 0;
					   }
					} else {
						$professional_tax = 0;
					}
				   
				    $Salmodel->total_earning = ( $Salmodel->basic + $Salmodel->hra + $Salmodel->dearness_allowance + $Salmodel->spl_allowance + $Salmodel->conveyance_allowance +
												$Salmodel->lta_earning + $Salmodel->medical_earning + $Salmodel->other_allowance + $Salmodel->arrear + $Salmodel->guaranted_benefit + $Salmodel->dust_allowance + 
												$Salmodel->performance_pay + $Salmodel->holiday_pay + $Salmodel->advance_arrear_tes + $Salmodel->over_time);

				   
				    $Salmodel->pf = $provident_fund;					
					$Salmodel->professional_tax = $professional_tax;
					$Salmodel->esi = $employee_state_insurance;
				   
				    $Salmodel->total_deduction = round($Salmodel->pf + $Salmodel->esi + $Salmodel->insurance + $Salmodel->professional_tax + $Salmodel->advance +
												$Salmodel->mobile + $Salmodel->loan + $Salmodel->rent + $Salmodel->tds + $Salmodel->lwf + $Salmodel->other_deduction + $Salmodel->tes);
					
					$Salmodel->net_amount = $Salmodel->total_earning - $Salmodel->total_deduction;
			
				   */
				} else {				
				   $upload = EmpSalaryUpload::find()->where(['empid' => $Emp->id, 'month' => $Salmonth->month])->one();
					if(!$upload){
						$uploadmodel = new EmpSalaryUpload();
						$uploadmodel->empid = $Emp->id;
						$uploadmodel->month = $Salmonth->month;
						$uploadmodel->status = 'Uploaded';
						$uploadmodel->save(false);
					} else {
					 $DelEmp = EmpDetails::findOne($Emp->id);
					 if($DelEmp->status == 'Relieved'){
						 $upload->delete();
						 } else {
						 $upload->status = 'Uploaded';
						 $upload->save(false);
						 }					    
					}
						
				}
				    
		    }
			$transaction->commit();
			return $this->redirect('salarygenerate');
		   } catch (\Exception $e) {     // Transaction Exception
			 $transaction->rollBack();
			 throw $e;
			 } catch (\Throwable $e) {
			 $transaction->rollBack();
			 throw $e;
			 }
  }
			
			
		
          
           
   
   
   

   /*
     public function actionCreate($id) {
     $model = new EmpSalary();
     $Leaveupdate = new EmpSalaryUpload();
     $leavecount = new EmpLeaveCounter();

     if ($model->load(Yii::$app->request->post())) {
     $model->user = Yii::$app->user->id;
     $created_at = date('Y-m-d H:i:s');
     $model->month = '01-' . $model->month;
     $model->date = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
     $model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");

     $m = date("m", strtotime($model->month));
     $y = date("Y", strtotime($model->month));
     $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);

     $remuneration = EmpRemunerationDetails::find()->where(['empid' => $id])->one();
     $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();

     $PayScale = EmpStaffPayScale::find()
     ->where(['salarystructure' => $remuneration->salary_structure])
     ->one();

     $Salarystructure = EmpSalarystructure::find()
     ->where(['salarystructure' => $remuneration->salary_structure])
     ->one();

     $sal = EmpSalary::find()->where(['empid' => $model->empid, 'month' => $model->month])->one();
     if (!$sal) {
     $Emp = EmpDetails::find()
     ->where(['id' => $id])
     ->one();

     if ($PayScale) {
     $LeaveStaff = EmpLeaveStaff::find()
     ->where(['empid' => $id])
     ->one();
     } else if ($Salarystructure) {
     $Leave = EmpLeave::find()
     ->where(['empid' => $id])
     ->one();
     }

     $transaction = \Yii::$app->db->beginTransaction();    // Transaction begin
     try {
     if ($Salarystructure) {
     if ($Leave)
     $Leaveupdate->LeaveUpdate($m, $model->absent, $Leave);
     } else if ($PayScale) {
     if ($LeaveStaff)
     $Leaveupdate->LeaveUpdateStaff($m, $model->absent, $LeaveStaff);
     }

     $model->empid = $id;
     $model->designation = $Emp->designation_id;
     $model->work_level = $remuneration->work_level;
     $model->paidallowance = $model->allowance_paid;
     $model->forced_lop = $model->lop;
     $model->grade = $remuneration->grade;
     $model->unit_id = $Emp->unit_id;
     $model->division_id = $Emp->division_id;
     $model->department_id = $Emp->department_id;
     $model->attendancetype = $remuneration->attendance_type;
     $model->salary_structure = $remuneration->salary_structure;
     $model->earnedgross = round($model->earnedgross);

     $leavecount->empid = $model->empid;
     $leavecount->month = $model->month;
     $leavecount->leave_days = $model->absent;
     $leavecount->forced_lop = $model->lop;
     $leavecount->save(false);

     $statutory_rate_pf_esi = $model->statutory_rate_esi;

     if ($remuneration->pf_applicablity == 'Yes') {
     if ($remuneration->restrict_pf == 'Yes') {
     if ($statutory_rate_pf_esi > 15000) {
     $model->pf_employer_contribution = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));
     } else {
     $model->pf_employer_contribution = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ( $statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));
     }
     } else {
     $model->pf_employer_contribution = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));
     }
     } else {
     $model->pf_employer_contribution = 0;
     }

     if ($remuneration->esi_applicability == 'Yes') {
     if ($remuneration->gross_salary <= 21000) {
     $model->esi_employer_contribution = ceil(number_format($statutory_rate_pf_esi * ($pf_esi_rates->esi_er / 100)),2, '.', '');
     } else {
     $model->esi_employer_contribution = 0;
     }
     } else {
     $model->esi_employer_contribution = 0;
     }

     $model->pli_employer_contribution = round($model->basic * ($remuneration->pli / 100));

     if ($remuneration->salary_structure == 'Manager' || $remuneration->salary_structure == 'Assistant Manager' || $remuneration->salary_structure == 'Sr. Engineer - I' || $remuneration->salary_structure == 'Sr. Engineer - II') {
     $model->lta_employer_contribution = round($model->basic * 0.0833);
     $model->med_employer_contribution = round($model->basic * 0.0833);
     } else {
     $model->lta_employer_contribution = 0;
     $model->med_employer_contribution = 0;
     }
     $model->earned_ctc = $model->total_earning + $model->pf_employer_contribution + $model->esi_employer_contribution + $model->pli_employer_contribution + $model->lta_employer_contribution + $model->med_employer_contribution;

     $model->save(false);
     $transaction->commit();     // Transaction Commit
     return $this->redirect(['view', 'id' => $model->id]);
     } catch (\Exception $e) {     // Transaction Exception
     $transaction->rollBack();
     throw $e;
     } catch (\Throwable $e) {
     $transaction->rollBack();
     throw $e;
     }
     } else {
     Yii::$app->session->setFlash("danger", 'Salary already Generated for month < ' . Yii::$app->formatter->asDate($model->month, "MM-yyyy") . ' >');
     }
     }

     return $this->render('create', [
     'model' => $model,
     'id' => $id,
     ]);
     } */
}

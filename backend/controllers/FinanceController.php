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
use common\models\Division;
use app\models\AuthAssignment;
use kartik\mpdf\Pdf;
use common\models\SalaryMonth;
use common\models\MailForm;
use common\models\EmpSalaryActual;
use common\models\Bonus;
use common\models\EmailSeparate;
use common\models\Finance;
use app\models\FinanceSearch;
use app\models\ApproveSearch;
use app\models\HrSearch;
use yii\helpers\Html;
use Mpdf\Mpdf;
error_reporting(0);
ini_set('max_execution_time', 0);



class FinanceController extends Controller {

public function behaviors() {
	$this->layout = 'finlayout';
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
                      'actions' => ['index','hrapproval','approval','finapproval','finapprovalhr','totamounthr','totamount','dashboard','totamountfinance'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return AuthAssignment::Rights('finance', 'view');
                 #return Yii::$app->authAssignment->Rights('recruitment', 'view');
              },
                      'roles' => ['@'],
                  ],
                  [
                      'allow' => true,
                      'actions' => ['index','bulkgenerate','hrapproval','approval','finapprovalhr','totamounthr','finapproval','totamount','dashboard','totamountfinance'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
					 return AuthAssignment::Rights('finance', 'update');
					 #return Yii::$app->authAssignment->Rights('recruitment', 'update');
					},
                      'roles' => ['@'],
                  ],
                  [
                      'allow' => true,
                      'actions' => ['index','bulkgenerate','hrapproval','approval','finapprovalhr','totamounthr','finapproval','totamount','dashboard','totamountfinance'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return AuthAssignment::Rights('finance', 'create');
                 #return Yii::$app->authAssignment->Rights('recruitment', 'create');
              },
                  //'roles' => ['@create'],
                  ],
                  [
                      'allow' => true,
                      'actions' => ['index','approval','hrapproval','finapprovalhr','totamounthr','finapproval','totamount','totamountfinance'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return AuthAssignment::Rights('finance', 'delete');
                 #return Yii::$app->authAssignment->Rights('recruitment', 'delete');
              },
                      'roles' => ['@'],
                  ],
                  
              // everything else is denied
              ],
          ],
      ];
   }

   

   public function actionIndex() {
	    
      $searchModel = new ApproveSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }
   
    public function actionHrapproval() {
	    
      $searchModel = new HrSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('hrapproval', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }
   
    public function actionApproval() {
	
		
     $searchModel = new FinanceSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('approval', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }
   
   public function actionDashboard()
    {
       
        //$model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();     

        return $this->render('dashboard');
    }
	
	public function actionFinapprovalhr() {
	 
	  
      $data = Yii::$app->request->post();
	   $result_success = [];
      $result_failure = [];
	  foreach($data['keylist'] as $key) {
		 //$advEar =0;
        $emp_salary = EmpSalary::find()->where(['id'=>$key])->one();
		
		 $Emp = EmpDetails::find()->where(['id'=>$emp_salary->empid])->one();
		
		$model = new Finance();
		
		$model->user = $emp_salary->user;
		$model->date = $emp_salary->date;
		$model->empid = $emp_salary->empid;
		$model->attendancetype = $emp_salary->attendancetype;
		$model->designation = $emp_salary->designation;
		$model->unit_id = $emp_salary->unit_id;
		$model->division_id = $emp_salary->division_id;
		$model->department_id = $emp_salary->department_id;
		$model->work_level = $emp_salary->work_level;
		$model->grade = $emp_salary->grade;
		$model->salary_structure = $emp_salary->salary_structure;
		$model->earnedgross = $emp_salary->earnedgross;
		$model->month = $emp_salary->month;
		$model->paiddays = $emp_salary->paiddays;
		$model->forced_lop = $emp_salary->forced_lop;
		$model->paidallowance = $emp_salary->paidallowance;
		$model->statutoryrate = $emp_salary->statutoryrate;
		$model->basic = $emp_salary->basic;
		$model->hra = $emp_salary->hra;
		$model->spl_allowance = $emp_salary->spl_allowance;
		$model->dearness_allowance = $emp_salary->dearness_allowance;
		$model->conveyance_allowance = $emp_salary->conveyance_allowance;
		$model->over_time = $emp_salary->over_time;
		$model->arrear = $emp_salary->arrear;
		$model->advance_arrear_tes = $emp_salary->advance_arrear_tes;
		$model->lta_earning = $emp_salary->lta_earning;
		$model->medical_earning = $emp_salary->medical_earning;
		$model->guaranted_benefit = $emp_salary->guaranted_benefit;
		$model->holiday_pay = $emp_salary->holiday_pay;
		$model->washing_allowance = $emp_salary->washing_allowance;
		$model->dust_allowance = $emp_salary->dust_allowance;
		$model->performance_pay = $emp_salary->performance_pay;
		$model->misc = $emp_salary->misc;
		$model->other_allowance = $emp_salary->other_allowance;
		$model->total_earning = $emp_salary->total_earning;
		$model->pf = $emp_salary->pf;
		$model->insurance = $emp_salary->insurance;
		$model->professional_tax = $emp_salary->professional_tax;
		$model->esi = $emp_salary->esi;
		$model->caution_deposit = $emp_salary->caution_deposit;
		$model->tes = $emp_salary->tes;
		$model->mobile = $emp_salary->mobile;
		$model->loan = $emp_salary->loan;
		$model->rent = $emp_salary->rent;
		$model->tds = $emp_salary->tds;
		$model->lwf = $emp_salary->lwf;
		$model->other_deduction = $emp_salary->other_deduction;
		$model->total_deduction = $emp_salary->total_deduction;
		$model->net_amount = $emp_salary->net_amount;
		$model->food_allowance = $emp_salary->food_allowance;
		$model->pf_employer_contribution = $emp_salary->pf_employer_contribution;
		$model->esi_employer_contribution = $emp_salary->esi_employer_contribution;
		$model->pli_employer_contribution = $emp_salary->pli_employer_contribution;
		$model->lta_employer_contribution = $emp_salary->lta_employer_contribution;
		$model->med_employer_contribution = $emp_salary->med_employer_contribution;
		$model->earned_ctc = $emp_salary->earned_ctc;
		$model->pf_wages = $emp_salary->pf_wages;
		$model->esi_wages = $emp_salary->esi_wages;
		$model->customer_id = $emp_salary->customer_id;
		$model->priority = $emp_salary->priority;
		$model->revised = $emp_salary->revised;
		$model->email_status = $emp_salary->email_status;
		$model->email_hash = $emp_salary->email_hash;
		$model->hold = $emp_salary->hold;
		$model->hrapproval = 1;
		
		
		if($model->save()){
		
		//$salery_updated = Empsalary::find()->where(['empid'=>$emp_salary->empid,'month'=>$emp_salary->month])->one();
		
		$salery_updated = Empsalary::find()->where(['empid'=>$model->empid,'month'=>$model->month])->one();
		
		$salery_updated->hrapproval = 1;
		
		$salery_updated->save(false);
			
		 $result_success[] = $Emp->empcode . '-Salary Approved for month < ' . Yii::$app->formatter->asDate($emp_salary->month, "MM-yyyy") . '></br>';	
		}
		
         
   }
   $jsonData['success'] = $result_success;
      $jsonData['error'] = $result_failure;
      return json_encode($jsonData);
	  }
   
 public function actionBulkgenerate() {
	 
	  
      $data = Yii::$app->request->post();
	   $result_success = [];
      $result_failure = [];
	  foreach($data['keylist'] as $key) {
		 //$advEar =0;
		 $emp_salary = Finance::find()->where(['id'=>$key])->one();
		
		 $Emp = EmpDetails::find()->where(['id'=>$emp_salary->empid])->one();
		
		$emp_salary->finance_approval1 = 1;
		
		if($emp_salary->save()){
		
		//$salery_updated = Empsalary::find()->where(['empid'=>$emp_salary->empid,'month'=>$emp_salary->month])->one();
		
		 $result_success[] = $Emp->empcode . '-Salary Approved for month < ' . Yii::$app->formatter->asDate($emp_salary->month, "MM-yyyy") . '></br>';	
		}
		
         
   }
   $jsonData['success'] = $result_success;
      $jsonData['error'] = $result_failure;
      return json_encode($jsonData);
	  }
	  
	  
	  public function actionFinapproval() {
	 
	  
      $data = Yii::$app->request->post();
	   $result_success = [];
      $result_failure = [];
	  foreach($data['keylist'] as $key) {
		 //$advEar =0;
		 $emp_salary = Finance::find()->where(['id'=>$key])->one();
		
		 $Emp = EmpDetails::find()->where(['id'=>$emp_salary->empid])->one();
		
		$emp_salary->finance_approval2 = 1;
		
		
		if($emp_salary->save()){
		
		//$salery_updated = Empsalary::find()->where(['empid'=>$emp_salary->empid,'month'=>$emp_salary->month])->one();
		
		 $result_success[] = $Emp->empcode . '-Salary Approved for month < ' . Yii::$app->formatter->asDate($emp_salary->month, "MM-yyyy") . '></br>';	
		}
		
         
   }
   $jsonData['success'] = $result_success;
      $jsonData['error'] = $result_failure;
      return json_encode($jsonData);
	  }
	  
	   public function actionTotamounthr() {
	 
	  $emp_net = 0;
      $data = Yii::$app->request->post();
	   $result_success = [];
      $result_failure = [];
	  foreach($data['keylist'] as $key) {
		 //$advEar =0;
		 $emp_salary = EmpSalary::find()->where(['id'=>$key])->one();
		
		 $Emp = EmpDetails::find()->where(['id'=>$emp_salary->empid])->one();	
		$emp_net +=  $emp_salary->net_amount;
     }
     echo $emp_net;
	  }
	  
	  
	  
	   public function actionTotamount() {
	 
	  $emp_net = 0;
      $data = Yii::$app->request->post();
	   $result_success = [];
      $result_failure = [];
	  foreach($data['keylist'] as $key) {
		 //$advEar =0;
		 $emp_salary = Finance::find()->where(['id'=>$key])->one();
		
		 $Emp = EmpDetails::find()->where(['id'=>$emp_salary->empid])->one();	
		$emp_net +=  $emp_salary->net_amount;
     }
     echo $emp_net;
	  }
	  
	   public function actionTotamountfinance() {
	 
	  $emp_net = 0;
      $data = Yii::$app->request->post();
	   $result_success = [];
      $result_failure = [];
	  foreach($data['keylist'] as $key) {
		 //$advEar =0;
		 $emp_salary = Finance::find()->where(['id'=>$key])->one();
		
		 $Emp = EmpDetails::find()->where(['id'=>$emp_salary->empid])->one();	
		$emp_net +=  $emp_salary->net_amount;
     }
     echo $emp_net;
	  }


  
}

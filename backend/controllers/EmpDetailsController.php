<?php

namespace backend\controllers;

use Yii;
use DateTime;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use common\models\EmpEducationdetails;
use common\models\EmpCertificates;
use common\models\EmpBankdetails;
use common\models\Department;
use common\models\Designation;
use common\models\Qualification;
use common\models\EmpStatutorydetails;
use common\models\Unit;
use common\models\EmpDetailsSearch;
use common\models\EmpRemunerationDetails;
use common\models\PreviousEmployment;
use common\models\EmpSalary;
use common\models\EmpPromotion;
use common\models\Course;


use common\models\EmpDetailsFront;
use common\models\EmpPersonaldetailsFront;
use common\models\EmpAddressFront;
use common\models\EmpFamilydetailsFront;
use common\models\EmpEducationdetailsFront;
use common\models\EmpCertificatesFront;
use common\models\EmpBankdetailsFront;
use common\models\PreviousEmploymentFront;

use app\models\Model;
use app\models\AppointmentLetter;
use app\models\EmpSalarystructure;
use app\models\EmpStaffPayScale;
use app\models\ImportExcel;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\components\AccessRule;
use yii\helpers\Json;
use common\models\StatutoryRates;
use common\models\SalaryMonth;
use kartik\mpdf\Pdf;
use yii\helpers\Html;
use common\models\MailForm;
use common\models\EmpBenefits; 
use app\models\VgGpaHierarchy;
use app\models\VgGmcHierarchy;
use common\models\EmpGpaBenifits; 
use common\models\EmpJoinSearch;
use common\models\EngineerTransfer;
use common\models\EngineertransferProject;
use common\models\UnitGroup;
use common\models\Division;
use common\models\Status;
error_reporting(0);
use app\models\AuthAssignment;

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Cache-Control: no-cache");
header("Pragma: no-cache");

class EmpDetailsController extends Controller {
	
	public function behaviors()
       {		  
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
						/*[
							'allow' => false,							
							'verbs' => ['POST']
						],*/
						
						// allow authenticated users
						[
							'allow' => true,
							'actions' => ['user-files','emp-log','appointment-mail','order-create','order-update','resigned-index','newjoin-index','enggsalaryannexure','staffsalaryannexure','export-contractemp','export-emp','mis-export','export-bank','export-edu','export-certificate','export-family','index','view','export',
							'promotion-export','import-employee','appointment-letter','generateorder','statutory-details','exportwodata',
							'previous_employment','bank-details','certificates-details','education-details','personal-details','salarystructure','worklevel',
							'remuneration','promotion-exportcontract','print-empdetails','appointmentpdf','college-index','course-index','qualification-index','engineer-list','division-transfer','engineertransfer-project','depend','status-change','appointment-without-header','exportidcarddata','exportid',
							],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['export-emp','export-contractemp','mis-export','export-bank','export-edu','export-certificate','export-family','index','view','create','update','export','promotion-export','import-employee','appointment-letter','generateorder','statutory-details',
							'previous_employment','bank-details','certificates-details','education-details','personal-details','salarystructure','worklevel','remuneration','exportwodata','exportidcarddata','exportid',
							],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['editor-app','send-mail','export-emp','mis-export','export-contractemp','export-bank','export-edu','export-certificate','export-family','index','view','create','update','export','promotion-export','import-employee','appointment-letter','generateorder','statutory-details',
							'previous_employment','bank-details','certificates-details','education-details','personal-details','salarystructure','worklevel','remuneration','exportwodata','exportidcarddata','exportid',
							],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('mis', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['export-emp','export-contractemp','mis-export','export-bank','export-edu','export-certificate','export-family','index','view','create','update','delete','export','promotion-export','import-employee','appointment-letter','generateorder','statutory-details',
							'previous_employment','bank-details','certificates-details','education-details','personal-details','salarystructure','worklevel','remuneration','exportwodata','exportidcarddata','exportid',
							],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'delete');									 
								 },
							'roles' => ['@'],
						],
						
						
						
						
						[
						'allow' => true,
						'actions'=>['enggsalaryannexure','staffsalaryannexure'],
						'roles' => ['?'],
						],
						// everything else is denied
					],
				],
			];
       }

   public function actionTest() {
      return $this->render('test');
   }
   
    public function actionExportid() {
      return $this->render('exportid');
   }
   
   public function actionExportidcarddata() {
      return $this->render('exportidcarddata');
   }
   
   public function actionExport() {
    return $this->render('export');
   }
   
    public function actionNjIndex() {
    return $this->render('nj-index');
   }
   
   public function actionCollegeIndex() {
    return $this->render('college-index');
   }
   
   public function actionCourseIndex() {
    return $this->render('course-index');
   }
   
   public function actionQualificationIndex() {
    return $this->render('qualification-index');
   }
  
   public function actionExportwodata() {
      return $this->render('exportwodata');
   }
   
   public function actionUserFiles($id) {	
      return $this->render('user-files');
   }
   public function actionEmpLog($id) {    
	   return $this->render('emp-log', [
                  'model' => $this->findModel($id),
      ]);
   }
   
   
  public function actionPrintEmpdetails($id) {
      $this->layout ='print_layout';
      return $this->render('print-empdetails', [
                  'model' => $this->findModel($id),
      ]);
   }
   
   public function actionExportFamily() {
      return $this->render('export-family');
   }
    public function actionExportBank() {
      return $this->render('export-bank');
   }
    public function actionExportEdu() {
      return $this->render('export-edu');
   }
    public function actionExportContractemp() {
      return $this->render('export-contractemp');
   }   
    public function actionExportCertificate() {
      return $this->render('export-certificate');
   }
    public function actionExportEmp() {
      return $this->render('export-emp');
   }   
   public function actionMisExport() {
      return $this->render('mis-export');
   }   
   public function actionPromotionExport() {
      return $this->render('promotion-export');
   }
 public function actionPromotionExportcontract() {
      return $this->render('promotion-exportcontract');
   }

   public function actionIndex() {
      $searchModel = new EmpDetailsSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }
   
    public function actionResignedIndex() {
	 //$salmonth = SalaryMonth::find()->orderBy(['month' => SORT_DESC])->one();
	 $currentdate = date('Y-m-d');
    $fromdate = date('Y-m-01');
	  $model = EmpDetails::find()->where(['between', 'last_working_date',$fromdate , $currentdate])
								->andWhere(['IN','status',['Relieved','Paid and Relieved']]);
      return $this->render('resigned-index', [
                  'model' => $model,
      ]);
   }
   
     public function actionNewjoinIndex() {
	 $searchModel = new EmpJoinSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('newjoin-index', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionView($id) {
      return $this->render('view', [
                  'model' => $this->findModel($id),
      ]);
   }


   public function actionImportEmployee() {
      $model = new importExcel();
      if ($model->load(Yii::$app->request->post())) {
         $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
         $connection = \Yii::$app->db;
         $model->file = UploadedFile::getInstance($model, 'file');

         if ($model->file && $model->validate()) {
            $model->file->saveAs('employee/' . $model->file->baseName . '.' . $model->file->extension);
            $fileName = 'employee/' . $model->file->baseName . '.' . $model->file->extension;
         }
         $data = \moonland\phpexcel\Excel::widget([
                     'mode' => 'import',
                     'fileName' => $fileName,
                     'setFirstRecordAsKeys' => true,
         ]);

         $countrow = 0;
         $startrow = 1;
         $totalrow = count($data);

         if ($model->uploadtype == 1 && $model->uploaddata == 1) {
            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
			   if (!empty($excelrow['Emp. Code'])) { 
                  $grossamount = 0;
                  $basic = 0;
                  $hra = 0;
                  $dearness_allowance = 0;
                  $spl_allowance = 0;
                  $conveyance_allowance = 0;
                  $pli_earning = 0;
                  $lta_earning = 0;
                  $medical_earning = 0;
                  $other_allowance = 0;
					
				  if (empty($excelrow['Emp. Code'])) {                 
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Code Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
				  
				   if (empty($excelrow['Emp. Name'])) {                
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Name Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if (empty($excelrow['Gender'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gender Column Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  $uniquecolumn = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                  if ($uniquecolumn) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Ecode Already Exists');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
				  
				if(!empty($excelrow['Date of Joining']) && $excelrow['Date of Joining'] !='01-01-1970' && $excelrow['Date of Joining'] !='1970-01-01'){
				   $doj = Yii::$app->formatter->asDate($excelrow['Date of Joining'], "yyyy-MM-dd");
				   $regex = '/^(^[1-9][0-9-]*)$/';
				   if(!preg_match( $regex, $doj ) ) {											 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoJ Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {					 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Date of Joining');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				 
                  if ($excelrow['Salary Structure'] != 'Consolidated pay' && !empty($excelrow['Salary Structure']) && $excelrow['Salary Structure'] != 'Contract' && $excelrow['Salary Structure'] != 'Conventional' && $excelrow['Salary Structure'] != 'Modern') {
                     $wl = $excelrow['Work Level'];
                     $SalarySalary = EmpSalarystructure::find()->where(['salarystructure' => $excelrow['Salary Structure'], 'worklevel' => $excelrow['Work Level'], 'grade' => $excelrow['Grade'],])->one();
                     if ($SalarySalary) {
                        $basic = $SalarySalary->basic;
                        $hra = $SalarySalary->hra;
                        $dearness_allowance = $SalarySalary->dapermonth;
                        $other_allowance = $SalarySalary->other_allowance;
                        $grossamount = $SalarySalary->netsalary;
                     } else {
                        Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Salary Structure Doesn\'t Match');
                        $startrow++;
                        $countrow +=1;
                        continue;
                     }
                  }

                  $PayScale = EmpStaffPayScale::find()->where(['salarystructure' => $excelrow['Salary Structure']])->one();
                  if ($PayScale) {
				  if(!empty($excelrow['Gross Salary'])){
					 $grossamount = $excelrow['Gross Salary'];
                     $basic = round($grossamount * $PayScale->basic);
                     $hra = round($grossamount * $PayScale->hra);
                     $dearness_allowance = round($grossamount * $PayScale->dearness_allowance);
                    // $spl_allowance = round($grossamount * $PayScale->spl_allowance);
                     $conveyance_allowance = round($PayScale->conveyance_allowance);
                     $lta_earning = round($basic * $PayScale->lta);
                     $medical_earning = round($basic * $PayScale->medical);
					 $other_allowance = round(($grossamount - ($basic + $hra + $dearness_allowance + $lta_earning + $medical_earning)) - $conveyance_allowance);
                  					  
				  } else {
				        Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gross Salary Empty');
                        $startrow++;
                        $countrow +=1;
                        continue;				  
				  }                   
                  } else {
                     $p_scale = NULL;
                  }
				  
				  if($excelrow['Salary Structure'] == 'Consolidated pay') {
					if(!empty($excelrow['Gross Salary']) && $excelrow['Gross Salary'] != 0) {
					  $grossamount = $excelrow['Gross Salary'];
                      $basic = round($grossamount);	
				  } else {					 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gross Salary Not Empty');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				  }
					
                  if (!empty($excelrow['PLI']) && $excelrow['PLI'] != 'N/A') {
                     $employer_pli = round($basic * ($excelrow['PLI']/100));
                  } else {
                     $employer_pli = 0;
                  }

                  if (!empty($excelrow['Salary Structure']) && $excelrow['Salary Structure'] != 'Engineer' && $excelrow['Salary Structure'] != 'Trainee' && $excelrow['Salary Structure'] != 'Consolidated pay' && $excelrow['Salary Structure'] != 'Contract' && $excelrow['Salary Structure'] != 'Conventional' && $excelrow['Salary Structure'] != 'Modern') {
                     $employer_medical = round($basic * (8.33/100));
                     $employer_lta = round($basic * (8.33/100));
                  } else {
                     $employer_medical = 0;
                     $employer_lta = 0;
                  }

                  if ($excelrow['ESI Applicability'] == 'Yes' && $grossamount < 21000) {
                     $employer_esi = ceil($grossamount * ($pf_esi_rates->esi_er / 100));
                  } else {
                     $employer_esi = 0;
                  }
				  
				  if ($excelrow['EPF Applicability'] == 'Yes') {				
						if ($excelrow['Restrict EPF'] == 'Yes') {
							$statutory_rate_pf = $grossamount - $hra;
							if($statutory_rate_pf <= 15000){
								$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));				
							} else {
								 $statutory_rate_pf = 15000;
								 $employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));			
							}
					    } else {
							$statutory_rate_pf = $grossamount - $hra;
							$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));					 
						}
                  } else {
						$employer_pf = 0;
                  }

                  $posting = strtolower(str_replace(' ', '', $excelrow['Designation']));
                  $design = Yii::$app->db->createCommand("SELECT id FROM designation WHERE LOWER(replace(designation ,' ',''))='" . $posting . "'")->queryOne();
                  if ($design)
                     $designation = $design['id'];
                  else
                     $designation = NULL;

                  $dept = strtolower(str_replace(' ', '', $excelrow['Department']));
                  $dept1 = Yii::$app->db->createCommand("SELECT id FROM department WHERE LOWER(replace(name ,' ',''))='" . $dept . "'")->queryOne();
                  if ($dept1)
                     $department = $dept1['id'];
                  else
                     $department = NULL;
				 
                  $unit = strtolower(str_replace(' ', '', $excelrow['Unit']));
                  $unit1 = Yii::$app->db->createCommand("SELECT id FROM unit WHERE LOWER(replace(name ,' ',''))='" . $unit . "'")->queryOne();
                  $unit_id = $unit1['id'];

                  if ($unit1)
                     $unit_id = $unit1['id'];
                  else
                     $unit_id = NULL;


                  $div = strtolower(str_replace(' ', '', $excelrow['Division']));
                  $division = Yii::$app->db->createCommand("SELECT id FROM division WHERE LOWER(replace(division_name ,' ',''))='" . $div . "'")->queryOne();
                  $division_id = $division['id'];

                  if ($unit1)
                     $division_id = $division['id'];
                  else
                     $division_id = NULL;
				 
				 
                  $modelEmp = new EmpDetails();
                  $modelEmp->empcode = $excelrow['Emp. Code'];
                  $modelEmp->empname = $excelrow['Emp. Name'];
				  $modelEmp->doj = $doj;
				
					  
				if(!empty($excelrow['Confirmation Date']) && $excelrow['Confirmation Date'] !='01-01-1970' && $excelrow['Confirmation Date'] !='1970-01-01'){
				$modelEmp->confirmation_date = Yii::$app->formatter->asDate($excelrow['Confirmation Date'], "yyyy-MM-dd");
				  $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelEmp->confirmation_date ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Confirmation Date Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {
				$modelEmp->confirmation_date =NULL; 
				}   
					  
					  
                  $modelEmp->designation_id = $designation;
                  $modelEmp->division_id = $division_id;
                  $modelEmp->unit_id = $unit_id;
                  $modelEmp->department_id = $department;
				  $modelEmp->category = $excelrow['Category'];
                  $modelEmp->email = $excelrow['Email(Official)'];
                  $modelEmp->mobileno = $excelrow['Mobile No(CUG)'];
                  $modelEmp->referedby = $excelrow['Referred By'];
                  $modelEmp->probation = $excelrow['Probation'];
                  $modelEmp->appraisalmonth = $excelrow['Appraisal Month'];
				  if(!empty($excelrow['Latest Promotion Date']) && $excelrow['Latest Promotion Date'] !='01-01-1970' && $excelrow['Latest Promotion Date'] !='1970-01-01'){
					 $modelEmp->recentdop = Yii::$app->formatter->asDate($excelrow['Latest Promotion Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->recentdop =NULL; 
				  }   
                 $modelEmp->joining_status = $excelrow['Joining Status'];
                  $modelEmp->experience = $excelrow['Previous Experience'];
				  
				   if(!empty($excelrow['Last Working Date']) && $excelrow['Last Working Date'] !='01-01-1970' && $excelrow['Last Working Date'] !='1970-01-01'){
					 $modelEmp->last_working_date = Yii::$app->formatter->asDate($excelrow['Last Working Date'], "yyyy-MM-dd");
					  $no_of_year = date_diff(date_create($doj), date_create($modelEmp->last_working_date));
						 if($no_of_year->format('%m') >=6 )
						  $modelEmp->service = $no_of_year->format('%y') + 1;
						else 
						  $modelEmp->service = $no_of_year->format('%y');
					 } else {
					 $modelEmp->last_working_date =NULL; 
					  $modelEmp->service = NULL;
				  } 
				  
				   if(!empty($excelrow['Resignation Date']) && $excelrow['Resignation Date'] !='01-01-1970' && $excelrow['Resignation Date'] !='1970-01-01'){
					 $modelEmp->resignation_date = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->resignation_date =NULL; 
				  } 
				  
				    if(!empty($excelrow['Date of Leaving']) && $excelrow['Date of Leaving'] !='01-01-1970' && $excelrow['Date of Leaving'] !='1970-01-01'){
					 $modelEmp->dateofleaving = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->dateofleaving =NULL; 
				  } 
				   	$modelEmp->reasonforleaving = $excelrow['Reason for Leaving'];
				  
				  if($excelrow['Status'] == ''){
					  $modelEmp->status = 'Active';
					  } else {
					   $modelEmp->status = $excelrow['Status'];
					  }
					  
					  
					  
                  $modelEmp->save(false);

                  $emptableid = Yii::$app->db->getLastInsertID();

                  $modelPer = new EmpPersonaldetails();
                  $modelPer->empid = $emptableid;
				  if(!empty($excelrow['DoB(Record)']) && $excelrow['DoB(Record)'] !='01-01-1970' && $excelrow['DoB(Record)'] !='1970-01-01'){
				     $modelPer->dob = Yii::$app->formatter->asDate($excelrow['DoB(Record)'], "yyyy-MM-dd");
					   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex,  $modelPer->dob ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoB Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->dob =NULL; 
					} 
					
					if(!empty($excelrow['Birthday']) && $excelrow['Birthday'] !='01-01-1970' && $excelrow['Birthday'] !='1970-01-01'){
				     $modelPer->birthday = Yii::$app->formatter->asDate($excelrow['Birthday'], "yyyy-MM-dd");
					   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelPer->birthday ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change birthday Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->birthday =NULL; 
					} 
                 
                  $modelPer->gender = $excelrow['Gender'];
                  $modelPer->mobile_no = $excelrow['Mobile No'];
                  $modelPer->email = $excelrow['Email(Personal)'];
                  $modelPer->blood_group = $excelrow['Blood Group'];
                  $modelPer->caste = $excelrow['Caste'];
                  $modelPer->community = $excelrow['Community'];
                  $modelPer->martialstatus = $excelrow['Marital Status'];
                  $modelPer->panno = $excelrow['PAN No'];
                  $modelPer->aadhaarno = $excelrow['Aadhaar No'];
                  $modelPer->passportno = $excelrow['Passport No'];
				  
				  if(!empty($excelrow['Passport Valid']) && $excelrow['Passport Valid'] !='01-01-1970' && $excelrow['Passport Valid'] !='1970-01-01') {
				     $modelPer->passportvalid = Yii::$app->formatter->asDate($excelrow['Passport Valid'], "yyyy-MM-dd");
					    $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelPer->passportvalid ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Passport valid Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->passportvalid =NULL; 
					} 
					
                  $modelPer->passport_remark = $excelrow['Passport Remarks'];
                  $modelPer->voteridno = $excelrow['Voter ID'];
                  $modelPer->drivinglicenceno = $excelrow['Driving Licence No'];
                  $modelPer->licence_categories = $excelrow['Licence Categories'];
                  $modelPer->licence_remark = $excelrow['Licence Remarks'];
                  $modelPer->save(false);

                  $modelAdd = new EmpAddress();
                  $modelAdd->empid = $emptableid;
                  $modelAdd->addfield1 = $excelrow['Res. No'];
                  $modelAdd->addfield2 = $excelrow['Res. Name'];
                  $modelAdd->addfield3 = $excelrow['Road/Street'];
                  $modelAdd->addfield4 = $excelrow['Locality/Area'];
                  $modelAdd->addfield5 = $excelrow['City'];
                  $modelAdd->district = $excelrow['District'];
                  $modelAdd->state = $excelrow['State'];
                  $modelAdd->pincode = $excelrow['Pincode'];
                  $modelAdd->save(false);
				  
				  $modelfamily = new EmpFamilydetails();
                  $modelfamily->empid = $emptableid;
				  $modelfamily->save(false);
				  
				  $modelBank = new EmpBankdetails();
                  $modelBank->empid = $emptableid;
				  $modelBank->save(false);
				  
				  $modelcertif = new EmpCertificates();
                  $modelcertif->empid = $emptableid;
				  $modelcertif->save(false);
				  
				  $modeledu = new EmpEducationdetails();
                  $modeledu->empid = $emptableid;
				  $modeledu->save(false);
				  
				  $modelPEmp = new PreviousEmployment();
                  $modelPEmp->empid = $emptableid;
				  $modelPEmp->save(false);
				  
				  $modelStatu = new EmpStatutorydetails();
                  $modelStatu->empid = $emptableid;
                  $modelStatu->esino = $excelrow['ESI No'];
                  $modelStatu->epfno = $excelrow['EPF No'];
                  $modelStatu->epfuanno = $excelrow['EPF UAN No'];
                  $modelStatu->zeropension = $excelrow['Zero Pension'];
                  $modelStatu->professionaltax = $excelrow['PT'];
				  $modelStatu->gpa_applicability = $excelrow['GPA Applicability'];
				  $modelStatu->gpa_no = $excelrow['GPA No'];
				  $modelStatu->gpa_sum_insured = $excelrow['GPA SUM Insured'];
				  $modelStatu->gpa_premium = $excelrow['GPA Premium'];
				  $modelStatu->gmc_applicability = $excelrow['GMC Applicability'];
				  $modelStatu->gmc_no = $excelrow['GMC No'];
				  $modelStatu->gmc_sum_insured = $excelrow['GMC SUM Insured'];
				  $modelStatu->gmc_premium = $excelrow['GMC Premium'];
				  $modelStatu->age_group = $excelrow['Age Group'];
				  $modelStatu->wc_applicability = $excelrow['WC Applicability'];
                  $modelStatu->wc_no = $excelrow['WC No'];
				  
				  /*if (!empty($excelrow['GPA Premium']) || $excelrow['GPA Applicability'] == 'Yes') {
				   $gpa = $excelrow['GPA Premium']/12;
              } else {
                   $gpa = NULL;			
              }*/
			  
			   /*$modelStatu->gmc_premium = $excelrow['GMC Premium'];
			  
			  if (!empty($excelrow['GMC Premium']) || $excelrow['GMC Applicability'] == 'Yes') {
				   $gmc = $excelrow['GMC Premium']/24;
              } else {
                   $gmc = NULL;			
              }*/
			  
                  $modelStatu->save(false);

				
                  $modelRemu = new EmpRemunerationDetails();
                  $modelRemu->empid = $emptableid;
                  $modelRemu->salary_structure = $excelrow['Salary Structure'];
                  $modelRemu->work_level = $excelrow['Work Level'];
                  $modelRemu->grade = $excelrow['Grade'];
                  $modelRemu->attendance_type = $excelrow['Attendance Type'];
                  $modelRemu->esi_applicability = $excelrow['ESI Applicability'];
                  $modelRemu->pf_applicablity = $excelrow['EPF Applicability'];
                  $modelRemu->restrict_pf = $excelrow['Restrict EPF'];
				  
                  if (empty($excelrow['PLI']) || $excelrow['PLI'] == 'N/A') {
                     $modelRemu->pli = NULL;
                  } else {
                     $modelRemu->pli = $excelrow['PLI'];
                  }
				  
                  $modelRemu->basic = $basic;
                  $modelRemu->hra = $hra;
                  $modelRemu->dearness_allowance = $dearness_allowance;
                //  $modelRemu->splallowance = $spl_allowance;
                  $modelRemu->conveyance = $conveyance_allowance;
                  $modelRemu->lta = $lta_earning;
                  $modelRemu->medical = $medical_earning;
                  $modelRemu->other_allowance = $other_allowance;
                  $modelRemu->gross_salary = $grossamount;
				  if (empty($excelrow['Food Allowance']) || $excelrow['Food Allowance'] == 'N/A') {
					  $modelRemu->food_allowance = NULL;					
					 } else{
                     $modelRemu->food_allowance = $excelrow['Food Allowance'];					
                    } 
						
                  $modelRemu->employer_pf_contribution = $employer_pf;
                  $modelRemu->employer_esi_contribution = $employer_esi;
                  $modelRemu->employer_pli_contribution = $employer_pli;
                  $modelRemu->employer_lta_contribution = $employer_lta;
                  $modelRemu->employer_medical_contribution = $employer_medical;
                  $modelRemu->ctc = ($grossamount + $employer_pf + $employer_esi + $employer_pli + $employer_lta + $employer_medical);
                  $modelRemu->save(false);                  
                  $startrow++;
               }
			}
               if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been imported');
               }
            } catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
         } else if ($model->uploadtype == 2 && $model->uploaddata == 1) {

            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
			   if (!empty($excelrow['Emp. Code'])) {
                  $grossamount = 0;
                  $basic = 0;
                  $hra = 0;
                  $dearness_allowance = 0;
                  $spl_allowance = 0;
                  $conveyance_allowance = 0;
                  $pli_earning = 0;
                  $lta_earning = 0;
                  $medical_earning = 0;
                  $other_allowance = 0;


                  if (empty($excelrow['Emp. Code'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Code Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if (empty($excelrow['Emp. Name'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Name Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }

                  if (empty($excelrow['Gender'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gender Column Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }		 
				 
				 if(!empty($excelrow['Date of Joining']) && $excelrow['Date of Joining'] !='01-01-1970' && $excelrow['Date of Joining'] !='1970-01-01'){
					 $doj = Yii::$app->formatter->asDate($excelrow['Date of Joining'], "yyyy-MM-dd");
				    $regex = '/^(^[1-9][0-9-]*)$/';
				   if(!preg_match( $regex, $doj ) ) {											 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoJ Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				 } else {					 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Date of Joining');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				 

                  if ($excelrow['Salary Structure'] != 'Consolidated pay' && !empty($excelrow['Salary Structure']) && $excelrow['Salary Structure'] != 'Contract') {
                     $wl = $excelrow['Work Level'];
                     $SalarySalary = EmpSalarystructure::find()->where(['salarystructure' => $excelrow['Salary Structure'], 'worklevel' => $excelrow['Work Level'], 'grade' => $excelrow['Grade'],])->one();
                     $PayScale = EmpStaffPayScale::find()->where(['salarystructure' => $excelrow['Salary Structure']])->one();
                     if ($SalarySalary || $PayScale) {
                        if ($SalarySalary) {
                           $basic = $SalarySalary->basic;
                           $hra = $SalarySalary->hra;
                           $dearness_allowance = $SalarySalary->dapermonth;
                           $other_allowance = $SalarySalary->other_allowance;
                           $grossamount = $SalarySalary->netsalary;
                        }

                        if ($PayScale) {
                           $p_scale = $PayScale->id;
                           $grossamount = $excelrow['Gross Salary'];
                           $basic = round($grossamount * $PayScale->basic);
                           $hra = round($grossamount * $PayScale->hra);
                           $dearness_allowance = round($grossamount * $PayScale->dearness_allowance);
                          // $spl_allowance = round($grossamount * $PayScale->spl_allowance);
                           $conveyance_allowance = round($PayScale->conveyance_allowance);
                           $lta_earning = round($basic * $PayScale->lta);
                           $medical_earning = round($basic * $PayScale->medical);
                           $other_allowance = round(($grossamount - ($basic + $hra + $dearness_allowance + $lta_earning + $medical_earning)) - $conveyance_allowance);
						 }
                     } else {
                        Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Salary Structure Doesn\'t Match');
                        $startrow++;
                        $countrow +=1;
                        continue;
                     }
                  }
				  
				   
				  
				  if($excelrow['Salary Structure'] == 'Consolidated pay' ) {
					if(!empty($excelrow['Gross Salary']) && $excelrow['Gross Salary'] != 0) {
					  $grossamount = $excelrow['Gross Salary'];
                      $basic = round($grossamount);					
				  } else {					 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gross Salary Empty');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
			   }

                  if (!empty($excelrow['PLI']) && $excelrow['PLI'] != 'N/A') {
                     $employer_pli = round($basic * ($excelrow['PLI']/100));
                  } else {
                     $employer_pli = 0;
                  }

                  if (!empty($excelrow['Salary Structure']) && $excelrow['Salary Structure'] != 'Engineer' && $excelrow['Salary Structure'] != 'Trainee' && $excelrow['Salary Structure'] != 'Consolidated pay' && $excelrow['Salary Structure'] != 'Contract' && $excelrow['Salary Structure'] != 'Conventional' && $excelrow['Salary Structure'] != 'Modern') {
                     $employer_medical = round($basic * (8.33/100));
                     $employer_lta = round($basic * (8.33/100));
                  } else {
                     $employer_medical = 0;
                     $employer_lta = 0;
                  }

                  if ($excelrow['ESI Applicability'] == 'Yes' && $grossamount < 21000) {
                     $employer_esi = ceil($grossamount * ($pf_esi_rates->esi_er / 100));
                  } else {
                     $employer_esi = 0;
                  }
                 if ($excelrow['EPF Applicability'] == 'Yes') {				
						if ($excelrow['Restrict EPF'] == 'Yes') {
						   $statutory_rate_pf = $grossamount - $hra;
							if($statutory_rate_pf <= 15000){								
								$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));						
							} else {
								 $statutory_rate_pf = 15000;
								 $employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));					
							}
					    } else {
							$statutory_rate_pf = $grossamount - $hra;
							$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));					 
						}
                  } else {
						$employer_pf = 0;
                  }

                  $posting = strtolower(str_replace(' ', '', $excelrow['Designation']));
                  $design = Yii::$app->db->createCommand("SELECT id FROM designation WHERE LOWER(replace(designation ,' ',''))='" . $posting . "'")->queryOne();
                  if ($design)
                     $designation = $design['id'];
                  else
                     $designation = NULL;



                  $dept = strtolower(str_replace(' ', '', $excelrow['Department']));
                  $dept1 = Yii::$app->db->createCommand("SELECT id FROM department WHERE LOWER(replace(name ,' ',''))='" . $dept . "'")->queryOne();
                  if ($dept1)
                     $department = $dept1['id'];
                  else
                     $department = NULL;


                  $unit = strtolower(str_replace(' ', '', $excelrow['Unit']));
                  $unit1 = Yii::$app->db->createCommand("SELECT id FROM unit WHERE LOWER(replace(name ,' ',''))='" . $unit . "'")->queryOne();
                  $unit_id = $unit1['id'];

                  if ($unit1)
                     $unit_id = $unit1['id'];
                  else {
                     $unit_id = NULL;
                  }

                  $div = strtolower(str_replace(' ', '', $excelrow['Division']));
                  $division = Yii::$app->db->createCommand("SELECT id FROM division WHERE LOWER(replace(division_name ,' ',''))='" . $div . "'")->queryOne();
                  $division_id = $division['id'];

                  if ($unit1)
                     $division_id = $division['id'];
                  else
                     $division_id = NULL;


                  $modelemployee = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                  if ($modelemployee) {
                     $modelEmp = EmpDetails::findOne($modelemployee->id);
                     $modelEmp->empcode = $excelrow['Emp. Code'];
                     $modelEmp->empname = $excelrow['Emp. Name'];
					 $modelEmp->doj = $doj;	
					 $modelEmp->category = $excelrow['Category'];	
					 
					if(!empty($excelrow['Confirmation Date']) && $excelrow['Confirmation Date'] !='01-01-1970' && $excelrow['Confirmation Date'] !='1970-01-01'){
				$modelEmp->confirmation_date = Yii::$app->formatter->asDate($excelrow['Confirmation Date'], "yyyy-MM-dd");
				$regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelEmp->confirmation_date ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Confirmation Date Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {
				$modelEmp->confirmation_date =NULL; 
				} 				
					
                     $modelEmp->designation_id = $designation;
                     $modelEmp->division_id = $division_id;
                     $modelEmp->unit_id = $unit_id;
                     $modelEmp->department_id = $department;
                     $modelEmp->email = $excelrow['Email(Official)'];
                     $modelEmp->mobileno = $excelrow['Mobile No(CUG)'];
                     $modelEmp->referedby = $excelrow['Referred By'];
                     $modelEmp->probation = $excelrow['Probation'];
                     $modelEmp->appraisalmonth = $excelrow['Appraisal Month'];
					  if(!empty($excelrow['Latest Promotion Date']) && $excelrow['Latest Promotion Date'] !='01-01-1970' && $excelrow['Latest Promotion Date'] !='1970-01-01'){
					 $modelEmp->recentdop = Yii::$app->formatter->asDate($excelrow['Latest Promotion Date'], "yyyy-MM-dd");
					 	   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex,  $modelEmp->recentdop ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Latest Promotion Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					  } else {
						 $modelEmp->recentdop =NULL; 
					  }  
                     $modelEmp->joining_status = $excelrow['Joining Status'];
                     $modelEmp->experience = $excelrow['Previous Experience'];
					 
					   if(!empty($excelrow['Last Working Date']) && $excelrow['Last Working Date'] !='01-01-1970' && $excelrow['Last Working Date'] !='1970-01-01'){
					 $modelEmp->last_working_date = Yii::$app->formatter->asDate($excelrow['Last Working Date'], "yyyy-MM-dd");
					  $no_of_year = date_diff(date_create($doj), date_create($modelEmp->last_working_date));
						 if($no_of_year->format('%m') >=6 )
						  $modelEmp->service = $no_of_year->format('%y') + 1;
						else 
						  $modelEmp->service = $no_of_year->format('%y');
					 } else {
					 $modelEmp->last_working_date =NULL; 
					 $modelEmp->service =NULL;  
					 } 
				  
				   if(!empty($excelrow['Resignation Date']) && $excelrow['Resignation Date'] !='01-01-1970' && $excelrow['Resignation Date'] !='1970-01-01'){
					 $modelEmp->resignation_date = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->resignation_date =NULL; 
				  } 
				  
				    if(!empty($excelrow['Date of Leaving']) && $excelrow['Date of Leaving'] !='01-01-1970' && $excelrow['Date of Leaving'] !='1970-01-01'){
					 $modelEmp->dateofleaving = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->dateofleaving =NULL; 
				  } 				 
					 $modelEmp->reasonforleaving = $excelrow['Reason for Leaving'];
					 
					  if($excelrow['Status'] == ''){
					  $modelEmp->status = 'Active';
					  } else {
					   $modelEmp->status = $excelrow['Status'];
					  }
                     $modelEmp->save(false);

                     $modelPer = EmpPersonaldetails::find()->where(['empid' => $modelemployee->id])->one();                   
					
					 if(!empty($excelrow['DoB(Record)']) && $excelrow['DoB(Record)'] !='01-01-1970' && $excelrow['DoB(Record)'] !='1970-01-01'){
				     $modelPer->dob = Yii::$app->formatter->asDate($excelrow['DoB(Record)'], "yyyy-MM-dd");
					   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex,  $modelPer->dob ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoB Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->dob =NULL; 
					} 
					
					if(!empty($excelrow['Birthday']) && $excelrow['Birthday'] !='01-01-1970' && $excelrow['Birthday'] !='1970-01-01'){
				     $modelPer->birthday = Yii::$app->formatter->asDate($excelrow['Birthday'], "yyyy-MM-dd");
					    $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex,  $modelPer->birthday ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change birthday Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->birthday =NULL; 
					} 					 
					 $modelPer->gender = $excelrow['Gender'];
                     $modelPer->mobile_no = $excelrow['Mobile No'];
                     $modelPer->email = $excelrow['Email(Personal)'];
                     $modelPer->blood_group = $excelrow['Blood Group'];
                     $modelPer->caste = $excelrow['Caste'];
                     $modelPer->community = $excelrow['Community'];
                     $modelPer->martialstatus = $excelrow['Marital Status'];
                     $modelPer->panno = $excelrow['PAN No'];
                     $modelPer->aadhaarno = $excelrow['Aadhaar No'];
                     $modelPer->passportno = $excelrow['Passport No'];
					  
				  if(!empty($excelrow['Passport Valid']) && $excelrow['Passport Valid'] !='01-01-1970' && $excelrow['Passport Valid'] !='1970-01-01'){
				     $modelPer->passportvalid = Yii::$app->formatter->asDate($excelrow['Passport Valid'], "yyyy-MM-dd");
					    $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex,  $modelPer->passportvalid ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change passportvalid Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->passportvalid =NULL; 
					} 
                     $modelPer->passport_remark = $excelrow['Passport Remarks'];
                     $modelPer->voteridno = $excelrow['Voter ID'];
                     $modelPer->drivinglicenceno = $excelrow['Driving Licence No'];
                     $modelPer->licence_categories = $excelrow['Licence Categories'];
                     $modelPer->licence_remark = $excelrow['Licence Remarks'];
                     $modelPer->save(false);

                     $modelAdd = EmpAddress::find()->where(['empid' => $modelemployee->id])->one();
                     $modelAdd->addfield1 = $excelrow['Res. No'];
                     $modelAdd->addfield2 = $excelrow['Res. Name'];
                     $modelAdd->addfield3 = $excelrow['Road/Street'];
                     $modelAdd->addfield4 = $excelrow['Locality/Area'];
                     $modelAdd->addfield5 = $excelrow['City'];
                     $modelAdd->district = $excelrow['District'];
                     $modelAdd->state = $excelrow['State'];
                     $modelAdd->pincode = $excelrow['Pincode'];
                     $modelAdd->save(false);

                     $modelRemu = EmpRemunerationDetails::find()->where(['empid' => $modelemployee->id])->one();
                     $modelRemu->salary_structure = $excelrow['Salary Structure'];
                     $modelRemu->work_level = $excelrow['Work Level'];
                     $modelRemu->grade = $excelrow['Grade'];
                     $modelRemu->attendance_type = $excelrow['Attendance Type'];
                     $modelRemu->esi_applicability = $excelrow['ESI Applicability'];
                     $modelRemu->pf_applicablity = $excelrow['EPF Applicability'];
                     $modelRemu->restrict_pf = $excelrow['Restrict EPF'];
                     if ($excelrow['PLI'] == 'N/A' || empty($excelrow['PLI'])) {
                        $modelRemu->pli = NULL;
                     } else {
                        $modelRemu->pli = $excelrow['PLI'];
                     }
                     $modelRemu->basic = $basic;
                     $modelRemu->hra = $hra;
                     $modelRemu->dearness_allowance = $dearness_allowance;
                   //  $modelRemu->splallowance = $spl_allowance;
                     $modelRemu->conveyance = $conveyance_allowance;
                     $modelRemu->lta = $lta_earning;
                     $modelRemu->medical = $medical_earning;
                     $modelRemu->other_allowance = $other_allowance;
                     $modelRemu->gross_salary = $grossamount;
					 if (empty($excelrow['Food Allowance']) || $excelrow['Food Allowance'] == 'N/A') {
						 $modelRemu->food_allowance = NULL;
					 } else {
						$modelRemu->food_allowance = $excelrow['Food Allowance'];
                     }
					 
					 $modelRemu->employer_pf_contribution = $employer_pf;
					  $modelRemu->employer_esi_contribution = $employer_esi;
					  $modelRemu->employer_pli_contribution = $employer_pli;
					  $modelRemu->employer_lta_contribution = $employer_lta;
					  $modelRemu->employer_medical_contribution = $employer_medical;
					  $modelRemu->ctc = ($grossamount + $employer_pf + $employer_esi + $employer_pli + $employer_lta + $employer_medical);
                     $modelRemu->save(false);
					 
					  $modelStatu = EmpStatutorydetails::find()->where(['empid' => $modelemployee->id])->one();	
					  $modelStatu->esino = $excelrow['ESI No'];
					  $modelStatu->epfno = $excelrow['EPF No'];
					  $modelStatu->epfuanno = $excelrow['EPF UAN No'];
					  $modelStatu->zeropension = $excelrow['Zero Pension'];
					  $modelStatu->professionaltax = $excelrow['PT'];
					  $modelStatu->gpa_applicability = $excelrow['GPA Applicability'];
					  $modelStatu->gpa_no = $excelrow['GPA No'];
					  $modelStatu->gpa_sum_insured = $excelrow['GPA SUM Insured'];
					  $modelStatu->gpa_premium = $excelrow['GPA Premium'];
				      $modelStatu->gmc_applicability = $excelrow['GMC Applicability'];
					  $modelStatu->gmc_no = $excelrow['GMC No'];
					  $modelStatu->gmc_sum_insured = $excelrow['GMC SUM Insured'];
					  $modelStatu->gmc_premium = $excelrow['GMC Premium'];
				      $modelStatu->age_group = $excelrow['Age Group'];
					  $modelStatu->wc_applicability = $excelrow['WC Applicability'];
                      $modelStatu->wc_no = $excelrow['WC No'];
					  
					   /*$modelStatu->gpa_premium = $excelrow['GPA Premium'];			  
				  if (!empty($excelrow['GPA Premium']) || $excelrow['GPA Applicability'] == 'Yes') {
					   $gpa = $excelrow['GPA Premium']/12;
				  } else {
					   $gpa = NULL;			
				  }*/
				  /*$modelStatu->gmc_premium = $excelrow['GMC Premium'];			  
				  if (!empty($excelrow['GMC Premium']) || $excelrow['GMC Applicability'] == 'Yes') {
					   $gmc = $excelrow['GMC Premium']/24;
				  } else {
					   $gmc = NULL;			
				  }*/
					  $modelStatu->save(false);
					 
                  } else {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: This Not Updated Record');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  $startrow++;
               }
			   }
               if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been Updated');
               }
            } catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
         } else if ($model->uploaddata == 2) {
		 $countrow = 0;
		  $startrow = 0;
		  $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
				 $modelemployee = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();	
				 if($modelemployee && !empty($excelrow['Relationship'])){
				  $family = EmpFamilydetails::find()->where(['empid' => $modelemployee->id])
															->andWhere(['LIKE', 'relationship', $excelrow['Relationship']])->one();
															
					 if(EmpFamilydetails::find()->where(['empid' => $modelemployee->id,'relationship'=>NULL])->exists()) {
							 $modelfamily = EmpFamilydetails::find()->where(['empid' => $modelemployee->id,'relationship'=>NULL])->one();
						} else if($family) {
							$modelfamily = $family;
						} else {
						  $modelfamily = new EmpFamilydetails();
						}
						  $modelfamily->empid = $modelemployee->id;
						  $modelfamily->relationship = $excelrow['Relationship'];
						  $modelfamily->name = $excelrow['Name'];
						  $modelfamily->mobileno = $excelrow['Mobile']; 
						  $modelfamily->aadhaarno = $excelrow['Aadhaar#']; 
						 
						  if(!empty($excelrow['Birthday']) && $excelrow['Birthday'] !='01-01-1970' && $excelrow['Birthday'] !='1970-01-01') {
							 $modelfamily->birthdate = Yii::$app->formatter->asDate($excelrow['Birthday'], "yyyy-MM-dd");
								$regex = '/^(^[1-9][0-9-]*)$/';
								 if(!preg_match( $regex, $modelfamily->birthdate ) ) {										 
								 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Birthday Date Format ');
								 $startrow++;
								 $countrow +=1;
								 continue;
								 }
							} else {
							 $modelfamily->birthdate =NULL; 
							} 				  			 
						   $modelfamily->nominee = $excelrow['Nominee'];
						   $modelfamily->gmc_no = $excelrow['GMC No'];
						   $modelfamily->sum_insured = $excelrow['SUM Insured'];
						   $modelfamily->age_group = $excelrow['Age Group'];
						  $modelfamily->save(false);
						   $startrow++;
					 }
			   }
			   if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been Updated');
               }
			} catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
		} else if ($model->uploaddata == 3) {
		  $countrow = 0;
		  $startrow = 0;
		  $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
					 $modelemployee = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();										
					if($modelemployee && !empty($excelrow['Degree'])) {					
						$quali = Qualification::find()->where(['LIKE','qualification_name',$excelrow['Degree']])->one();						
						if(EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>$quali->id])->exists()) {
							 $edumodel = EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>$quali->id])->one();
						} else if(EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>NULL])->exists()) {
							$edumodel = EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>NULL])->one();
						} else {
						  $edumodel = new EmpEducationdetails();
						}
						
						 $course = strtolower(str_replace(' ', '', $excelrow['Specialization']));
						  $coursemodel = Yii::$app->db->createCommand("SELECT id FROM course WHERE LOWER(replace(coursename ,' ',''))='" . $course . "'")->queryOne();                 

						  if ($coursemodel)
							 $course_id = $coursemodel['id'];
						  else
							 $course_id = NULL;
						 
						  $college = strtolower(str_replace(' ', '', $excelrow['Institute']));
						  $collegemodel = Yii::$app->db->createCommand("SELECT id FROM college WHERE LOWER(replace(collegename,' ',''))='" . $college . "'")->queryOne();                 

						  if ($collegemodel)
							 $college_id = $collegemodel['id'];
						  else
							 $college_id = NULL;
						
							$edumodel->empid = $modelemployee->id;
							$edumodel->qualification = $quali->id;
							$edumodel->course = $course_id;
						    $edumodel->institute = $college_id;   
						    $edumodel->yop = $excelrow['YOP'];   
						    $edumodel->board = $excelrow['Board'];   
						    $edumodel->save(false);
							 $startrow++;
						 }
					 }
				  if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been Updated');
               }			
			   
			} catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
		} else if ($model->uploaddata == 4) {
		  $countrow = 0;
		  $startrow = 0;
		  $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
					 $modelemployee = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();										
					if($modelemployee && !empty($excelrow['Certificate Name'])) {
						if(EmpCertificates::find()->where(['LIKE','certificatesname',$excelrow['Certificate Name']])->exists()) {
							 $certimodel = EmpCertificates::find()->where(['LIKE','certificatesname',$excelrow['Certificate Name']])->one();
						} else if(EmpCertificates::find()->where(['empid' => $modelemployee->id,'certificatesname'=>NULL])->exists()) {
							$certimodel = EmpCertificates::find()->where(['empid' => $modelemployee->id,'certificatesname'=>NULL])->one();
						} else {
						  $certimodel = new EmpCertificates();
						}
							$certimodel->empid = $modelemployee->id;
							$certimodel->certificateno = $excelrow['Certificate No']; 
							$certimodel->issue_authority = $excelrow['Issue Authority'];
						    $certimodel->save(false);
							$startrow++;
						 }
					 }
				  if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been Updated');
               }			
			   
			} catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
		 } else if ($model->uploaddata == 5) {
		  $countrow = 0;
		  $startrow = 0;
		  $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
					 $modelemployee = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();										
					if($modelemployee && !empty($excelrow['Account Number'])) {
						if(EmpBankdetails::find()->where(['LIKE','acnumber',$excelrow['Account Number']])->exists()) {
							$bankmodel = EmpBankdetails::find()->where(['LIKE','acnumber',$excelrow['Account Number']])->one();
						} else if(EmpBankdetails::find()->where(['empid' => $modelemployee->id,'acnumber'=>NULL])->exists()) {
							$bankmodel = EmpBankdetails::find()->where(['empid' => $modelemployee->id,'acnumber'=>NULL])->one();
						} else {
						  $bankmodel = new EmpBankdetails();
						}
							$bankmodel->empid = $modelemployee->id;
							$bankmodel->bankname = $excelrow['Bank Name']; 
							$bankmodel->acnumber = $excelrow['Account Number'];  
							$bankmodel->branch = $excelrow['Branch'];
							$bankmodel->ifsc = $excelrow['IFSC'];
						    $bankmodel->save(false);
							$startrow++;
						 } 
					 }
				  if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been Updated');
               }			
			   
			} catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
		 } else if ($model->uploadtype == 1 && $model->uploaddata == 6) {
            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
			   if (!empty($excelrow['Emp. Code'])) { 
                  $grossamount = 0;
                  $basic = $excelrow['Basic'];
                  $hra = 0;
                  $dearness_allowance = 0;
                  $spl_allowance = 0;
                  $conveyance_allowance = 0;
                  $pli_earning = 0;
                  $lta_earning = 0;
                  $medical_earning = 0;
                  $other_allowance = 0;
				  
				  $employer_medical = 0;
                  $employer_lta = 0;
					
				  if (empty($excelrow['Emp. Code'])) {                 
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Code Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
				  
				   if (empty($excelrow['Emp. Name'])) {                
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Name Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if (empty($excelrow['Gender'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gender Column Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  $uniquecolumn = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                  if ($uniquecolumn) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Ecode Already Exists');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
				  
				if(!empty($excelrow['Date of Joining']) && $excelrow['Date of Joining'] !='01-01-1970' && $excelrow['Date of Joining'] !='1970-01-01'){
				   $doj = Yii::$app->formatter->asDate($excelrow['Date of Joining'], "yyyy-MM-dd");
				   $regex = '/^(^[1-9][0-9-]*)$/';
				   if(!preg_match( $regex, $doj ) ) {											 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoJ Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {					 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Date of Joining');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					
                 
                  $posting = strtolower(str_replace(' ', '', $excelrow['Designation']));
                  $design = Yii::$app->db->createCommand("SELECT id FROM designation WHERE LOWER(replace(designation ,' ',''))='" . $posting . "'")->queryOne();
                  if ($design)
                     $designation = $design['id'];
                  else
                     $designation = NULL;

                  $dept = strtolower(str_replace(' ', '', $excelrow['Department']));
                  $dept1 = Yii::$app->db->createCommand("SELECT id FROM department WHERE LOWER(replace(name ,' ',''))='" . $dept . "'")->queryOne();
                  if ($dept1)
                     $department = $dept1['id'];
                  else
                     $department = NULL;
				 
                  $unit = strtolower(str_replace(' ', '', $excelrow['Unit']));
                  $unit1 = Yii::$app->db->createCommand("SELECT id FROM unit WHERE LOWER(replace(name ,' ',''))='" . $unit . "'")->queryOne();
                  $unit_id = $unit1['id'];

                  if ($unit1)
                     $unit_id = $unit1['id'];
                  else
                     $unit_id = NULL;


                  $div = strtolower(str_replace(' ', '', $excelrow['Division']));
                  $division = Yii::$app->db->createCommand("SELECT id FROM division WHERE LOWER(replace(division_name ,' ',''))='" . $div . "'")->queryOne();
                  $division_id = $division['id'];

                  if ($unit1)
                     $division_id = $division['id'];
                  else
                     $division_id = NULL;
				 
				 
                  $modelEmp = new EmpDetails();
                  $modelEmp->empcode = $excelrow['Emp. Code'];
                  $modelEmp->empname = $excelrow['Emp. Name'];
				  $modelEmp->doj = $doj;
				
					  
				if(!empty($excelrow['Confirmation Date']) && $excelrow['Confirmation Date'] !='01-01-1970' && $excelrow['Confirmation Date'] !='1970-01-01'){
				$modelEmp->confirmation_date = Yii::$app->formatter->asDate($excelrow['Confirmation Date'], "yyyy-MM-dd");
				  $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelEmp->confirmation_date ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Confirmation Date Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {
				$modelEmp->confirmation_date =NULL; 
				}   
					  
					  
                  $modelEmp->designation_id = $designation;
                  $modelEmp->division_id = $division_id;
                  $modelEmp->unit_id = $unit_id;
                  $modelEmp->department_id = $department;
				  $modelEmp->category = $excelrow['Category'];
                  $modelEmp->email = $excelrow['Email(Official)'];
                  $modelEmp->mobileno = $excelrow['Mobile No(CUG)'];
                  $modelEmp->referedby = $excelrow['Referred By'];
                  $modelEmp->probation = $excelrow['Probation'];
                  $modelEmp->appraisalmonth = $excelrow['Appraisal Month'];
				  if(!empty($excelrow['Latest Promotion Date']) && $excelrow['Latest Promotion Date'] !='01-01-1970' && $excelrow['Latest Promotion Date'] !='1970-01-01'){
					 $modelEmp->recentdop = Yii::$app->formatter->asDate($excelrow['Latest Promotion Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->recentdop =NULL; 
				  }   
				  
				     if(!empty($excelrow['Last Working Date']) && $excelrow['Last Working Date'] !='01-01-1970' && $excelrow['Last Working Date'] !='1970-01-01'){
					 $modelEmp->last_working_date = Yii::$app->formatter->asDate($excelrow['Last Working Date'], "yyyy-MM-dd");
					 $no_of_year = date_diff(date_create($doj), date_create($modelEmp->last_working_date));
						 if($no_of_year->format('%m') >=6 )
						  $modelEmp->service = $no_of_year->format('%y') + 1;
						else 
						  $modelEmp->service = $no_of_year->format('%y');
					 } else {
					 $modelEmp->last_working_date =NULL;
					 $modelEmp->service = NULL;
					 } 
					 
					   if(!empty($excelrow['Resignation Date']) && $excelrow['Resignation Date'] !='01-01-1970' && $excelrow['Resignation Date'] !='1970-01-01'){
					 $modelEmp->resignation_date = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->resignation_date =NULL; 
				  } 
				  
				    if(!empty($excelrow['Date of Leaving']) && $excelrow['Date of Leaving'] !='01-01-1970' && $excelrow['Date of Leaving'] !='1970-01-01'){
					 $modelEmp->dateofleaving = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->dateofleaving =NULL; 
				  } 		
				  
				   $modelEmp->reasonforleaving = $excelrow['Reason for Leaving'];
				  
                 $modelEmp->joining_status = $excelrow['Joining Status'];
                  $modelEmp->experience = $excelrow['Previous Experience'];
				  
				  
				  if($excelrow['Status'] == ''){
					  $modelEmp->status = 'Active';
					  } else {
					   $modelEmp->status = $excelrow['Status'];
					  }
					  
				  
                  $modelEmp->save(false);

                  $emptableid = Yii::$app->db->getLastInsertID();

                  $modelPer = new EmpPersonaldetails();
                  $modelPer->empid = $emptableid;
				  if(!empty($excelrow['DoB(Record)']) && $excelrow['DoB(Record)'] !='01-01-1970' && $excelrow['DoB(Record)'] !='1970-01-01'){
				     $modelPer->dob = Yii::$app->formatter->asDate($excelrow['DoB(Record)'], "yyyy-MM-dd");
					   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex,  $modelPer->dob ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoB Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->dob =NULL; 
					} 
					
					if(!empty($excelrow['Birthday']) && $excelrow['Birthday'] !='01-01-1970' && $excelrow['Birthday'] !='1970-01-01'){
				     $modelPer->birthday = Yii::$app->formatter->asDate($excelrow['Birthday'], "yyyy-MM-dd");
					   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelPer->birthday ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change birthday Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->birthday =NULL; 
					} 
                 
                  $modelPer->gender = $excelrow['Gender'];
                  $modelPer->mobile_no = $excelrow['Mobile No'];
                  $modelPer->email = $excelrow['Email(Personal)'];
                  $modelPer->blood_group = $excelrow['Blood Group'];
                  $modelPer->caste = $excelrow['Caste'];
                  $modelPer->community = $excelrow['Community'];
                  $modelPer->martialstatus = $excelrow['Marital Status'];
                  $modelPer->panno = $excelrow['PAN No'];
                  $modelPer->aadhaarno = $excelrow['Aadhaar No'];
                  $modelPer->passportno = $excelrow['Passport No'];
				  
				  if(!empty($excelrow['Passport Valid']) && $excelrow['Passport Valid'] !='01-01-1970' && $excelrow['Passport Valid'] !='1970-01-01') {
				     $modelPer->passportvalid = Yii::$app->formatter->asDate($excelrow['Passport Valid'], "yyyy-MM-dd");
					    $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelPer->passportvalid ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Passport valid Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->passportvalid =NULL; 
					} 
					
                 $modelPer->passport_remark = $excelrow['Passport Remarks'];
                  $modelPer->voteridno = $excelrow['Voter ID'];
                  $modelPer->drivinglicenceno = $excelrow['Driving Licence No'];
                  $modelPer->licence_categories = $excelrow['Licence Categories'];
                  $modelPer->licence_remark = $excelrow['Licence Remarks'];
                  $modelPer->save(false);

                  $modelAdd = new EmpAddress();
                  $modelAdd->empid = $emptableid;
                  $modelAdd->addfield1 = $excelrow['Res. No'];
                  $modelAdd->addfield2 = $excelrow['Res. Name'];
                  $modelAdd->addfield3 = $excelrow['Road/Street'];
                  $modelAdd->addfield4 = $excelrow['Locality/Area'];
                  $modelAdd->addfield5 = $excelrow['City'];
                  $modelAdd->district = $excelrow['District'];
                  $modelAdd->state = $excelrow['State'];
                  $modelAdd->pincode = $excelrow['Pincode'];
                  $modelAdd->save(false);
				  
				  $modelfamily = new EmpFamilydetails();
                  $modelfamily->empid = $emptableid;
				  $modelfamily->save(false);
				  
				  $modelBank = new EmpBankdetails();
                  $modelBank->empid = $emptableid;
				  $modelBank->save(false);
				  
				  $modelcertif = new EmpCertificates();
                  $modelcertif->empid = $emptableid;
				  $modelcertif->save(false);
				  
				  $modeledu = new EmpEducationdetails();
                  $modeledu->empid = $emptableid;
				  $modeledu->save(false);
				  
				  $modelPEmp = new PreviousEmployment();
                  $modelPEmp->empid = $emptableid;
				  $modelPEmp->save(false);
				  
				  $modelStatu = new EmpStatutorydetails();
                  $modelStatu->empid = $emptableid;
                  $modelStatu->esino = $excelrow['ESI No'];
                  $modelStatu->epfno = $excelrow['EPF No'];
                  $modelStatu->epfuanno = $excelrow['EPF UAN No'];
                  $modelStatu->zeropension = $excelrow['Zero Pension'];
                  $modelStatu->professionaltax = $excelrow['PT'];
				  $modelStatu->gpa_applicability = $excelrow['GPA Applicability'];
				  $modelStatu->gpa_no = $excelrow['GPA No'];
				  $modelStatu->gpa_sum_insured = $excelrow['GPA SUM Insured'];
				  $modelStatu->gpa_premium = $excelrow['GPA Premium'];
				  $modelStatu->gmc_applicability = $excelrow['GMC Applicability'];				  
				  $modelStatu->gmc_no = $excelrow['GMC No'];
				  $modelStatu->gmc_sum_insured = $excelrow['GMC SUM Insured'];
				  $modelStatu->gmc_premium = $excelrow['GMC Premium'];
				  $modelStatu->age_group = $excelrow['Age Group'];
				  $modelStatu->wc_applicability = $excelrow['WC Applicability'];
                  $modelStatu->wc_no = $excelrow['WC No'];
				  /*$modelStatu->gpa_premium = $excelrow['GPA Premium'];			  
				  if (!empty($excelrow['GPA Premium']) || $excelrow['GPA Applicability'] == 'Yes') {
					   $gpa = $excelrow['GPA Premium']/12;
				  } else {
					   $gpa = NULL;			
				  }*/
				 /* $modelStatu->gmc_premium = $excelrow['GMC Premium'];			  
				  if (!empty($excelrow['GMC Premium']) || $excelrow['GMC Applicability'] == 'Yes') {
					   $gmc = $excelrow['GMC Premium']/24;
				  } else {
					   $gmc = NULL;			
				  }*/
                  
				  $modelStatu->save(false);
				
                  $modelRemu = new EmpRemunerationDetails();
                  $modelRemu->empid = $emptableid;
                  $modelRemu->salary_structure = $excelrow['Salary Structure'];
                  $modelRemu->work_level = $excelrow['Work Level'];
                  $modelRemu->grade = $excelrow['Grade'];
                  $modelRemu->attendance_type = $excelrow['Attendance Type'];
                  $modelRemu->esi_applicability = $excelrow['ESI Applicability'];
                  $modelRemu->pf_applicablity = $excelrow['EPF Applicability'];
                  $modelRemu->restrict_pf = $excelrow['Restrict EPF'];
				  
				  $modelRemu->basic = $excelrow['Basic'];
				  $modelRemu->hra = $excelrow['HRA'];
				  $modelRemu->dearness_allowance = $excelrow['DA'];
				  $modelRemu->personpay = $excelrow['Personpay'];
				  $modelRemu->dust_allowance = $excelrow['Dust Allowance'];
				  $modelRemu->washing_allowance = $excelrow['Washing Allowance'];
				  $modelRemu->guaranteed_benefit = $excelrow['Guaranteed Benefit'];
				  $modelRemu->other_allowance = $excelrow['Other Allowance'];
				  $modelRemu->misc = $excelrow['Miscellaneous'];
				  $modelRemu->gross_salary = $modelRemu->basic + $modelRemu->hra + $modelRemu->dearness_allowance + $modelRemu->personpay + $modelRemu->dust_allowance + $modelRemu->washing_allowance + $modelRemu->guaranteed_benefit + $modelRemu->other_allowance + $modelRemu->misc;
				  $grossamount = $modelRemu->gross_salary;
				
				   if (empty($excelrow['Food Allowance']) || $excelrow['Food Allowance'] == 'N/A') {
                     $modelRemu->food_allowance = NULL;
					 } else {
                     $modelRemu->food_allowance = $excelrow['Food Allowance'];
                  }
				  
				  
				   if (!empty($excelrow['PLI']) && $excelrow['PLI'] != 'N/A') {
					   $employer_pli = round($modelRemu->basic * ($excelrow['PLI']/100));
                  } else {
						$employer_pli = 0;
                  }

                 if ($excelrow['EPF Applicability'] == 'Yes') {				
						if ($excelrow['Restrict EPF'] == 'Yes') {
							if($grossamount <= 15000){
								$statutory_rate_pf = $grossamount - ($modelRemu->hra + $modelRemu->misc);
								$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));					
							} else {
								 $statutory_rate_pf = 15000;
								 $employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));					
							}
					    } else {
							$statutory_rate_pf = $grossamount - $modelRemu->hra;
							$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));						 
						}
                  } else {
						$employer_pf = 0;
                  }
				  
                  if ($excelrow['ESI Applicability'] == 'Yes' && $grossamount < 21000) {
                     $employer_esi = ceil(($grossamount - $modelRemu->misc) * ($pf_esi_rates->esi_er / 100));
                  } else {
                     $employer_esi = 0;
                  }
				  
				  
                  if (empty($excelrow['PLI']) || $excelrow['PLI'] == 'N/A') {
                     $modelRemu->pli = NULL;
                  } else {
                     $modelRemu->pli = $excelrow['PLI'];
                  }
                  
                  $modelRemu->employer_pf_contribution = $employer_pf;
                  $modelRemu->employer_esi_contribution = $employer_esi;
                  $modelRemu->employer_pli_contribution = $employer_pli;
                  $modelRemu->employer_lta_contribution = $employer_lta;
                  $modelRemu->employer_medical_contribution = $employer_medical;
                  $modelRemu->ctc = ($grossamount + $employer_pf + $employer_esi + $employer_pli + $employer_lta + $employer_medical);
                  $modelRemu->save(false);                  
                  $startrow++;
               }
			}
               if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been imported');
               }
            } catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
         } else if ($model->uploadtype == 2 && $model->uploaddata == 6) {
            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
			   if (!empty($excelrow['Emp. Code'])) { 
                  $grossamount = 0;
                  $basic = $excelrow['Basic'];
                  $hra = 0;
                  $dearness_allowance = 0;
                  $spl_allowance = 0;
                  $conveyance_allowance = 0;
                  $pli_earning = 0;
                  $lta_earning = 0;
                  $medical_earning = 0;
                  $other_allowance = 0;
				  
				  $employer_medical = 0;
                  $employer_lta = 0;
					
				  if (empty($excelrow['Emp. Code'])) {                 
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Code Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
				  
				   if (empty($excelrow['Emp. Name'])) {                
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Name Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if (empty($excelrow['Gender'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gender Column Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                 /* $uniquecolumn = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                  if ($uniquecolumn) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Ecode Already Exists');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  } */
				  
				if(!empty($excelrow['Date of Joining']) && $excelrow['Date of Joining'] !='01-01-1970' && $excelrow['Date of Joining'] !='1970-01-01'){
				   $doj = Yii::$app->formatter->asDate($excelrow['Date of Joining'], "yyyy-MM-dd");
				   $regex = '/^(^[1-9][0-9-]*)$/';
				   if(!preg_match( $regex, $doj ) ) {											 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoJ Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {					 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Date of Joining');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					
                 
                  $posting = strtolower(str_replace(' ', '', $excelrow['Designation']));
                  $design = Yii::$app->db->createCommand("SELECT id FROM designation WHERE LOWER(replace(designation ,' ',''))='" . $posting . "'")->queryOne();
                  if ($design)
                     $designation = $design['id'];
                  else
                     $designation = NULL;

                  $dept = strtolower(str_replace(' ', '', $excelrow['Department']));
                  $dept1 = Yii::$app->db->createCommand("SELECT id FROM department WHERE LOWER(replace(name ,' ',''))='" . $dept . "'")->queryOne();
                  if ($dept1)
                     $department = $dept1['id'];
                  else
                     $department = NULL;
				 
                  $unit = strtolower(str_replace(' ', '', $excelrow['Unit']));
                  $unit1 = Yii::$app->db->createCommand("SELECT id FROM unit WHERE LOWER(replace(name ,' ',''))='" . $unit . "'")->queryOne();
                  $unit_id = $unit1['id'];

                  if ($unit1)
                     $unit_id = $unit1['id'];
                  else
                     $unit_id = NULL;


                  $div = strtolower(str_replace(' ', '', $excelrow['Division']));
                  $division = Yii::$app->db->createCommand("SELECT id FROM division WHERE LOWER(replace(division_name ,' ',''))='" . $div . "'")->queryOne();
                  $division_id = $division['id'];

                  if ($unit1)
                     $division_id = $division['id'];
                  else
                     $division_id = NULL;
				 
				  $modelemployee = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                  if ($modelemployee) {
                 $modelEmp = EmpDetails::findOne($modelemployee->id);                
                  $modelEmp->empcode = $excelrow['Emp. Code'];
                  $modelEmp->empname = $excelrow['Emp. Name'];
				  $modelEmp->doj = $doj;
				
					  
				if(!empty($excelrow['Confirmation Date']) && $excelrow['Confirmation Date'] !='01-01-1970' && $excelrow['Confirmation Date'] !='1970-01-01'){
				$modelEmp->confirmation_date = Yii::$app->formatter->asDate($excelrow['Confirmation Date'], "yyyy-MM-dd");
				  $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelEmp->confirmation_date ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Confirmation Date Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {
				$modelEmp->confirmation_date =NULL; 
				}   
					  
					  
                  $modelEmp->designation_id = $designation;
                  $modelEmp->division_id = $division_id;
                  $modelEmp->unit_id = $unit_id;
                  $modelEmp->department_id = $department;
				  $modelEmp->category = $excelrow['Category'];
                  $modelEmp->email = $excelrow['Email(Official)'];
                  $modelEmp->mobileno = $excelrow['Mobile No(CUG)'];
                  $modelEmp->referedby = $excelrow['Referred By'];
                  $modelEmp->probation = $excelrow['Probation'];
                  $modelEmp->appraisalmonth = $excelrow['Appraisal Month'];
				  if(!empty($excelrow['Latest Promotion Date']) && $excelrow['Latest Promotion Date'] !='01-01-1970' && $excelrow['Latest Promotion Date'] !='1970-01-01'){
					 $modelEmp->recentdop = Yii::$app->formatter->asDate($excelrow['Latest Promotion Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->recentdop =NULL; 
				  }   
				   if(!empty($excelrow['Last Working Date']) && $excelrow['Last Working Date'] !='01-01-1970' && $excelrow['Last Working Date'] !='1970-01-01'){
					 $modelEmp->last_working_date = Yii::$app->formatter->asDate($excelrow['Last Working Date'], "yyyy-MM-dd");
					 $no_of_year = date_diff(date_create($doj), date_create($modelEmp->last_working_date));
						 if($no_of_year->format('%m') >=6 )
						  $modelEmp->service = $no_of_year->format('%y') + 1;
						else 
						  $modelEmp->service = $no_of_year->format('%y');
					 } else {
					 $modelEmp->last_working_date =NULL;
					 $modelEmp->service = NULL;
					 } 
					 
					   if(!empty($excelrow['Resignation Date']) && $excelrow['Resignation Date'] !='01-01-1970' && $excelrow['Resignation Date'] !='1970-01-01'){
					 $modelEmp->resignation_date = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->resignation_date =NULL; 
				  } 
				  
				    if(!empty($excelrow['Date of Leaving']) && $excelrow['Date of Leaving'] !='01-01-1970' && $excelrow['Date of Leaving'] !='1970-01-01'){
					 $modelEmp->dateofleaving = Yii::$app->formatter->asDate($excelrow['Resignation Date'], "yyyy-MM-dd");
				  } else {
					 $modelEmp->dateofleaving =NULL; 
				  } 		
				  
				 $modelEmp->reasonforleaving = $excelrow['Reason for Leaving'];
                 $modelEmp->joining_status = $excelrow['Joining Status'];
                  $modelEmp->experience = $excelrow['Previous Experience'];
				  if($excelrow['Status'] == ''){
					  $modelEmp->status = 'Active';
					  } else {
					   $modelEmp->status = $excelrow['Status'];
					  }
                  $modelEmp->save(false);
                 

                 $modelPer = EmpPersonaldetails::find()->where(['empid' => $modelemployee->id])->one();
                  $modelPer->empid = $modelemployee->id;
				  if(!empty($excelrow['DoB(Record)']) && $excelrow['DoB(Record)'] !='01-01-1970' && $excelrow['DoB(Record)'] !='1970-01-01'){
				     $modelPer->dob = Yii::$app->formatter->asDate($excelrow['DoB(Record)'], "yyyy-MM-dd");
					   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex,  $modelPer->dob ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change DoB Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->dob =NULL; 
					} 
					
					if(!empty($excelrow['Birthday']) && $excelrow['Birthday'] !='01-01-1970' && $excelrow['Birthday'] !='1970-01-01'){
				     $modelPer->birthday = Yii::$app->formatter->asDate($excelrow['Birthday'], "yyyy-MM-dd");
					   $regex = '/^(^[1-9][0-9-]*)$/';
				 if(!preg_match( $regex, $modelPer->birthday ) ) {										 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change birthday Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
					} else {
					 $modelPer->birthday =NULL; 
					} 
                 
                  $modelPer->gender = $excelrow['Gender'];
                  $modelPer->mobile_no = $excelrow['Mobile No'];
                  $modelPer->email = $excelrow['Email(Personal)'];
                  $modelPer->blood_group = $excelrow['Blood Group'];
                  $modelPer->caste = $excelrow['Caste'];
                  $modelPer->community = $excelrow['Community'];
                  $modelPer->martialstatus = $excelrow['Marital Status'];
                  $modelPer->panno = $excelrow['PAN No'];
                  $modelPer->aadhaarno = $excelrow['Aadhaar No'];
                  $modelPer->passportno = $excelrow['Passport No'];
				  
				  if(!empty($excelrow['Passport Valid']) && $excelrow['Passport Valid'] !='01-01-1970' && $excelrow['Passport Valid'] !='1970-01-01') {
				     $modelPer->passportvalid = Yii::$app->formatter->asDate($excelrow['Passport Valid'], "yyyy-MM-dd");
					    $regex = '/^(^[1-9][0-9-]*)$/';
						 if(!preg_match( $regex, $modelPer->passportvalid ) ) {										 
						 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Passport valid Date Format ');
						 $startrow++;
						 $countrow +=1;
						 continue;
						 }
					} else {
					 $modelPer->passportvalid =NULL; 
					} 
					
                  $modelPer->passport_remark = $excelrow['Passport Remarks'];
                  $modelPer->voteridno = $excelrow['Voter ID'];
                  $modelPer->drivinglicenceno = $excelrow['Driving Licence No'];
                  $modelPer->licence_categories = $excelrow['Licence Categories'];
                  $modelPer->licence_remark = $excelrow['Licence Remarks'];
                  $modelPer->save(false);

                  $modelAdd = EmpAddress::find()->where(['empid' => $modelemployee->id])->one();
                  $modelAdd->empid = $modelemployee->id;
                  $modelAdd->addfield1 = $excelrow['Res. No'];
                  $modelAdd->addfield2 = $excelrow['Res. Name'];
                  $modelAdd->addfield3 = $excelrow['Road/Street'];
                  $modelAdd->addfield4 = $excelrow['Locality/Area'];
                  $modelAdd->addfield5 = $excelrow['City'];
                  $modelAdd->district = $excelrow['District'];
                  $modelAdd->state = $excelrow['State'];
                  $modelAdd->pincode = $excelrow['Pincode'];
                  $modelAdd->save(false);
				  

				  $modelStatu = EmpStatutorydetails::find()->where(['empid' => $modelemployee->id])->one();
                  $modelStatu->empid = $modelemployee->id;
                  $modelStatu->esino = $excelrow['ESI No'];
                  $modelStatu->epfno = $excelrow['EPF No'];
                  $modelStatu->epfuanno = $excelrow['EPF UAN No'];
                  $modelStatu->zeropension = $excelrow['Zero Pension'];
                  $modelStatu->professionaltax = $excelrow['PT'];
				  $modelStatu->gpa_applicability = $excelrow['GPA Applicability'];
				  $modelStatu->gpa_no = $excelrow['GPA No'];
				  $modelStatu->gpa_sum_insured = $excelrow['GPA SUM Insured'];
				  $modelStatu->gpa_premium = $excelrow['GPA Premium'];
				  $modelStatu->gmc_applicability = $excelrow['GMC Applicability'];
				  $modelStatu->gmc_no = $excelrow['GMC No'];
				  $modelStatu->gmc_sum_insured = $excelrow['GMC SUM Insured'];
				  $modelStatu->gmc_premium = $excelrow['GMC Premium'];
				  $modelStatu->age_group = $excelrow['Age Group'];
				  $modelStatu->wc_applicability = $excelrow['WC Applicability'];
                  $modelStatu->wc_no = $excelrow['WC No'];
				   /*if (!empty($excelrow['GPA Premium']) || $excelrow['GPA Applicability'] == 'Yes') {
					   $gpa = $excelrow['GPA Premium']/12;
				  } else {
					   $gpa = NULL;			
				  }
				  $modelStatu->gmc_premium = $excelrow['GMC Premium'];			  
				  if (!empty($excelrow['GMC Premium']) || $excelrow['GMC Applicability'] == 'Yes') {
					   $gmc = $excelrow['GMC Premium']/24;
				  } else {
					   $gmc = NULL;			
				  }*/
                  $modelStatu->save(false);
				  
                  $modelRemu = EmpRemunerationDetails::find()->where(['empid' => $modelemployee->id])->one();
                  $modelRemu->empid = $modelemployee->id;
                  $modelRemu->salary_structure = $excelrow['Salary Structure'];
                  $modelRemu->work_level = $excelrow['Work Level'];
                  $modelRemu->grade = $excelrow['Grade'];
                  $modelRemu->attendance_type = $excelrow['Attendance Type'];
                  $modelRemu->esi_applicability = $excelrow['ESI Applicability'];
                  $modelRemu->pf_applicablity = $excelrow['EPF Applicability'];
                  $modelRemu->restrict_pf = $excelrow['Restrict EPF'];
				  
				  $modelRemu->basic = $excelrow['Basic'];
				  $modelRemu->hra = $excelrow['HRA'];
				  $modelRemu->dearness_allowance = $excelrow['DA'];
				  $modelRemu->personpay = $excelrow['Personpay'];
				  $modelRemu->dust_allowance = $excelrow['Dust Allowance'];
				  $modelRemu->washing_allowance = $excelrow['Washing Allowance'];				  
				  $modelRemu->guaranteed_benefit = $excelrow['Guaranteed Benefit'];
				  $modelRemu->other_allowance = $excelrow['Other Allowance'];
				  $modelRemu->misc = $excelrow['Miscellaneous'];
				  $modelRemu->gross_salary = $modelRemu->basic + $modelRemu->hra + $modelRemu->dearness_allowance + $modelRemu->washing_allowance + $modelRemu->personpay + $modelRemu->dust_allowance + $modelRemu->guaranteed_benefit + $modelRemu->other_allowance + $modelRemu->misc;
				  $grossamount = $modelRemu->gross_salary;
				 
				   if (empty($excelrow['Food Allowance']) || $excelrow['Food Allowance'] == 'N/A') {
                     $modelRemu->food_allowance = NULL;
					 } else {
                     $modelRemu->food_allowance = $excelrow['Food Allowance'];
                   }
				   
				   if (!empty($excelrow['PLI']) && $excelrow['PLI'] != 'N/A') {
					   $employer_pli = round($modelRemu->basic * ($excelrow['PLI']/100));
                  } else {
					   $employer_pli = 0;
                  }

                  
                  if ($excelrow['ESI Applicability'] == 'Yes' && $grossamount < 21000) {
                     $employer_esi = ceil(($grossamount - $modelRemu->misc)  * ($pf_esi_rates->esi_er / 100));
                  } else {
                     $employer_esi = 0;
                  }
				  
                 if ($excelrow['EPF Applicability'] == 'Yes') {				
						if ($excelrow['Restrict EPF'] == 'Yes') {
							if($grossamount <= 15000){
								$statutory_rate_pf = $grossamount - ($modelRemu->hra  + $modelRemu->misc);
								$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));						
							} else {
								 $statutory_rate_pf = 15000;
								 $employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));					
							}
					    } else {
							$statutory_rate_pf = $grossamount - $modelRemu->hra;
							$employer_pf = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));						 
						}
                  } else {
						$employer_pf = 0;
                  }
				  
                  if (empty($excelrow['PLI']) || $excelrow['PLI'] == 'N/A') {
                     $modelRemu->pli = NULL;
                  } else {
                     $modelRemu->pli = $excelrow['PLI'];
                  }
                  
                  $modelRemu->employer_pf_contribution = $employer_pf;
                  $modelRemu->employer_esi_contribution = $employer_esi;
                  $modelRemu->employer_pli_contribution = $employer_pli;
                  $modelRemu->employer_lta_contribution = $employer_lta;
                  $modelRemu->employer_medical_contribution = $employer_medical;
                  $modelRemu->ctc = ($grossamount + $employer_pf + $employer_esi + $employer_pli + $employer_lta + $employer_medical);
                  $modelRemu->save(false); 
				  } else {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: This Not Updated Record');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  $startrow++;
               }
			}
               if ($countrow == 0) {
                  $transaction->commit();
                  $insertrows = $startrow - 1;
                  Yii::$app->session->setFlash("success", $insertrows . ' rows had been imported');
               }
            } catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
         }
		 
		 /*else if ($model->uploadtype == 3) {
            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
                  $model = new EmpPromotion();
                  if (!empty($excelrow['Effective Date'])) {
                     $effectdate = $excelrow['Effective Date'];
                     $created_at = date('Y-m-d H:i:s');
                     $model->user = Yii::$app->user->id;
                     $model->createdate = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
                     $model->effectdate = Yii::$app->formatter->asDate($effectdate, "yyyy-MM-dd");
                     $empmodel = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                     $model->ss_from = $empmodel->remuneration->salary_structure;
                     $model->wl_from = $empmodel->remuneration->work_level;
                     $model->grade_from = $empmodel->remuneration->grade;
                     $model->gross_from = $empmodel->remuneration->gross_salary;
                     $model->designation_from = $empmodel->designation_id;
                     /// code for import promotion
                  }
               }
            } catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
         } */
         unlink($fileName);
      }

      return $this->render('import-employee', [
                  'model' => $model,
      ]);
   }

   public function actionCreate() {
      $model = new EmpDetails();

      $modelremuneration = new EmpRemunerationDetails();
      $personalmodel = new EmpPersonaldetails();
      $modeladd = new EmpAddress();
      $modelfamily = new EmpFamilydetails();
      $modeleducation = new EmpEducationdetails();
      $modelcer = new EmpCertificates();
      $modelbank = new EmpBankdetails();
      $modelstatutory = new EmpStatutorydetails();
      $modelemployment = new PreviousEmployment();

      if ($model->load(Yii::$app->request->post())) {
          
          $model->emp_password	=	$this->random_strings(6); 

         $model->doj = Yii::$app->formatter->asDate($model->doj, "yyyy-MM-dd");
				  
		  if($model->recentdop && $model->recentdop != '0000-00-00' && $model->recentdop != '1970-01-01'){
			$model->recentdop = Yii::$app->formatter->asDate($model->recentdop, "yyyy-MM-dd");
			} else {
			 $model->recentdop = NULL; 
			}
			
		 if($model->dateofleaving && $model->dateofleaving != '0000-00-00' && $model->dateofleaving != '1970-01-01'){
          $model->dateofleaving = Yii::$app->formatter->asDate($model->dateofleaving, "yyyy-MM-dd");
		 /* $salmonth = SalaryMonth::find()->orderBy(['month' => SORT_DESC])->one();
		  $month1 = Yii::$app->formatter->asDate($model->dateofleaving, "yyyy-MM-dd");
		  $month2 = Yii::$app->formatter->asDate($salmonth->month, "yyyy-MM-dd");
		   if($month2 <= $month1){
			   $model->status = 'Paid and Relieved';
			}else {
			$model->status = 'Relieved';
			}	*/		   
		  } else {
		  $model->dateofleaving =NULL;
		//  $model->status = 'Active';
		  }
		  
		  
		   if($model->last_working_date && $model->last_working_date != '0000-00-00' && $model->last_working_date != '1970-01-01'){
          $model->last_working_date = Yii::$app->formatter->asDate($model->last_working_date, "yyyy-MM-dd");
		   $no_of_year = date_diff(date_create( $model->doj), date_create($model->last_working_date));
						 if($no_of_year->format('%m') >=6 )
						  $model->service = $no_of_year->format('%y') + 1;
						else 
						  $model->service = $no_of_year->format('%y');
		  } else {
		  $model->last_working_date =NULL;
		  $model->service  = NULL;
		  }
		  
		   if($model->resignation_date && $model->resignation_date != '0000-00-00' && $model->resignation_date != '1970-01-01'){
          $model->resignation_date = Yii::$app->formatter->asDate($model->resignation_date, "yyyy-MM-dd");
		  } else {
		  $model->resignation_date =NULL;
		  }
		  
		  
		  if($model->confirmation_date && $model->confirmation_date != '0000-00-00' && $model->confirmation_date != '1970-01-01'){
          $model->confirmation_date = Yii::$app->formatter->asDate($model->confirmation_date, "yyyy-MM-dd");
		  } else {
		  $model->confirmation_date =NULL;
		  }
		  
       
         $model->photo = UploadedFile::getInstance($model, 'photo');
		  $fileName = 'emp_photo/' . $model->empcode . '.' . $model->photo->extension;
         if ($model->photo != '') {
			 if($fileName){
			
		unlink($fileName);
		}
            if ($model->upload($model->empcode)) {
               $model->photo = $model->empcode . '.' . $model->photo->extension;
               $model->save();
            }
         } else {
            $model->save();
         }
         $empid = Yii::$app->db->getLastInsertID();

         $modeleducation->empid = $empid;
         $modeleducation->save();

         $modelremuneration->empid = $empid;
         $modelremuneration->save();

         $modelcer->empid = $empid;
         $modelcer->save();

         $modelbank->empid = $empid;
         $modelbank->save();

         $modelstatutory->empid = $empid;
         $modelstatutory->save();

         $modeladd->empid = $empid;
         $modeladd->save();

         $personalmodel->empid = $empid;
         $personalmodel->save();

         $modelfamily->empid = $empid;
         $modelfamily->save();

         $modelemployment->empid = $empid;
         $modelemployment->save();

         return $this->redirect(['remuneration', 'id' => $model->id]);
      }
      return $this->render('employee_form', [
                  'model' => $model,
      ]);
   }
   
   public function actionUpdate($id) {
	  
      $model = EmpDetails::findOne($id);
	  $modelBefore = EmpDetails::findOne($id);
      $photoname = $model->photo;
      $post = Yii::$app->request->post();
      if ($model->load($post)) {
         $model->doj = Yii::$app->formatter->asDate($model->doj, "yyyy-MM-dd");	 
		 
		  if($model->recentdop && $model->recentdop != '0000-00-00' && $model->recentdop != '1970-01-01'){
			$model->recentdop = Yii::$app->formatter->asDate($model->recentdop, "yyyy-MM-dd");
			} else {
			 $model->recentdop = NULL; 
			}
			
		 if($model->dateofleaving && $model->dateofleaving != '0000-00-00' && $model->dateofleaving != '1970-01-01'){
          $model->dateofleaving = Yii::$app->formatter->asDate($model->dateofleaving, "yyyy-MM-dd");
		 /* $salmonth = SalaryMonth::find()->orderBy(['month' => SORT_DESC])->one();
		  $month1 = Yii::$app->formatter->asDate($model->dateofleaving, "yyyy-MM-dd");
		  $month2 = Yii::$app->formatter->asDate($salmonth->month, "yyyy-MM-dd");
		   if($month2 <= $month1){
			   $model->status = 'Paid and Relieved';
			}else {
			$model->status = 'Relieved';
			}	*/		   
		  } else {
		  $model->dateofleaving =NULL;
		 // $model->status = 'Active';
		  } 
		  
		  if($model->confirmation_date && $model->confirmation_date != '0000-00-00' && $model->confirmation_date != '1970-01-01'){
          $model->confirmation_date = Yii::$app->formatter->asDate($model->confirmation_date, "yyyy-MM-dd");
		  } else {
		  $model->confirmation_date =NULL;
		  }
		  
		  if($model->last_working_date && $model->last_working_date != '0000-00-00' && $model->last_working_date != '1970-01-01'){
          $model->last_working_date = Yii::$app->formatter->asDate($model->last_working_date, "yyyy-MM-dd");
		  $no_of_year = date_diff(date_create( $model->doj), date_create($model->last_working_date));
						 if($no_of_year->format('%m') >=6 )
						  $model->service = $no_of_year->format('%y') + 1;
						else 
						  $model->service = $no_of_year->format('%y');
		  } else {
		  $model->last_working_date =NULL;
		   $model->service = NULL;
		  }
		  
		   if($model->resignation_date && $model->resignation_date != '0000-00-00' && $model->resignation_date != '1970-01-01'){
          $model->resignation_date = Yii::$app->formatter->asDate($model->resignation_date, "yyyy-MM-dd");
		  } else {
		  $model->resignation_date =NULL;
		  }
       
		 
		 if($modelBefore->doj != $model->doj){
				     error_log(date("d-m-Y g:i:s a ") . $model->empcode." DOJ Changed to ".$model->doj." from ".$modelBefore->doj." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }
		 if($modelBefore->last_working_date != $model->last_working_date){
				     error_log(date("d-m-Y g:i:s a ") . $model->empcode." Last Working Date Changed to ".$model->last_working_date." from ".$modelBefore->last_working_date." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }
		 if($modelBefore->confirmation_date != $model->confirmation_date){
				     error_log(date("d-m-Y g:i:s a ") . $model->empcode." Conformation Changed to ".$model->confirmation_date." from ".$modelBefore->confirmation_date." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }
		 if($modelBefore->designation_id != $model->designation_id){
				     error_log(date("d-m-Y g:i:s a ") . $model->empcode." Designation Changed to ".$model->doj." from ".$modelBefore->doj." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }
		 if($modelBefore->division_id != $model->division_id){
				     error_log(date("d-m-Y g:i:s a ") . $model->empcode." Division Changed to ".$model->division->division_name." from ".$modelBefore->division->division_name." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }
		 if($modelBefore->unit_id != $model->unit_id){
				     error_log(date("d-m-Y g:i:s a ") . $model->empcode." Unit Changed to ".$model->units->name." from ".$modelBefore->units->name." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }
		 if($modelBefore->department_id != $model->department_id){
				     error_log(date("d-m-Y g:i:s a ") . $model->empcode." Department Changed to ".$model->department->name." from ".$modelBefore->department->name." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }	
		 
		
			//if($fileName){
			//unlink($fileName);
		 
         $model->photo = UploadedFile::getInstance($model, 'photo');
		  $fileName = 'emp_photo/' . $model->empcode . '.' . $model->photo->extension;
		 //echo $fileName;
		// exit;
		
         if ($model->photo != '') {
			 if($fileName){
			
		unlink($fileName);
		}
			
            if ($model->upload($model->empcode)) {
			
               $model->photo = $model->empcode . '.' . $model->photo->extension;
               $model->save();			   
			   
			    /*$modelfront						=	EmpDetailsFront::find()->where(['empcode' => $model->empcode])->one();
				$modelfrontemp					=	EmpDetailsFront::findOne($modelfront->id);
				$modelfrontemp->attributes		=	$model->attributes;
				$modelfrontemp->id 				=	$modelfront->id;
				$modelfrontemp->save();*/
            }
         } else {
           // $model->photo = UploadedFile::getInstance($model, 'photo');;
            $model->save();
			
			/*$modelfront						=	EmpDetailsFront::find()->where(['empcode' => $model->empcode])->one();
			$modelfrontemp						=	EmpDetailsFront::findOne($modelfront->id);
			$modelfrontemp->attributes			=	$model->attributes;
			$modelfrontemp->id 					=	$modelfront->id;
			$modelfrontemp->save();*/
         }
         return $this->redirect(['remuneration', 'id' => $model->id]);
      } else {
         return $this->render('employee_form', [
                     'model' => $model,
         ]);
      }
   }

   public function actionRemuneration($id) {
      $model = EmpRemunerationDetails::find()->where(['empid' => $id])->one();
	  $BeforeUpadte = EmpRemunerationDetails::find()->where(['empid' => $id])->one();
      $Emp = EmpDetails::findOne($id);
	  $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
	  $statutory = EmpStatutorydetails::find()->where(['empid' => $id])->one();
      if ($model->load(Yii::$app->request->post())) {
				$model->empid = $id;
				// Stores Logs to user_update log file
			
			    if($BeforeUpadte->salary_structure != $model->salary_structure){
				  error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." Salary Structure Changed to ".$model->salary_structure." from ".$BeforeUpadte->salary_structure." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 
				}
				if($BeforeUpadte->work_level != $model->work_level || $BeforeUpadte->grade != $model->grade){ 
				    error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." Work Level Changed to ".$model->work_level."/".$model->grade." from ".$BeforeUpadte->work_level."/".$BeforeUpadte->grade." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			 
				}
				if($BeforeUpadte->gross_salary != $model->gross_salary){
				    error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." Gross Salary Changed to ".$model->gross_salary." from ".$BeforeUpadte->gross_salary." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			 
				}
				if($BeforeUpadte->basic != $model->basic){
				     error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." Basic Salary Changed to ".$model->basic." from ".$BeforeUpadte->basic." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
				}
		
				 if (!empty($model->pli) && $model->pli != 'NA') {
					 $model->employer_pli_contribution = round($model->basic * ($model->pli/100));
                  } else {
                     $model->employer_pli_contribution = 0;
                  }
	
                  if (!empty($model->salary_structure) && $model->salary_structure != 'Engineer' && $model->salary_structure != 'Trainee' && $model->salary_structure != 'Consolidated pay' && $model->salary_structure != 'Contract' && $model->salary_structure != 'Conventional' && $model->salary_structure != 'Modern') {
                     $model->employer_medical_contribution = round($model->basic * (8.33/100));
                     $model->employer_lta_contribution = round($model->basic * (8.33/100));
                  } else {
                     $model->employer_medical_contribution = 0;
                     $model->employer_lta_contribution = 0;
                  }
					
                  if ($model->esi_applicability == 'Yes' && $model->gross_salary < 21000) {
                     $model->employer_esi_contribution = ceil($model->gross_salary * ($pf_esi_rates->esi_er / 100));
                  } else {
                     $model->employer_esi_contribution = 0;
                  }
				  $statutory_rate_pf = $model->gross_salary - $model->hra;
                  if ( $model->pf_applicablity == 'Yes') {
				  if ($model->restrict_pf == 'Yes') {
					if($statutory_rate_pf <= 15000){
						//$statutory_rate_pf = $model->gross_salary - ($model->hra + $model->misc);
						 if ($statutory->pmrpybeneficiary == 'Yes') {
						 $model->employer_pf_contribution =0;
						 } else {
						 $model->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));											
						 }
                        } else {
						 $statutory_rate_pf = 15000;						
                         $model->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));		
                        }						
				   } else {
				    $statutory_rate_pf = $model->gross_salary - $model->hra;
                     $model->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));				 
				  }
                  } else {
                     $model->employer_pf_contribution = 0;
                  }
		 
		 
	    if ($model->pli == 'NA' || empty($model->pli)) {
            $model->pli = NULL;
         }
		 
         $model->ctc = $model->gross_salary + $model->employer_pli_contribution + $model->employer_medical_contribution + $model->employer_lta_contribution + $model->employer_esi_contribution + $model->employer_pf_contribution;
         $model->save();		
         return $this->redirect(['statutory-details', 'id' => $id]);
      }

      return $this->render('remuneration_form', [
                  'model' => $model,
      ]);
   }

   public function actionWorklevel($id) {
      if ($id == 'Manager') {

         echo "<option value='WL3A'>WL3A</option>";
      } else if ($id == 'Assistant Manager') {
         echo "<option value='WL3B'>WL3B</option>";
      } else if ($id == 'Sr. Engineer - I') {
         echo "<option value='WL4A'>WL4A</option>";
      } else if ($id == 'Sr. Engineer - II') {
         echo "<option value='WL4B'>WL4B</option>";
      } else if ($id == 'Engineer') {
         echo "<option value='WL4C'>WL4C</option>";
      } else if ($id == 'Trainee') {
         echo "<option value='WL5'>WL5</option>";
      } else {
	     echo "<option > </option>";
         echo "<option value='WL3A'>WL3A</option>";
         echo "<option value='WL3B'>WL3B</option>";
         echo "<option value='WL4A'>WL4A</option>";
         echo "<option value='WL4B'>WL4B</option>";
         echo "<option value='WL4C'>WL4C</option>";
         echo "<option value='WL5'>WL5</option>";
		 echo "<option value='WL4'>WL4</option>";
		 echo "<option value='WL3'>WL3</option>";
		 echo "<option value='WL2'>WL2</option>";
		 echo "<option value='WL1'>WL1</option>";
      }
   }

   public function actionSalarystructure() {
      $post = Yii::$app->request->post();
      if ($post['empmtype'] == 'Staff') {
         $PayScale = EmpStaffPayScale::find()
                 ->where(['salarystructure' => $post['sla_structure']])
                 ->one();

         $grossamount = $post['amount'];
         $basic = round($grossamount * $PayScale->basic);
         $hra = round($grossamount * $PayScale->hra);
         $dearness_allowance = round($grossamount * $PayScale->dearness_allowance);
        // $spl_allowance = round($grossamount * $PayScale->spl_allowance);
         $conveyance_allowance = round($PayScale->conveyance_allowance);
         // $pli_earning = round($basic * $PayScale->pli);
         $lta_earning = round($basic * $PayScale->lta);
         $medical_earning = round($basic * $PayScale->medical);
		 $other_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
        
        /* if ($PayScale->salarystructure == 'Modern') {
            $spl_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
            $other_allowance = 0;
         } else {
            $spl_allowance = round($grossamount * $PayScale->spl_allowance);
            $other_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
         } */

         if ($other_allowance > 0) {
            $other_allowance = $other_allowance;
         } else {
            $other_allowance = 0;
         }
         echo Json::encode(['basic' => $basic, 'hra' => $hra, 'da' => $dearness_allowance, 'ca' => $conveyance_allowance, 'lta' => $lta_earning, 'medical' => $medical_earning, 'other' => $other_allowance]);
      } else if ($post['empmtype'] == 'Engineer') {
         $Salstructure = EmpSalarystructure::find()
                 ->where(['salarystructure' => $post['sla_structure'], 'worklevel' => $post['worklevel'], 'grade' => $post['grade']])
                 ->one();
         echo Json::encode(['basic' => $Salstructure->basic, 'hra' => $Salstructure->hra, 'other_allowance' => $Salstructure->other_allowance, 'dapermonth' => $Salstructure->dapermonth, 'gross' => $Salstructure->netsalary]);
      }
   }

   public function actionPersonalDetails($id) {
      $model = EmpPersonaldetails::find()->where(['empid' => $id])->one();
      $addressModel = EmpAddress::find()->where(['empid' => $id])->one();
      $oldsiblingIds = EmpFamilydetails::find()->select('id')->where(['empid' => $id])->asArray()->all();
      $oldsiblingIds = ArrayHelper::getColumn($oldsiblingIds, 'id');

      $modelSiblings = EmpFamilydetails::findAll(['id' => $oldsiblingIds]);
      $modelSiblings = (empty($modelSiblings)) ? [new EmpFamilydetails] : $modelSiblings;

      $post = Yii::$app->request->post();
      if ($model->load($post) && $addressModel->load($post)) {
         
		 
		 if(!empty($model->dob) && $model->dob !='01-01-1970' && $model->dob !='1970-01-01'){
				     $model->dob = Yii::$app->formatter->asDate($model->dob, "yyyy-MM-dd");
					 } else {
					 $model->dob =NULL; 
					} 
					
				if(!empty($model->birthday) && $model->birthday !='01-01-1970' && $model->birthday !='1970-01-01'){
				     $model->birthday = Yii::$app->formatter->asDate($model->birthday, "yyyy-MM-dd");
					 } else {
					 $model->birthday =NULL; 
					} 
					
					if(!empty($model->passportvalid) && $model->passportvalid !='01-01-1970' && $model->passportvalid !='1970-01-01'){
				     $model->passportvalid = Yii::$app->formatter->asDate($model->passportvalid, "yyyy-MM-dd");
					 } else {
					 $model->passportvalid =NULL; 
					} 

					if(!empty($model->year_of_marriage) && $model->year_of_marriage !='01-01-1970' && $model->year_of_marriage !='1970-01-01'){
				     $model->year_of_marriage = Yii::$app->formatter->asDate($model->year_of_marriage, "yyyy-MM-dd");
					 } else {
					 $model->year_of_marriage =NULL; 
					} 	
         $modelSiblings = Model::createMultiple(EmpFamilydetails::classname(), $modelSiblings);
         Model::loadMultiple($modelSiblings, Yii::$app->request->post());
         $newsiblingIds = ArrayHelper::getColumn($modelSiblings, 'id');

         $delsiblingIds = array_diff($oldsiblingIds, $newsiblingIds);
         if (!empty($delsiblingIds))
            EmpFamilydetails::deleteAll(['id' => $delsiblingIds]);

         $valid = $model->validate();
       //  $valid = Model::validateMultiple($modelSiblings) && $valid;

         if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {

               $model->empid = $id;
               if ($flag = $model->save()) {
                  $addressModel->empid = $id;
                  $addressModel->save(false);

                  foreach ($modelSiblings as $modelSibl) { /* save Siblings */
                     $modelSibl->birthdate = Yii::$app->formatter->asDate($modelSibl->birthdate, "yyyy-MM-dd");
                     $modelSibl->empid = $id;
                     if (!($flag = $modelSibl->save(false))) {
                        $transaction->rollBack();
                        break;
                     }
                  }
               }

               if ($flag) {
                  $transaction->commit();
                  return $this->redirect(['education-details', 'id' => $id]);
               }
            } catch (Exception $e) {
               $transaction->rollBack();
            }
         }
      } else {
         return $this->render('personaldetails_form', [
                     'model' => $model,
                     'addressModel' => $addressModel,
                     'modelSibling' => (empty($modelSiblings)) ? [new EmpFamilydetails] : $modelSiblings,
         ]);
      }
   }

   public function actionEducationDetails($id) {
      $modelEduRef = new EmpEducationdetails();
      $oldEduIds = EmpEducationdetails::find()->select('id')->where(['empid' => $id])->asArray()->all();
      $oldEduIds = ArrayHelper::getColumn($oldEduIds, 'id');

      $model = EmpEducationdetails::findAll(['id' => $oldEduIds]);
      $model = (empty($model)) ? [new EmpEducationdetails] : $model;

      $modelEducation = Model::createMultiple(EmpEducationdetails::classname(), $model);
      if (Model::loadMultiple($modelEducation, Yii::$app->request->post())) {

         $newEduIds = ArrayHelper::getColumn($modelEducation, 'id');

         $delEduIds = array_diff($oldEduIds, $newEduIds);
         if (!empty($delEduIds))
            EmpEducationdetails::deleteAll(['id' => $delEduIds]);

         $transaction = \Yii::$app->db->beginTransaction();
         try {
            foreach ($modelEducation as $modelEdu) { /* save Education */
               $modelEdu->empid = $id;	
               if (!($flag = $modelEdu->save(false))) {
                  $transaction->rollBack();
                  break;
               }
            }
            if ($flag) {
               $transaction->commit();
               return $this->redirect(['certificates-details', 'id' => $id]);
            }
         } catch (Exception $e) {
            $transaction->rollBack();
         }
      } else {
         return $this->render('education_form', [
                     'model' => $modelEduRef,
                     'modelEducation' => (empty($model)) ? [new EmpEducationdetails] : $model,
         ]);
      }
   }
   

   public function actionCertificatesDetails($id) {
      $modelCerRef = new EmpCertificates();
      $oldCerIds = EmpCertificates::find()->select('id')->where(['empid' => $id])->asArray()->all();
      $oldCerIds = ArrayHelper::getColumn($oldCerIds, 'id');

      $model = EmpCertificates::findAll(['id' => $oldCerIds]);
      $model = (empty($model)) ? [new EmpCertificates] : $model;

      $modelCertificates = Model::createMultiple(EmpCertificates::classname(), $model);
      if (Model::loadMultiple($modelCertificates, Yii::$app->request->post())) {
         $newCerIds = ArrayHelper::getColumn($modelCertificates, 'id');

         $delCerIds = array_diff($oldCerIds, $newCerIds);
         if (!empty($delCerIds))
            EmpCertificates::deleteAll(['id' => $delCerIds]);

         $transaction = \Yii::$app->db->beginTransaction();
         try {
            foreach ($modelCertificates as $modelCer) { /* save Certificate */
               $modelCer->empid = $id;
               if (!($flag = $modelCer->save())) {
                  $transaction->rollBack();
                  break;
               }
            }
            if ($flag) {
               $transaction->commit();
               return $this->redirect(['previous_employment', 'id' => $id]);
            }
         } catch (Exception $e) {
            $transaction->rollBack();
         }
      } else {
         return $this->render('certificate_form', [
                     'modelCertificate' => (empty($model)) ? [new EmpCertificates] : $model,
                     'model' => $modelCerRef,
         ]);
      }
   }
  
   public function actionBankDetails($id) {
      $modelBankRef = new EmpBankdetails();
	  $Emp = EmpDetails::findOne($id);
	   
      $oldBankIds = EmpBankdetails::find()->select('id')->where(['empid' => $id])->asArray()->all();
      $oldBankIds = ArrayHelper::getColumn($oldBankIds, 'id');

      $model = EmpBankdetails::findAll(['id' => $oldBankIds]);
      $model = (empty($model)) ? [new EmpBankdetails] : $model;

      $modelBank = Model::createMultiple(EmpBankdetails::classname(), $model);
      if (Model::loadMultiple($modelBank, Yii::$app->request->post())) {
         $newBankIds = ArrayHelper::getColumn($modelBank, 'id');

         $delBankIds = array_diff($oldBankIds, $newBankIds);
         if (!empty($delBankIds)) {
            EmpBankdetails::deleteAll(['id' => $delBankIds]);
			error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." Bank Details Deleted By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 			
		 }  

         $transaction = \Yii::$app->db->beginTransaction();
         try {
            foreach ($modelBank as $modelBnk) { /* save Certificate */
               $modelBnk->empid = $id;
               if (!($flag = $modelBnk->save())) {
                  $transaction->rollBack();
                  break;
               }
            }
            if ($flag) {
               $transaction->commit();
               return $this->redirect(['personal-details', 'id' => $id]);
            }
         } catch (Exception $e) {
            $transaction->rollBack();
         }
      } else {
         return $this->render('bank_form', [
                     'modelBank' => (empty($model)) ? [new EmpBankdetails] : $model,
                     'model' => $modelBankRef,
         ]);
      }
   }

   public function actionPrevious_employment($id) {
      $modelEmploymentRef = new PreviousEmployment();
      $oldemployementIds = PreviousEmployment::find()->select('id')->where(['empid' => $id])->asArray()->all();
      $oldemployementIds = ArrayHelper::getColumn($oldemployementIds, 'id');

      $model = PreviousEmployment::findAll(['id' => $oldemployementIds]);
      $model = (empty($model)) ? [new PreviousEmployment] : $model;

      $modelEmployment = Model::createMultiple(PreviousEmployment::classname(), $model);
      if (Model::loadMultiple($modelEmployment, Yii::$app->request->post())) {
         $newemployementIds = ArrayHelper::getColumn($modelEmployment, 'id');

         $delEmploymentIds = array_diff($oldemployementIds, $newemployementIds);
         if (!empty($delEmploymentIds))
            PreviousEmployment::deleteAll(['id' => $delEmploymentIds]);


         $transaction = \Yii::$app->db->beginTransaction();
         try {
            foreach ($modelEmployment as $Employment) { /* save Certificate */
               $Employment->empid = $id;
			   
			   if(!empty($Employment->work_from) && $Employment->work_from !='1970-01-01' && $Employment->work_from != '01-01-1970'){
				    $Employment->work_from = Yii::$app->formatter->asDate($Employment->work_from, "yyyy-MM-dd");
				   } else {
				    $Employment->work_from = NULL;
				   }
				   
              if(!empty($Employment->work_to) && $Employment->work_to !='1970-01-01' && $Employment->work_to != '01-01-1970'){
				  $Employment->work_to = Yii::$app->formatter->asDate($Employment->work_to, "yyyy-MM-dd");
				   } else {
				    $Employment->work_to = NULL;
				   }
			  if (!($flag = $Employment->save())) {
                  $transaction->rollBack();
                  break;
               }
            }
            if ($flag) {
               $transaction->commit();
               return $this->redirect(['index']);
            }
         } catch (Exception $e) {
            $transaction->rollBack();
         }
      } else {
         return $this->render('previous_employment', [
                     'modelEmployment' => (empty($model)) ? [new $modelEmployment] : $model,
                     'model' => $modelEmploymentRef,
         ]);
      }
   }
 
   public function actionStatutoryDetails($id) {
      $model = EmpStatutorydetails::find()->where(['empid' => $id])->one();
	  $olddata = EmpStatutorydetails::find()->where(['empid' => $id])->one();
	  $modelRemu = EmpRemunerationDetails::find()->where(['empid' => $id])->one();
	  $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one(); 
	  $Emp = EmpDetails::findOne($id);
      $post = Yii::$app->request->post();
      if ($model->load(Yii::$app->request->post())) {
	  
		if($olddata->epfno != $model->epfno)
				error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." EPFNO Changed to ".$model->epfno." from ".$olddata->epfno." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 					
	  	if($olddata->esino != $model->esino)
				error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." ESI Changed to ".$model->esino." from ".$olddata->esino." Changed By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log"); 		
		if($olddata->professionaltax != $model->professionaltax)
				error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." PT Changed to ".$model->professionaltax." from ".$olddata->professionaltax." Changed By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log");
		if($olddata->pmrpybeneficiary != $model->pmrpybeneficiary)
				error_log(date("d-m-Y g:i:s a ") . $Emp->empcode." PMRPY Changed to ".$model->pmrpybeneficiary." from ".$olddata->pmrpybeneficiary." Changed By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log");
		if ($olddata->gpa_applicability == 'Yes' && $olddata->gpa_no != $model->gpa_no)
                error_log(date("d-m-Y g:i:s A ") . "<span style='font-weight: 800;'>" . $Emp->empcode . '/' . $Emp->empname . "</span> GPA Policy No Changed From <b>" . $olddata->gpa_no . "</b> To <b>" . $model->gpa_no . "</b> Changed by User --->" . Yii::$app->user->identity->username . "\n", 3, "policy_update.log");
        if ($olddata->gpa_applicability == 'Yes' && $olddata->gpa_sum_insured != $model->gpa_sum_insured)
                error_log(date("d-m-Y g:i:s A ") . "<span style='font-weight: 800;'>" . $Emp->empcode . '/' . $Emp->empname . "</span> GPA Amount Changed From <b>" . $olddata->gpa_sum_insured . "</b> To <b>" . $model->gpa_sum_insured . "</b> Changed by User --->" . Yii::$app->user->identity->username . "\n", 3, "policy_update.log");
        if ($olddata->gmc_applicability == 'Yes' && $olddata->gmc_no != $model->gmc_no)
                error_log(date("d-m-Y g:i:s A ") . "<span style='font-weight: 800;'>" . $Emp->empcode . '/' . $Emp->empname . "</span> GMC Policy No Changed From <b>" . $olddata->gmc_no . "</b> To <b>" . $model->gmc_no . "</b> Changed by User --->" . Yii::$app->user->identity->username . "\n", 3, "policy_update.log");
        if ($olddata->gmc_applicability == 'Yes' && $olddata->gmc_sum_insured != $model->gmc_sum_insured)
                error_log(date("d-m-Y g:i:s A ") . "<span style='font-weight: 800;'>" . $Emp->empcode . '/' . $Emp->empname . "</span> GMC Amount Changed From <b>" . $olddata->gmc_sum_insured . "</b> To <b>" . $model->gmc_sum_insured . "</b> Changed by User --->" . Yii::$app->user->identity->username . "\n", 3, "policy_update.log");
        if ($olddata->gmc_applicability == 'Yes' && $olddata->age_group != $model->age_group)
                error_log(date("d-m-Y g:i:s A ") . "<span style='font-weight: 800;'>" . $Emp->empcode . '/' . $Emp->empname . "</span> GMC Age Group Changed From <span style='font-weight: 800;'>" . $olddata->age_group . "</span> To <span style='font-weight: 800;'>" . $model->age_group . "</span> Changed by User --->" . Yii::$app->user->identity->username . "\n", 3, "policy_update.log");
        if ($olddata->wc_applicability == 'Yes' && $olddata->wc_no != $model->wc_no)
                error_log(date("d-m-Y g:i:s A ") . "<span style='font-weight: 800;'>" . $Emp->empcode . '/' . $Emp->empname . "</span> WC No Changed From <span style='font-weight: 800;'>" . $olddata->wc_no . "</span> To <span style='font-weight: 800;'>" . $model->wc_no . "</span> Changed by User --->" . Yii::$app->user->identity->username . "\n", 3, "policy_update.log");
		
        $model->empid = $id;
        $ctc = $modelRemu->ctc - $modelRemu->employer_pf_contribution;
		 
		  if ($modelRemu->pf_applicablity == 'Yes') {
				  if ($modelRemu->restrict_pf == 'Yes') {
					if($modelRemu->gross_salary <= 15000){
						$statutory_rate_pf = $modelRemu->gross_salary - $modelRemu->hra;
						 if ($model->pmrpybeneficiary == 'Yes') {						 
						 $modelRemu->employer_pf_contribution =0;						  
						 } else {
						 $modelRemu->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));												
						 }
                        } else {
						$statutory_rate_pf = 15000;						
                         $modelRemu->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));		
                        }						
				   } else {
				    $statutory_rate_pf = $modelRemu->gross_salary - $modelRemu->hra;
                     $modelRemu->employer_pf_contribution = round(($statutory_rate_pf * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_2_er / 100)) + ($statutory_rate_pf * ($pf_esi_rates->epf_ac_21_er / 100)));						 
				  }
                  } else {
                     $modelRemu->employer_pf_contribution = 0;
                  }
				  
				  
				  if($model->gpa_applicability == 'Yes' && 	$model->gpa_premium !=''){
		  $gpa = $model->gpa_premium / 12;	  
		  } else {
		  $gpa = 0;
		  }
		  
		  
		  if($model->gmc_applicability == 'Yes' && 	$model->gmc_premium !=''){
		  $gmc = $model->gmc_premium / 24;	  
		  } else {
		  $gmc = 0;
		  }
		  
		  
		$modelRemu->ctc = round($ctc + $modelRemu->employer_pf_contribution);
		 $modelRemu->save(false);
		  $model->save(false);		
         return $this->redirect(['bank-details', 'id' => $id]);
      } else {
         return $this->render('statutory_form', [
                     'model' => $model,
         ]);
      }
   }


   public function actionDelete($id) {
      $salaryModel = EmpSalary::find()->where(['empid' => $id])->one();
      if ($salaryModel) {

         Yii::$app->session->setFlash("error", "This Employee Can't be deleted, Because already Salary Processed");
      } else {
         $this->findModel($id)->delete();
		 
	  $modelremuneration = EmpRemunerationDetails::find()->where(['empid' => $id])->one();
	  $modelremuneration->delete();
      $personalmodel =  EmpPersonaldetails::find()->where(['empid' => $id])->one();
	  $personalmodel->delete();
      $modeladd =  EmpAddress::find()->where(['empid' => $id])->one();
	  $modeladd->delete();
      $modelfamily =  EmpFamilydetails::find()->where(['empid' => $id])->one();
	  $modelfamily->delete();
      $modeleducation =  EmpEducationdetails::find()->where(['empid' => $id])->one();
	  $modeleducation->delete();
      $modelcer =  EmpCertificates::find()->where(['empid' => $id])->one();
	  $modelcer->delete();
      $modelbank =  EmpBankdetails::find()->where(['empid' => $id])->one();
	  $modelbank->delete();
      $modelstatutory =  EmpStatutorydetails::find()->where(['empid' => $id])->one();
	  $modelstatutory->delete();
      $modelemployment =  PreviousEmployment::find()->where(['empid' => $id])->one();
	  $modelemployment->delete();
      }

      return $this->redirect(['index']);
   }

   protected function findModel($id) {
      if (($model = EmpDetails::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }
	
	public function actionStaffsalaryannexure($id) {
        $model = EmpRemunerationDetails:: find()->where(['empid'=>$id])->one();
		 $Salarystructure = EmpSalarystructure::find()
                       ->where(['salarystructure' => $model->salary_structure])
                        ->count();
	if($Salarystructure >= 1){
		 $content = $this->renderPartial('enggsalaryannexure',[ 'model' => $model,]);		
	} else {
	$content = $this->renderPartial('staffsalaryannexure',[ 'model' => $model,]);  
	}
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
		'marginTop' =>1,
    ]); 
	
    return $pdf->render();   
	}
  public function actionAppointmentpdf($id) {  
  return $this->render('appointmentpdf');  
  }
  public function actionAppointmentWithoutHeader($id) {  
  return $this->render('appointment-without-header');  
  }
  
   public function actionAppointmentMail($id) {  
		$mailmodel = new MailForm();
		$empmodel = EmpDetails::findOne($id); 
		$filename = 'Appointment Order-'.$empmodel->empcode.'.pdf';
		
		 $mailmodel->from = "pr@voltechgroup.com";		
		 $mailmodel->password = "Welcome@123";
		 $mailmodel->subject = 'Appointment Order';
		 $mailmodel->body = 'Dear '. $empmodel->empname.' ('.$empmodel->empcode.'),<br>	<br>	
					<br>
					Greetings!!<br><br>
					Kindly, find the attached Appointment Order. 
					<br>
					<br>
					Regards,<br>
					Human Resources Department. <br>
					Voltech Engineers Pvt. Ltd. <br>
					2/429, Mount Poonamallee Road, Ayyapanthangal,<br>
					Chennai-600056. Ph:8754417008, Tel : +91-44-43978000,Ext : 286.
		 ';
		$mailmodel->bcc = "pr@voltechgroup.com";
	    $mailmodel->cc = "kumaresan.e@voltechgroup.com";
		$mailmodel->attachment ='doc_file/'.$filename;
				
					if($mailmodel->sendEmail($empmodel->email)){	
					    unlink('doc_file/'.$filename);
						Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
						return $this->redirect('index');
					} 
   }
  /* 
   public function actionAppointmentpdf($id) {
	 $content = $this->renderPartial('_appointmentView');
 
    // setup kartik\mpdf\Pdf component
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
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.css',
        // any css to be embedded if required
      /*  'cssInline' => '@page :first {    
					header: html_myHeader1;					
		}', */
         // set mPDF properties on the fly
       // 'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly		 
	/*	 'marginTop' =>1,
		 
	
       
    ]);
    return $pdf->render();
	 } */
  
   
   public function actionOrderCreate($id) { 
        $model = new AppointmentLetter();
		$data = Yii::$app->request->post();
		if($data){		 
			$appno = AppointmentLetter::find()
					 ->orderBy(['id' => SORT_DESC])
					 ->one();
				$model->empid = $id;
				$model->app_no = $appno ? $appno->app_no + 1 : 1;
				$model->letter = $_POST['Editor1'];		 
				$model->save(false);
				return $this->redirect(['order-update', 'id' => $id]);
		}
		return $this->render('order-create');     
   }
   
   
   public function actionOrderUpdate($id) {   
    $model = AppointmentLetter::find()->where(['empid' => $id])->one();
		 $data = Yii::$app->request->post();	  
			  if($data) {	   
				 $model->letter = $_POST['Editor1'];		 
				 $model->save(false);
			   
			  }	  
			  
			return $this->render('order-update', [
					  'model' => $model,
		  ]);  
   }
   
    public function random_strings($length_of_string) 
    { 

            // String of all alphanumeric character 
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 

            // Shufle the $str_result and returns substring 
            // of specified length 
            return substr(str_shuffle($str_result),  
                                               0, $length_of_string); 
    }

                    ///////// Transfer //////////
    public function actionEngineertransferProject($id)
    {
        $modelEmp = EmpDetails::find()->where(['id'=>$id])->one();
    $model = new EngineertransferProject();
    $unit_from = $modelEmp->unit_id;
    $division_from = $modelEmp->division_id;
     if ($model->load(Yii::$app->request->post())){       
      $modelEmp->division_id = $model->division_to;
      $modelEmp->unit_id = $model->unit_to; 
       if($modelEmp->save(false)){
         $model ->empid= $modelEmp->id;
         $model->unit_from=$model->unit_from;
         $model ->division_from= $model->division_from;
         $model ->unit_to= $model->unit_to;
         $model ->division_to= $model->division_to;
         $model ->transfer_date = Yii::$app->formatter->asDate($model->transfer_date, "yyyy-MM-dd");
         $model->save(false);
       }
        return $this->redirect('index');
     }
        return $this->render('engineertransfer-project', [
            'id' => $id,
            'model' => $model,  
      'modelEmp' => $modelEmp,
        ]);
    }
  public function actionDivisionTransfer($id)
    {

        $modelEmp = EmpDetails::find()->where(['id'=>$id])->one();
    $model = new EngineerTransfer();
    $division_from = $modelEmp->division_id;
     if ($model->load(Yii::$app->request->post())){       
      $modelEmp->division_id = $model->division_to; 
       if($modelEmp->save(false)){
         $model ->empid= $modelEmp->id;
         $model ->division_from= $model->division_from;
         $model ->division_to= $model->division_to;
         $model ->transfer_date = Yii::$app->formatter->asDate($model->transfer_date, "yyyy-MM-dd");
         $model->save(false);
       }
       
        return $this->redirect('index');
     }
        return $this->render('division-transfer', [
            'id' => $id,
      //'model' => $this->findModel($id),
            'model' => $model,  
      'modelEmp' => $modelEmp,
        ]);
    }
  public function actionEngineerList()
    {
   //return $this->render('user-files');
    return $this->render('engineer-list');
  }
   public function actionDepend()
    {
  
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id = $parents[0];
                $model = Unitgroup::find()->where(['unit_id' => $id])->all();

                foreach ($model as $contact) {
          $division = Division::find()->where(['id'=>$contact->division_id])->all();
          foreach($division as $div){

                    $out[] = ['id' => $div->id, 'name' => $div->division_name];
                }
        }
                echo Json::encode(['output' => $out, 'selected' => '']);
            }
        }
    }
  public function actionStatusChange($id)
    {
        $modelEmp = EmpDetails::find()->where(['id'=>$id])->one();
    $model = new Status();
    $status_from = $modelEmp->status;
     if ($model->load(Yii::$app->request->post())){       
      $modelEmp->status = $model->status_to; 
       if($modelEmp->save(false)){
         $model ->empid= $modelEmp->id;
         $model ->status_from= $model->status_from;
         $model ->status_to= $model->status_to;
         $model ->status_change_date = Yii::$app->formatter->asDate($model->status_change_date, "yyyy-MM-dd");
         $model->save(false);
       }
        return $this->redirect('index.php?r=project-details/attendance-menu');
     }
        return $this->render('status-change', [
            'id' => $id,
            'model' => $model,  
      'modelEmp' => $modelEmp,
        ]);
    }

}

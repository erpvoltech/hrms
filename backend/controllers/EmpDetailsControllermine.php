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
use common\models\EmpStatutorydetails;
use common\models\Unit;
use common\models\EmpDetailsSearch;
use common\models\EmpRemunerationDetails;
use common\models\PreviousEmployment;
use common\models\EmpSalary;
use common\models\EmpPromotion;
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

use app\models\AuthAssignment;

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
							'actions' => ['index','view'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['update'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create','import-employee'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('mis', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['delete'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('mis', 'delete');									 
								 },
							'roles' => ['@'],
						],
						// everything else is denied
					],
				],
			];
       }

   /*public function behaviors() {
      return [
          'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                  [
                      'actions' => ['index', 'view'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return Yii::$app->authManager->Rights('mis', 'view');
              }
                  ],
                  [
                      'actions' => ['create', 'education-details'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return Yii::$app->authManager->Rights('mis', 'create');
              }
                  ],
                  [
                      'actions' => ['update'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return Yii::$app->authManager->Rights('mis', 'update');
              }
                  ],
                  [
                      'actions' => ['delete'],
                      'allow' => true,
                      'matchCallback' => function ($rule, $action) {
                 return Yii::$app->authManager->Rights('mis', 'delete');
              }
                  ],
                  [
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
          ],
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'delete' => ['POST'],
              ],
          ],
      ];
   }*/

   public function actionTest() {

      return $this->render('test');
   }

   public function actionExport() {
      return $this->render('export');
   }

   public function actionPromotionExport() {
      return $this->render('promotion-export');
   }

   public function actionIndex() {
      $searchModel = new EmpDetailsSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
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

         if ($model->uploadtype == 1) {
            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
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

                  if ($excelrow['Emp. Code'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Code Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if ($excelrow['Emp. Name'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Name Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if ($excelrow['Gender'] == ' ') {
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
                  if ($excelrow['Salary Structure'] != 'Consolidated pay' && $excelrow['Salary Structure'] != '' && $excelrow['Salary Structure'] != 'Contract' && $excelrow['Salary Structure'] != 'Conventional' && $excelrow['Salary Structure'] != 'Modern') {
                     $wl = $excelrow['Work Level'];
                     $SalarySalary = EmpSalarystructure::find()->where(['salarystructure' => $excelrow['Salary Structure'], 'worklevel' => $excelrow['Work Level'], 'grade' => $excelrow['Grade'],])->one();
                     if ($SalarySalary) {
                        $basic = $SalarySalary->basic;
                        $hra = $SalarySalary->hra;
                        $dearness_allowance = $SalarySalary->dapermonth;
                        $spl_allowance = $SalarySalary->splallowance;
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
                     $grossamount = $excelrow['Gross Salary'];
                     $basic = round($grossamount * $PayScale->basic);
                     $hra = round($grossamount * $PayScale->hra);
                     $dearness_allowance = round($grossamount * $PayScale->dearness_allowance);
                     $spl_allowance = round($grossamount * $PayScale->spl_allowance);
                     $conveyance_allowance = round($PayScale->conveyance_allowance);
                     $lta_earning = round($basic * $PayScale->lta);
                     $medical_earning = round($basic * $PayScale->medical);
                     if ($PayScale->salarystructure == 'Moderan') {
                        $other_allowance = round(($grossamount - ($basic + $hra + $dearness_allowance + $lta_earning + $medical_earning)) - $conveyance_allowance);
                     } else {
                        $other_allowance = round(($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $lta_earning + $medical_earning)) - $conveyance_allowance);
                     }
                  } else {
                     $p_scale = 'NULL';
                  }

                  if ($excelrow['PLI'] != '' || $excelrow['PLI'] != 'N/A') {
                     $employer_pli = round($basic * ($excelrow['PLI']/100));
                  } else {
                     $employer_pli = 0;
                  }

                  if ($excelrow['Salary Structure'] != '' && $excelrow['Salary Structure'] != 'Engineer' && $excelrow['Salary Structure'] != 'Trainee' && $excelrow['Salary Structure'] != 'Consolidated pay' && $excelrow['Salary Structure'] != 'Contract' && $excelrow['Salary Structure'] != 'Conventional' && $excelrow['Salary Structure'] != 'Modern') {
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
                     $employer_pf = 1950;
                  } else {
                     $employer_pf = 0;
                  }


                  $posting = strtolower(str_replace(' ', '', $excelrow['Designation']));
                  $design = Yii::$app->db->createCommand("SELECT id FROM designation WHERE LOWER(replace(designation ,' ',''))='" . $posting . "'")->queryOne();
                  if ($design)
                     $designation = $design['id'];
                  else
                     $designation = 'NULL';

                  $dept = strtolower(str_replace(' ', '', $excelrow['Department']));
                  $dept1 = Yii::$app->db->createCommand("SELECT id FROM department WHERE LOWER(replace(name ,' ',''))='" . $dept . "'")->queryOne();
                  if ($dept1)
                     $department = $dept1['id'];
                  else
                     $department = 'NULL';
				 
                  $unit = strtolower(str_replace(' ', '', $excelrow['Unit']));
                  $unit1 = Yii::$app->db->createCommand("SELECT id FROM unit WHERE LOWER(replace(name ,' ',''))='" . $unit . "'")->queryOne();
                  $unit_id = $unit1['id'];

                  if ($unit1)
                     $unit_id = $unit1['id'];
                  else
                     $unit_id = 'NULL';


                  $div = strtolower(str_replace(' ', '', $excelrow['Division']));
                  $division = Yii::$app->db->createCommand("SELECT id FROM division WHERE LOWER(replace(division_name ,' ',''))='" . $div . "'")->queryOne();
                  $division_id = $division['id'];

                  if ($unit1)
                     $division_id = $division['id'];
                  else
                     $division_id = 'NULL';

                  $modelEmp = new EmpDetails();
                  $modelEmp->empcode = $excelrow['Emp. Code'];
                  $modelEmp->empname = $excelrow['Emp. Name'];
                  $modelEmp->doj = Yii::$app->formatter->asDate($excelrow['Date of Joining'], "yyyy-MM-dd");
                  $modelEmp->confirmation_date = Yii::$app->formatter->asDate($excelrow['Confirmation Date'], "yyyy-MM-dd");
                  $modelEmp->designation_id = $designation;
                  $modelEmp->division_id = $division_id;
                  $modelEmp->unit_id = $unit_id;
                  $modelEmp->department_id = $department;
                  $modelEmp->email = $excelrow['Email(Official)'];
                  $modelEmp->mobileno = $excelrow['Mobile No(CUG)'];
                  $modelEmp->referedby = $excelrow['Referred By'];
                  $modelEmp->probation = $excelrow['Probation'];
                  $modelEmp->appraisalmonth = $excelrow['Appraisal Month'];
                  $modelEmp->recentdop = $excelrow['Latest Promotion Date'];
                  $modelEmp->joining_status = $excelrow['Joining Status'];
                  $modelEmp->experience = $excelrow['Previous Experience'];
                  $modelEmp->save(false);

                  $emptableid = Yii::$app->db->getLastInsertID();

                  $modelPer = new EmpPersonaldetails();
                  $modelPer->empid = $emptableid;
                  $modelPer->dob = Yii::$app->formatter->asDate($excelrow['DoB(Record)'], "yyyy-MM-dd");
                  $modelPer->birthday = Yii::$app->formatter->asDate($excelrow['Birthday'], "yyyy-MM-dd");
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
                  $modelPer->passportvalid = Yii::$app->formatter->asDate($excelrow['Passport Valid'], "yyyy-MM-dd");
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

                  $modelBank = new EmpBankdetails();
                  $modelBank->empid = $emptableid;
                  $modelBank->bankname = $excelrow['Bank Name'];
                  $modelBank->acnumber = $excelrow['Account Number'];
                  $modelBank->branch = $excelrow['Branch'];
                  $modelBank->ifsc = $excelrow['IFSC'];
                  $modelBank->save(false);

                  $modelStatu = new EmpStatutorydetails();
                  $modelStatu->empid = $emptableid;
                  $modelStatu->esino = $excelrow['ESI No'];
                  $modelStatu->epfno = $excelrow['EPF No'];
                  $modelStatu->epfuanno = $excelrow['EPF UAN No'];
                  $modelStatu->zeropension = $excelrow['Zero Pension'];
                  $modelStatu->professionaltax = $excelrow['PT'];
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
                  if ($excelrow['PLI'] == 'N/A') {
                     $modelRemu->pli = 'NULL';
                  } else {
                     $modelRemu->pli = $excelrow['PLI'];
                  }
                  $modelRemu->basic = $basic;
                  $modelRemu->hra = $hra;
                  $modelRemu->dearness_allowance = $dearness_allowance;
                  $modelRemu->splallowance = $spl_allowance;
                  $modelRemu->conveyance = $conveyance_allowance;
                  $modelRemu->lta = $lta_earning;
                  $modelRemu->medical = $medical_earning;
                  $modelRemu->other_allowance = $other_allowance;
                  $modelRemu->gross_salary = $grossamount;
                  $modelRemu->employer_pf_contribution = $employer_pf;
                  $modelRemu->employer_esi_contribution = $employer_esi;
                  $modelRemu->employer_pli_contribution = $employer_pli;
                  $modelRemu->employer_lta_contribution = $employer_lta;
                  $modelRemu->employer_medical_contribution = $employer_medical;
                  $modelRemu->ctc = ($grossamount + $employer_pf + $employer_esi + $employer_pli + $employer_lta + $employer_medical);
                  $modelRemu->save(false);
                  $startrow++;
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
         } else if ($model->uploadtype == 2) {

            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
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


                  if ($excelrow['Emp. Code'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Code Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if ($excelrow['Emp. Name'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Name Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }

                  if ($excelrow['Gender'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Gender Column Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }

                  if ($excelrow['Salary Structure'] != 'Consolidated pay' && $excelrow['Salary Structure'] != '' && $excelrow['Salary Structure'] != 'Contract') {
                     $wl = $excelrow['Work Level'];
                     $SalarySalary = EmpSalarystructure::find()->where(['salarystructure' => $excelrow['Salary Structure'], 'worklevel' => $excelrow['Work Level'], 'grade' => $excelrow['Grade'],])->one();
                     $PayScale = EmpStaffPayScale::find()->where(['salarystructure' => $excelrow['Salary Structure']])->one();
                     if ($SalarySalary || $PayScale) {
                        if ($SalarySalary) {
                           $basic = $SalarySalary->basic;
                           $hra = $SalarySalary->hra;
                           $dearness_allowance = $SalarySalary->dapermonth;
                           $spl_allowance = $SalarySalary->splallowance;
                           $grossamount = $SalarySalary->netsalary;
                        }

                        if ($PayScale) {
                           $p_scale = $PayScale->id;
                           $grossamount = $excelrow['Gross Salary'];
                           $basic = round($grossamount * $PayScale->basic);
                           $hra = round($grossamount * $PayScale->hra);
                           $dearness_allowance = round($grossamount * $PayScale->dearness_allowance);
                           $spl_allowance = round($grossamount * $PayScale->spl_allowance);
                           $conveyance_allowance = round($PayScale->conveyance_allowance);
                           $lta_earning = round($basic * $PayScale->lta);
                           $medical_earning = round($basic * $PayScale->medical);
                           if ($PayScale->salarystructure == 'Moderan') {
                              $other_allowance = round(($grossamount - ($basic + $hra + $dearness_allowance + $lta_earning + $medical_earning)) - $conveyance_allowance);
                           } else {
                              $other_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
                           }
                        }
                     } else {
                        Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Salary Structure Doesn\'t Match');
                        $startrow++;
                        $countrow +=1;
                        continue;
                     }
                  }

                  $posting = strtolower(str_replace(' ', '', $excelrow['Designation']));
                  $design = Yii::$app->db->createCommand("SELECT id FROM designation WHERE LOWER(replace(designation ,' ',''))='" . $posting . "'")->queryOne();
                  if ($design)
                     $designation = $design['id'];
                  else
                     $designation = 'NULL';



                  $dept = strtolower(str_replace(' ', '', $excelrow['Department']));
                  $dept1 = Yii::$app->db->createCommand("SELECT id FROM department WHERE LOWER(replace(name ,' ',''))='" . $dept . "'")->queryOne();
                  if ($dept1)
                     $department = $dept1['id'];
                  else
                     $department = 'NULL';


                  $unit = strtolower(str_replace(' ', '', $excelrow['Unit']));
                  $unit1 = Yii::$app->db->createCommand("SELECT id FROM unit WHERE LOWER(replace(name ,' ',''))='" . $unit . "'")->queryOne();
                  $unit_id = $unit1['id'];

                  if ($unit1)
                     $unit_id = $unit1['id'];
                  else {
                     $unit_id = 'NULL';
                  }

                  $div = strtolower(str_replace(' ', '', $excelrow['Division']));
                  $division = Yii::$app->db->createCommand("SELECT id FROM division WHERE LOWER(replace(division_name ,' ',''))='" . $div . "'")->queryOne();
                  $division_id = $division['id'];

                  if ($unit1)
                     $division_id = $division['id'];
                  else
                     $division_id = 'NULL';


                  $modelemployee = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
                  if ($modelemployee) {
                     $modelEmp = EmpDetails::findOne($modelemployee->id);
                     $modelEmp->empcode = $excelrow['Emp. Code'];
                     $modelEmp->empname = $excelrow['Emp. Name'];
                     $modelEmp->doj = Yii::$app->formatter->asDate($excelrow['Date of Joining'], "yyyy-MM-dd");
                     $modelEmp->confirmation_date = Yii::$app->formatter->asDate($excelrow['Confirmation Date'], "yyyy-MM-dd");
                     $modelEmp->designation_id = $designation;
                     $modelEmp->division_id = $division_id;
                     $modelEmp->unit_id = $unit_id;
                     $modelEmp->department_id = $department;
                     $modelEmp->email = $excelrow['Email(Official)'];
                     $modelEmp->mobileno = $excelrow['Mobile No(CUG)'];
                     $modelEmp->referedby = $excelrow['Referred By'];
                     $modelEmp->probation = $excelrow['Probation'];
                     $modelEmp->appraisalmonth = $excelrow['Appraisal Month'];
                     $modelEmp->recentdop = $excelrow['Latest Promotion Date'];
                     $modelEmp->joining_status = $excelrow['Joining Status'];
                     $modelEmp->experience = $excelrow['Previous Experience'];
                     $modelEmp->save(false);

                     $modelPer = EmpPersonaldetails::find()->where(['empid' => $modelemployee->id])->one();
                     $modelPer->dob = Yii::$app->formatter->asDate($excelrow['DoB(Record)'], "yyyy-MM-dd");
                     $modelPer->birthday = Yii::$app->formatter->asDate($excelrow['Birthday'], "yyyy-MM-dd");
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
                     $modelPer->passportvalid = Yii::$app->formatter->asDate($excelrow['Passport Valid'], "yyyy-MM-dd");
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

                     $modelBank = EmpBankdetails::find()->where(['empid' => $modelemployee->id])->one();
                     $modelBank->bankname = $excelrow['Bank Name'];
                     $modelBank->acnumber = $excelrow['Account Number'];
                     $modelBank->branch = $excelrow['Branch'];
                     $modelBank->ifsc = $excelrow['IFSC'];
                     $modelBank->save(false);

                     $modelStatu = EmpStatutorydetails::find()->where(['empid' => $modelemployee->id])->one();
                     $modelStatu->esino = $excelrow['ESI No'];
                     $modelStatu->epfno = $excelrow['EPF No'];
                     $modelStatu->epfuanno = $excelrow['EPF UAN No'];
                     $modelStatu->zeropension = $excelrow['Zero Pension'];
                     $modelStatu->professionaltax = $excelrow['PT'];
                     $modelStatu->save(false);


                     $modelRemu = EmpRemunerationDetails::find()->where(['empid' => $modelemployee->id])->one();
                     $modelRemu->salary_structure = $excelrow['Salary Structure'];
                     $modelRemu->work_level = $excelrow['Work Level'];
                     $modelRemu->grade = $excelrow['Grade'];
                     $modelRemu->attendance_type = $excelrow['Attendance Type'];
                     $modelRemu->esi_applicability = $excelrow['ESI Applicability'];
                     $modelRemu->pf_applicablity = $excelrow['EPF Applicability'];
                     $modelRemu->restrict_pf = $excelrow['Restrict EPF'];
                     if ($excelrow['PLI'] == 'N/A') {
                        $modelRemu->pli = 'NULL';
                     } else {
                        $modelRemu->pli = $excelrow['PLI'];
                     }
                     $modelRemu->basic = $basic;
                     $modelRemu->hra = $hra;
                     $modelRemu->dearness_allowance = $dearness_allowance;
                     $modelRemu->splallowance = $spl_allowance;
                     $modelRemu->conveyance = $conveyance_allowance;
                     $modelRemu->lta = $lta_earning;
                     $modelRemu->medical = $medical_earning;
                     $modelRemu->other_allowance = $other_allowance;
                     $modelRemu->gross_salary = $grossamount;
                     $modelRemu->save(false);
                  } else {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: This Not Updated Record');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  $startrow++;
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
         } else if ($model->uploadtype == 3) {
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
         }
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
      $modeledu = new EmpEducationdetails();
      $modelcer = new EmpCertificates();
      $modelbank = new EmpBankdetails();
      $modelstatutory = new EmpStatutorydetails();
      $modelemployment = new PreviousEmployment();

      if ($model->load(Yii::$app->request->post())) {

         $model->doj = Yii::$app->formatter->asDate($model->doj, "yyyy-MM-dd");
         $model->recentdop = Yii::$app->formatter->asDate($model->recentdop, "yyyy-MM-dd");
         $model->dateofleaving = Yii::$app->formatter->asDate($model->dateofleaving, "yyyy-MM-dd");
         $model->confirmation_date = Yii::$app->formatter->asDate($model->confirmation_date, "yyyy-MM-dd");
         $model->photo = UploadedFile::getInstance($model, 'photo');
         if ($model->photo != '') {
            if ($model->upload($model->empcode)) {
               $model->photo = $model->empcode . '.' . $model->photo->extension;
               $model->save();
            }
         } else {
            $model->save();
         }
         $empid = Yii::$app->db->getLastInsertID();

         $modeledu->empid = $empid;
         $modeledu->save();

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
      $photoname = $model->photo;
      $post = Yii::$app->request->post();
      if ($model->load($post)) {
         $model->doj = Yii::$app->formatter->asDate($model->doj, "yyyy-MM-dd");
         $model->recentdop = Yii::$app->formatter->asDate($model->recentdop, "yyyy-MM-dd");
         $model->dateofleaving = Yii::$app->formatter->asDate($model->dateofleaving, "yyyy-MM-dd");
         $model->confirmation_date = Yii::$app->formatter->asDate($model->confirmation_date, "yyyy-MM-dd");
         if ($model->dateofleaving != '0000-00-00' && $model->dateofleaving != '1970-01-01' && $model->dateofleaving != ' ') {
            $model->status = 'Relieved';
         } else {
            $model->status = 'Active';
         }
         $model->photo = UploadedFile::getInstance($model, 'photo');
         if ($model->photo != '') {
            if ($model->upload($model->empcode)) {
               $model->photo = $model->empcode . '.' . $model->photo->extension;
               $model->save();
            }
         } else {
            $model->photo = $photoname;
            $model->save();
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
      $Emp = EmpDetails::findOne($id);

      if ($model->load(Yii::$app->request->post())) {
         $model->empid = $id;
         if ($model->pli == 'N/A') {
            $model->pli = 'NULL';
         }
         $model->gross_salary = $model->basic + $model->hra + $model->splallowance + $model->dearness_allowance + $model->personpay + $model->dust_allowance + $model->guaranteed_benefit + $model->other_allowance + $model->conveyance + $model->lta + $model->medical;
         $model->save();
         return $this->redirect(['personal-details', 'id' => $id]);
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
         echo "<option value='WL3A'>WL3A</option>";
         echo "<option value='WL3B'>WL3B</option>";
         echo "<option value='WL4A'>WL4A</option>";
         echo "<option value='WL4B'>WL4B</option>";
         echo "<option value='WL4C'>WL4C</option>";
         echo "<option value='WL5'>WL5</option>";
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
         $spl_allowance = round($grossamount * $PayScale->spl_allowance);
         $conveyance_allowance = round($PayScale->conveyance_allowance);
         // $pli_earning = round($basic * $PayScale->pli);
         $lta_earning = round($basic * $PayScale->lta);
         $medical_earning = round($basic * $PayScale->medical);
         if ($PayScale->salarystructure == 'Moderan') {
            $spl_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
            $other_allowance = 0;
         } else {
            $spl_allowance = round($grossamount * $PayScale->spl_allowance);
            $other_allowance = round($grossamount - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance + $lta_earning + $medical_earning));
         }

         if ($other_allowance > 0) {
            $other_allowance = $other_allowance;
         } else {
            $other_allowance = 0;
         }
         echo Json::encode(['basic' => $basic, 'hra' => $hra, 'splallowance' => $spl_allowance, 'da' => $dearness_allowance, 'ca' => $conveyance_allowance, 'lta' => $lta_earning, 'medical' => $medical_earning, 'other' => $other_allowance]);
      } else if ($post['empmtype'] == 'Engineer') {
         $Salstructure = EmpSalarystructure::find()
                 ->where(['salarystructure' => $post['sla_structure'], 'worklevel' => $post['worklevel'], 'grade' => $post['grade']])
                 ->one();
         echo Json::encode(['basic' => $Salstructure->basic, 'hra' => $Salstructure->hra, 'splallowance' => $Salstructure->splallowance, 'dapermonth' => $Salstructure->dapermonth, 'gross' => $Salstructure->netsalary]);
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

         $model->dob = Yii::$app->formatter->asDate($model->dob, "yyyy-MM-dd");
         $model->birthday = Yii::$app->formatter->asDate($model->birthday, "yyyy-MM-dd");
         $model->passportvalid = Yii::$app->formatter->asDate($model->passportvalid, "yyyy-MM-dd");

         $modelSiblings = Model::createMultiple(EmpFamilydetails::classname(), $modelSiblings);
         Model::loadMultiple($modelSiblings, Yii::$app->request->post());
         $newsiblingIds = ArrayHelper::getColumn($modelSiblings, 'id');

         $delsiblingIds = array_diff($oldsiblingIds, $newsiblingIds);
         if (!empty($delsiblingIds))
            EmpFamilydetails::deleteAll(['id' => $delsiblingIds]);

         $valid = $model->validate();
         $valid = Model::validateMultiple($modelSiblings) && $valid;

         if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {

               $model->empid = $id;
               if ($flag = $model->save()) {
                  $addressModel->empid = $id;
                  $addressModel->save();

                  foreach ($modelSiblings as $modelSibl) { /* save Siblings */
                     $modelSibl->birthdate = Yii::$app->formatter->asDate($modelSibl->birthdate, "yyyy-MM-dd");
                     $modelSibl->empid = $model->id;
                     if (!($flag = $modelSibl->save())) {
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
               return $this->redirect(['bank-details', 'id' => $id]);
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
      $oldBankIds = EmpBankdetails::find()->select('id')->where(['empid' => $id])->asArray()->all();
      $oldBankIds = ArrayHelper::getColumn($oldBankIds, 'id');

      $model = EmpBankdetails::findAll(['id' => $oldBankIds]);
      $model = (empty($model)) ? [new EmpBankdetails] : $model;

      $modelBank = Model::createMultiple(EmpBankdetails::classname(), $model);
      if (Model::loadMultiple($modelBank, Yii::$app->request->post())) {
         $newBankIds = ArrayHelper::getColumn($modelBank, 'id');

         $delBankIds = array_diff($oldBankIds, $newBankIds);
         if (!empty($delBankIds))
            EmpBankdetails::deleteAll(['id' => $delBankIds]);

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
               return $this->redirect(['statutory-details', 'id' => $id]);
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
               $Employment->work_from = Yii::$app->formatter->asDate($Employment->work_from, "yyyy-MM-dd");
               $Employment->work_to = Yii::$app->formatter->asDate($Employment->work_to, "yyyy-MM-dd");
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

      $post = Yii::$app->request->post();
      if ($model->load(Yii::$app->request->post())) {
         $model->empid = $id;
         $model->save();
         return $this->redirect(['previous_employment', 'id' => $id]);
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
      }

      return $this->redirect(['index']);
   }

   protected function findModel($id) {
      if (($model = EmpDetails::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }

   public function actionGenerateorder($id) {
      $model = new AppointmentLetter();

      $emp = EmpDetails::findOne($id);
      $remunerationmodel = EmpRemunerationDetails::find()->where(['empid' => $id])->one();

      $empadd = EmpAddress::find()->where(['empid' => $id])->one();

      $app_letter = AppointmentLetter::find()
              ->where(['empid' => $emp->id])
              ->one();

      if (!$app_letter) {
         $appno = AppointmentLetter::find()
                 ->orderBy(['id' => SORT_DESC])
                 ->one();

         $model->empid = $id;
//$model->type=$emp->etype;
         $model->app_no = $appno ? $appno->app_no + 1 : 1;

         $Designation = Designation::find()
                 ->where(['id' => $emp->designation_id])
                 ->one();

         $letter = '<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p><strong><em>Ref: VEPL/HR/2018-19/APP/E/' . $model->app_no . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Date: ' . date('d-m-Y') . '</em></strong></p>

		<p>&nbsp;</p>

		<p><strong>' . $emp->empname . ',</strong><br />';
         if ($empadd->addfield1 != '')
            $letter .= '<strong>' . $empadd->addfield1 . ',</strong><br />';
         if ($empadd->addfield2 != '')
            $letter .='<strong>' . $empadd->addfield2 . ',</strong><br />';
         if ($empadd->addfield3 != '')
            $letter .='<strong>' . $empadd->addfield3 . ',</strong><br />';
         if ($empadd->addfield4 != '')
            $letter .='<strong>' . $empadd->addfield4 . ',</strong></br>';
         if ($empadd->addfield5 != '')
            $letter .='<strong>' . $empadd->addfield5 . ',</strong></br>';

         $letter .='<strong>' . $empadd->district . ',</strong></br>
		<strong>' . $empadd->state . $empadd->pincode . '.</strong></p>

		<p>&nbsp;</p>

		<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sub: Appointment Letter</strong></p>

		<p>Dear <strong>' . $emp->empname . ', </strong></p>

		<p>We are pleased to appoint you in the position of<strong> &ldquo;' . $Designation->designation . '&rdquo;</strong> under the following terms and conditions.</p>
		       <ol>
			<li><strong>Effective Date of Appointment: ' . Yii::$app->formatter->asDate($emp->doj, "dd-MM-yyyy") . '</strong></li>
			<li><strong>Employee Number</strong><strong>:' . $emp->empcode . '</strong>&amp; <strong>Work Level</strong> : <strong>' . $remunerationmodel->work_level . '</strong></li>
			<li><strong>Salary &amp; Allowance</strong><strong>:</strong> You shall be entitled to a Gross salary of <strong>Rs.' . $remunerationmodel->gross_salary * 12 . '/- </strong>(' . $emp->getIndianCurrency($remunerationmodel->gross_salary * 12) . 'Only) Payable per annum. Detailed Salary breaks up as being described in Annexure &ndash; 1.</li>
			<li><strong>Probation</strong><strong>:</strong> You will be on probation for a period of <strong>One Year. </strong>Your Confirmation will be subjected to satisfactory performance during the probation period.</li>
			<li><strong>Transfer</strong> : You will be liable to be transferred from one department to another, one section to another, one branch to another, one establishment to another&nbsp; or to any of its associate companies, in India or abroad, either existing today or to be started at any time subsequent to your employment.</li>
			<li><strong>Full Time Employment</strong>: This is a full time employment, and therefore you shall devote full time to the work of the company and will not undertake any direct / indirect business or work, honorary or remuneratory, except with prior written permission of the management, in each case.</li>
			<li><strong>Secrecy</strong><strong>: </strong>During the term of your appointment and for two (2) year after its termination, you shall not disclose, divulge to anyone by word of mouth or otherwise the content of this appointment letter, particulars or details of products, developing process, technical knowhow, administrative or organizational matters, client data and information, proprietary information pertaining to the company either directly or indirectly, which may be your personal privilege to know by virtue of being in employment of the company.</li>
			<li><strong>Medical Fitness</strong><strong>:</strong> This appointment and its continuance are subjected to your being found &amp; remaining in sound physical and mental health. As and when required you shall report for any medical examination to a qualified doctor as rectified by the Govt. / appointed by the company.</li>
			<li><strong>Residential Address</strong><strong>:</strong>&nbsp; Your address as given in the application will be deemed to be correct for the purpose of sending any communication to you. In case of any change, you will inform the management in writing.</li>
			<li><strong>Termination: </strong>This agreement can be terminated by either party by giving Ninety (90) days written notice or Six (6) months&rsquo; salary. Upon termination of employment, all the company documents, information and property, business cards, office keys must be returned to the office prior to leaving.</li>
			<li><strong>Leave</strong><strong>: </strong>On Completion of Your probation, you will be entitled to earned leave and casual leave as per the rules operational in the company and which is subjected to change.</li>
			<li><strong>Documents:</strong> Your appointment is valid subjected to submission of these documents on the joining date.
			<li><strong>Benefits: </strong>You shall travel in <strong>II Class Sleeper Coaches</strong> in trains during your official tours. You shall avail exceptions worth Max.<strong>Rs.250/-</strong> pm in Mobile CUG bills. Company will provide coverage under insurance policies such as Personal Accident Policy and Med claim Policy on welfare basis. On your separation, the coverage under the policies will be ceased immediately without prior notice.
				<table border="1" cellpadding="0" cellspacing="0" style="width:500px">
					<tbody>
						<tr>
							<td style="height:7.65pt; vertical-align:top; width:127.15pt">
							<p><strong>Out of Office Stay</strong></p>
							</td>
							<td><strong>Metro</strong></td>
							<td><strong>Non Metro</strong></td>
						</tr>
						<tr>
							<td><strong>Lodging</strong></td>
							<td>Rs.500/- per Day</td>
							<td>Rs.300/- per day</td>
						</tr>
						<tr>
							<td><strong>Boarding</strong></td>
							<td>Rs.150/-per Day</td>
							<td>Rs.150/-per Day</td>
						</tr>
					</tbody>
				</table>
				</li>
			</li>
			<li>
			<p><strong>Business Loss Compensation:</strong> You are liable to work minimum 3 years in our organization. In case of your resignation before completing 3 years of service (from the date of joining), you will have to pay a sum of <strong>Rs.1, 00,000/-(Rupees One Lakh)</strong> towards business loss, On-the-Job training cost and administrative expenses. You shall not avail Experience Certificate, Conduct Certificate etc.</p>
			</li>
			<li>
			<p>Please ensure that all the document submitted by you and the details provided in the company application form are authentic and accurate. In the event the said particulars are found to be incorrect or that you have withheld some other relevant facts your appointment in the company shall stand cancelled without any notice. Your appointment and continuance in employment is also subjected to our receiving a satisfactory independent reference check.</p>
			</li>
		</ol>

		<p>You shall conduct all activities under this appointment in accordance with sound business practices and ethics and in a manner which reflects favorably upon the company and its products and the goodwill associated herewith.</p>

		<p>The appointment will be governed by the Indian laws and be subjected to the jurisdiction of Chennai court.</p>

		<p>Please submit to us the written acceptance of this offer by signing the second copy of this letter.</p>

		<p>We welcome you to VOLTECH Group of Companies, and look forward to your continued growth with us. We are sure you will enjoy being part of the team.</p>

		<p>Yours Sincerely.</p>

		<p><strong>For VOLTECH Engineers Private Limited,</strong></p>

		<p>&nbsp;</p>

		<p>&nbsp;</p>

		<p><strong>M.UMAPATHI</strong></p>

		<p><strong>Managing Director</strong></p>

		<p>&nbsp;</p>

		<p><strong>Declaration:</strong></p>

		<p>&nbsp;</p>

		<p>I have carefully read this appointment letter and I willingly and unconditionally accept to abide the terms and the conditions prescribed therein.</p>

		<p>Place &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature&nbsp;&nbsp;&nbsp; :</p>

		<p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</p>

		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ANNEXURE - I</strong></p>

		<p>&nbsp;</p>

		<p><strong>Basic Salary&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong>Rs.' . $remunerationmodel->basic . ' p.m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. ' . ($remunerationmodel->basic * 12) . ' p.a<br />
		<strong>HRA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong>Rs. ' . $remunerationmodel->hra . ' p.m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs.' . ($remunerationmodel->hra * 12) . ' p.a<br />
		<strong>Special Allowance&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong>Rs. ' . $remunerationmodel->splallowance . ' p.m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. ' . ($remunerationmodel->splallowance * 12) . ' p.a<br />
		<strong>Domestic Site Allowance&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong>Rs. ' . $remunerationmodel->dearness_allowance . ' p.m &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. ' . ($remunerationmodel->dearness_allowance * 12) . ' p.a<br />
		<strong>(Rs.' . round(($remunerationmodel->dearness_allowance / 30)) . '/-per day)</strong><br />
		<strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -------------------------&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------------------------</strong><br />
		<strong>Gross Salary&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</strong>Rs. ' . $remunerationmodel->gross_salary . ' p.m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs.' . ($remunerationmodel->gross_salary * 12) . ' p.a<br />
		<strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -------------------------&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; --------------------------</strong></p>

		<p><strong>Deductions: PF &ndash; Rs.1, 604/- P.M and ESI: Rs.234 P.M</strong></p>

		<p>&nbsp;</p>

		<p>&nbsp;</p>

		<p><strong>For VOLTECH Engineers Private Limited,</strong></p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>

		<p><strong>M.UMAPATHI</strong><br />
		<strong>Managing Director</strong></p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>

		<p><strong>Declaration:</strong></p>
		<p>&nbsp;</p>
		<p>I have carefully taken note of this remuneration structure and I willingly and unconditionally accept the same.</p>

		<p>&nbsp;</p>

		<p>Place &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature&nbsp;&nbsp; :</p>

		<p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</p>';
         /*  } else if($emp->etype =='Staff') {
           $PayScale = EmpStaffPayScale::find()
           ->where(['id' => $emp->staff_pay_scale_id])
           ->one();

           $basic =  round($emp->gross_salary * $PayScale->basic);
           $hra =  round($emp->gross_salary * $PayScale->hra);
           $dearness_allowance =  round($emp->gross_salary * $PayScale->dearness_allowance);
           $spl_allowance =  round($emp->gross_salary * $PayScale->spl_allowance);
           $conveyance_allowance =  round($PayScale->conveyance_allowance);
           $pli_earning = round($basic * $PayScale->pli);
           $lta_earning = round($basic * $PayScale->lta);
           $medical_earning = round($basic * $PayScale->medical);
           $other_allowance = round($emp->gross_salary - ($basic + $hra + $dearness_allowance + $spl_allowance + $conveyance_allowance	+ $pli_earning + $lta_earning + $medical_earning));

           $total_earning_pa =$emp->gross_salary*12;

           $letter = '<p>&nbsp;</p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p><strong><em>Ref: VEPL/HR/2018-19/APP/S/'. $model->app_no .'&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Date: '. date('d-m-Y').'</em></strong></p>

           <p>&nbsp;</p>

           <p><strong>'.$emp->empname.',</strong><br />';
           if($empadd->addfield1 != '')
           $letter .= '<strong>'.$empadd->addfield1.',</strong><br />';
           if($empadd->addfield2 != '')
           $letter .='<strong>'.$empadd->addfield2.',</strong><br />';
           if($empadd->addfield3 != '')
           $letter .='<strong>'.ucfirst(strtolower($empadd->addfield3)).',</strong><br />';
           if($empadd->addfield4 != '')
           $letter .='<strong>'.ucfirst(strtolower($empadd->addfield4)).',</strong></br>';
           if($empadd->addfield5 != '')
           $letter .='<strong>'.ucfirst(strtolower($empadd->addfield5)).',</strong></br>';

           $letter .='<strong>'.$empadd->district.',</strong></br>
           <strong>'.ucfirst(strtolower($empadd->state)).' - '.$empadd->pincode.'.</strong></p>

           <p>&nbsp;</p>

           <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sub: Appointment Letter</strong></p>

           <p>Dear <strong>'.$emp->empname.', </strong></p>

           <p>We are pleased to appoint you in the position of<strong> &ldquo;'.$Designation->designation.'&rdquo;</strong> under the following terms and conditions.</p>

           <ol>
           <li><strong>Effective Date of Appointment: '. Yii::$app->formatter->asDate($emp->doj, "dd-MM-yyyy") .'</strong></li>
           <li><strong>Employee Number</strong><strong>:'.$emp->ecode.'</strong>&amp; <strong>Work Level</strong> : <strong>'.$emp->worklevel.'</strong></li>
           <li><strong>Salary &amp; Allowance</strong><strong>:</strong> You shall be entitled to a CTC of <strong>Rs.'. $total_earning_pa .'/-</strong>('.$emp->getIndianCurrency($total_earning_pa) .'Only) Payable per annum as per Annexure.</li>
           <li><strong>Progression</strong><strong>:</strong> You shall work under the terms of this letter for a period of<strong> One Year.</strong> Further Progression will be subjected to your satisfactory performance.</li>
           <li><strong>Transfer</strong> : You will be liable to be transferred from one department to another, one section to another, one branch to another, one establishment to another&nbsp; or to any of its associate companies, in India or abroad, either existing today or to be started at any time subsequent to your employment.</li>
           <li><strong>Full Time Employment</strong>: This is a full time employment, and therefore you shall devote full time to the work of the company and will not undertake any direct / indirect business or work, honorary or remuneratory, except with prior written permission of the management, in each case.</li>
           <li><strong>Secrecy</strong><strong>: </strong>During the term of your appointment and for two (2) year after its termination, you shall not disclose, divulge to anyone by word of mouth or otherwise the content of this appointment letter, particulars or details of products, developing process, technical knowhow, administrative or organizational matters, client data and information, proprietary information pertaining to the company either directly or indirectly, which may be your personal privilege to know by virtue of being in employment of the company.</li>
           <li><strong>Medical Fitness</strong><strong>:</strong> This appointment and its continuance are subjected to your being found &amp; remaining in sound physical and mental health. As and when required you shall report for any medical examination to a qualified doctor as rectified by the Govt. / appointed by the company.</li>
           <li><strong>Residential Address</strong><strong>:&nbsp;</strong>Your address as given in the application will be deemed to be correct for the purpose of sending any communication to you. In case of any change in the same, you will inform the management in writing.</li>
           <li><strong>Termination: </strong>This agreement can be terminated by either party by giving Thirty (30) days written notice or two (2) months&rsquo; salary. Upon termination of employment, all the company documents, information and property, business cards, office keys must be returned to the office prior to leaving.</li>
           <li><strong>Leave</strong><strong>: </strong>You will be entitled to earned leave and casual leave as per the rules operational in the company and which is subjected to change.</li>
           <li><strong>Documents:</strong> Your appointment is valid subjected to submission of these documents on the joining date.
           <ul>
           <li>Latest Degree Certificate and Police Verification Certificate (Original).</li>
           <li>Photocopies of your ID / Address Proofs, All Educational Certificates.</li>
           <li>Ten passport size Photographs, One Family photo (visiting card size).</li>
           </ul>
           </li>
           <li><strong>Benefits: </strong>You shall claim your Leave Travel Allowances in every March and Medical allowances in every September. Company shall provide insurance coverage for Rs.10, 00,000/- under Personal Accident Insurance Policy and Rs.5, 00,000/- per annum under Med claim Policy. On your separation, the coverage under the policies will be ceased immediately without notice.
           <ul>
           <li>You shall travel in 2 Tier AC Coaches in trains during your official tours.</li>
           <li>You will be entitled to avail 30 days leaves per year on pro rata basis.</li>
           <li>You shall avail exceptions worth Max.Rs.2, 000/- pm in Mobile CUG bills.</li>
           <li>Laptop shall be provided with necessary peripherals required for your job.</li>
           </ul>
           </li>
           <li><strong>Boarding &amp; Lodging</strong>: Your salary is inclusive of accommodation allowance. You shall be entitled to make use of external lodging options when you are on official tours. External Boarding and Lodging allowances shall be limited to the following slab:



           <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:500px">
           <thead>
           <tr>
           <th>
           <strong>Out of Office Stay</strong>
           </th>
           <th>
           <strong>Metro</strong>
           </th>
           <th>
           <strong>Non Metro</strong>
           </th>
           </tr>
           </thead>
           <tbody>
           <tr>
           <td>
           <strong>Lodging</strong>
           </td>
           <td>Rs.2,000/- per Day</td>
           <td>Rs.1,500/- per day</td>
           </tr>
           <tr>
           <td>
           <strong>Boarding</strong>
           </td>
           <td>Rs.300/-per Day</td>
           <td>Rs.250/-per Day</td>
           </tr>
           </tbody>
           </table>
           </li>
           <li>
           <p>Please ensure that all the document submitted by you and the details provided in the company application form are authentic and accurate. In the event the said particulars are found to be incorrect or that you have withheld some other relevant facts your appointment in the company shall stand cancelled without any notice. Your appointment and continuance in employment is also subjected to our receiving a satisfactory independent reference check.</p>
           </li>
           </ol>
           <p>You shall conduct all activities under this appointment in accordance with sound business practices and ethics and in a manner which reflects favorably upon the company and its products and the goodwill associated herewith.</p>

           <p>The appointment will be governed by the Indian laws and be subjected to the jurisdiction of Chennai court.</p>

           <p>We welcome you to VOLTECH Group of Companies, and look forward to your continued growth with us. We are sure you will enjoy being part of the team.</p>

           <p>Please submit to us the written acceptance of this offer by signing the second copy of this letter.</p>

           <p>Yours Sincerely.</p>
           <p><strong>For VOLTECH Engineers Private Limited,</strong></p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p><strong>M.UMAPATHI</strong></p>
           <p><strong>Managing Director</strong></p>
           <p>&nbsp;</p>
           <p><strong>Declaration:</strong></p>
           <p>I have carefully read this appointment letter and I willingly and unconditionally accept to abide the terms and the conditions prescribed therein.</p>
           <p>Place &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature&nbsp;&nbsp;&nbsp; :</p>
           <p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</p>


           <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ANNEXURE - I</strong></p>

           <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:500px">
           <tbody>
           <tr>
           <td><strong>Basic Salary</strong></td>
           <td>Rs.'. $basic .' p.m</td>
           <td>Rs.'. $basic * 12 .' p.a</td>
           </tr>
           <tr>
           <td><strong>Dearness Allowance</strong></td>
           <td>Rs.'.$dearness_allowance .' p.m;</td>
           <td>Rs.'.$dearness_allowance * 12 .' p.a</td>
           </tr>
           <tr>
           <td><strong>HRA</strong></td>
           <td>Rs.'. $hra .' p.m</td>
           <td>Rs.'. $hra * 12 .' p.a</td>
           </tr>';
           if($PayScale->package_name=='without CTC'){
           $letter .='<tr>
           <td><strong>Special Allowance</strong></td>
           <td>Rs.'. $spl_allowance .' p.m;</td>
           <td>Rs.'. $spl_allowance * 12 .'p.a</td>
           </tr>';
           }
           if($PayScale->package_name !='Consultant' && $PayScale->package_name !='without CTC' ){
           $letter .='<tr>
           <td><strong>Conveyance Allowance</strong></td>
           <td>Rs.'. $conveyance_allowance .' p.m;</td>
           <td>Rs.'. $conveyance_allowance * 12 .'p.a</td>
           </tr>';
           }
           if($PayScale->package_name =='with CTC -Mannual' && $PayScale->package_name =='with CTC' ){
           $letter .='<tr>
           <td><strong>LTA</strong></td>
           <td>Rs.'. $lta_earning .' p.m;</td>
           <td>Rs.'. $lta_earning * 12 .'p.a</td>
           </tr>';
           }
           if($PayScale->package_name =='with CTC' ){
           $letter .='<tr>
           <td><strong>Medical Allowance</strong></td>
           <td>Rs.'. $medical_earning .' p.m;</td>
           <td>Rs.'. $medical_earning * 12 .'p.a</td>
           </tr>';
           }
           if($PayScale->package_name !='Consultant' && $PayScale->package_name !='without CTC' ){
           $letter .='<tr>
           <td><strong>PLI</strong></td>
           <td>Rs.'. $pli_earning .' p.m;</td>
           <td>Rs.'. $pli_earning * 12 .'p.a</td>
           </tr>';
           }
           if($other_allowance > 0 ){
           $letter .='<tr>
           <td><strong>Other Allowance</strong></td>
           <td>Rs.'. $other_allowance .' p.m;</td>
           <td>Rs.'. $other_allowance * 12 .'p.a</td>
           </tr>';
           }
           $letter .='<tr>
           <td><strong>Gross Salary</strong></td>
           <td>Rs.'. $emp->gross_salary .' p.m;</td>
           <td>Rs.'. $emp->gross_salary * 12 .' p.a;</td>
           </tr>
           </tbody>
           </table>

           <p><strong>Deductions: PF, ESI &amp; Professional Tax Applicable.</strong></p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p><strong>For VOLTECH Engineers Private Limited,</strong></p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p><strong>M.UMAPATHI</strong></p>

           <p><strong>Managing Director</strong></p>
           <p>&nbsp;</p>
           <p>&nbsp;</p>
           <p><strong>Declaration:</strong></p>
           <p>&nbsp;</p>

           <p>I have carefully taken note of this remuneration structure and I willingly and unconditionally accept the same.</p>

           <p>&nbsp;</p>
           <p>Place &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature&nbsp;&nbsp; :</p>
           <p>Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</p>';
           } */


         $model->letter = $letter;
         if ($model->save(false)) {
            return $this->redirect(['appointment-letter', 'id' => $id]);
         }
      } else {
         return $this->redirect(['appointment-letter', 'id' => $app_letter->empid]);
      }
   }

   public function actionAppointmentLetter($id) {
      $model = AppointmentLetter::find()->where(['empid' => $id])->one();
      if ($model->load(Yii::$app->request->post())) {
         $model->empid = $id;
         $model->save();
      }
      return $this->render('appointment_letter', [
                  'model' => $model,
      ]);
   }

}

<?php
namespace frontend\controllers;
use Yii;
use DateTime;
/*use frontend\models\EmpDetailsFront;
use frontend\models\EmpPersonaldetailsFront;
use frontend\models\EmpAddressFront;
use frontend\models\EmpFamilydetailsFront;
use frontend\models\EmpEducationdetailsFront;
use frontend\models\EmpCertificatesFront;
use frontend\models\EmpBankdetailsFront;
use frontend\models\Department;
use frontend\models\Designation;
use frontend\models\Qualification;
#use common\models\EmpStatutorydetails;
use frontend\models\Unit;
use frontend\models\EmpDetailsFrontSearch;
#use common\models\EmpRemunerationDetails;
use frontend\models\PreviousEmploymentFront;
#use common\models\EmpSalary;
#use common\models\EmpPromotion;
#use common\models\Course;*/

use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use common\models\EmpEducationdetails;
use common\models\EmpCertificates;
use common\models\EmpBankdetails;
use common\models\PreviousEmployment;

use common\models\EmpDetailsFront;
use common\models\EmpPersonaldetailsFront;
use common\models\EmpAddressFront;
use common\models\EmpFamilydetailsFront;
use common\models\EmpEducationdetailsFront;
use common\models\EmpCertificatesFront;
use common\models\EmpBankdetailsFront;
use common\models\Department;
use common\models\Designation;
use common\models\Qualification;
#use common\models\EmpStatutorydetails;
use common\models\Unit;
use common\models\EmpDetailsFrontSearch;
#use common\models\EmpRemunerationDetails;
use common\models\PreviousEmploymentFront;
#use common\models\EmpSalary;
#use common\models\EmpPromotion;
#use common\models\Course;
use app\models\Model;
#use app\models\AppointmentLetter;
#use app\models\EmpSalarystructure;
###use app\models\EmpStaffPayScale;
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


#use app\models\AuthAssignment;

class EmpDetailsFrontController extends Controller {
	
	
	public function behaviors()
        {
			//$this->$layout = 'main';
			if(isset(Yii::$app->user->identity->username) ){
				 Yii::$app->layout = 'main';
			}
			if(!isset(Yii::$app->user->identity->username)){
				 Yii::$app->layout = 'main_mis';
			}
		    return [
			'verbs' => [
                   'class' => VerbFilter::className(),
                   'actions' => [
                       'delete' => ['post'],
                   ],
               ],				
			];
        }

   public function actionTest() {
      return $this->render('test');
   }
   
   public function actionExport() {
    return $this->render('export');
   }
   
   public function actionExportwodata() {
      return $this->render('exportwodata');
   }

    public function actionPromotionExport() {
      return $this->render('promotion-export');
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
    public function actionExportCertificate() {
      return $this->render('export-certificate');
    }
    public function actionExportEmp() {
      return $this->render('export-emp');
    }
   
    public function actionMisExport() {
      return $this->render('mis-export');
    }
	
	public function actionLogin() {
		$model = new EmpDetailsFront();
		if ($model->load(Yii::$app->request->post())) {			
			#exit;
			$modelEmp = EmpDetails::find()->where(['empcode' => $model->empcode])->one();
			#echo "</br> entry pass: ".$model->emp_password;
			#echo "</br> emp_password: ".$modelEmp->emp_password;
			#exit;
			if($model->emp_password == $modelEmp->emp_password && $modelEmp->consolidated_status == 'No' ){
				Yii::$app->session->setFlash('success', 'Successfully logged in.');
				#return $this->redirect(['update', 'id' => $modelEmp->id]);
				#echo "</br>hihihi";
				#exit;
				$modelEmpFrontcnt 	= EmpDetailsFront::find()->where(['empcode' => $model->empcode])->count();
				$modelEmpFront		= EmpDetailsFront::find()->where(['empcode' => $model->empcode])->one();
				if($modelEmpFrontcnt == 0){
					return $this->redirect(['create', 'ecode' => $modelEmp->empcode]);
				}else{
					return $this->redirect(['update', 'id' => $modelEmpFront->id]);
				}
			}else{
				#echo "</br> consolidated status: ".$modelEmp->consolidated_status;
				#exit;
				if($model->emp_password != $modelEmp->emp_password){
					Yii::$app->session->setFlash('error', 'Enter Correct Password.');
				}
				if($modelEmp->consolidated_status == 'Yes'){
					Yii::$app->session->setFlash('error', 'You had completed the updation!!!.');
				}
				return $this->redirect(['login', ['model' => $model,]]);
			}
		}else{
			return $this->render('login',['model' => $model,]);
		}
	}

    public function actionIndex() {
      $searchModel = new EmpDetailsFrontSearch();
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
   
   
   public function actionCreate($ecode) {
	   
	  $modelback	=	EmpDetails::find()->where(['empcode' => $ecode])->one();
	  #echo "<pre>";print_r($modelback);echo "</pre>";
	  $modelcount = EmpDetailsFront::find()
                       ->where(['empcode' => $ecode])
                        ->count();
		#echo "</br> modelcount: ".$modelcount;
		
		#exit;				
		if($modelcount == 0){
		  $model = new EmpDetailsFront();
		  
		  $model->attributes	=	$modelback->attributes;
		  #$model->id = '';
		  #echo "<pre>";print_r($model);echo "</pre>";
		  #echo "</br> empcode: ".$model->empcode;
		  #exit;

		  #$modelremuneration = new EmpRemunerationDetails();
		  $personalmodel = new EmpPersonaldetailsFront();
		  $modeladd = new EmpAddressFront();
		  $modelfamily = new EmpFamilydetailsFront();
		  $modeleducation = new EmpEducationdetailsFront();
		  $modelcer = new EmpCertificatesFront();
		  $modelbank = new EmpBankdetailsFront();
		  #$modelstatutory = new EmpStatutorydetails();
		  $modelemployment = new PreviousEmploymentFront();

		  #if ($model->load(Yii::$app->request->post())) {
		  if ($model) {

			 $model->doj = Yii::$app->formatter->asDate($model->doj, "yyyy-MM-dd");
					  
			  if($model->recentdop && $model->recentdop != '0000-00-00' && $model->recentdop != '1970-01-01'){
					$model->recentdop = Yii::$app->formatter->asDate($model->recentdop, "yyyy-MM-dd");
				} else {
					$model->recentdop = NULL; 
				}
				
			  if($model->dateofleaving && $model->dateofleaving != '0000-00-00' && $model->dateofleaving != '1970-01-01'){
				$model->dateofleaving = Yii::$app->formatter->asDate($model->dateofleaving, "yyyy-MM-dd");
				$model->status = 'Relieved';
			  } else {
				$model->dateofleaving =NULL;
				$model->status = 'Active';
			  }
			  
			  if($model->confirmation_date && $model->confirmation_date != '0000-00-00' && $model->confirmation_date != '1970-01-01'){
				$model->confirmation_date = Yii::$app->formatter->asDate($model->confirmation_date, "yyyy-MM-dd");
			  } else {
				$model->confirmation_date = NULL;
			  }
			  
		   
			 $model->photo = UploadedFile::getInstance($model, 'photo');
			 if ($model->photo != '') {
				if ($model->upload($model->empcode)) {
				   $model->photo = $model->empcode . '.' . $model->photo->extension;
				   $model->save();
				}
			 } else {
				$model->save(false);
			 }
			 $empid = Yii::$app->db->getLastInsertID();
			 
			 #echo "</br> empid: ".$empid;
			 #exit;
			 $modeleducation->empid = $empid;
			 $modeleducation->save(false);

			 $modelcer->empid = $empid;
			 $modelcer->save(false);

			 $modelbank->empid = $empid;
			 $modelbank->save(false);
			

			 $modeladd->empid = $empid;
			 $modeladd->save(false);

			 $personalmodel->empid = $empid;
			 $personalmodel->save(false);

			 $modelfamily->empid = $empid;
			 $modelfamily->save(false);

			 $modelemployment->empid = $empid;
			 $modelemployment->save(false);

			 return $this->redirect(['update', 'id' => $model->id]);
		  }      
		}else{
			
			$modelFront = EmpDetailsFront::find()
						   ->where(['empcode' => $ecode])
							->one();
			if($modelFront->consolidated_status == 'No'){
				return $this->redirect(['update', 'id' => $modelFront->id]);
			}else{
				Yii::$app->session->setFlash('error', 'Already consolidated. ');
				return $this->redirect('login');
			}
		}
    }
	
	public function actionVerifyecode(){
		#echo "<pre>";print_r($_POST);echo "</pre>";
		#exit;
		$selection	=	$_POST['selection'];
		foreach($selection as $res){		
			
			#### EMP DETAILS UPDATE #############
			$model 							=  	EmpDetailsFront::findOne($res);
			$modelback						=	EmpDetails::find()->where(['empcode' => $model->empcode])->one();			
			$modelbackemp					=	EmpDetails::findOne($modelback->id);
			$modelbackemp->attributes		=	$model->attributes;
			$modelbackemp->id 				=	$modelback->id;
			$modelbackemp->verify_status	=	'Yes';
			$modelbackemp->save();
			$model->verify_status			=	'Yes';
			$model->save();
			#### EMP DETAILS UPDATE #############
			
			#### PERSONAL DETAILS UPDATE #############		
			
			$personalfrontmodel = EmpPersonaldetailsfront::find()->where(['empid' => $model->id])->one();
			$personalbackmodel  = EmpPersonaldetails::find()->where(['empid' => $modelbackemp->id])->one();
			#echo $modelbackemp->id;
			#echo "<pre>";print_r($personalbackmodel);echo "</pre>";
			#exit;
						
			$personalfrontmodel2	=	EmpPersonaldetailsfront::findOne($personalfrontmodel->id);
			$personalbackmodel2		=	EmpPersonaldetails::findOne($personalbackmodel->id);			
			$personalbackmodel2->attributes	=	$personalfrontmodel2->attributes;
			$personalbackmodel2->id			=	$personalbackmodel->id;
			$personalbackmodel2->empid		=	$personalbackmodel->empid;
			$personalbackmodel2->save(false);
			
			#### PERSONAL DETAILS UPDATE #############	
			
			#### ADDRESS DETAILS UPDATE #############			
			$empaddressfrontmodel = EmpAddressFront::find()->where(['empid' => $model->id])->one();
			$empaddressbackmodel  = EmpAddress::find()->where(['empid' => $modelbackemp->id])->one();
			
			$empaddressfrontmodel2					=	EmpAddressFront::findOne($empaddressfrontmodel->id);
			$empaddressbackmodel2					=	EmpAddress::findOne($empaddressbackmodel->id);			
			$empaddressbackmodel2->attributes		=	$empaddressfrontmodel2->attributes;
			$empaddressbackmodel2->id				=	$empaddressbackmodel->id;
			$empaddressbackmodel2->empid			=	$empaddressbackmodel->empid;			
			$empaddressbackmodel2->save(false);
			#### ADDRESS DETAILS UPDATE #############	
			
			#### FAMILY DETAILS UPDATE #############			
			$empfamilyfrontmodel = EmpFamilydetailsFront::find()->where(['empid' => $model->id])->one();
			$empfamilybackmodel  = EmpFamilydetails::find()->where(['empid' => $modelbackemp->id])->one();
			
			$empfamilyfrontmodel2					=	EmpFamilydetailsFront::findOne($empfamilyfrontmodel->id);
			$empfamilybackmodel2					=	EmpFamilydetails::findOne($empfamilybackmodel->id);
			$empfamilybackmodel2->attributes		=	$empfamilyfrontmodel2->attributes;
			$empfamilybackmodel2->id				=	$empfamilybackmodel->id;
			$empfamilybackmodel2->empid				=	$empfamilybackmodel->empid;	
			$empfamilybackmodel2->save(false);
			#### FAMILY DETAILS UPDATE #############	
			
			#### EDUCATION DETAILS UPDATE #############			
			$empedufrontmodel = EmpEducationdetailsFront::find()->where(['empid' => $model->id])->one();
			$empedubackmodel  = EmpEducationdetails::find()->where(['empid' => $modelbackemp->id])->one();
			
			$empedufrontmodel2						=	EmpEducationdetailsFront::findOne($empedufrontmodel->id);
			$empedubackmodel2						=	EmpEducationdetails::findOne($empedubackmodel->id);
			$empedubackmodel2->attributes			=	$empedufrontmodel2->attributes;
			$empedubackmodel2->id					=	$empedubackmodel->id;
			$empedubackmodel2->empid				=	$empedubackmodel->empid;	
			$empedubackmodel2->save(false);
			#### EDUCATION DETAILS UPDATE #############	
			
			#### CERTIFICATES DETAILS UPDATE #############			
			/*$empcertificatefrontmodel = EmpCertificatesFront::find()->where(['empid' => $model->id])->one();
			$empcertificatebackmodel  = EmpCertificates::find()->where(['empid' => $modelbackemp->id])->one();
			
			$empcertificatefrontmodel2				=	EmpCertificatesFront::findOne($empcertificatefrontmodel->id);
			$empcertificatebackmodel2				=	EmpCertificates::findOne($empcertificatebackmodel->id);
			$empcertificatebackmodel2->attributes	=	$empcertificatefrontmodel2->attributes;
			$empcertificatebackmodel2->id			=	$empcertificatebackmodel->id;
			$empcertificatebackmodel2->empid		=	$empcertificatebackmodel->empid;	
			$empcertificatebackmodel2->save(false);*/
			#### CERTIFICATES DETAILS UPDATE #############	
			
			#### BANK DETAILS UPDATE #############			
			$empbankfrontmodel = EmpBankdetailsFront::find()->where(['empid' => $model->id])->one();
			$empbankbackmodel  = EmpBankdetails::find()->where(['empid' => $modelbackemp->id])->one();
			
			$empbankfrontmodel2						=	EmpBankdetailsFront::findOne($empbankfrontmodel->id);
			$empbankbackmodel2						=	EmpBankdetails::findOne($empbankbackmodel->id);
			
			
			  $modelBankRef = new EmpBankdetails();
			  $oldBankIds = EmpBankdetails::find()->select('id')->where(['empid' => $modelbackemp->id])->asArray()->all();
			  $oldBankIds = ArrayHelper::getColumn($oldBankIds, 'id');
			  
			  $modelBankRefFront = new EmpBankdetailsFront();
			  $oldBankIdsFront = EmpBankdetailsFront::find()->select('id')->where(['empid' => $model->id])->asArray()->all();
			  $oldBankIdsFront = ArrayHelper::getColumn($oldBankIdsFront, 'id');

			  $modelback = EmpBankdetails::findAll(['id' => $oldBankIds]);
			  $modelback = (empty($modelback)) ? [new EmpBankdetails] : $modelback;
			  
			  $modelFront = EmpBankdetailsFront::findAll(['id' => $oldBankIdsFront]);
			  $modelFront = (empty($modelFront)) ? [new EmpBankdetailsFront] : $modelFront;

			  $modelBank = Model::createMultiple(EmpBankdetails::classname(), $modelback);
			  $modelBankfront = Model::createMultiple(EmpBankdetailsFront::classname(), $modelFront);
			  if (Model::loadMultiple($modelBankfront, $empbankfrontmodel2->attributes)) {
				 $newBankIds = ArrayHelper::getColumn($modelBank, 'id');

				 $delBankIds = array_diff($oldBankIds, $newBankIds);
				 if (!empty($delBankIds))
					EmpBankdetails::deleteAll(['id' => $delBankIds]);

				 $transaction = \Yii::$app->db->beginTransaction();
				 try {
					foreach ($modelBankfront as $modelBankfront) { /* save Certificate */
					
						#$empbankbackmodel2->attributes			=	$empbankfrontmodel2->attributes;
						#$empbankbackmodel2->id					=	$empbankbackmodel->id;
						$modelBnk->attributes			=	$modelBankfront->attributes;
						$modelBnk->empid = $modelbackemp->id;
					   if (!($flag = $modelBnk->save())) {
						  $transaction->rollBack();
						  break;
					   }
					}
					if ($flag) {
					   $transaction->commit();
					   #return $this->redirect(['previous_employment', 'id' => $id]);
					}
				 } catch (Exception $e) {
					$transaction->rollBack();
				 }
			  }
			
			/*
			$empbankbackmodel2->attributes			=	$empbankfrontmodel2->attributes;
			$empbankbackmodel2->id					=	$empbankbackmodel->id;
			$empbankbackmodel2->empid				=	$empbankbackmodel->empid;	
			$empbankbackmodel2->save(false);*/
			
			#### BANK DETAILS UPDATE #############	
			
			#### PREVIOUS EMPLOYMENT DETAILS UPDATE #############			
			$empprevempfrontmodel = PreviousEmploymentFront::find()->where(['empid' => $model->id])->one();
			$empprevempbackmodel  = PreviousEmployment::find()->where(['empid' => $modelbackemp->id])->one();
			
			$empprevempfrontmodel2					=	PreviousEmploymentFront::findOne($empprevempfrontmodel->id);
			$empprevempbackmodel2					=	PreviousEmployment::findOne($empprevempbackmodel->id);
			$empprevempbackmodel2->attributes		=	$empprevempfrontmodel2->attributes;
			$empprevempbackmodel2->id				=	$empprevempbackmodel->id;
			$empprevempbackmodel2->empid			=	$empprevempbackmodel->empid;	
			$empprevempbackmodel2->save(false);
			#### PREVIOUS EMPLOYMENT DETAILS UPDATE #############	
			
			return $this->redirect(['index']);
		}
		
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
                     $employer_pf = 1950;
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
					 $modelPer->passportvalid = NULL; 
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
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Date of Joining');
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
                     $employer_pf = 1950;
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
					if($modelemployee && !empty($excelrow['Qualification'])) {					
						$quali = Qualification::find()->where(['LIKE','qualification_name',$excelrow['Qualification']])->one();						
						if(EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>$quali->id])->exists()) {
							 $edumodel = EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>$quali->id])->one();
						} else if(EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>NULL])->exists()) {
							$edumodel = EmpEducationdetails::find()->where(['empid' => $modelemployee->id,'qualification'=>NULL])->one();
						} else {
						  $edumodel = new EmpEducationdetails();
						}
						
						 $course = strtolower(str_replace(' ', '', $excelrow['Course']));
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

   
   public function actionUpdate($id) {
		$model = EmpDetailsFront::findOne($id);
		
		if($model->consolidated_status == 'No'){	  
		  if($model->photo)
		  $photoname = $model->photo;
		  else
		  $photoname = '';
	  
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
			   $model->status = 'Relieved';
			  } else {
			  $model->dateofleaving =NULL;
			  $model->status = 'Active';
			  }
			  
			  if($model->confirmation_date && $model->confirmation_date != '0000-00-00' && $model->confirmation_date != '1970-01-01'){
			  $model->confirmation_date = Yii::$app->formatter->asDate($model->confirmation_date, "yyyy-MM-dd");
			  } else {
			  $model->confirmation_date =NULL;
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
			 return $this->redirect(['personal-details', 'id' => $model->id]);
		  } else {
			 return $this->render('employee_form', [
						 'model' => $model,
			 ]);
		  }
		}else{
			Yii::$app->session->setFlash('success', 'Successfully updated!!!.');	
			return $this->redirect(['login']);  
		}
   }

   public function actionRemuneration($id) {
      $model = EmpRemunerationDetails::find()->where(['empid' => $id])->one();
      $Emp = EmpDetails::findOne($id);
	  $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
		
      if ($model->load(Yii::$app->request->post())) {
				$model->empid = $id;
		
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
				
                  if ( $model->pf_applicablity == 'Yes') {
                     $model->employer_pf_contribution = 1950;
                  } else {
                     $model->employer_pf_contribution = 0;
                  }
		 
		 
	    if ($model->pli == 'NA' || empty($model->pli)) {
            $model->pli = NULL;
         }
		 
         $model->ctc = $model->gross_salary + $model->employer_pli_contribution + $model->employer_medical_contribution + $model->employer_lta_contribution + $model->employer_esi_contribution + $model->employer_pf_contribution;
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
		 echo "<option value='WL5'>WL4</option>";
		 echo "<option value='WL5'>WL3</option>";
		 echo "<option value='WL5'>WL2</option>";
		 echo "<option value='WL5'>WL1</option>";
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
	  $modelEmployeeFront = EmpDetailsFront::findOne($id);
	  if($modelEmployeeFront->consolidated_status == 'No'){
		  $model = EmpPersonaldetailsFront::find()->where(['empid' => $id])->one();
		  $addressModel = EmpAddressFront::find()->where(['empid' => $id])->one();
		  $oldsiblingIds = EmpFamilydetailsFront::find()->select('id')->where(['empid' => $id])->asArray()->all();
		  $oldsiblingIds = ArrayHelper::getColumn($oldsiblingIds, 'id');

		  $modelSiblings = EmpFamilydetailsFront::findAll(['id' => $oldsiblingIds]);
		  $modelSiblings = (empty($modelSiblings)) ? [new EmpFamilydetailsFront] : $modelSiblings;
		  
		  /*if(isset($_POST))
			$post = Yii::$app->request->post();
		  else
			$post = ''; */  
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

			 $modelSiblings = Model::createMultiple(EmpFamilydetailsFront::classname(), $modelSiblings);
			 Model::loadMultiple($modelSiblings, Yii::$app->request->post());
			 $newsiblingIds = ArrayHelper::getColumn($modelSiblings, 'id');

			 $delsiblingIds = array_diff($oldsiblingIds, $newsiblingIds);
			 if (!empty($delsiblingIds))
				EmpFamilydetailsFront::deleteAll(['id' => $delsiblingIds]);

			 $valid = $model->validate();
		   //  $valid = Model::validateMultiple($modelSiblings) && $valid;

			 if ($valid) {
				$transaction = \Yii::$app->db->beginTransaction();
				try {

				   $model->empid = $id;
				   if ($flag = $model->save()) {
					  $addressModel->empid = $id;
					  $addressModel->save(false);

					  foreach ($modelSiblings as $modelSibl) { // save Siblings 
						 $modelSibl->birthdate = Yii::$app->formatter->asDate($modelSibl->birthdate, "yyyy-MM-dd");
						 #$modelSibl->empid = $model->id;
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
		  }else {
			 return $this->render('personaldetails_form', [
						 'model' => $model,
						 'addressModel' => $addressModel,
						 'modelSibling' => (empty($modelSiblings)) ? [new EmpFamilydetailsFront] : $modelSiblings,
			 ]);
		  }
		}else{
				Yii::$app->session->setFlash('success', 'Successfully updated!!!.');	
				return $this->redirect(['login']);  
		}
   }

   public function actionEducationDetails($id) {
	  $modelEmployeeFront = EmpDetailsFront::findOne($id);
	  if($modelEmployeeFront->consolidated_status == 'No'){
		  $modelEduRef = new EmpEducationdetailsFront();
		  $oldEduIds = EmpEducationdetailsFront::find()->select('id')->where(['empid' => $id])->asArray()->all();
		  $oldEduIds = ArrayHelper::getColumn($oldEduIds, 'id');

		  $model = EmpEducationdetailsFront::findAll(['id' => $oldEduIds]);
		  $model = (empty($model)) ? [new EmpEducationdetailsFront] : $model;

		  $modelEducation = Model::createMultiple(EmpEducationdetailsFront::classname(), $model);
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
						 'modelEducation' => (empty($model)) ? [new EmpEducationdetailsFront] : $model,
			 ]);
		  }
		}else{
			Yii::$app->session->setFlash('success', 'Successfully updated!!!.');	
			return $this->redirect(['login']);  
		}
   }
   
   public function actionCertificatesDetails($id) {
	  $modelEmployeeFront = EmpDetailsFront::findOne($id);
	  if($modelEmployeeFront->consolidated_status == 'No'){
		  $modelCerRef = new EmpCertificatesFront();
		  $oldCerIds = EmpCertificatesFront::find()->select('id')->where(['empid' => $id])->asArray()->all();
		  $oldCerIds = ArrayHelper::getColumn($oldCerIds, 'id');

		  $model = EmpCertificatesFront::findAll(['id' => $oldCerIds]);
		  $model = (empty($model)) ? [new EmpCertificatesFront] : $model;

		  $modelCertificates = Model::createMultiple(EmpCertificatesFront::classname(), $model);
		  if (Model::loadMultiple($modelCertificates, Yii::$app->request->post())) {
			 $newCerIds = ArrayHelper::getColumn($modelCertificates, 'id');

			 $delCerIds = array_diff($oldCerIds, $newCerIds);
			 if (!empty($delCerIds))
				EmpCertificatesFront::deleteAll(['id' => $delCerIds]);

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
						 'modelCertificate' => (empty($model)) ? [new EmpCertificatesFront] : $model,
						 'model' => $modelCerRef,
			 ]);
		  }
	  }else{
		  Yii::$app->session->setFlash('success', 'Successfully updated!!!.');	
		  return $this->redirect(['login']);  
	  }
   }
  
   public function actionBankDetails($id) {
	  $modelEmployeeFront = EmpDetailsFront::findOne($id);
	  if($modelEmployeeFront->consolidated_status == 'No'){
		  $modelBankRef = new EmpBankdetailsFront();
		  $oldBankIds = EmpBankdetailsFront::find()->select('id')->where(['empid' => $id])->asArray()->all();
		  $oldBankIds = ArrayHelper::getColumn($oldBankIds, 'id');

		  $model = EmpBankdetailsFront::findAll(['id' => $oldBankIds]);
		  $model = (empty($model)) ? [new EmpBankdetailsFront] : $model;

		  $modelBank = Model::createMultiple(EmpBankdetailsFront::classname(), $model);
		  if (Model::loadMultiple($modelBank, Yii::$app->request->post())) {
			 $newBankIds = ArrayHelper::getColumn($modelBank, 'id');

			 $delBankIds = array_diff($oldBankIds, $newBankIds);
			 if (!empty($delBankIds))
				EmpBankdetailsFront::deleteAll(['id' => $delBankIds]);

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
				   return $this->redirect(['previous_employment', 'id' => $id]);
				}
			 } catch (Exception $e) {
				$transaction->rollBack();
			 }
		  } else {
			 return $this->render('bank_form', [
						 'modelBank' => (empty($model)) ? [new EmpBankdetailsFront] : $model,
						 'model' => $modelBankRef,
			 ]);
		  }
	  }else{
		  Yii::$app->session->setFlash('success', 'Successfully updated!!!.');	
		  return $this->redirect(['login']);  
	  }
   }

   public function actionPrevious_employment($id) {
      $modelEmploymentRef = new PreviousEmploymentFront();	 
	  $modelEmployeeFront 	= EmpDetailsFront::findOne($id);
	  $modelback 			= EmpDetails::find()->where(['empcode' => $modelEmployeeFront->empcode])->one();	  
	  #echo "<pre>";print_r($_POST);echo "</pre>";
	  #exit;
	  if($modelEmployeeFront->consolidated_status == 'No'){
		  $oldemployementIds = PreviousEmploymentFront::find()->select('id')->where(['empid' => $id])->asArray()->all();
		  $oldemployementIds = ArrayHelper::getColumn($oldemployementIds, 'id');

		  $model = PreviousEmploymentFront::findAll(['id' => $oldemployementIds]);
		  $model = (empty($model)) ? [new PreviousEmploymentFront] : $model;

		  $modelEmployment = Model::createMultiple(PreviousEmploymentFront::classname(), $model);
		  if (Model::loadMultiple($modelEmployment, Yii::$app->request->post())) {
			 $newemployementIds = ArrayHelper::getColumn($modelEmployment, 'id');

			 $delEmploymentIds = array_diff($oldemployementIds, $newemployementIds);
			 if (!empty($delEmploymentIds))
				PreviousEmploymentFront::deleteAll(['id' => $delEmploymentIds]);


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
					#echo "<pre>";print_r($_POST);echo "</pre>";
					#echo "</br> consolidated_status: ".$_POST['consolidated_status'];
					#exit;
					$flag = $Employment->save();
					$modelEmployeeFront->consolidated_status	=	$_POST['consolidated_status'];
					$modelEmployeeFront->save();
					
					$modelback->consolidated_status	=	$_POST['consolidated_status'];
					$modelback->save();
					#echo "</br>consolidated_status: ".$modelEmployeeFront->consolidated_status;
					#exit;
				  if (!($flag)) {		
					  $transaction->rollBack();
					  break;
				   }
				}
				if ($flag) {
				   $transaction->commit();
				   if($modelEmployeeFront->consolidated_status == 'Yes'){
					Yii::$app->session->setFlash('success', 'Successfully updated!!!.');
					return $this->redirect(['login']);
				   }
				   else
					return $this->redirect(['previous_employment', 'id' => $id]);
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
	  }else{		 
		Yii::$app->session->setFlash('success', 'Successfully updated!!!.');				
		return $this->redirect(['login']);  
	  }
   }
 
   public function actionStatutoryDetails($id) {
      $model = EmpStatutorydetails::find()->where(['empid' => $id])->one();

      $post = Yii::$app->request->post();
      if ($model->load(Yii::$app->request->post())) {
         $model->empid = $id;
         $model->save(false);
         return $this->redirect(['previous_employment', 'id' => $id]);
      } else {
         return $this->render('statutory_form', [
                     'model' => $model,
         ]);
      }
   }


   public function actionDelete($id) {      
	  
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
      $modelemployment =  PreviousEmployment::find()->where(['empid' => $id])->one();
	  $modelemployment->delete();
      

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
         $model->save(false);
      }
      return $this->render('appointment_letter', [
                  'model' => $model,
      ]);
   }

}

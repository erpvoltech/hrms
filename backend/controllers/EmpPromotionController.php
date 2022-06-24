<?php

namespace backend\controllers;

use Yii;
use common\models\EmpPromotion;
use app\models\EmpPromotionSearch;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\Designation;
use app\models\ImportExcel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\MailForm;
use yii\helpers\Html;
use yii\filters\AccessControl;
use common\components\AccessRule;
use app\models\AuthAssignment;
use common\models\MailCc;
error_reporting(0);
/**
 * EmpPromotionController implements the CRUD actions for EmpPromotion model.
 */
class EmpPromotionController extends Controller {

   /**
    * {@inheritdoc}
    */
	
	
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
							'actions' => ['index','view','import-promotion','promotion-mail','promotion-index','promotion-create','mail-config','config-delete','mailconfig-index','promotion-export'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','update'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create','promotion','employee'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('payroll', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','delete'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'delete');									 
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
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'delete' => ['POST'],
              ],
          ],
      ];
   }*/

   
   public function actionIndex() {
      $searchModel = new EmpPromotionSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
                  'searchModel' => $searchModel,
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionPromotion() {
      $model = new EmpPromotion();

      if ($model->load(Yii::$app->request->post())) {
         $created_at = date('Y-m-d H:i:s');
         $model->effectdate = '01-' . $model->effectdate;
         $model->user = Yii::$app->user->id;
         $model->createdate = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
         $model->effectdate = Yii::$app->formatter->asDate($model->effectdate, "yyyy-MM-dd");
         $empmodel = EmpDetails::find()->where(['id' => $model->empid])->one();        
         $model->ss_from = $empmodel->remuneration->salary_structure;
         $model->wl_from = $empmodel->remuneration->work_level;
         $model->grade_from = $empmodel->remuneration->grade;
         $model->gross_from = $empmodel->remuneration->gross_salary;
         $model->designation_from = $empmodel->designation_id;
		 $model->flag =1;
		 $model->email_flag = 1;

        /* if ($empmodel->remuneration->grade == $model->grade_to) {
            if ($empmodel->remuneration->work_level == $model->wl_to) {
               Yii::$app->session->addFlash("error", ' Same Grade Selected');
            }
         } else {
		
		  $model->flag =1;
            $model->save(false);
            return $this->redirect('index');
         } */
		 
		     $model->flag =1;
             $model->save(false);
			 return $this->redirect('index');
      }
      return $this->render('promotion_form', [
                  'model' => $model,
      ]);
   }
   
    public function actionImportPromotion() {
      $model = new ImportExcel();
	   if ($model->load(Yii::$app->request->post())) {
			$model->uploadtype =1; // Not important for this model but required for validation(this refer common model ImportExcel)
			$model->uploaddata =1; // Not important for this model but required for validation(this refer common model ImportExcel)
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
		  $connection = \Yii::$app->db;
		 $countrow = 0;
         $startrow = 1;
         $totalrow = count($data);
		 $flagrow =0;
		 
		 $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {
			   $flagrow =0;
			    if (empty($excelrow['Emp. Code'])) {                 
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Employee Code Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  } 
				 
				if(empty($excelrow['Status'])){
					 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Promotion Status Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
				} 
				  
				  
				if(!empty($excelrow['Effective Date']) && $excelrow['Effective Date'] !='01-01-1970' && $excelrow['Effective Date'] !='1970-01-01'){
						$doe = Yii::$app->formatter->asDate($excelrow['Effective Date'], "yyyy-MM-dd");
				   $regex = '/^(^[1-9][0-9-]*)$/';
				   if(!preg_match( $regex, $doe ) ) {											 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Change Effective Date Format ');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				} else {					 
				 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: DEffective Date');
				 $startrow++;
				 $countrow +=1;
				 continue;
				 }
				  
				  $uniquecolumn = EmpPromotion::find()->joinWith(['employee'])->where(['emp_details.empcode' => $excelrow['Emp. Code'],'flag'=>1])->one();
				  
                  if ($uniquecolumn) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Ecode Already Exists');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }	
				   $empmodel = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();
				 
				 /*  if(!empty($empmodel->remuneration->salary_structure) && $empmodel->remuneration->salary_structure != 'Consolidated pay' && $empmodel->remuneration->salary_structure != 'Contract' && $empmodel->remuneration->salary_structure != 'Conventional' && $empmodel->remuneration->salary_structure != 'Modern') {
				    if($empmodel->remuneration->grade == $excelrow['New Grade'] && $empmodel->remuneration->work_level == $excelrow['New Work Level'] && $empmodel->remuneration->salary_structure == $excelrow['New Salary Structure'] && $empmodel->designation->designation == $excelrow['New Designation']) {
						$flagrow=1; 
					}
				   } else if(!empty($empmodel->remuneration->salary_structure) || $empmodel->remuneration->salary_structure == 'Consolidated pay' || $empmodel->remuneration->salary_structure == 'Conventional' || $empmodel->remuneration->salary_structure == 'Modern' ) {				  
					if($excelrow['Current SS'] != 'Contract'){
					if (($empmodel->remuneration->gross_salary == $excelrow['New Gross'] && $empmodel->designation->designation == $excelrow['New Designation']) || (empty($excelrow['New Gross']) && (empty($excelrow['New Designation'])))){					
						$flagrow=1;
						}
					}
				   } */
				   
				   
					if($flagrow == 0){
						if(empty($excelrow['New Gross'])){
							$newgrows = NULL;
						} else {
							$newgrows = $excelrow['New Gross'];
						}	
						
						if(empty($excelrow['New Designation'])){
							$designation = NULL;
						} else {
						    $design = Designation::find()->where(['designation' => $excelrow['New Designation']])->one();
							$designation = $design->id;
						}	
						
						if(empty($excelrow['New Work Level'])){
							$wl = NULL;
						} else {
							$wl = $excelrow['New Work Level'];
						}
						
						if(empty($excelrow['New Salary Structure'])){
							$ss = NULL;
						} else {
							$ss = $excelrow['New Salary Structure'];
						}
						
						if(empty($excelrow['New Grade'])){
							$grade = NULL;
						} else {
							$grade = $excelrow['New Grade'];
						}
						
						if(empty($excelrow['New PLI'])){
							$pli = NULL;
						} else {
							$pli = $excelrow['New PLI'];
						}
						
						 $created_at = date('Y-m-d H:i:s');
						 $promomodel = new EmpPromotion();				     
						 $promomodel->user = Yii::$app->user->id;
						 $promomodel->empid = $empmodel->id;
						 $promomodel->createdate = Yii::$app->formatter->asDate($created_at, "yyyy-MM-dd");
						 $promomodel->effectdate = Yii::$app->formatter->asDate($excelrow['Effective Date'], "yyyy-MM-dd");					        
						
						 $promomodel->ss_from = $empmodel->remuneration->salary_structure;
						 $promomodel->wl_from = $empmodel->remuneration->work_level;
						 $promomodel->grade_from = $empmodel->remuneration->grade;
						 $promomodel->gross_from = $empmodel->remuneration->gross_salary;
						 $promomodel->designation_from = $empmodel->designation_id;
						 $promomodel->pli_from = $empmodel->remuneration->pli;
						 
						if($excelrow['Status'] == 'Promotion'){
							 $promomodel->type =1;
						} else if($excelrow['Status'] == 'Increment'){
							 $promomodel->type =2;
						} else if($excelrow['Status'] == 'Confirmation'){
							 $promomodel->type =3;							
						}
						
						 $promomodel->ss_to = $ss;
						 $promomodel->wl_to = $wl;
						 $promomodel->grade_to = $grade;
						 $promomodel->gross_to = $newgrows;
						 $promomodel->designation_to = $designation;
						 $promomodel->pli_to = $pli;
						 $promomodel->flag =1;
						 $promomodel->email_flag = 1;
						 
						 $promomodel->save(false);						
						 
						 $startrow++;
					}				    
			   }
			   
			   if ($countrow == 0) {
                  $transaction->commit();
				  unlink($fileName);
                  $insertrows = $startrow - 1;
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
	   return $this->render('index');
	   }
	   return $this->render('import-promotion', [
                  'model' => $model,
      ]);
	}
   

	public function actionPromotionExport() {
      return $this->render('promotion-export');
   }
 
   public function actionEmployee() {
      if ($post = Yii::$app->request->post()) {
         $model = new EmpPromotion();
         $user = $post['EmpPromotion']['searchuser'];
         $empmodel = EmpDetails::find()->where(['empcode' => $user])
                 ->orWhere(['empname' => $user])
                 ->one();
         if ($empmodel) {
            return $this->redirect(['promotion', 'model' => $model, 'id' => $empmodel->id, 'user' => $user]);
         } else {
            return $this->redirect(['promotion', 'model' => $model, 'user' => $user]);
         }
      }
   }

   public function actionView($id) {
      return $this->render('view', [
                  'model' => $this->findModel($id),
      ]);
   }

   public function actionCreate() {
      $model = new EmpPromotion();

      if($model->load(Yii::$app->request->post())){		  
			$model->flag =1;
			$model->save();
			return $this->redirect(['view', 'id' => $model->id]);
       }
      return $this->render('create', [
                  'model' => $model,
      ]);
   }

   public function actionUpdate($id) {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post())) {
         $model->effectdate = '01-' . $model->effectdate;
         $model->effectdate = Yii::$app->formatter->asDate($model->effectdate, "yyyy-MM-dd");
         $empmodel = EmpDetails::find()->where(['id' => $model->empid])->one();
         if ($empmodel->remuneration->grade == $model->grade_to) {
            if ($empmodel->remuneration->work_level == $model->wl_to) {
               Yii::$app->session->addFlash("error", ' Same Grade Selected');
            }
         } else {
            $model->save();
            return $this->redirect('index');
         }
      }

      return $this->render('update', [
                  'model' => $model,
      ]);
   }

   public function actionDelete($id) {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }

   protected function findModel($id) {
      if (($model = EmpPromotion::findOne($id)) !== null) {
         return $model;
      }	  

      throw new NotFoundHttpException('The requested page does not exist.');
   }
   
   public function actionPromotionIndex(){      
    return $this->render('promotion-index');
   }
   
    public function actionPromotionCreate(){      
    return $this->render('editor-promotion');
   }
   
   public function actionPromotionMail() {
   $sent_mail_flag=0;
   $mailmodel = new MailForm();
   $data = Yii::$app->request->post();
   $result_success = [];
   $result_failure = [];
   foreach($data['keylist'] as $key){
	$cc=[];
	$bcc=[];
	$sendCC ='';
	$sendBCC = '';
    $model = $this->findModel($key);
	$Emp = EmpDetails::find()->where(['id' => $model->empid])->one();
	$EmpPersonal = EmpPersonaldetails::find()->where(['empid' => $Emp->id])->one();
	
	$modelCC = MailCc::find()->where(['unit'=>$Emp->unit_id,'division'=>$Emp->division_id])->all();
	foreach($modelCC as $mailcc){
		if($mailcc->cc !=''){
		$Empmail_cc = EmpDetails::find()->where(['id' => $mailcc->cc])->one();
			$cc[]=$Empmail_cc->email;
		}
		if($mailcc->bcc !=''){
		$Empmail_bcc = EmpDetails::find()->where(['id' => $mailcc->bcc])->one();
			$bcc[]=$Empmail_bcc->email;
		}
	}
	
	if($EmpPersonal->gender == 'Male') {
		$salutation ='Mr. ';
		} elseif($EmpPersonal->gender == 'Female') {
		$salutation ='Ms. ';
		} else {
		$salutation = 'Dear ';
	}		
					
		if($model->type == 1) { 	 
			$DesignationFrom = Designation::find()->where(['id'=>$model->designation_from])->one();
			$DesignationTo = Designation::find()->where(['id'=>$model->designation_to])->one();				
			
			
			$document_letter ='<br></br>
			
			<p>&nbsp;</p>
			
			<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
			<strong>'.$DesignationFrom->designation.'</strong><br>
			
			<p>&nbsp;</p>
			<p><strong>Sub:</strong> Job Promotion &#x2010; Reg.</p>
			<p>&nbsp;</p>
			<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
			
			<p>&nbsp;</p>
			
			<p>With high appreciations, The Management would like to inform that, you have been promoted to the post of &ldquo;<strong>'.$DesignationTo->designation.'</strong>&rdquo; under <strong>'.$model->wl_to.' '.$model->grade_to.'</strong>. 
			This promotion is a result of the passion and commitment you have been exhibiting in your existing role. Your revised remuneration shall be as per the Annexure &lt;&lt;<strong><a href="http://hrms.voltechgroup.com/backend/web/emp-details/staffsalaryannexure?id='.$Emp->id.'"> click here </a></strong>&gt;&gt; with effect from <strong>'.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</strong>.  </p>
			
			<p>You shall be responsible for the establishment, in keeping with all terms and conditions of your earlier appointment order dated <strong>'.Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy").' </strong>.
			We appreciate the efforts put in by you and expect that you would continue to do so in the future.</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			<p>Regards,</p>
			<p>For <strong>VOLTECH Engineers Private Limited,</strong></p>
			<p><strong>On Behalf of the Managing Director,</strong></p>
			<p><strong>TEAM VEPL HRD </strong></p>';
			//and your previous improvement letter dated '.Yii::$app->formatter->asDate($Emp->recentdop, "dd-MM-yyyy").'
		} else if($model->type == 2) {
			
			$Designation = Designation::find()->where(['id'=>$Emp->designation_id])->one();
	   			
			$document_letter ='<br></br>
			
			
			<p>&nbsp;</p>
			
			<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
			<strong>'.$Designation->designation.'</strong><br>
			
			<p>&nbsp;</p>
			<p><strong>Sub:</strong> Increment in the Remunerations &#x2010; Reg.</p>
			<p>&nbsp;</p>
			<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
			
			<p>&nbsp;</p>
			
			<p>With high appreciations, The Management would like to inform that, your remunerations has been hiked to Work Level <strong>'.$model->wl_to.' '.$model->grade_to.'</strong>. This Increment is a result of the passion and commitment you have been exhibiting in your existing role.</p>

			<p>Your revised remuneration shall be as per the annexure  &lt;&lt;<strong><a href="http://hrms.voltechgroup.com/backend/web/emp-details/staffsalaryannexure?id='.$Emp->id.'"> click here </a></strong>&gt;&gt; with effect from <strong>'.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</strong>. </p>

			<p>You shall be responsible for the establishment, in keeping with all terms and conditions of your earlier appointment order dated <strong>'.Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy").'</strong> and your earlier improvement letter dated <strong>'.Yii::$app->formatter->asDate($Emp->recentdop, "dd-MM-yyyy").'</strong>. </p>

			<p>We appreciate the efforts put in by you and expect that you would continue to do so in the future.</p>
			
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			<p>Regards,</p>
			<p>For <strong>VOLTECH Engineers Private Limited,</strong></p>
			<p><strong>On Behalf of the Managing Director,</strong></p>
			<p><strong>TEAM VEPL HRD </strong></p>';				
		} else if($model->type == 3) {
		
			if(!empty($model->designation_to)){
				$DesignationTo = Designation::find()->where(['id'=>$model->designation_to])->one();	
			} else{
				$DesignationTo = Designation::find()->where(['id'=>$Emp->designation_id])->one();
			}
			$DesignationFrom = Designation::find()->where(['id'=>$model->designation_from])->one();
			
			//<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</b></p>
			
			$document_letter ='<br></br>
			
			
			<p>&nbsp;</p>
			
			<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
			<strong>'.$DesignationFrom->designation.'</strong><br>
			
			<p>&nbsp;</p>
			<p><strong>Sub:</strong> Confirmation and Promotion of Job &#x2010; Reg.</p>
			<p>&nbsp;</p>
			<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
			
			<p>&nbsp;</p>
			<p>With high appreciations, The Management would like to inform that, you have been confirmed and Promoted to the post of &ldquo;<strong>'.$DesignationTo->designation.'&rdquo;</strong>. This confirmation is a result of careful appraisal of your performance during your probation period and the promotion is awarded for the passion and commitment you have been exhibiting in your existing role.</p> 

			<p>Your revised remuneration shall be as per the Annexure  &lt;&lt;<strong><a href="http://hrms.voltechgroup.com/backend/web/emp-details/staffsalaryannexure?id='.$Emp->id.'"> click here </a></strong>&gt;&gt; with effect from <strong>'.Yii::$app->formatter->asDate($model->effectdate, "dd-MM-yyyy").'</strong>. </p>

			<p>You shall be responsible for the establishment, in keeping with all terms and conditions of your earlier appointment order dated <strong>'.Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy").'</strong>. </p>

			<p>We appreciate the efforts put in by you and expect that you would continue to do so in the future.</p>

			
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			<p>Regards,</p>
			<p>For <strong>VOLTECH Engineers Private Limited,</strong></p>
			<p><strong>On Behalf of the Managing Director,</strong></p>
			<p><strong>TEAM VEPL HRD </strong></p>';
		} 	
			if(!empty($cc)){			
				$sendCC =$cc;
			}
			if(!empty($bcc)){
				$sendBCC = $bcc;
			}
		
		 $mailmodel->from = "hrd@voltechgroup.com";
		 $mailmodel->password = "Welcome@123";
         $mailmodel->fromName = 'VEPL HRD';
         $mailmodel->subject = 'Job Appraisal '.date("Y").' - Reg';
		
         $mailmodel->body = $document_letter;
	
		
		if($model->email_flag == 1){
			if ($mailmodel->MailWithMultCC($Emp->email,$sendCC,$sendBCC)) {
            $model->email_flag = 2;
            $model->save(false);
			$sent_mail_flag=1;
			}		     
		} 	
	}	
	
	if($sent_mail_flag == 1){	
		 Yii::$app->session->setFlash("success", ' Successfully Sent your message');
		return $this->redirect('promotion-index');
	} else {
		 Yii::$app->session->setFlash("success", 'Message Not Send'); 
	} 	  
   }
  public function actionMailConfig() {
  
   $model = new MailCc();

      if($model->load(Yii::$app->request->post())){ 
	  foreach($model->cc as $key => $val){
		  $modelcc = new MailCc();
		   $modelcc->unit = $model->unit; 
		   $modelcc->division = $model->division;
		   $modelcc->cc =$val;
		   if($model->bcc[$key] != " "){
			   $modelcc->bcc =$model->bcc[$key];
		  }
		   $modelcc->save();
		}	
	  return $this->redirect('mail-config');
	  }
      return $this->render('mail-config', [
                  'model' => $model,
      ]);
	
  }
  
  public function actionMailconfigIndex() {
      return $this->render('mailconfig-index');	
  }
  
  public function actionConfigDelete($id) {
      MailCc::findOne($id)->delete();
	    return $this->redirect('mail-config');
  }

}

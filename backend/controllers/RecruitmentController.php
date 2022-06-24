<?php

namespace backend\controllers;

use Yii;
use DateTime;
use common\components\AccessRule;
#use common\models\User;
use app\models\Recruitment;
use app\models\RecruitmentSearch;
use app\models\CallletterSearch;
use app\models\RecruitmentprocessSearch;
use app\models\RecruitmentBatch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\UploadTextFile;

use arogachev\excel\import\basic\Importer;
use app\models\ImportExcel;
use PHPExcel;
use yii\web\UploadedFile;

use app\models\AuthAssignment;
use common\models\MailForm;
/**
 * RecruitmentController implements the CRUD actions for Recruitment model.
 */
class RecruitmentController extends Controller
{
    /**
     * @inheritdoc
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
							'actions' => ['index','view','import','export','export_template','move_uploaded_file','sendcallletter','recruitmentprocess'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('recruitment', 'view');
									 #return Yii::$app->authAssignment->Rights('recruitment', 'view');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','update','batchstore','batchcreate','import','export','export_template','move_uploaded_file','sendcallletter','recruitmentprocess'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('recruitment', 'update');
									 #return Yii::$app->authAssignment->Rights('recruitment', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create','batchstore','batchcreate','import','export','export_template','move_uploaded_file','sendcallletter','recruitmentprocess'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('recruitment', 'create');
											#return Yii::$app->authAssignment->Rights('recruitment', 'create');
								 },
							//'roles' => ['@create'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','delete','export','import','export','export_template','move_uploaded_file','sendcallletter','recruitmentprocess'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('recruitment', 'delete');
									 #return Yii::$app->authAssignment->Rights('recruitment', 'delete');
								 },
							'roles' => ['@'],
						],
						// everything else is denied
					],
				],
			];
       }
	 
	 
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all Recruitment models.
     * @return mixed
     */
    public function actionIndex()
    {	
		 
        /*$dataProvider = new ActiveDataProvider([
            'query' => Recruitment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);*/
		
		$searchModel = new RecruitmentSearch();		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize	=	50;        
		return $this->render('index', [
					  'searchModel' => $searchModel,
					  'dataProvider' => $dataProvider,
		]);
    }

    /**
     * Displays a single Recruitment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionBatchcreate()
    {
        $model = new RecruitmentBatch();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         //   return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('batchcreate', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionBatchstore()
    {         
        $model = new RecruitmentBatch();      
        return $this->renderAjax('batchstore', [
                'model' => $model,
            ]);
    }
	
	   
    public function actionCreate()
    {
        $model = new Recruitment();

        if ($model->load(Yii::$app->request->post())) {
			
			$model->resume = UploadedFile::getInstance($model, 'resume');
		  
            if ($model->resume != '') {
				$model->upload();
				$model->resume = $model->resume->baseName . '.' . $model->resume->extension;               
            }
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }	
	
	public function actionImport()
    {
        $model = new importExcel();
		#echo "<pre>";print_r(Yii::$app->request->post());echo "</pre>";
		if ($model->load(Yii::$app->request->post())) {
         $connection = \Yii::$app->db;
         $model->file = UploadedFile::getInstance($model, 'file');
			#echo "hi ".$model->file;
			# exit;
         if ($model->file) {			 
            $model->file->saveAs('recruitment/' . $model->file->baseName . '.' . $model->file->extension);
            $fileName = 'recruitment/' . $model->file->baseName . '.' . $model->file->extension;
         }
         $data = \moonland\phpexcel\Excel::widget([
                     'mode' => 'import',
                     'fileName' => $fileName,
                     'setFirstRecordAsKeys' => true,
         ]);

         $countrow 		=	0;
         $startrow 		= 	2;
		 $importedrow	=	0;
         $totalrow 		= 	count($data);
		 #echo "upload type: ".$model->uploadtype;
		 

         if ($model->uploadtype == 1) {
            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {                 

                  if (empty($excelrow['register_no'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Register Number Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if (empty($excelrow['type'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Recruitment Type Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
				  #echo "</br>Name: ".$excelrow['name'];
                  if (empty($excelrow['name'])) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Name Column Empty');
                     $startrow++;
                     $countrow +=1;	
					 #echo "</br>Name empty";
					 #exit;
                     continue;
                  }
				  
				 # echo "<br> register_no: ".$excelrow['register_no'];
				  
                  $uniquecolumn = Recruitment::find()->where(['register_no' => $excelrow['register_no']])->count();
                 
				  if ($uniquecolumn > 0) {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Register Number Already Exists');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }    
				  
				  if (empty($excelrow['email'])) {
                    Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Email Empty');
                    $startrow++;
                    $countrow +=1;
                    continue;
                  }

					$uniquemail = Recruitment::find()->where(['email' => $excelrow['email']])->one();
					if ($uniquemail) {
						 Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Email id Already Exists');
						 $startrow++;
						 $countrow +=1;
						 continue;
					}    

                  $batch = strtolower(str_replace(' ', '', $excelrow['batch']));
                  $batchid = Yii::$app->db->createCommand("SELECT id FROM recruitment_batch WHERE LOWER(replace(batch_name ,' ',''))='" . $batch . "'")->queryOne();
                  if ($batchid)
                     $batchdata_id = $batchid['id'];
                  else
                     $batchdata_id = 'NULL';
				 
					#echo "batchdata_id: ".$batchdata_id;
					#exit;
				 #echo "</br> name: ".$excelrow['name'];
                  $modelRec = new Recruitment();
                  $modelRec->register_no = $excelrow['register_no'];
                  $modelRec->type = $excelrow['type'];
                  $modelRec->batch_id = $batchdata_id;
                  $modelRec->name = $excelrow['name'];
                  $modelRec->qualification = $excelrow['qualification'];
                  $modelRec->specialization = $excelrow['specialization'];
                  $modelRec->year_of_passing = $excelrow['year_of_passing'];
                  #$modelRec->year_of_passing = Yii::$app->formatter->asDate($excelrow['year_of_passing'], "yyyy");
				  $modelRec->selection_mode = $excelrow['source'];
				  $modelRec->referred_by 	= $excelrow['referred_by'];
				  #$modelRec->other_selection_mode = $excelrow['other_selection_mode'];
				  $modelRec->position = $excelrow['position'];
				  $modelRec->contact_no = $excelrow['contact_no'];
				  $modelRec->email = $excelrow['email'];
				  $modelRec->community = $excelrow['community'];
				  $modelRec->caste = $excelrow['caste'];
				  $modelRec->status = $excelrow['status'];
				  #$modelRec->rejected_reason = $excelrow['rejected_reason']; 
					#echo "</br> name: ".$excelrow['name'];
					#exit;				  
                  $modelRec->save(false);  
				  $importedrow++;	
				  $startrow++;				  
				} 
						if ($countrow == 0) {
						  $transaction->commit();
						  $insertrows = $startrow - 1;
						  Yii::$app->session->setFlash("success", $importedrow . ' rows had been imported');
						}
					
				} catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
        }
		 
		 if ($model->uploadtype == 2) {
            $transaction = $connection->beginTransaction();
            try {
               foreach ($data as $key => $excelrow) {                  

                  if ($excelrow['register_no'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Register Number Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if ($excelrow['type'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Recruitment Type Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                  if ($excelrow['name'] == ' ') {
                     Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error: Name Column Empty');
                     $startrow++;
                     $countrow +=1;
                     continue;
                  }
                                 

                  $batch = strtolower(str_replace(' ', '', $excelrow['batch']));
                  $batchid = Yii::$app->db->createCommand("SELECT id FROM recruitment_batch WHERE LOWER(replace(batch_name ,' ',''))='" . $batch . "'")->queryOne();
					if ($batchid)
                     $batchdata_id = $batchid['id'];
					else
                     $batchdata_id = 'NULL';
				 
					#echo "batchdata_id: ".$batchdata_id;
					#exit;
				 
                  $modelrecruitment = Recruitment::find()->where(['register_no' => $excelrow['register_no']])->one();
                  if ($modelrecruitment) {
                  $modelrecruitment->register_no = $excelrow['register_no'];
                  $modelrecruitment->type = $excelrow['type'];
                  $modelrecruitment->batch_id = $batchdata_id;
                  $modelrecruitment->name = $excelrow['name'];
                  $modelrecruitment->qualification = $excelrow['qualification'];
                  $modelrecruitment->specialization = $excelrow['specialization'];
                  $modelrecruitment->year_of_passing = $excelrow['year_of_passing'];
                  #$modelrecruitment->year_of_passing = Yii::$app->formatter->asDate($excelrow['year_of_passing'], "yyyy");
				  $modelrecruitment->selection_mode = $excelrow['source'];
				  $modelrecruitment->referred_by 	= $excelrow['referred_by'];
				  #$modelrecruitment->other_selection_mode = $excelrow['other_selection_mode'];
				  $modelrecruitment->position = $excelrow['position'];
				  $modelrecruitment->contact_no = $excelrow['contact_no'];
				  $modelrecruitment->email = $excelrow['email'];
				  $modelrecruitment->caste = $excelrow['caste'];
				  $modelrecruitment->status = $excelrow['status'];
				  #$modelrecruitment->rejected_reason = $excelrow['rejected_reason'];  
					
				  $modelrecruitment->save(); 
				  $importedrow++;
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
					  Yii::$app->session->setFlash("success", $importedrow . ' rows had been affected');
				    }				  
				} catch (\Exception $e) {
               $transaction->rollBack();
               throw $e;
            } catch (\Throwable $e) {
               $transaction->rollBack();
               throw $e;
            }
         }		 
		}
		
		return $this->render('import-recruitment', [
                  'model' => $model,
      ]);
	}
	
    /**
     * Updates an existing Recruitment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post())) {
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			if(empty($model->process_status)){
				$model->process_status	=	NULL;
			}
			$model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionExport() {
		/*$searchModel = new RecruitmentSearch();		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('export', [
					  'searchModel' => $searchModel,
					  'dataProvider' => $dataProvider,
		]);*/
		return $this->render('export');
	}
	
	public function actionExport_template() {
      return $this->render('export_template');
	}

    /**
     * Deletes an existing Recruitment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionSendcallletter(){
		
		$model = new MailForm();
		#&& $_POST['sendcallletter'] == 'Send Call Letter'
        if(isset($_POST['sendcallletter']) ) {
			
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			$recsel	=	$_POST['selection'];
			foreach($recsel as $res){
				$recModel			=	Recruitment::findOne($res);
				$toMail				=	$recModel->email;
				#echo $toMail;
				#exit;
				if($_POST['CallletterSearch']['mail_option']	==	'sendmail'){
					$model->body	=	$_POST['CallletterSearch']['callletter'];
					$model->subject	=	'INTERVIEW CALL LETTER @ VOLTECH ENGINEERS PRIVATE LIMITED - Reg.';
					#echo "</br> toMail: ".$toMail;
					#exit;
					#$Salmodel = EmpSalary::findOne($id);
					#$ModelEmp = EmpDetails::find()->where(['id'=>$Salmodel->empid])->one();
					$model->from = "careers@voltechgroup.com";
                                        $model->password 	= "ya74qs";
					$model->fromName = 'Careers';
					if ($model->sendEmail($toMail)) {
						Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
						$recModel->callletter_status = 1;
						$recModel->save(false);
					} else {
						Yii::$app->session->setFlash('error', 'There was an error sending your message.');
					}				
				}elseif($_POST['CallletterSearch']['mail_option'] == 'alreadysent'){
					Yii::$app->session->setFlash('success', 'Successfully updated the Callletter Status. ');
					$recModel->callletter_status =1;
					$recModel->save(false);
				}
			}			
			return $this->redirect('sendcallletter');
        }
		
		
		#$searchModel = new CallletterSearch();		
		#$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$searchModel = new CallletterSearch();		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$callletter_content	=	'<p style="font-family: "Book Antiqua";">Greetings,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
											<p style="font-family: "Book Antiqua";">&nbsp;</p>
											<p style="font-family: "Book Antiqua";">We extend our warmest wishes from <strong>VOLTECH Engineers Private Limited</strong>!!!</p>
											<p style="font-family: "Book Antiqua";">&nbsp;</p>
											<p style="font-family: "Book Antiqua";">In furtherance to our discussion, we are pleased to invite you to our <strong>VOLTECH CORPORATE OFFICE</strong> on <strong>14<sup>th</sup> of December 2018</strong> &nbsp;at 08:30 AM for an interaction with our selection panel and subsequently on <strong>16<sup>th</sup> of December 2018</strong> &nbsp;as well at 08:30 AM for an <strong>final interaction</strong> with our Managing Director.</p>
											<p style="font-family: "Book Antiqua";">&nbsp;</p>
											<p style="font-family: "Book Antiqua";"><strong><u>Note</u></strong><strong>:</strong></p>
											<p style="font-family: "Book Antiqua";"><strong>&nbsp;</strong></p>
											<ul style="font-family: "Book Antiqua";">
											<li>Kindly bring a copy of this Interview Call Letter, your updated Resume and 1 photograph.&nbsp;</li>
											<li>You are expected to be present in formal attire (i.e.) full shirt &amp; trouser, shoes and professional hair &amp; beard style.</li>
											<li>Kindly ensure your arrival at the venue 30 Minutes prior to the scheduled time.</li>
											<li>Refreshments will be served, however lunch will not be provided.</li>
											</ul>
											<p style="font-family: "Book Antiqua";">&nbsp;</p>
											<p style="font-family: "Book Antiqua";">To know more about the organization, visit our website <a href="http://www.voltechgroup.com">www.voltechgroup.com</a>.</p>
											<p style="font-family: "Book Antiqua";">For clarifications / on arrival, kindly report to the undersigned.</p>
											<p style="font-family: "Book Antiqua";">&nbsp;</p>
											<p style="font-family: "Book Antiqua";"><strong>WITH BEST WISHES,</strong></p>
											<p style="font-family: "Book Antiqua";"><strong>V.Raja Santosh Kumar</strong></p>
											<p style="font-family: "Book Antiqua";"><strong>Asst. Manager &ndash; HR (Recruitment)</strong></p>
											<p style="font-family: "Book Antiqua";"><strong>VOLTECH Engineers Private Limited</strong><strong>|VOLTECH Eco Tower|Regd &amp; Corporate Office|No.2/429, Mount Poonamalle Road|Ayyappanthangal|Chennai &ndash; 600056. (Landmark: Adjacent to Indian Oil Fuel Station)</strong></p>
											<p style="font-family: "Book Antiqua";"><strong>Mob : +91-9940518844 | Ext: 287 | Tel : +91-44-43978000 | Fax : +91-44-</strong><strong>42867746 </strong><strong>| E-Mail : </strong><a href="mailto:careers@voltechgroup.com"><strong>careers@voltechgroup.com</strong></a></p>
											<p style="font-family: "Book Antiqua";"><strong><em><u>Please Save Paper</u></em> - before you print this e-mail, think of the environment Prevent Pollution at the Source!!!</strong></p>';
		
		$searchModel->callletter	=	$callletter_content;

        return $this->render('callletter', [
            'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
	}
	
	public function actionRecruitmentprocess(){
		$searchModel = new RecruitmentprocessSearch();		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$model	=	new Recruitment;
		if(isset($_POST['recruitmentprocess']) ) {
			
			#echo "<pre>";print_r($_POST);echo "</pre>";
			#exit;
			$recsel	=	$_POST['selection'];
			foreach($recsel as $res){
				$recModel							=	Recruitment::findOne($res);	
				$recModel->process_status			=	$_POST['RecruitmentprocessSearch']['process_status'];
				$recModel->process_statusremarks	=	$_POST['process_statusremarks'];
				$recModel->save(false);
			}			
		}
		
		return $this->render('recruitmentprocess', [
            'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
        ]);
	}	

    /**
     * Finds the Recruitment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recruitment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recruitment::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
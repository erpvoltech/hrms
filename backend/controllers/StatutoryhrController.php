<?php
	
	namespace backend\controllers;
	
	use Yii;
	use yii\base\Model;
	use common\models\EmpDetails;
	use common\models\StatutoryHr;
	use common\models\StatutoryEsi;
	use common\models\EmpSalary;
	use common\models\EmpRemunerationDetails;
	use common\models\EmpStatutorydetails;
	use common\models\PfList;
	use common\models\EsiList;
	use app\models\PfListSearch;
	use app\models\EsiListSearch;
	use app\models\StatutoryHrSearch;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use yii\web\UploadedFile;
	
	use yii\filters\AccessControl;
	use common\components\AccessRule;
	use app\models\AuthAssignment;
	use app\models\EmpSearch;
	use common\models\EmpDetailsSearch;
	use app\models\NonuanSearch;
	
	class StatutoryhrController extends Controller
	{
		
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
			'actions' => ['non-uan','index','view','challan-all','download','downloadtxt','exportesi','pflist','epfreport','epfsearch','esireport','esisearch', 'pf_list_txt', 'esiindex', 'esilist', 'loadesidata', 'esi-challan-all'],
			'allow' => true,
			'matchCallback' => function ($rule, $action) {
				return AuthAssignment::Rights('statutoryhr', 'view');									 
			},
			'roles' => ['@'],
			],
			
			[
			'allow' => true,
			'actions' => ['pflist','index','update','download','downloadtxt','trrnno','exportesi'],
			'allow' => true,
			'matchCallback' => function ($rule, $action) {
				return AuthAssignment::Rights('statutoryhr', 'update');
			},
			'roles' => ['@'],
			],
			
			[
			'allow' => true,
			'actions' => ['pflist','index','create','upload','download','downloadtxt','trrnno','exportesi','trrn_no'],
			'allow' => true,
			'matchCallback' => function ($rule, $action) {
				return AuthAssignment::Rights('statutoryhr', 'create');
			},
			'roles' => ['@'],
			],
			
			[
			'allow' => true,
			'actions' => ['pflist','index','delete','download','downloadtxt','trrnno','exportesi','list-delete'],
			'allow' => true,
			'matchCallback' => function ($rule, $action) {
				return AuthAssignment::Rights('statutoryhr', 'delete');									 
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
		
		public function actionIndex()
		{
			$searchModel = new StatutoryHrSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			]);
		}
		
		public function actionPflist()
		{
			$searchModel = new PfListSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			return $this->render('pf_list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			]);
		}
		
		public function actionChallanAll($id)
		{
			$model = StatutoryHr::findOne($id);
			if($model){
				return $this->render('challan-all', [ 
				'model'=>$model,
				]);
				} else {
				Yii::$app->session->setFlash("error", 'data not found');
			}  
		}
		
		public function actionListDelete($id)
		{
			$delmodel = StatutoryHr::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction(); 
			try {
				$del = PfList::deleteAll('list_id = :list_id', [':list_id' => $delmodel->id]);
				$delmodel->delete();            
				$transaction->commit();
				error_log(date("d-m-Y g:i:s a ") ." PF LIST & Trrn-no ".$delmodel->list_no.$delmodel->trrn_no." Deleted By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log");		 
				Yii::$app->session->setFlash("error", ' Deleted PF List No'.$delmodel->list_no);
				return $this->redirect(['index']);
				} catch (\Exception $e) {
				$transaction->rollBack();
				throw $e;
				} catch (\Throwable $e) {
				$transaction->rollBack();
				throw $e;
			}
			
			
		}
		
		
		public function actionTrrnno($id)
		{
			$model = StatutoryHr::findOne($id);
			if ($model->load(Yii::$app->request->post()) ) {
				//prepare model to save if necessary
				$model->save(false);
				return $this->redirect(['index']); //<---This would return to the gridview once model is saved
			}
			return $this->render('trrn_no', [
			'model' => $model,
			]);
		} 
		public function actionDownloadtxt($id)
		{	
			$model = StatutoryHr::findOne($id);
			if($model){
				return $this->render('pf_list_txt', [ 
				'model'=>$model,
				]);
				} else {
				Yii::$app->session->setFlash("error", 'data not found');
			}       
		}
		
		public function actionExportesi($month)
		{	
			$mon = '01-' . $month;
			return $this->render('export_esi', [ 
			'month'=>$mon,
            ]);		      
		}
		
		public function actionTest()
		{	
			echo 'Test';
		} 
		
		
		public function actionDownload($month,$unit,$div,$categ)
		{	
			
			$unitdata = explode(',',$unit);
			$divdata = explode(',',$div);
			$catdata = explode(',',$categ);
			
			$mon = '01-' . $month;	
			
			
			if($unit !=''){
				$sal = EmpSalary::find()->joinWith(['employee'])
				->where(['emp_salary.month'=>Yii::$app->formatter->asDate($mon, "yyyy-MM-dd")])
				->andWhere(['IN', 'emp_salary.unit_id', $unitdata])
				->andWhere(['IN', 'emp_salary.division_id', $divdata])
				->andWhere(['IN', 'emp_details.category', $catdata])
				->andWhere(['or',
				['emp_salary.revised'=>0],
				['emp_salary.revised'=>NULL]
				])
				->all();
				} else {
				$sal = EmpSalary::find()->where(['month'=>Yii::$app->formatter->asDate($mon, "yyyy-MM-dd")])	 
				->andWhere(['or',
				['revised'=>0],
				['revised'=>NULL]
				])
				->all();
			}	
			if($sal){
				return $this->render('export', [               
				'month' =>$mon,
				'salary'=>$sal,
				]); 
				} else {		 
				Yii::$app->session->setFlash("error", 'data not found');		  
			} 
		}
		
		/*public function actionUpload()
			{
			$model = new StatutoryHr(); 
			
			if ($model->load(Yii::$app->request->post()) && $model->validate(['month,file'])) {
			$model->month = '01-' . $model->month;
			
			$listNo = StatutoryHr::find()->where(['month'=>Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd")])->orderBy(['list_no' => SORT_DESC]) ->one();
			if($listNo){
			$pflistno = $listNo->list_no + 1;
			} else {
			$pflistno = 1;
			}
			
			
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
			$model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
			$model->list_no = $pflistno; 
			$model->save(false);
			$listid = Yii::$app->db->getLastInsertID();
			$countrow = 0;
			$startrow = 2;
			//$arrayinc =0;
			$result_error ='';
			foreach ($data as $key => $excelrow) {
			$list = new PfList();
			if($excelrow['UAN'] != '' && $excelrow['UAN'] != '#N/A'){
			$Empid = EmpStatutorydetails::find()->where(['epfuanno' => $excelrow['UAN']])->one();
			
			if($Empid){
			$list->list_id = $listid;
			$list->list_no = $pflistno; 
			$list->empid = $Empid->empid;
			$list->uanno = $excelrow['UAN'];
			$list->gross = $excelrow['GROSS WAGES'];
			$list->epf_wages = $excelrow['EPF WAGES'];
			$list->eps_wages = $excelrow['EPS WAGES'];
			$list->edli_wages = $excelrow['EDLI WAGES'];
			$list->epf_contri_remitted = $excelrow['EPF CONTRI REMITTED'];
			$list->eps_contri_remitted = $excelrow['EPS CONTRI REMITTED'];
			$list->epf_eps_diff_remitted = $excelrow['EPF EPS DIFF REMITTED'];
			$list->ncp_days = $excelrow['NCP DAYS'];
			$list->refund_of_advance = $excelrow['REFUND OF ADVANCES'];
			$list->save(false);			  
			} else {			  
			$countrow =1;		   
			$result_error .= 'Error in row ' . $startrow . 'User Not Found<br>';
			// $arrayinc++;
			}
			} else {
			$countrow =1;		   
			$result_error .= 'Error in row ' . $startrow . 'UAN Not found<br>';
			//$arrayinc++;
			}
			$startrow++;
			}
			
			if ($countrow == 0) {
			$transaction->commit();
			Yii::$app->session->setFlash("success",' Upload Success');
			} else {
			// foreach($result_error as $key => $error){
			Yii::$app->session->setFlash("error",$result_error);
			// }	
			}
			} catch (\Exception $e) {
            $transaction->rollBack();			
            throw $e;
			} catch (\Throwable $e) {
            $transaction->rollBack();
			Yii::$app->session->setFlash("error",' Upload Error');
            throw $e;
			} 
			
			
			} 
			
			return $this->render('export_form', [
			'model' => $model,
            ]);
			
		}*/
		
		public function actionUpload() {
			$model = new StatutoryHr();
			$esimodel = new StatutoryEsi();
			
			if ($model->load(Yii::$app->request->post()) && $model->validate(['month,file'])) {
				
				
				$model->month = '01-' . $model->month;
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
				if ($model->pfesi == 'pf') {
					
					$listNo = StatutoryHr::find()->where(['month' => Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd")])->orderBy(['list_no' => SORT_DESC])->one();
					if ($listNo) {
						$pflistno = $listNo->list_no + 1;
						} else {
						$pflistno = 1;
					}
					
					$transaction = \Yii::$app->db->beginTransaction();
					try {
						$model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
						$model->list_no = $pflistno;
						$model->save(false);
						$listid = Yii::$app->db->getLastInsertID();
						$countrow = 0;
						$startrow = 2;
						//$arrayinc =0;
						$result_error = '';
						foreach ($data as $key => $excelrow) {
							$list = new PfList();
							if ($excelrow['UAN'] != '' && $excelrow['UAN'] != '#N/A') {
								$Empid = EmpStatutorydetails::find()->where(['epfuanno' => $excelrow['UAN']])->one();
								
								if ($Empid) {
									$list->list_id = $listid;
									$list->list_no = $pflistno;
									$list->empid = $Empid->empid;
									$list->uanno = $excelrow['UAN'];
									$list->gross = $excelrow['GROSS WAGES'];
									$list->epf_wages = $excelrow['EPF WAGES'];
									$list->eps_wages = $excelrow['EPS WAGES'];
									$list->edli_wages = $excelrow['EDLI WAGES'];
									$list->epf_contri_remitted = $excelrow['EPF CONTRI REMITTED'];
									$list->eps_contri_remitted = $excelrow['EPS CONTRI REMITTED'];
									$list->epf_eps_diff_remitted = $excelrow['EPF EPS DIFF REMITTED'];
									$list->ncp_days = $excelrow['NCP DAYS'];
									$list->refund_of_advance = $excelrow['REFUND OF ADVANCES'];
									$list->save(false);
									} else {
									$countrow = 1;
									$result_error .= 'Error in row ' . $startrow . 'User Not Found<br>';
									// $arrayinc++;
								}
								} else {
								$countrow = 1;
								$result_error .= 'Error in row ' . $startrow . 'UAN Not found<br>';
								//$arrayinc++;
							}
							$startrow++;
						}
						
						if ($countrow == 0) {
							$transaction->commit();
							unlink($fileName);
							Yii::$app->session->setFlash("success", ' Upload Success');
							} else {
							// foreach($result_error as $key => $error){
							Yii::$app->session->setFlash("error", $result_error);
							// }
						}
						} catch (\Exception $e) {
						$transaction->rollBack();
						unlink($fileName);
						throw $e;
						} catch (\Throwable $e) {
						$transaction->rollBack();
						unlink($fileName);
						Yii::$app->session->setFlash("error", ' Upload Error');
						throw $e;
					}
					} else if ($model->pfesi == 'esi') {
					$esiListNo = StatutoryEsi::find()->where(['month' => Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd")])->orderBy(['esi_list_no' => SORT_DESC])->one();
					if ($esiListNo) {
						$esilistnum = $esiListNo->esi_list_no + 1;
						} else {
						$esilistnum = 1;
					}
					
					$transaction = \Yii::$app->db->beginTransaction();
					try {
						$esimodel->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
						$esimodel->esi_list_no = $esilistnum;
						$esimodel->save(false);
						$listid = Yii::$app->db->getLastInsertID();
						$countrow = 0;
						$startrow = 2;
						//$arrayinc =0;
						$result_error = '';
						foreach ($data as $key => $excelrow) {
							$list = new EsiList();
							if ($excelrow['IP Number'] != '' && $excelrow['IP Number'] != '#N/A') {
								$Empid = EmpStatutorydetails::find()->where(['esino' => $excelrow['IP Number']])->one();
								//print_r($Empid);
								$empSal = EmpSalary::find()->where(['empid' => $Empid['empid'], 'month' => $esimodel->month])->one();
								//echo $empSal->esi_employer_contribution;
								
								if ($Empid) {
									$list->esi_list_id = $listid;
									$list->esi_list_no = $esilistnum;
									$list->empid = $Empid->empid;
									$list->esino = $excelrow['IP Number'];
									$list->gross = $excelrow['GROSS WAGES'];
									$list->esi_employee_contribution = $excelrow['ESI AMT'];
									$list->esi_employer_contribution = $empSal->esi_employer_contribution;
									$list->save(false);
									} else {
									$countrow = 1;
									$result_error .= 'Error in row ' . $startrow . 'User Not Found<br>';
									// $arrayinc++;
								}
								} else {
								$countrow = 1;
								$result_error .= 'Error in row ' . $startrow . 'IP Number Not found<br>';
								//$arrayinc++;
							}
							$startrow++;
						}
						
						if ($countrow == 0) {
							$transaction->commit();
							unlink($fileName);
							Yii::$app->session->setFlash("success", ' Upload Success');
							} else {
							// foreach($result_error as $key => $error){
							Yii::$app->session->setFlash("error", $result_error);
							// }
						}
						} catch (\Exception $e) {
						$transaction->rollBack();
						unlink($fileName);
						throw $e;
						} catch (\Throwable $e) {
						$transaction->rollBack();
						unlink($fileName);
						Yii::$app->session->setFlash("error", ' Upload Error');
						throw $e;
					}
				}
				//exit;
			}
			
			return $this->render('export_form', [
			'model' => $model,
			]);
		}
		
		public function actionEpfsearch()    { 
			
			if ($post = Yii::$app->request->post()) {
				if (Yii::$app->request->post('statement') == 'submit') {
					$group = $post['SalaryStatementsearch']['unit_group'];
					$unit = $post['SalaryStatementsearch']['unit_id'];
					$month = $post['SalaryStatementsearch']['salarymonth'];
					$month = '01-' . $month;
					$month_date = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");
					return $this->redirect(['epfreport','group' => $group,'month'=>$month_date,'unit'=>$unit]);
					//return $this->redirect(['salary-statement','month'=>$month_date]);
					}  else {
					return $this->redirect(['epfreport']);	
				}
			}
		}
		
		public function actionEpfreport(){ 
			return $this->render('epfreport');	 
		}
		
		public function actionEsisearch()    { 		 
			if ($post = Yii::$app->request->post()) {
				if (Yii::$app->request->post('statement') == 'submit') {
					$group = $post['SalaryStatementsearch']['unit_group'];
					$unit = $post['SalaryStatementsearch']['unit_id'];
					$month = $post['SalaryStatementsearch']['salarymonth'];
					$month = '01-' . $month;
					$month_date = Yii::$app->formatter->asDate($month, "yyyy-MM-dd");
					return $this->redirect(['esireport','group' => $group,'month'=>$month_date,'unit'=>$unit]);
					//return $this->redirect(['salary-statement','month'=>$month_date]);
					}  else {
					return $this->redirect(['epfreport']);	
				}
			}
		}
		
		public function actionEsireport(){ 
			return $this->render('esireport');	 
		}
		public function actionNonUan(){ 
			$searchModel = new NonuanSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			return $this->render('non-uan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			]);
		}
		
		public function actionEsiindex() {
			return $this->render('esiindex');
		}
		
		public function actionEsilist() {
			$searchModel = new EsiListSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			return $this->render('esi_list', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			]);
		}
		
		public function actionLoadesidata($id) {
			$model = StatutoryEsi::findOne($id);
			if ($model) {
				return $this->render('esi_list_data', [
				'model' => $model,
				]);
				} else {
				Yii::$app->session->setFlash("error", 'data not found');
			}
		}
		
		public function actionEsiChallanAll($id) {
			$model = StatutoryEsi::findOne($id);
			if ($model) {
				return $this->render('esi-challan-all', [
				'model' => $model,
				]);
				} else {
				Yii::$app->session->setFlash("error", 'data not found');
			}
		}
		
		public function actionEsiListDelete($id) {
			$delmodel = StatutoryEsi::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				$del = EsiList::deleteAll('esi_list_id = :esi_list_id', [':esi_list_id' => $delmodel->id]);
				$delmodel->delete();
				$transaction->commit();
				error_log(date("d-m-Y g:i:s a ") . " ESI LIST " . $delmodel->esi_list_no . " Deleted by User --->" . Yii::$app->user->identity->username . "\n", 3, "user_update.log");
				Yii::$app->session->setFlash("error", ' Deleted ESI List No' . $delmodel->esi_list_no);
				return $this->redirect(['esiindex']);
				} catch (\Exception $e) {
				$transaction->rollBack();
				throw $e;
				} catch (\Throwable $e) {
				$transaction->rollBack();
				throw $e;
			}
		}
		
	}

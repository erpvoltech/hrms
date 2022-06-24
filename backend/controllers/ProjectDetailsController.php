<?php

namespace backend\controllers;

use Yii;
use common\models\ProjectDetails;
use app\models\ProjectDetailsSearch;
use common\models\CustomerContact;
use common\models\ProjectEmp;
use common\models\ProjectEmpAttendance;
use common\models\ProjectTracking;
use common\models\EmpDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json; 
use yii\web\UploadedFile;
use app\models\ProjectSalUpload;
use common\models\ProjectSalary;
use common\models\StatutoryRates;

class ProjectDetailsController extends Controller
{
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    
    public function actionIndex()
    {
        $searchModel = new ProjectDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionAssignEmp()
    {
		$model = new ProjectEmp(); 
		$modelAtt = new ProjectEmpAttendance();
		if ($model->load(Yii::$app->request->post())) {		 
			$Emp = EmpDetails::find()->Where(['empcode'=>$model->emp_id])->one();
			$model->emp_id = $Emp->id;
			$model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
		    $model->save();
			/*$modelAtt->project_emp_id = $Emp->id;
			$modelAtt->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
			$modelAtt->save(); */
            return $this->redirect(['view', 'id' => $model->project_id]);
        }
		return $this->renderAjax('assign-emp', [
            'model' => $model,
        ]);
    }
	
	public function actionViewDetails($id)
    {
		$model =ProjectEmp::findOne($id); 
		return $this->renderAjax('view-details', [
            'model' => $model,
        ]);
    }
	
	public function actionEmpEdit($id)
    {
		$model =ProjectEmp::findOne($id); 
		if ($model->load(Yii::$app->request->post())) {		 
			$Emp = EmpDetails::find()->Where(['empcode'=>$model->emp_id])->one();
			$model->emp_id = $Emp->id;
			$model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
		    $model->save();
			/*$modelAtt->project_emp_id = $Emp->id;
			$modelAtt->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
			$modelAtt->save();*/			
            return $this->redirect(['view', 'id' => $model->project_id]);
        }
		return $this->render('emp-edit', [
            'model' => $model,
        ]); 
    }
	
	public function actionEmpDelete($id)
    {
		$model =ProjectEmp::findOne($id); 
		$ProSalary = ProjectSalary::find()->where(['project_id'=>$model->project_id,'emp_id'=>$model->id])->one();
		if($ProSalary){		
		 Yii::$app->getSession()->setFlash('error', 'Salary Processed, Delete not accepted');
		 } else {		
			ProjectEmp::findOne($id)->delete();	
			Yii::$app->getSession()->setFlash('error',  'Deleted');			
		}
		 return $this->redirect(['view', 'id' => $model->project_id]); 
    }

    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {
        $model = new ProjectDetails();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {		
		    $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
		 $error =  $model->errors;
		 print_r($error);
		}

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	
	public function actionContacts()
    {	
		$out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id = $parents[0];                
				  $model = CustomerContact::find()->where(['customer_id' => $id])->all();					
					foreach ($model as $contact) {
						$out[] = ['id' => $contact->id, 'name' => $contact->contact_person];
					}				
                echo Json::encode(['output' => $out, 'selected' => '']);
            }
        }
    }

    
    public function actionDelete($id)
    {
		$model = ProjectSalary::find()->where(['project_id'=>$id])->one();	
		if($model){			
			Yii::$app->getSession()->setFlash('error', 'Salary Processed, Delete not accepted');
		} else {		
			$this->findModel($id)->delete();
			Yii::$app->getSession()->setFlash('error', 'Deleted');
		}
       return $this->redirect(['index']);
    }
	
	public function actionTrackingEdit($id)
	{

		  $model = ProjectTracking::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
				$model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
				if(!empty($model->attendance_division))
				$model->attendance_division = Yii::$app->formatter->asDate($model->attendance_division, "yyyy-MM-dd");
			if(!empty($model->attendance_send))
				$model->attendance_send = Yii::$app->formatter->asDate($model->attendance_send, "yyyy-MM-dd");
			if(!empty($model->prs_received))
				$model->prs_received = Yii::$app->formatter->asDate($model->prs_received, "yyyy-MM-dd");
			if(!empty($model->prs_send_division))
				$model->prs_send_division = Yii::$app->formatter->asDate($model->prs_send_division, "yyyy-MM-dd");
			if(!empty($model->docs_division))
				$model->docs_division = Yii::$app->formatter->asDate($model->docs_division, "yyyy-MM-dd");
			if(!empty($model->docs_send))
				$model->docs_send = Yii::$app->formatter->asDate($model->docs_send, "yyyy-MM-dd");	
				$model->save();

           return $this->redirect(['track-index', 'id' => $model->project_id]);
        }

        return $this->render('tracking-edit', [
            'model' => $model,
        ]);
	}
	
	public function actionTrackingDelete($id,$proj)
	{
		$model = ProjectTracking::findOne($id)->delete();
		 return $this->redirect(['track-index', 'id' => $proj]);
	}
	
	
	public function actionProjectTracking()
	{
		$model = new ProjectTracking();
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {

				$model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
				
				if(!empty($model->attendance_division))
				$model->attendance_division = Yii::$app->formatter->asDate($model->attendance_division, "yyyy-MM-dd");
				
				if(!empty($model->attendance_send))
				$model->attendance_send = Yii::$app->formatter->asDate($model->attendance_send, "yyyy-MM-dd");
				
				if(!empty($model->prs_received))
				$model->prs_received = Yii::$app->formatter->asDate($model->prs_received, "yyyy-MM-dd");
				
				if(!empty($model->prs_send_division))
				$model->prs_send_division = Yii::$app->formatter->asDate($model->prs_send_division, "yyyy-MM-dd");
				
				if(!empty($model->docs_division))
				$model->docs_division = Yii::$app->formatter->asDate($model->docs_division, "yyyy-MM-dd");
				
				if(!empty($model->docs_send))
				$model->docs_send = Yii::$app->formatter->asDate($model->docs_send, "yyyy-MM-dd");				
				$model->save();
				return $this->redirect(['index']);
			}
		}

		return $this->render('project-tracking', [
			'model' => $model,
		]);
	}
	
	public function actionTrackIndex($id)
	{
		$model = ProjectTracking::find()->where(['project_id'=>$id]);	
		return $this->render('track-index', [
			'model' => $model,
		]);
		
	}
	
	public function actionSalaryIndex($id)
	{
		$model = ProjectSalary::find()->where(['project_id'=>$id])->groupBy('month')->orderBy([           
            'month' => SORT_DESC,
        ]);	
		return $this->render('salary-index', [
			'model' => $model,
		]);		
	}
	
	public function actionSalaryView($id,$month)
	{			
		$model = ProjectSalary::find()->where(['project_id'=>$id,'month'=>$month]);	
		return $this->render('salary-view', [
			'model' => $model,
		]);	
	}
	
	public function actionAttView($id,$month)
	{			
		$model = ProjectEmpAttendance::find()->where(['project_id'=>$id,'month'=>$month]);	
		return $this->render('att-view', [
			'model' => $model,
		]);	
	}
	public function actionAttEdit($id)
	{			
		$model = ProjectEmpAttendance::findOne($id);
		if($model->load(Yii::$app->request->post())) {
			if($model->save()) {
			$salary =ProjectSalary::find()->where(['project_id'=>$model->project_id,'month' => $model->month,'emp_id'=>$model->project_emp_id])->one();			
			 $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
				 $salary ->basic_da 		= $salary->wages * $model->days;
				 
				 $earining  = $salary ->basic_da + $salary ->spacial_basic +  $salary->overtime_payment +  $salary ->hra  
				 + $salary->canteen_allowance + $salary->transport_allowance + $salary->washing_allowance;
				 
				// $salaryModel->other_allowance	= $Uploadsal->other_allowance;
				
				 $salary ->total 			= $earining + $salary ->other_allowance;
				 $salary ->pf 				= round($salary ->basic_da < 15000 ? $salary ->basic_da * ($pf_esi_rates->epf_ac_1_ee / 100) : 1800);
				 $salary ->esi 		= round($salary ->total < 21000 ? ceil(number_format(($salary ->total * ($pf_esi_rates->esi_ee / 100)), 2, '.', '')) : "");
				  
				 $salary ->deduction_total = $salary->pf + $salary->esi + $salary->society + $salary->income_tax + $salary ->insurance +$salary ->others +$salary ->recoveries;   
				 $salary ->netpayment 		= $salary ->total + $salary ->deduction_total;
				 $salary ->employer_pf 	= $salary ->pf;
				 $salary->save(false);
				   return $this->redirect(['att-view', 'id' => $model->project_id,'month' => $model->month]);
				 
			}		
		}
		return $this->render('att-edit', [
			'model' => $model,
		]);	
	}
	
	
	public function actionSalEdit($id,$month,$emp)
	{			
		$model = ProjectSalUpload::find()->where(['project_id'=>$id,'month' => $month,'project_emp_id'=>$emp])->one();
		 if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if($model->save()) {
			 $earining =0;
			$salary =ProjectSalary::find()->where(['project_id'=>$model->project_id,'month' => $model->month,'emp_id'=>$model->project_emp_id])->one();			
				 $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
				 
				 $salary ->wages		 	= $model->wage;
				 $salary ->overtime_hours 	= 0;
				 $salary ->basic_da 		= $model->wage * $salary->days;
				 $salary ->spacial_basic 	= $model->special_basic;
				 $salary->overtime_payment	= 0;
				 $salary ->hra 				= $model->hra;
				 $salary->canteen_allowance	= $model->canteen_allowance;
				 $salary->transport_allowance= $model->transport_allowance;
				 $salary->washing_allowance	= $model->washing_allowance;
				 
				 @$earining  = $salary->basic_da+$salary->spacial_basic+$salary->overtime_payment+$salary->hra+$salary->canteen_allowance+$salary->transport_allowance+$salary->washing_allowance;
				 
				 $salary->other_allowance	= $model->other_allowance;
				
				 @$salary ->total 			= $earining + $salary ->other_allowance;
				 $salary ->pf 				= round($salary ->basic_da < 15000 ? $salary ->basic_da * ($pf_esi_rates->epf_ac_1_ee / 100) : 1800);
				 $salary ->esi 				= round($salary ->total < 21000 ? ceil(number_format(($salary ->total * ($pf_esi_rates->esi_ee / 100)), 2, '.', '')) : "");
				
				 $salary ->society 			= $model->society;
				 $salary ->income_tax 		= $model->income_tax;
				 $salary ->insurance 		= $model->insurance;
				 $salary ->others 			= $model->others;
				 $salary ->recoveries 		= $model->recoveries;
				 
				 @$salary ->deduction_total = $salary->pf + $salary->esi + $salary->society + $salary->income_tax + $salary ->insurance +$salary ->others +$salary ->recoveries;   
				 $salary ->netpayment 		= $salary ->total + $salary ->deduction_total;
				 $salary ->employer_pf 	= $salary ->pf;
				 $salary->save(false);
				  return $this->redirect(['salary-view', 'id' => $model->project_id,'month' => $model->month]);
				 
			}		
		}
		return $this->render('sal-edit', [
			'model' => $model,
		]);	
	}
	
	public function actionExport($id,$month)
	{		
		//$model =ProjectDetails::findOne($id); 
		return $this->render('export', [
            'id' => $id,
			'month' => $month,
        ]);	
	}
	
	public function actionDashboardIr()
	{
		return $this->render('dashboard-ir');	
	}
	
	public function actionTemplateAtt($id)
	{
		$model =ProjectDetails::findOne($id); 
		return $this->render('template-att', [
            'model' => $model,
        ]);		
	}
	
	public function actionTemplateSal($id)
	{
		$model =ProjectDetails::findOne($id); 
		return $this->render('template-sal', [
            'model' => $model,
        ]);	
	}
	
	
	public function actionSal($id)
    {	
//	$model =ProjectDetails::findOne($id); 
		$model = new ProjectSalUpload();
		 if ($model->load(Yii::$app->request->post())) {
			 $model->file = UploadedFile::getInstance($model, 'file');
			 
			  $model->month = '01-' . $model->month;      
			 $model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
				
				 if ($model->file) {
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
				 
				   $transaction = \Yii::$app->db->beginTransaction();
						try {
							foreach ($data as $key => $excelrow) {
							  $upload = new ProjectSalUpload();
								if (!empty($excelrow['E Code'])) {
								   $Emp = EmpDetails::find()->where(['empcode' => $excelrow['E Code']])->one();
								     $projectEmp = ProjectEmp::find()->Where(['emp_id'=>$Emp->id,'project_id' => $id,'date_of_exit' => NULL])->one();
									 if($projectEmp){
									 $upload->project_id = $id;
									 $upload->month = $model->month;
									 $upload->project_emp_id =$projectEmp->id;
									 $upload->wage = $excelrow['Rate of Wages'];
									 $upload->special_basic = $excelrow['Special Basic'];
									 $upload->hra = $excelrow['HRA'];
									 $upload->canteen_allowance = $excelrow['Canteen Allowance'];
									 $upload->transport_allowance = $excelrow['Transport Allowance'];
									 $upload->washing_allowance = $excelrow['Washing Allowance'];
									 $upload->other_allowance = $excelrow['Others Allowance'];
									 $upload->society = $excelrow['Society'];
									 $upload->income_tax = $excelrow['Income Tax'];
									 $upload->insurance = $excelrow['Insurance'];
									 $upload->others = $excelrow['Others'];
									 $upload->recoveries = $excelrow['Recoveries'];
									 $upload->save(false);
									  } else {
									   $result_error .= 'Error in row ' . $startrow . 'Emp. Code Not found<br>';
									    $countrow =1;
									  }
							      } else {
								  $result_error .= 'Error in row ' . $startrow . 'Emp. Code Empty<br>';
								   $countrow =1;
								  }
								  $startrow++;
							 }
							 
							if ($countrow == 0) {
							   $transaction->commit();
							   Yii::$app->session->setFlash("success",$startrow-1 .' Rows Upload Success');
							} else {							
								 Yii::$app->session->setFlash("error",$result_error);							
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
		return $this->render('sal', [
            'model' => $model,
        ]);			
    }
	
	public function actionSalary($id)
	{		 
		  $model = new ProjectSalary();
		  if($model->load(Yii::$app->request->post())) {
			  $pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();
			  $projectEmp = ProjectEmp::find()->Where(['project_id'=>$id,'date_of_exit' => NULL])->all();
			  $model->month = '01-' . $model->month;      
			  $model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
			  foreach($projectEmp as $empproject){
				$earining = 0;
			     $salaryModel = new ProjectSalary();
				 $Uploadsal =ProjectSalUpload::find()->where(['project_id'=>$id,'month' => $model->month,'project_emp_id'=>$empproject->id])->one();
				 $Uploadatt =ProjectEmpAttendance::find()->where(['project_id'=>$id,'month' => $model->month,'project_emp_id'=>$empproject->id])->one();
				 $salaryModel ->project_id 		= $id;
				 $salaryModel ->month 			= $model->month;
				 $salaryModel ->emp_id 			= $empproject->id; 
				 $salaryModel ->wages		 	= $Uploadsal->wage;
				 $salaryModel ->days 			= $Uploadatt->days;
				 $salaryModel ->overtime_hours 	= NULL;
				 $salaryModel ->basic_da 		= $Uploadsal->wage * $Uploadatt->days;
				 $salaryModel ->spacial_basic 	= $Uploadsal->special_basic;
				 $salaryModel->overtime_payment	= NULL;
				 $salaryModel ->hra 			= $Uploadsal->hra;
				 $salaryModel->canteen_allowance= $Uploadsal->canteen_allowance;
				 $salaryModel->transport_allowance= $Uploadsal->transport_allowance;
				 $salaryModel->washing_allowance= $Uploadsal->washing_allowance;
				 
				 $earining  = $salaryModel ->basic_da + $salaryModel ->spacial_basic +  $salaryModel->overtime_payment +  $salaryModel ->hra  
				 + $salaryModel->canteen_allowance + $salaryModel->transport_allowance + $salaryModel->washing_allowance;
				 
				 $salaryModel ->other_allowance	= $Uploadsal->other_allowance;
				 $salaryModel ->total 			= $earining + $salaryModel ->other_allowance;
				 $salaryModel ->pf 				= round($salaryModel ->basic_da < 15000 ? $salaryModel ->basic_da * ($pf_esi_rates->epf_ac_1_ee / 100) : 1800);
				 $salaryModel ->esi 		= round($salaryModel ->total < 21000 ? ceil(number_format(($salaryModel ->total * ($pf_esi_rates->esi_ee / 100)), 2, '.', '')) : "");
				 $salaryModel ->society 		= $Uploadsal->society;
				 $salaryModel ->income_tax 		= $Uploadsal->income_tax;
				 $salaryModel ->insurance 		= $Uploadsal->insurance;
				 $salaryModel ->others 			= $Uploadsal->others;
				 $salaryModel ->recoveries 		= $Uploadsal->recoveries; 
				 $salaryModel ->deduction_total = $salaryModel->pf + $salaryModel->esi + $salaryModel->society + $salaryModel->income_tax + $salaryModel ->insurance +$salaryModel ->others +$salaryModel ->recoveries;   
				 $salaryModel ->netpayment 		= $salaryModel ->total + $salaryModel ->deduction_total;
				 $salaryModel ->employer_pf 	= $salaryModel ->pf;
				 $salaryModel->save(false);
				 }
		  } else {		  
		  return $this->render('salary', [
				'model' => $model,
			]);	
		  }
			
	}
	
	public function actionAtt($id)
    {
		$model = new ProjectEmpAttendance();
		 if ($model->load(Yii::$app->request->post())) {
			 $model->file = UploadedFile::getInstance($model, 'file');
			 
			  $model->month = '01-' . $model->month;      
			 $model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
				
				 if ($model->file) {
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
				 
				   $transaction = \Yii::$app->db->beginTransaction();
						try {
							 foreach ($data as $key => $excelrow) {
							  $upload = new ProjectEmpAttendance();
								if (!empty($excelrow['E Code'])) {
								   $Emp = EmpDetails::find()->where(['empcode' => $excelrow['E Code']])->one();
								     $projectEmp = ProjectEmp::find()->Where(['emp_id'=>$Emp->id,'project_id' => $id,'date_of_exit' => NULL])->one();
									 if($projectEmp){
									 $upload->project_id = $id;									
									 $upload->project_emp_id =$projectEmp->id;
								     $upload->month = $model->month;
									 $upload->days = $excelrow['Days'];
									 $upload->hours = $excelrow['Hours'];
									 $upload->day1_in = $excelrow['D1 IN'];
									 $upload->day1_out = $excelrow['D1 OUT'];
									 $upload->day2_in = $excelrow['D2 IN'];
									 $upload->day2_out = $excelrow['D2 OUT'];
									 $upload->day3_in = $excelrow['D3 IN'];
									 $upload->day3_out = $excelrow['D3 OUT'];
									 $upload->day4_in = $excelrow['D4 IN'];
									 $upload->day4_out = $excelrow['D4 OUT'];
									 $upload->day5_in = $excelrow['D5 IN'];
								     $upload->day5_out = $excelrow['D5 OUT'];
									 $upload->day6_in = $excelrow['D6 IN'];
									 $upload->day6_out = $excelrow['D6 OUT'];
									 $upload->day7_in = $excelrow['D7 IN']; 
									 $upload->day7_out = $excelrow['D7 OUT'];
									 $upload->day8_in = $excelrow['D8 IN']; 
									 $upload->day8_out = $excelrow['D8 OUT'];
									 $upload->day9_in = $excelrow['D9 IN']; 
									 $upload->day9_out = $excelrow['D9 OUT'];
									 $upload->day10_in = $excelrow['D10 IN'];
									 $upload->day10_out = $excelrow['D10 OUT'];
									 $upload->day11_in = $excelrow['D11 IN']; 
									 $upload->day11_out = $excelrow['D11 OUT'];
									 $upload->day12_in = $excelrow['D12 IN'];
									 $upload->day12_out = $excelrow['D12 OUT'];
									 $upload->day13_in = $excelrow['D13 IN'];
									 $upload->day13_out = $excelrow['D13 OUT'];
									 $upload->day14_in = $excelrow['D14 IN'];
									 $upload->day14_out = $excelrow['D14 OUT'];
									 $upload->day15_in = $excelrow['D15 IN'];
									 $upload->day15_out = $excelrow['D15 OUT'];
									 $upload->day16_in = $excelrow['D16 IN'];
									 $upload->day16_out = $excelrow['D16 OUT'];
									 $upload->day17_in = $excelrow['D17 IN'];
									 $upload->day17_out = $excelrow['D17 OUT'];
									 $upload->day18_in = $excelrow['D18 IN'];
									 $upload->day18_out = $excelrow['D18 OUT'];
									 $upload->day19_in = $excelrow['D19 IN'];
									 $upload->day19_out = $excelrow['D19 OUT'];
									 $upload->day20_in = $excelrow['D20 IN'];
									 $upload->day20_out = $excelrow['D20 OUT'];
									 $upload->day21_in = $excelrow['D21 IN'];
									 $upload->day21_out = $excelrow['D21 OUT'];
									 $upload->day22_in = $excelrow['D22 IN'];
									 $upload->day22_out = $excelrow['D22 OUT'];
									 $upload->day23_in = $excelrow['D23 IN'];
									 $upload->day23_out = $excelrow['D23 OUT'];
									 $upload->day24_in = $excelrow['D24 IN'];
									 $upload->day24_out = $excelrow['D24 OUT'];
									 $upload->day25_in = $excelrow['D25 IN'];
									 $upload->day25_out = $excelrow['D25 OUT'];
									 $upload->day26_in = $excelrow['D26 IN'];
									 $upload->day26_out = $excelrow['D26 OUT'];
									 $upload->day27_in = $excelrow['D27 IN'];
									 $upload->day27_out = $excelrow['D27 OUT'];
									 $upload->day28_in = $excelrow['D28 IN'];
									 $upload->day28_out = $excelrow['D28 OUT'];
									 $upload->day29_in = $excelrow['D29 IN'];
									 $upload->day29_out = $excelrow['D29 OUT'];
									 $upload->day30_in = $excelrow['D30 IN'];
									 $upload->day30_out = $excelrow['D30 OUT'];
									 $upload->day31_in = $excelrow['D31 IN'];
									 $upload->day31_out = $excelrow['D31 OUT'];
									 $upload->save(false);
									  } else {
									   $result_error .= 'Error in row ' . $startrow . 'Emp. Code Not found<br>';
									    $countrow =1;
									  }
							      } else {
								  $result_error .= 'Error in row ' . $startrow . 'Emp. Code Empty<br>';
								   $countrow =1;
								  }
								  $startrow++;
							 }
							 
							if ($countrow == 0) {
							   $transaction->commit();
							   Yii::$app->session->setFlash("success",$startrow-1 .' Rows Upload Success');
							} else {							
								 Yii::$app->session->setFlash("error",$result_error);							
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
		return $this->render('sal', [
            'model' => $model,
        ]);
    }
  
    
    protected function findModel($id)
    {
        if (($model = ProjectDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

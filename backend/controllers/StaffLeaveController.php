<?php

namespace backend\controllers;

use Yii;
use common\models\EmpLeaveStaff;
use app\models\ImportExcel;
use common\models\EmpDetails;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use common\components\AccessRule;
use app\models\AuthAssignment;


class StaffLeaveController extends Controller
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
							'actions' => ['index','view'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['update'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('payroll', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['delete'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'delete');									 
								 },
							'roles' => ['@'],
						],
						[
							'allow' => true,
							'roles' => ['@'],
						],
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
        $dataProvider = new ActiveDataProvider([
            'query' => EmpLeaveStaff::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

   
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {
        $model = new EmpLeaveStaff();

        if ($model->load(Yii::$app->request->post()) ) {
           $ModelEmp = EmpDetails::find()->where(['ecode' => $model->ecode])->one();
		   $model->empid = $ModelEmp->id;
		   $model->save();
		   return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	public function actionLeaveTemplateStaff()
	{	
		 return $this->renderpartial('leave-template-staff');		
	}
	
	public function actionImportleave()
    {
		$model = new importExcel(); 
		
	    if ($model->load(Yii::$app->request->post()) ) {		
		$model->file = UploadedFile::getInstance($model, 'file');
		
            if ($model->file) {                
                $model->file->saveAs('employee/' . $model->file->baseName . '.' . $model->file->extension);
				$fileName ='employee/'.$model->file->baseName. '.' . $model->file->extension;
            }
		
		$data = \moonland\phpexcel\Excel::widget([
		'mode' => 'import', 		
		'fileName' => $fileName,
 		'setFirstRecordAsKeys' => true,
		]);
		
		$countrow=0;
		$startrow=1;
			foreach($data as $key => $excelrow){			
			$ModelEmp = EmpDetails::find()->where(['empcode' => $excelrow['EmpCode']])->one();
			$empleave = EmpLeaveStaff::find()->where(['empid' => $ModelEmp->id])->one();
			
			if($excelrow['EmpCode'] ==''){
				Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error:ECode Missing');
					$startrow++;					
					$countrow +=1;	
					continue;
				}	
				
			 if ($empleave) {				
				$modelL = EmpLeaveStaff::findOne($empleave->id);					
				$modelL->empid = $ModelEmp->id;
				$modelL->eligible_first_quarter = $excelrow['Eligible I Quarter'];
				$modelL->eligible_second_quarter = $excelrow['Eligible II Quarter'];
				$modelL->eligible_third_quarter = $excelrow['Eligible III Quarter'];
				$modelL->eligible_fourth_quarter = $excelrow['Eligible IV Quarter'];
				$modelL->leave_taken_first_quarter = $excelrow['Leave Taken I Quarter'];
				$modelL->leave_taken_second_quarter = $excelrow['Leave Taken II Quarter'];
				$modelL->leave_taken_third_quarter = $excelrow['Leave Taken III Quarter'];				
				$modelL->leave_taken_fourth_quarter = $excelrow['Leave Taken IV Quarter'];
				$modelL->remaining_leave_first_quarter = $excelrow['Balance Leave I Quarter'];				
				$modelL->remaining_leave_second_quarter = $excelrow['Balance Leave II Quarter'];				
				$modelL->remaining_leave_third_quarter = $excelrow['Balance Leave III Quarter'];				
				$modelL->remaining_leave_fourth_quarter = $excelrow['Balance Leave IV Quarter'];				
				$modelL->save(false);
				$startrow++;  
				
				} else {				
	
				$Leavemodel = new EmpLeaveStaff();
				$Leavemodel->empid = $ModelEmp->id;
				$Leavemodel->eligible_first_quarter = $excelrow['Eligible I Quarter'];
				$Leavemodel->eligible_second_quarter = $excelrow['Eligible II Quarter'];
				$Leavemodel->eligible_third_quarter = $excelrow['Eligible III Quarter'];
				$Leavemodel->eligible_fourth_quarter = $excelrow['Eligible IV Quarter'];
				$Leavemodel->leave_taken_first_quarter = $excelrow['Leave Taken I Quarter'];
				$Leavemodel->leave_taken_second_quarter = $excelrow['Leave Taken II Quarter'];
				$Leavemodel->leave_taken_third_quarter = $excelrow['Leave Taken III Quarter'];				
				$Leavemodel->leave_taken_fourth_quarter = $excelrow['Leave Taken IV Quarter'];
				$Leavemodel->remaining_leave_first_quarter = $excelrow['Balance Leave I Quarter'];				
				$Leavemodel->remaining_leave_second_quarter = $excelrow['Balance Leave II Quarter'];				
				$Leavemodel->remaining_leave_third_quarter = $excelrow['Balance Leave III Quarter'];				
				$Leavemodel->remaining_leave_fourth_quarter = $excelrow['Balance Leave IV Quarter'];				
				$Leavemodel->save(false);
				$startrow++;
				}
				$ModelEmp->	leave_eligible_status =1;
				$ModelEmp->save(false);
			}
			$insertrows = ($startrow- $countrow) - 1;
			Yii::$app->session->setFlash("success",  $insertrows . ' rows had been imported');
			unlink($fileName);
		}
		 return $this->render('importleave', [
                'model' => $model,
            ]);
		
	}

    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

   
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    
    protected function findModel($id)
    {
        if (($model = EmpLeaveStaff::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

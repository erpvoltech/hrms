<?php

namespace backend\controllers;

use Yii;
use common\models\EmpLeave;
use app\models\ImportExcel;
use common\models\EmpDetails;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use common\components\AccessRule;
use common\models\EngineerLeave;
use common\models\EngineerLeaveTaken;

use common\models\EngineerAttendance;
use app\models\AuthAssignment;

/**
 * EngineerLeaveController implements the CRUD actions for EmpLeave model.
 */
class EngineerLeaveController extends Controller {

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
							'actions' => ['index','view','leave-template-engg','importleave','engineer-leave-taken','engineer-leave-separate','engineer-leave-month','engineer-leave'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'view');									 
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['update','leave-template-engg','importleave'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											  return AuthAssignment::Rights('payroll', 'update');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['index','create','leave-template-engg','importleave'],
										  'allow' => true,
										  'matchCallback' => function ($rule, $action) {
											return AuthAssignment::Rights('payroll', 'create');
								 },
							'roles' => ['@'],
						],
						
						[
							'allow' => true,
							'actions' => ['delete','leave-template-engg','importleave'],
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

   /**
    * Lists all EmpLeave models.
    * @return mixed
    */
   public function actionIndex() {
      $dataProvider = new ActiveDataProvider([
          'query' => EmpLeave::find(),
      ]);

      return $this->render('index', [
                  'dataProvider' => $dataProvider,
      ]);
   }

   public function actionView($id) {
      return $this->render('view', [
                  'model' => $this->findModel($id),
      ]);
   }

   public function actionCreate() {
      $model = new EmpLeave();

      if ($model->load(Yii::$app->request->post())) {
         $ModelEmp = EmpDetails::find()->where(['empcode' => $model->empcode])->one();
         $model->empid = $ModelEmp->id;
         $model->save();
         return $this->redirect(['index']);
      }

      return $this->render('create', [
                  'model' => $model,
      ]);
   }

   public function actionLeaveTemplateEngg() {
      return $this->renderpartial('leave-template-engg');
   }

   public function actionUpdate($id) {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
         return $this->redirect(['index']);
      }

      return $this->render('update', [
                  'model' => $model,
      ]);
   }

   public function actionImportleave() {
      $model = new importExcel();

      if ($model->load(Yii::$app->request->post())) {
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

         $countrow = 0;
         $startrow = 1;
         foreach ($data as $key => $excelrow) {
            $ModelEmp = EmpDetails::find()->where(['empcode' => $excelrow['Emp. Code']])->one();

            if ($excelrow['Emp. Code'] == '') {
               Yii::$app->session->addFlash("error", 'Row ' . $startrow . ' has error:ECode Missing');
               $startrow++;
               $countrow +=1;
               continue;
            }

            $empleave = EmpLeave::find()->where(['empid' => $ModelEmp->id])->one();
            if ($empleave) {
               $id = $empleave->id;
               $modelL = EmpLeave::findOne($empleave->id);
               $modelL->empid = $ModelEmp->id;
               $modelL->eligible_first_half = $excelrow['Eligible I Half'];
               $modelL->eligible_second_half = $excelrow['Eligible II Half'];
               $modelL->leave_taken_first_half = $excelrow['Leave Taken I Half'];
               $modelL->leave_taken_second_half = $excelrow['Leave Taken II Half'];
               $modelL->remaining_leave_first_half = $excelrow['Balance Leave I Half'];
               $modelL->remaining_leave_second_half = $excelrow['Balance Leave II Half'];
               $modelL->save(false);
               $startrow++;
            } else {
               $Leavemodel = new EmpLeave();
               $Leavemodel->empid = $ModelEmp->id;
               $Leavemodel->eligible_first_half = $excelrow['Eligible I Half'];
               $Leavemodel->eligible_second_half = $excelrow['Eligible II Half'];
               $Leavemodel->leave_taken_first_half = $excelrow['Leave Taken I Half'];
               $Leavemodel->leave_taken_second_half = $excelrow['Leave Taken II Half'];
               $Leavemodel->remaining_leave_first_half = $excelrow['Balance Leave I Half'];
               $Leavemodel->remaining_leave_second_half = $excelrow['Balance Leave II Half'];
               $Leavemodel->save();
               $startrow++;
            }
         }
         $insertrows = ($startrow - $countrow) - 1;
         Yii::$app->session->setFlash("success", $insertrows . ' rows had been imported');
         unlink($fileName);
      }
      return $this->render('importleave', [
                  'model' => $model,
      ]);
   }

   public function actionDelete($id) {
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
   }

   protected function findModel($id) {
      if (($model = EmpLeave::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('The requested page does not exist.');
   }

   //////// New leave /////////

public function actionEngineerLeaveTaken() {
     
      $model = new EngineerLeaveTaken();
   
   //exit;
    //$delete = EngineerLeaveTaken::deleteAll();
    $fromdate = '2020-04-01';
        $todate = '2021-03-31';
    /*$flpflag = 'm1';
    $m11 = 0;
        $m12 = 0;
        $m13 = 0;
        $m14 = 0;
    $m15 = 0;
        $m16 = 0;
        $m17 = 0;
        $m18 = 0;
        $m19 = 0;
    $m110 = 0;
        $m111 = 0;
        $m112 = 0;
        $totm1 = 0;*/
    
    //exit;
      if ($model->load(Yii::$app->request->post())) {
     
    EngineerLeaveTaken::deleteAll();
                                    /*if (strlen($n) == 1) {
                                        $m = '0' . $n;
                                    } else {
                                        $m = $n;
                                    }
                                    $flpvar = $flpflag . $n;*/


                                    
                                     
                  
                  
                  //$currentYear = date('Y');
                  $modelEmp =  EmpDetails::find()->where([ 'status' => 'Active'])->andWhere(['in', 'category', ['International Engineer','Domestic Engineer']])->andWhere(['in', 'unit_id', [1,2]])->all();
                  foreach($modelEmp as $emp){
                  
                  //$Modelatt_count = EngineerAttendance::find()->where(['between','date',"2020-07-01", "2020-07-31"])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>07])->andwhere(['emp_id'=>2305])->count();
                  //echo $Modelatt_count;
                  //exit;
                   //for ($n = 1; $n <= 12; $n++) {
                  $Modelatt = EngineerAttendance::find()->select('emp_id')->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->where(['emp_id'=>$emp->id])->distinct()->all();
                  foreach($Modelatt as $att){
                  $Modelatt_count1 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>1])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count2 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>2])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count3 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>3])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count4 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>4])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count5 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>5])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count6 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>6])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count7 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>7])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count8 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>8])->andwhere(['emp_id'=>$att->emp_id])->count();
                  //$Modelatt_count8 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>08])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count9 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>9])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count10 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>10])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count11 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>11])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count12 = EngineerAttendance::find()->where(['between','date',$fromdate, $todate])->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>12])->andwhere(['emp_id'=>$att->emp_id])->count();
                  $Modelatt_count = EngineerAttendance::find()->andWhere(['attendance'=>'Leave'])->andWhere(['month(date)'=>$att->date])->andWhere(['emp_id'=>$att->emp_id])->count();    
                   
                  
                  //echo"<pre>";echo $Modelatt_count9;echo"</pre>";
                  }
                  $model = new EngineerLeaveTaken();
                  //print_r($emp->emp_id);
                  $model->empid = $emp->id;
                  $model->jan =$Modelatt_count1;
                  $model->feb =$Modelatt_count2;
                  $model->mar =$Modelatt_count3;
                  $model->apr =$Modelatt_count4;
                  $model->may =$Modelatt_count5;
                  $model->jun =$Modelatt_count6;
                  $model->jul =$Modelatt_count7;
                  $model->aug =$Modelatt_count8;
                  $model->sep =$Modelatt_count9;
                  $model->oct =$Modelatt_count10;
                  $model->nov =$Modelatt_count11;
                  $model->decm =$Modelatt_count12;
                  $model->leave_days = $Modelatt_count1 + $Modelatt_count2 + $Modelatt_count3 + $Modelatt_count4 + $Modelatt_count5 +$Modelatt_count6 + $Modelatt_count7 +$Modelatt_count8 + $Modelatt_count9 + $Modelatt_count10 + $Modelatt_count11 + $Modelatt_count12;
                  $model->year=$currentYear = date('Y');
                  
                  $model->save();
                    
                    }
                    
                    //}
                    //echo"<pre>";echo $m17;echo"</pre>";
                    //exit;
                    /*echo"<pre>";echo $m11;echo"</pre>";
                    echo"<pre>";echo $m12;echo"</pre>";
                    echo"<pre>";echo $m13;echo"</pre>";
                    echo"<pre>";echo $m14;echo"</pre>";
                    echo"<pre>";echo $m15;echo"</pre>";
                    echo"<pre>";echo $m16;echo"</pre>";
                    echo"<pre>";echo $m17;echo"</pre>";
                    echo"<pre>";echo $m18;echo"</pre>";
                    echo"<pre>";echo $m19;echo"</pre>";
                    echo"<pre>";echo $m110;echo"</pre>";
                    echo"<pre>";echo $m111;echo"</pre>";
                    echo"<pre>";echo $m112;echo"</pre>";
                    
                    exit;*/
                  
                  /*while ($salessub1 = mysqli_fetch_array($queryone)) {
                                        $subqueryone = mysqli_query($dbcon, "SELECT * FROM sales_order_item WHERE status <>2 AND orderno=" . $salessub1['orderno'] . " AND division='" . $m3row['id'] . "'");
                                        while ($subqueryrow = mysqli_fetch_array($subqueryone)) {
                                            $$flpvar += ($subqueryrow['turnover']);
                                        }
                                        $div = "CRP";
                                        $subrow['company'] = "M3";
                                    }
                                }*/
     
         
    
         return $this->redirect(['engineer-leave-taken']);
      
    }

      return $this->render('engineer-leave-taken', [
                  'model' => $model,
      ]);
   }
    public function actionEngineerLeaveSeparate($empid) {
      return $this->render('engineer-leave-separate');
   }
     public function actionEngineerLeaveMonth() {
      return $this->render('engineer-leave-month');
   }
   
    public function actionEngineerLeave() {
      $model = new EngineerLeave();

      if ($model->load(Yii::$app->request->post())) {
         $ModelEmp = EmpDetails::find()->where(['empcode' => $model->empcode])->one();
         $model->empid = $ModelEmp->id;
         $model->save();
      Yii::$app->session->setFlash("success",'rows has been added');
     
     
         return $this->redirect(['engineer-leave']);
      }

      return $this->render('engineer-leave', [
                  'model' => $model,
      ]);
   }

}

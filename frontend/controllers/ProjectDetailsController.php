<?php

namespace frontend\controllers;

use Yii;
use yii\base\Model;
use common\models\ProjectDetails;
use app\models\ProjectDetailsSearch;
use common\models\EmpDetailsSearch;
use common\models\EngineerAttendance;
use common\models\AttendanceAccessRule;
use common\models\EmpDetails;
use common\models\Division;
use common\models\Unit;
use common\models\District;
use common\models\State;
use common\models\User;
use common\models\Customer;
use common\models\CustomerContact;
use common\models\UnitGroup;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\components\AccessRule;
use common\models\EngineerTransfer;
use common\models\EngineertransferProject;
use app\models\EngineerSearch;
use app\models\ChangePassword;
use yii\data\ActiveDataProvider;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use kartik\mpdf\Pdf;
use yii\helpers\Html;
use common\models\ProjectTracking;
use common\models\Status;
use common\models\PoMaster;
use common\models\Invoice;



/**
 * ProjectDetailsController implements the CRUD actions for ProjectDetails model.
 */
class ProjectDetailsController extends Controller
{
    /**
		* {@inheritdoc}
     */
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

    /**
     * Lists all ProjectDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	 public function actionRequestEngineer()
    {
        $searchModel = new EngineerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('request-engineer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectDetails model.
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


    public function actionCreate()
    {
        $model = new ProjectDetails();

        if ($model->load(Yii::$app->request->post())) {
			if($_POST['ProjectDetails']['compliance_required']){
            $model->compliance_required = implode(",", $_POST['ProjectDetails']['compliance_required']);
			} else{
				$model->compliance_required =NULL;
			}
            //echo $model->compliance_required;
			if($model->consultant==''){
				$model->consultant=NULL;
			}

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash("error", ' Error');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	 public function actionEngineerList($id)
    {
        //$searchModel = new EmpDetailsSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('engineer-list', [
            'id' => $id,
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
	}
	
	
	public function actionStaffsalaryannexure($id) {
	
	
        $model = EmpRemunerationDetails:: find()->where(['empid'=>$id])->one();
		//print_r($model);
		//exit;
		 $Salarystructure = EmpSalarystructure::find()
                       ->where(['salarystructure' => $model->salary_structure])
                        ->count();
	if($Salarystructure >= 0){
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
	public function actionPrintEmpdetails($id) {
      $this->layout ='print_layout';
      return $this->render('print-empdetails', [
                  'model' => $id,
      ]);
   }
	public function actionEmpLog($id) {    
	   return $this->render('emp-log', [
                  'model' => $id,
				  
      ]);
   }
   public function actionAttendancereportProject()
    {
        return $this->render('attendancereport-project');
    }
	
	
	 public function actionEmployeeTransfer($eid)
    {
        $modelEmp = EmpDetails::find()->where(['id'=>$eid])->one();
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
			  return $this->redirect('index.php?r=project-details/employee-list');
		 }
        return $this->render('employee-transfer', [
            'eid' => $eid,
            'model' => $model,  
			'modelEmp' => $modelEmp,
        ]);
    }
	
	 public function actionEngineerTransfer($id)
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
			  return $this->redirect('index.php?r=project-details/unitadmin-index');
		 }
        return $this->render('engineer-transfer', [
            'id' => $id,
            'model' => $model,  
			'modelEmp' => $modelEmp,
        ]);
    }

	public function actionEngineerlistProjectadmin($ec)
    {
        $model = new EmpDetails();
        $unitlist = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();     

        return $this->render('engineerlist-projectadmin', [
            'model' => $model,
            'unitlist' => $unitlist,
            //'unit' => $uid,
            //'division' => $did,
            //'attdate' => $dt,
            'ecode' => $ec,
        ]);
    }
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
			  return $this->redirect('index.php?r=project-details/engineerlist-projectadmin&ec=');
		 }
        return $this->render('engineertransfer-project', [
            'id' => $id,
            'model' => $model,  
			'modelEmp' => $modelEmp,
        ]);
    }
	
	
    public function actionAttendance($uid,$did,$att_date)
    {
        $model = new EngineerAttendance();
        $modelEmp = EmpDetails::find()->where(['division_id' => $did, 'unit_id' => $uid])->andwhere(['!=','category','HO Staff'])->andwhere(['!=','category','BO Staff'])->andWhere(['IN','status',['Active','Paid and Relieved','Transferred','Notice Period','Exit Formality Inprocess']])->all();
        //print_r($modelEmp);
        //exit;
        //$Project = ProjectDetails::find()->where(['project_code'=>$model->project_id])->all();
		$arr = [];
		foreach($modelEmp as $emps)
		{
			$arr[] = $emps->id;
		}
		$EmpAttendence = EngineerAttendance::find()->where(['in', 'emp_id', $arr])->andWhere(['date' => Yii::$app->formatter->asDate($att_date, 'yyyy-MM-dd')])->all();
		
       $AttDets = [];
		foreach($EmpAttendence as $EmpAtt) {
			//echo "<br>";echo $EmpAtt->emp_id; echo "<br/>";
			$AttDets[$EmpAtt->emp_id] = $EmpAtt->project_id.'|'.$EmpAtt->attendance.'|'.$EmpAtt->overtime.'|'.$EmpAtt->role.'|'.$EmpAtt->special_allowance.'|'.$EmpAtt->advance_amount;
		}
		//exit;
	   if ($model->load(Yii::$app->request->post())) {
		   //print_r($_POST['EngineerAttendance']['emp_id']);
		   //exit;
            $totEmp = sizeof(array_filter($_POST['EngineerAttendance']['emp_id']));
		
            for ($count = 0; $count < $totEmp; $count++) {
                if ($model['attendance'][$count] != "" && $model['role'][$count] != "") {
                    $EngAtt = new EngineerAttendance();
                    $EngAtt->date = Yii::$app->formatter->asDate($att_date, "yyyy-MM-dd");  
                    $EngAtt->emp_id =  $model['emp_id'][$count];
                    $EngAtt->project_id = $model['project_id'][$count];
                    $EngAtt->attendance = $model['attendance'][$count];
					$EngAtt->overtime = $model['overtime'][$count];
					$EngAtt->role = $model['role'][$count];
					$EngAtt->special_allowance = $model['special_allowance'][$count];
					//if($count !=142){
					//echo $model['emp_id'][$count].'_'.$model['advance_amount'][$count].'<br>';
					///print_r(count($model['advance_amount']));
					//}
					$EngAtt->advance_amount = $model['advance_amount'][$count];
                    
					$select = EngineerAttendance::find()->where(['date'=>$EngAtt->date,'emp_id'=>$EngAtt->emp_id])->one();
					if($select){
					$select->delete();
					}
					$EngAtt->save();
                }
            }
			if (Yii::$app->user->identity->role == 'unit admin') {
            return $this->redirect('index.php?r=project-details/unitadmin-castatt');
			}else{
			 return $this->redirect('index.php?r=project-details/attendance-index');
			}
        }

        return $this->render('attendance', [
            'model' => $model,
            'modelemp' => $modelEmp,
            'attdets' => $AttDets,
        ]);
    }


    public function actionAttendanceMenu()
    {
        #$model = new EngineerAttendance();
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();

        /*if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return;
        }
    } */

        return $this->render('attendance-menu', [
            'model' => $model,
        ]);
    }
	
	public function actionUnitadminIndex()
    {
       
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();     

        return $this->render('unitadmin-index', [
            'model' => $model,
        ]);
    }
	
	public function actionUnitadminDashboard()
    {
       
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();     

        return $this->render('unitadmin-dashboard', [
            'model' => $model,
        ]);
    }

    public function actionMisDashboard()
    {
       
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();     

        return $this->render('mis-dashboard', [
            'model' => $model,
        ]);
    }
    
	public function actionUnitadminEmplist()
    {
       
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();     

        return $this->render('unitadmin-emplist', [
            'model' => $model,
        ]);
    }
	public function actionUnitadminCastatt()
    {
       
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();     

        return $this->render('unitadmin-castatt', [
            'model' => $model,
        ]);
    }

    /*public function actionContacts()
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
    }*/

    public function actionExport()
    {
        $model = new ProjectDetails();

        /*if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return;
        }
    }*/

        return $this->render('export', [

            'model' => $model,
        ]);
    }


    public function actionProjectList()
    {
        $searchModel = new ProjectDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('project-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmployeeList()
    {
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();


        return $this->render('employee-list', [
            'model' => $model,
        ]);
    }


    /*public function actionAttendanceView()
{
	
    $model = new EngineerAttendance();
    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return;
        }
    }

    return $this->render('attendance-view', [
        'model' => $model,
    ]);
}*/
    public function actionAttendanceView($uid, $did, $dt,$ec,$pid,$att,$dff,$dtt)
    {
        $model = new EngineerAttendance();
        return $this->render('attendance-view', [
            'model' => $model,
            'unit' => $uid,
            'division' => $did,
            'attdate' => $dt,
			'ecode' => $ec,
			'project_id' => $pid,
			'attendance' => $att,
			'dff'=>$dff,
			'dtt'=>$dtt,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->compliance_required = explode(',', $model->compliance_required);
        if ($model->load(Yii::$app->request->post())) {
			if($_POST['ProjectDetails']['compliance_required']){
            $model->compliance_required = implode(",", $_POST['ProjectDetails']['compliance_required']);
			} else{
				$model->compliance_required =NULL;
			}
            //echo $model->compliance_required;
			if($model->consultant==''){
				$model->consultant=NULL;
			}
           // $model->compliance_required = implode(",", $_POST['ProjectDetails']['compliance_required']);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAttendanceUpdate($id, $uid, $did, $dt,$ec,$pid,$att,$dff,$dtt)
    {
        $model = EngineerAttendance::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['attendance-view', 'uid' => $uid, 'did' => $did, 'dt' => $dt,'ec'=>$ec,'pid'=>$pid,'att'=>$att,'dff'=>$dff,'dff'=>$dtt]);
        }

        return $this->render('attendance-update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProjectDetails model.
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

    public function actionAttendanceDelete($id, $uid, $did, $dt,$ec,$pid,$att,$dff,$dtt)
    {
        $model = EngineerAttendance::findOne($id)->delete();
        return $this->redirect(['attendance-view', 'uid' => $uid, 'did' => $did, 'dt' => $dt,'ec'=>$ec,'pid'=>$pid,'att'=>$att,'dff'=>$dff,'dtt'=>$dtt]);
    }


    public function actionAttendanceIndex()
    {
        // $model = new EngineerAttendance();
        $model = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
        //$modelUser = AttendanceAccessRule::find()->where(['division'=>$user->division,'unit'=>$user->unit])->all();
        return $this->render('attendance-index', [
            'model' => $model,
        ]);
    }


    public function actionImportProject()
    {
         $model = new ProjectDetails();

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

            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $countrow = 0;
                $startrow = 2;
                //$arrayinc =0;
                $result_error = '';

                foreach ($data as $key => $excelrow) {
                    $list = new ProjectDetails();
                    $project = ProjectDetails::find()->select('project_code')->where(['project_code'=>$excelrow['Project code']])->one();
                    if (!$project && $excelrow['Project code'] != '' && $excelrow['Project code'] != '#N/A') {
                        $Empid = Customer::find()->where(['customer_name' => $excelrow['Principal Employer']])->one();
                        $Custid = Customer::find()->where(['customer_name' => $excelrow['Customer']])->one();
                        $Consultid = Customer::find()->where(['customer_name' => $excelrow['Consultant Name']])->one();
                        $sta = State::find()->where(['state_name'=>$excelrow['State']])->one();
                        $dist = District::find()->where(['district_name'=>$excelrow['District']])->one();
                        //print_r($Empid);
                        //exit;
                        //$cust = Customer::find()->where(['id' => $excelrow['Principal Employer']])->one();
                        
                        $princialemployer =NULL;
                        $consultant =NULL;
                        $customer =NULL;
                        $state_id = NULL;
                        $district_id = NULL;
                        
                            if(!empty($Empid)){
                                $princialemployer = $Empid->id;
                            }
                            if(!empty($Custid)){
                                $customer = $Custid->id;
                            }
                            if(!empty($Consultid)){
                                $consultant = $Consultid->id;
                            }
                            if(!empty($sta)){
                                $state_id = $sta->id;
                            }
                            if(!empty($dist)){
                                $district_id = $dist->id;
                            }

                        $list->project_code = $excelrow['Project code'];
                        $list->project_name = $excelrow['Project Name'];
                        $list->pono = $excelrow['Po No'];
                        $list->po_date = $excelrow['Po Date'];
                        $list->po_deliverydate = $excelrow['Po Delivery Date'];
                        $list->location_code = $excelrow['Location Code'];
                        $list->principal_employer = $princialemployer;
                        $list->pehr_name = $excelrow['PE HR Name'];
                        $list->pehr_contact = $excelrow['PE HR Contact'];
                        $list->pehr_email = $excelrow['PE HR Email'];
                        $list->petech_name = $excelrow['PE Tech Name'];
                        $list->petech_contact = $excelrow['PE Tech Contact'];
                        $list->petech_email = $excelrow['PE Tech Email'];
                        $list->customer_id = $customer;
                        $list->conhr_name = $excelrow['Customer HR Name'];
                        $list->conhr_contact = $excelrow['Customer HR Contact'];
                        $list->conhr_email = $excelrow['Customer HR Email'];
                        $list->contech_name = $excelrow['Customer Tech Name'];
                        $list->contech_contact = $excelrow['Customer Tech Contact'];
                        $list->contech_email = $excelrow['Customer Tech Email'];
                        $list->job_details = $excelrow['Job Details'];
                        if($sta){
                        $list->state = $state_id;
						}else{
						$list->state = "";
						}
						if($dist){
							$list->district = $district_id;
							}
							else{
								 $list->district = "";
								}
                        $list->compliance_required = $excelrow['Compliance Required'];
                        $list->consultant = $excelrow['Consultant'];
                        $list->consultant_id = $consultant;
                        $list->consulthr_name = $excelrow['Consultant HR Name'];
                        $list->consulthr_contact = $excelrow['Consultant HR Contact'];
                        $list->consulthr_email = $excelrow['Consultant HR Email'];
                        $list->consultech_name = $excelrow['Consultant Tech Name'];
                        $list->consultech_contact = $excelrow['Consultant Tech Contact'];
                        $list->consultech_email = $excelrow['Consultant Tech Email'];
                        $list->project_status = $excelrow['Project Status'];
                        $list->remark = $excelrow['Remark'];
                        $list->save(false);

                        $startrow++;
                    }
                }
                if ($countrow == 0) {
                    $transaction->commit();
                    Yii::$app->session->setFlash("success", ' Upload Success');
                } else {
                    // foreach($result_error as $key => $error){
                    Yii::$app->session->setFlash("error", $result_error);
                    // }    
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash("error", ' Upload Error');
                throw $e;
            }
        }

        return $this->render('import-project', [
            'model' => $model,
        ]);
    }

     public function actionMisView($ec)
    {
        $model = new EmpDetails();
        $unitlist = AttendanceAccessRule::find()->where(['user' => Yii::$app->user->identity->id])->all();
        return $this->render('mis-view', [
             'unitlist' => $unitlist,
            'ecode' => $ec,
            'model'=>$model,
        ]);
    }
    


    public function actionAttendanceReport()
    {
        return $this->render('attendance-report');
    }
    public function actionOtReport()
    {
        return $this->render('ot-report');
    }


    public function actionContacts()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id = $parents[0];
                $model = District::find()->where(['state_id' => $id])->all();

                foreach ($model as $contact) {


                    $out[] = ['id' => $contact->id, 'name' => $contact->district_name];
                }
                echo Json::encode(['output' => $out, 'selected' => '']);
            }
        }
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

    /*public function actionAttendanceUpdate($id)
    {
        $model = EngineerAttendance::find()->where(['date'=>$model->date,'project_id' => $model->project_id,'attendance'=>$model->attendance])->one();

        if ($model->load(Yii::$app->request->post())
			&& $model->save()) {
            return $this->redirect(['attendance-view']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/

    /**
     * Finds the ProjectDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionResetpassword()
    {
		$model = new ChangePassword();
		
		if ($model->load(Yii::$app->request->post())) {	
			$user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();			
			$user->setPassword($model->changepassword);
			$user->generateAuthKey();			
			if($user->validate()){
				$user->save(false);
				Yii::$app->session->setFlash('success', 'New password saved.');

				return $this->goHome();
			}
		 }
		return $this->render('resetpassword', [
		'model' => $model
		]);
    }
	
	public function actionEngineerView($id)
    {
		$model = EmpDetails::findOne($id);
		 return $this->render('engineer-view', [
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
	public function actionTrackingEdit($id)
	{
		  $model = ProjectTracking::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
				$model->month = Yii::$app->formatter->asDate($model->month, "yyyy-MM-dd");
				$model->attendance_division = Yii::$app->formatter->asDate($model->attendance_division, "yyyy-MM-dd");
				$model->attendance_send = Yii::$app->formatter->asDate($model->attendance_send, "yyyy-MM-dd");
				$model->prs_received = Yii::$app->formatter->asDate($model->prs_received, "yyyy-MM-dd");
				$model->prs_send_division = Yii::$app->formatter->asDate($model->prs_send_division, "yyyy-MM-dd");
				$model->docs_division = Yii::$app->formatter->asDate($model->docs_division, "yyyy-MM-dd");
				$model->docs_send = Yii::$app->formatter->asDate($model->docs_send, "yyyy-MM-dd");	
				$model->save();
           return $this->redirect(['track-index', 'id' => $model->project_id]);
        }

        return $this->render('project-tracking', [
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
				$model->attendance_division = Yii::$app->formatter->asDate($model->attendance_division, "yyyy-MM-dd");
				$model->attendance_send = Yii::$app->formatter->asDate($model->attendance_send, "yyyy-MM-dd");
				$model->prs_received = Yii::$app->formatter->asDate($model->prs_received, "yyyy-MM-dd");
				$model->prs_send_division = Yii::$app->formatter->asDate($model->prs_send_division, "yyyy-MM-dd");
				$model->docs_division = Yii::$app->formatter->asDate($model->docs_division, "yyyy-MM-dd");
				$model->docs_send = Yii::$app->formatter->asDate($model->docs_send, "yyyy-MM-dd");				
				$model->save();
				return $this->redirect(['index']);
			}
		}

		return $this->render('project-tracking', [
			'model' => $model,
		]);
	}
	public function actionDashboardIr()
	{
		return $this->render('dashboard-ir');	
	}
	/////15/08/2020////////
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
			  return $this->redirect('index.php?r=project-details/attendance-menu');
		 }
        return $this->render('division-transfer', [
            'id' => $id,
            'model' => $model,  
			'modelEmp' => $modelEmp,
        ]);
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
	public function actionPoCreate()
    {
        $model = new PoMaster();

        if ($model->load(Yii::$app->request->post())) {
		  $model ->po_date = Yii::$app->formatter->asDate($model->po_date, "yyyy-MM-dd");
		  $model ->po_delivery_date = Yii::$app->formatter->asDate($model->po_delivery_date, "yyyy-MM-dd");
		  $model->save();
            return $this->redirect('index.php?r=project-details%2Fattendance-menu');
        }

        return $this->render('po-create', [
            'model' => $model,
        ]);
    }
	public function actionInvoiceCreate()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post())) {
		  $model ->invoice_date = Yii::$app->formatter->asDate($model->invoice_date, "yyyy-MM-dd");
		  //$model ->po_delivery_date = Yii::$app->formatter->asDate($model->po_delivery_date, "yyyy-MM-dd");
		  $model->save();
            return $this->redirect('index.php?r=project-details%2Fattendance-menu');
        }

        return $this->render('invoice-create', [
            'model' => $model,
        ]);
    }
	 public function actionComplianceReport()
    {
        return $this->render('compliance-report');
    }
	
}

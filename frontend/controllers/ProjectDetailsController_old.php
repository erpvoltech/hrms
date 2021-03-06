<?php

namespace frontend\controllers;

use Yii;
use yii\base\Model;
use common\models\ProjectDetails;
use app\models\ProjectDetailsSearch;
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
use app\models\EngineerSearch;

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
            $model->compliance_required = implode(",", $_POST['ProjectDetails']['compliance_required']);
            //echo $model->compliance_required;

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
		return $this->render('engineer-list', [
            'id' => $id,
        ]);
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

    public function actionAttendance($uid, $did)
    {
        $model = new EngineerAttendance();
        $modelEmp = EmpDetails::find()->where(['division_id' => $did, 'unit_id' => $uid, 'status' => 'Active'])->all();
        //$Project = ProjectDetails::find()->where(['project_code'=>$model->project_id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $totEmp = sizeof(array_filter($_POST['EngineerAttendance']['emp_id']));
            for ($count = 0; $count < $totEmp; $count++) {
                if ($model['project_id'][$count] != "" && $model['attendance'][$count] != "") {
                    $EngAtt = new EngineerAttendance();
                    $EngAtt->date = Yii::$app->formatter->asDate($model->date, "yyyy-MM-dd");
                    $EngAtt->emp_id =  $model['emp_id'][$count];
                    $EngAtt->project_id = $model['project_id'][$count];
                    $EngAtt->attendance = $model['attendance'][$count];
                    $EngAtt->save();
                }
            }
            return $this->redirect('index.php?r=project-details/attendance-index');
        }

        return $this->render('attendance', [
            'model' => $model,
            'modelemp' => $modelEmp,
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
    public function actionAttendanceView($uid, $did, $dt,$ec,$pid,$att)
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
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->compliance_required = explode(',', $model->compliance_required);
        if ($model->load(Yii::$app->request->post())) {
            $model->compliance_required = implode(",", $_POST['ProjectDetails']['compliance_required']);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAttendanceUpdate($id, $uid, $did, $dt)
    {
        $model = EngineerAttendance::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['attendance-view', 'uid' => $uid, 'did' => $did, 'dt' => $dt]);
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

    public function actionAttendanceDelete($id, $uid, $did, $dt)
    {
        $model = EngineerAttendance::findOne($id)->delete();
        return $this->redirect(['attendance-view', 'uid' => $uid, 'did' => $did, 'dt' => $dt]);
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
                    if ($excelrow['Project code'] != '' && $excelrow['Project code'] != '#N/A') {
                        $Empid = Customer::find()->where(['customer_name' => $excelrow['Principal Employer']])->one();
                        $Custid = Customer::find()->where(['customer_name' => $excelrow['Customer']])->one();
                        $Consultid = Customer::find()->where(['customer_name' => $excelrow['Consultant Name']])->one();
                        //print_r($Empid);
                        //exit;
                        //$cust = Customer::find()->where(['id' => $excelrow['Principal Employer']])->one();
						
						$princialemployer =NULL;
						$consultant =NULL;
						$customer =NULL;
						
							if(!empty($Empid)){
								$princialemployer = $Empid->id;
							}
							if(!empty($Custid)){
								$customer = $Custid->id;
							}
							if(!empty($Consultid)){
								$consultant = $Consultid->id;
							}

                        $list->project_code = $excelrow['Project code'];
                        $list->project_name = $excelrow['Project Name'];
                        $list->pono = $excelrow['Pono'];
                        $list->po_deliverydate = $excelrow['Po Deliverydate'];
                        $list->location_code = $excelrow['Location Code'];
                        $list->principal_employer = $princialemployer;
                        $list->pehr_contact = $excelrow['Pehr Contact'];
                        $list->pehr_email = $excelrow['Pehr Email'];
                        $list->petech_contact = $excelrow['Petech Contact'];
                        $list->petech_email = $excelrow['Petech Email'];
                        $list->customer_id = $customer;
                        $list->conhr_contact = $excelrow['Conhr Contact'];
                        $list->conhr_email = $excelrow['Conhr Email'];
                        $list->contech_contact = $excelrow['Contech Contact'];
                        $list->contech_email = $excelrow['Contech Email'];
                        $list->job_details = $excelrow['Job Details'];
                        $list->state = $excelrow['State'];
                        $list->district = $excelrow['District'];
                        $list->compliance_required = $excelrow['Compliance Required'];
                        $list->consultant = $excelrow['Consultant'];
                        $list->consultant_id = $consultant;
                        $list->consulthr_contact = $excelrow['Consulthr Contact'];
                        $list->consulthr_email = $excelrow['Consulthr Email'];
                        $list->consultech_contact = $excelrow['Consultech Contact'];
                        $list->consultech_email = $excelrow['Consultech Email'];
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


    public function actionAttendanceReport()
    {
        return $this->render('attendance-report');
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
}

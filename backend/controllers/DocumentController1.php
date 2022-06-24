<?php
	
	namespace backend\controllers;
	
	use Yii;
	use common\models\EmpDetails;
	use common\models\EmpRemunerationDetails;
	use common\models\Department;
	use common\models\Designation;
	use common\models\Unit;
	use common\models\EmpAddress;
	use common\models\Division;
	use common\models\Document;
	use common\models\EmpPersonaldetails;
	use app\models\ImportExcel;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use yii\helpers\Html;
	use yii\web\UploadedFile;
	use common\models\MailForm;
	use kartik\mpdf\Pdf;
	use Mpdf\Mpdf;	
	use app\models\ShowcauseSearch;
	error_reporting(0);
	/**
		* DocumentController implements the CRUD actions for Document model.
	*/
	class DocumentController extends Controller
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
		
		
		public function actionIndex()
		{
			
			/*	$modelDoc = Document::find()->all();
				foreach ($modelDoc as $model) {
				if($model->type == 3 ) {
				if(empty($model->file_name)) {
				$updatemodel = $this->findModel($model->id);
				$Emp = EmpDetails::findOne($model->empid);
				$empadd = EmpAddress::find()->where(['empid' => $Emp->id])->one();
				$div = Division::find()->where(['id' => $Emp->division_id])->one();
				
				
				$filename = 'Show Cause Notice-'.$Emp->empcode.'-'.date('d-m-Y H:i:s').'.pdf';
				$updatemodel->file_name=$filename;
				$content ='
				<p>'.Html::img("@web/img/letterpad.png").'</p>
				<br></br>
				<h2><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SHOW CAUSE NOTICE</strong></h2>
				
				<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.date('d/m/Y').'</b></p>
				
				<p>&nbsp;</p>
				
				<p><strong>Mr. '.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
				<strong>'.$Emp->designation->designation.'</strong><br>
				<strong>'.$div->division_name.'.</strong></p>
				
				<p>&nbsp;</p>
				
				<p>Dear <strong>Mr. '.$Emp->empname.'</strong>,</p>';
				
				$content .= $model->document;
				
				$content .='<p>&nbsp;</p>
				
				<p>For <strong>VOLTECH Engineers Private Limited,</strong><br>
				
				'.Html::img("@web/img/seal.png").' <br>
				
				<strong>E.Kumaresan</strong></p>
				
				<p><strong>Asst. General Manger &ndash; HR &amp; IR.</strong></p>
				';
				$updatemodel->save();
				$pdfdoc = new Pdf();
				$mpdfdoc = $pdfdoc->api;
				$mpdfdoc->WriteHtml($content);
				$mpdfdoc->Output('doc_file/'.$updatemodel->file_name, 'F');
				}
				}
			} */
			
			return $this->render('index');
		}
		
		public function actionView($id)
		{
			$model = $this->findModel($id);
			
			return $this->render('view', [
			'model' => $this->findModel($id),
			]);
		}
		public function actionShowCause()
		{
			return $this->render('show-cause');
		}
		public function actionShowCauseAll()
		{
		 $searchModel = new ShowcauseSearch();
		 $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
			return $this->render('show-cause-all',[
			 'searchModel' => $searchModel,
			 'dataProvider' => $dataProvider,
			]);
		}
		
		public function actionShowCauseImport()
		{
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
				$connection = \Yii::$app->db;
				$countrow = 0;
				$startrow = 1;
				$totalrow = count($data);
				$flagrow =0;
				
				$transaction = $connection->beginTransaction();
				try {
					foreach ($data as $key => $excelrow) {
						$empid = $excelrow['Emp. Code'];
						$work_date = Yii::$app->formatter->asDate($excelrow['Left Date'], "dd/MM/yyyy");
						$Emp = EmpDetails::find()->where(['empcode' => $empid])->one();
						$EmpPersonal = EmpPersonaldetails::find()->where(['empid' => $Emp->id])->one();
						$div = Division::find()->where(['id' => $Emp->division_id])->one();
						
						if($EmpPersonal->gender == 'Male') {
							$salutation ='Mr. ';
							} elseif($EmpPersonal->gender == 'Female') {
							$salutation ='Ms. ';
							} else {
							$salutation = 'Dear ';
						}
						
						$document_letter ='<br></br>
						<h2><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SHOW CAUSE NOTICE</strong></h2>
						
						<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.date('d/m/Y').'</b></p>
						
						<p>&nbsp;</p>
						
						<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
						<strong>'.$Emp->designation->designation.'</strong><br>
						<strong>'.$div->division_name.'.</strong></p>
						
						<p>&nbsp;</p>
						
						<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
						
						<p>&nbsp;</p>
						
						<p>It is reported that you&rsquo;ve left your work site on  <strong>'.$work_date.'</strong> and till date you&rsquo;ve neither reported to job nor we got any response from your end. You&rsquo;re expected to contact your reporting Boss &amp; Management through phone or mail as soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.</p>
						
						<p>If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter, which may lead to the closure of your service from our concern.</p>
						
						
						<p>For <strong>Voltech Engineers Pvt. Ltd</strong><br />
						'.Html::img("@web/img/seal.png").'
						<p><strong>E.Kumaresan,</strong></p>
						<p><strong>Asst. General Manger &ndash; HR &amp; IR.</strong></p>';
						
						$document = new Document();
						$document->empid =$Emp->id;
						$document->date =date('Y-m-d');
						$document->type =3;
						$document->last_working_date = Yii::$app->formatter->asDate($excelrow['Left Date'], "yyyy-MM-dd");
						$document->document = $document_letter;
						$document->mail =0;
						$document->save(false);
						$startrow++;
					}
					$transaction->commit();
					unlink('employee/'.$fileName);
					$insertrows = $startrow - 1;
					Yii::$app->session->setFlash("success", $insertrows . ' rows had been imported');
					} catch (\Exception $e) {
					$transaction->rollBack();
					throw $e;
					} catch (\Throwable $e) {
					$transaction->rollBack();
					throw $e;
				}
				
			}
			return $this->render('show-cause-import', [
			'model' => $model,
			]);
		}
		public function actionDeleteShowCause($id)
		{
			$model = $this->findModel($id);
			$empid = $model->empid;
			$type = $model->type;
			if($model->type == 3) {
				unlink('doc_file/'.$model->file_name);
			}
			$model->delete();
			return $this->redirect(['index', 'id' => $empid,'type'=>$type]);
		}
		
		public function actionSendAll()
		{
			//$showcausemodel = Document::find()->where(['type'=>3,'mail'=>0])->all();
			//foreach($showcausemodel as $sendmodel) {
			$data = Yii::$app->request->post();
			$result_success = [];
			$result_failure = [];
			
			foreach($data['keylist'] as $key) {
				$mailmodel = new MailForm();
				$model = Document::find()
				->where(['id' =>$key])
				->one();
				
				$Emp = EmpDetails::findOne($model->empid);
				
				error_log(date("d-m-Y g:i:s a ") ." Show Cause Notice Send To  ".$Emp->empcode ." By User --->".Yii::$app->user->identity->username."\n", 3, "user_update.log");
				
				if($model->type==3) {
					$filename = 'Show Cause Notice-'.$Emp->empcode.'-'.date('d-m-Y').'.pdf';
				}
				
				$content ='<p>'.Html::img("@web/img/letterpad.png").'</p>'.$model->document;
				
				$mpdf = new mPDF();
				//$mpdf = $pdf->api;
				$mpdf->WriteHtml($content);
				$mpdf->Output('doc_file/'.$filename, 'F');
				
			
				
				if(file_exists('doc_file/'.$filename)){
					$mailflag = 1;
				}
				
				if($mailflag == 1) {
					if($model->type==3) {
						$mailmodel->from = "careers@voltechgroup.com";
						$mailmodel->password = "ya74qs";
						$mailmodel->subject = 'Show Cause Notice';
						$mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>
						<br>
						It is reported that you&rsquo;ve left from office/site. you&rsquo;ve neither reported to job nor we got any
						response from your end. You&rsquo;re expected to contact your reporting Boss & Management through phone or mail as
						soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.
						If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter,
						which may lead to the closure of your service from our concern.
						<br>
						<br>
						<br>
						Regards,<br>
						Human Resources Department. <br>
						Voltech Engineers Pvt. Ltd. <br>
						2/429, Mount Poonamallee Road,<br>
						Ayyapanthangal,<br>
						Chennai-600056.<br>
						Ph:9940518844, Ext : 287.
						';
						$mailmodel->bcc = "careers@voltechgroup.com";
					}
					$mailmodel->fromName = 'VEPL HRD';
					$mailmodel->cc = "kumaresan.e@voltechgroup.com";
					$mailmodel->attachment ='doc_file/'.$filename;
					
					if($mailmodel->sendEmail($Emp->email)){
						unlink('doc_file/'.$filename);
						$model->mail = 1;
						$model->save(false);
						$result_success[] = $Emp->empcode . 'Successfully Sent your message </br>';
					} 
				}
			}
			$jsonData['success'] = $result_success;
			$jsonData['error'] = $result_failure;
			return json_encode($jsonData);
		}
		
		public function actionSendShowCause($id)
		{
			$mailmodel = new MailForm();
			$model = Document::find()
			->where(['id' =>$id])
			->one();
			
			$Emp = EmpDetails::findOne($model->empid);
			
			if($model->type==3) {
				$filename = 'Show Cause Notice-'.$Emp->empcode.'-'.date('d-m-Y').'.pdf';
			}
			
			$content ='<p>'.Html::img("@web/img/letterpad.png").'</p>'.$model->document;
			
			//$pdf = new Pdf();
			//$mpdf = $pdf->api;
			$mpdf = new mPDF();
			$mpdf->showImageErrors = true;			
			$mpdf->WriteHtml($content);
			$mpdf->Output('doc_file/'.$filename, 'F');
			
			if(file_exists('doc_file/'.$filename)){
				$mailflag = 1;
			}
			
			if($mailflag == 1) {
				if($model->type==3) {
					$mailmodel->from = "careers@voltechgroup.com";
					$mailmodel->password = "ya74qs";
					$mailmodel->subject = 'Show Cause Notice';
					$mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>
					<br>
					It is reported that you&rsquo;ve left from office/site. you&rsquo;ve neither reported to job nor we got any
					response from your end. You&rsquo;re expected to contact your reporting Boss & Management through phone or mail as
					soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.
					If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter,
					which may lead to the closure of your service from our concern.
					<br>
					<br>
					<br>
					Regards,<br>
					Human Resources Department. <br>
					Voltech Engineers Pvt. Ltd. <br>
					2/429, Mount Poonamallee Road,<br>
					Ayyapanthangal,<br>
					Chennai-600056.<br>
					Ph:9940518844, Ext : 287.
					';
					$mailmodel->bcc = "careers@voltechgroup.com";
				}
				$mailmodel->fromName = 'VEPL HRD';
				$mailmodel->cc = "kumaresan.e@voltechgroup.com";
				$mailmodel->attachment ='doc_file/'.$filename;
				
				if($mailmodel->sendEmail($Emp->email)){
					unlink('doc_file/'.$filename);
					$model->mail = 1;
					$model->save(false);
					Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
					return $this->redirect('show-cause');
				}
			}
		}
		
		public function actionCreate()
		{
			$doctype = $_GET['type'];
			$empid = $_GET['id'];
			//$type = $_GET['type'];
			$m = date('m');
			$y = date('y');
			$d = date('d');
			
			$model = new Document();
			if($data = Yii::$app->request->post()){
			    $created_at = date('Y-m-d H:i:s');
				$model->empid =$empid;
				$model->date = $created_at;
				$model->type = $doctype;
				$model->document = $_POST['Editor1'];
				$refQry = Document::find()->where(['type' => 2])
				->orderBy(['reference_count' => SORT_DESC,])
				->limit(1)
				->one();
				
				if ($refQry == '') {
					$relNum = 1;
					} else {
					$relNum = $refQry['reference_count'] + 1;
				}
				
				$length = strlen($relNum);
				if ($length == 1) {
					$relNoCount = 0 . $relNum;
					} else {
					$relNoCount = $relNum;
				}
				//exit;
				$model->reference_no = 'REF:VERL' . $m . $y . $d . $relNoCount;
				
				$model->reference_count = $relNum;
				$model->save();
				$insertid = Yii::$app->db->getLastInsertID();
				return $this->redirect(['update', 'id' => $insertid]);
				} else {
				$Emp = EmpDetails::findOne($empid);
				$empadd = EmpAddress::find()->where(['empid' => $empid])->one();
				$div = Division::find()->where(['id' => $Emp->division_id])->one();
				$EmpPersonal = EmpPersonaldetails::find()->where(['empid' => $Emp->id])->one();
				
				if($EmpPersonal->gender == 'Male') {
					$salutation ='Mr.';
					} elseif($EmpPersonal->gender == 'Female') {
					$salutation ='Ms.';
					} else {
					$salutation = 'Dear';
				}
				
				if($doctype == 1){
					$document_letter ='
					<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Date:'.date('d/m/Y').'</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p><br/>
					
					
					<p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="style="text-decoration: underline">TO WHOMSOEVER IT MAY CONCERN</span></strong><br />
					&nbsp;</p>
					<p>&nbsp;</p>
					<p><br />
					This is to certify that <strong>' .$salutation . $Emp->empname . '('.$Emp->empcode.') </strong>,working as &lsquo;<strong>'.$Emp->designation->designation.'&rsquo;</strong> in our organization since ' . Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy") . ' as per the employment records available with us. Her current address is,<br />
					&nbsp;</p>';
					
					if ($empadd->addfield1 != '')
					$document_letter .= '<strong>' . $empadd->addfield1 . ',</strong><br />';
					if ($empadd->addfield2 != '')
					$document_letter .='<strong>' . $empadd->addfield2 . ',</strong><br />';
					if ($empadd->addfield3 != '')
					$document_letter .='<strong>' . $empadd->addfield3 . ',</strong><br />';
					if ($empadd->addfield4 != '')
					$document_letter .='<strong>' . $empadd->addfield4 . ',</strong></br>';
					if ($empadd->addfield5 != '')
					$document_letter .='<strong>' . $empadd->addfield5 . ',</strong></br>';
					
					$document_letter .= '<p>&nbsp;</p>
					<p>This address proof letter is issued for the purpose of Bank loan.</p>
					<p>&nbsp;</p>
					<p><br />
					&nbsp;</p>
					<p>For <strong>Voltech Engineers Pvt. Ltd</strong><br />
					'.Html::img("@web/img/seal.png").'
					<p><strong>E.Kumaresan,</strong></p>
					<p><strong>AGM HR &amp; IR. </strong></p>';
					} else if($doctype == 2){
					$refQry = Document::find()->where(['type' => 2])
					->orderBy(['reference_count' => SORT_DESC,])
					->limit(1)
					->one();
					
					if ($refQry == '') {
						$relNum = 1;
						} else {
						$relNum = $refQry['reference_count'] + 1;
					}
					
					$length = strlen($relNum);
					if ($length == 1) {
						$relNoCount = 0 . $relNum;
						} else {
						$relNoCount = $relNum;
					}
					//exit;
					
					$reference_no = 'REF:VERL' . $m . $y . $d . $relNoCount;
					$document_letter ='
					<p>' . $reference_no . ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Date: '.date('d/m/Y').'</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p><strong>'.$salutation . $Emp->empname . '('.$Emp->empcode.')</strong><br />
					<strong>'.$Emp->designation->designation.'</strong></p>
					
					<p>&nbsp;</p>
					
					<p><strong>Sub: Relieving Letter </strong></p>
					
					<p><strong>'.$salutation.$Emp->empname .'</strong>,</p>
					
					<p>This has reference to your Appointment Order dated '.Yii::$app->formatter->asDate($Emp->doj, "dd.MM.yyyy").' and Letter of Resignation dated '.Yii::$app->formatter->asDate($Emp->resignation_date, "dd.MM.yyyy").' and
					your last working date is '.Yii::$app->formatter->asDate($Emp->last_working_date, "dd.MM.yyyy").' wherein you have requested to be relieved from the services of the company.
					We would like to inform you that your resignation is hereby accepted and you are being relieved from the services of the company with effect from closing office hours of '.Yii::$app->formatter->asDate($Emp->dateofleaving, "dd.MM.yyyy").'.</p>
					
					<p>We also certify that your full and final settlement of account has been cleared.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
					
					<p>Your contributions to the organization and its success will always be appreciated.</p>
					
					<p>We wish you all the best in your future endeavors.</p>
					
					<p><strong>For VOLTECH ENGINEERS PVT LTD.,</strong></p>  <br><br><br>
					<p><strong>E.Kumaresan,</strong></p>
					<p><strong>AGM HR &amp; IR. </strong></p>
					
				
				<p>...................................................................................................................................................................................</p>
				
				<p>I am willingly and unconditionally accept this settlement from the company and I wish to state that I have no dues pending from the company towards me.</p>
				
				<p>Place :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature&nbsp;&nbsp;&nbsp;&nbsp; :</p>
				
				<p>Date&nbsp;&nbsp; :&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</p>';
				
				} else if($doctype == 3){
				
				$document_letter ='<br></br>
				<h2><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SHOW CAUSE NOTICE</strong></h2>
				
				<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.date('d/m/Y').'</b></p>
				
				<p>&nbsp;</p>
				
				<p><strong>'.$salutation.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
				<strong>'.$Emp->designation->designation.'</strong><br>
				<strong>'.$div->division_name.'.</strong></p>
				
				<p>&nbsp;</p>
				
				<p><strong>'.$salutation .$Emp->empname.'</strong>,</p>
				
				<p>&nbsp;</p>
				
				<p>It is reported that you&rsquo;ve left your work site on  <strong>(DATE)</strong> and till date you&rsquo;ve neither reported to job nor we got any response from your end. You&rsquo;re expected to contact your reporting Boss &amp; Management through phone or mail as soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.</p>
				
				<p>If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter, which may lead to the closure of your service from our concern.</p>
				
				
				<p>For <strong>Voltech Engineers Pvt. Ltd</strong><br />
				'.Html::img("@web/img/seal.png").'
				<p><strong>E.Kumaresan,</strong></p>
				<p><strong>Asst. General Manger &ndash; HR &amp; IR.</strong></p>';
				
				
				
				
				/*
				$document_letter ='
				<p>It is reported that you&rsquo;ve left your work site on  <strong>(DATE)</strong> and till date you&rsquo;ve neither reported to job nor we got any response from your end. You&rsquo;re expected to contact your reporting Boss &amp; Management through phone or mail as soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.</p>
				
				<p>If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter, which may lead to the closure of your service from our concern.</p>';
				
				*/
				
				}else {
				$document_letter ='';
				}
				return $this->render('create', [
				'model' => $model,
				'document'=> $document_letter,
				'type'=> $type,
				'empid' =>$empid
				]);
				}
				}
				
				
				public function actionUpdate($id) {
				$model = $this->findModel($id);
				$data = Yii::$app->request->post();
				if($data) {
				$model->document = $_POST['Editor1'];
				$model->save(false);
				}
				
				return $this->render('update', [
				'model' => $model,
				'document'=> $model->document,
				'type'=> $model->type,
				'empid' =>$model->empid
				]);
				}
				
				
				public function actionViewpdf($id) {
				return $this->render('viewpdf');
				}
				
				public function actionSendMail($id){
				
				$mailmodel = new MailForm();
				$model = Document::find()
				->where(['id' =>$id])
				->one();
				
				$Emp = EmpDetails::findOne($model->empid);
				
				if($model->type==1) {
				$filename = 'Bonafide-'.$Emp->empcode.'-'.date('d-m-Y').'.pdf';
				} else if($model->type==2) {
				$filename = 'relivingorder-'.$Emp->empcode.'-'.date('d-m-Y').'.pdf';
				} else if($model->type==3) {
				$filename = 'Show Cause Notice-'.$Emp->empcode.'-'.date('d-m-Y').'.pdf';
				}
				
				
				$content ='<p>'.Html::img("@web/img/letterpad.png").'</p>'.$model->document;
				
				//$pdf = new Pdf();
				//$mpdf = $pdf->api;
				$mpdf = new mPDF();
				$mpdf->WriteHtml($content);
				$mpdf->Output('doc_file/'.$filename, 'F');
				
				if(file_exists('doc_file/'.$filename)){
				$mailflag = 1;
				}
				
				if($mailflag == 1) {
				if($model->type==1) {
				$mailmodel->from = "pr@voltechgroup.com";
				$mailmodel->password = "Vepl@4321";
				$mailmodel->subject = 'Bonafide Certificate';
				$mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>
				<br>
				Greetings!!<br><br>
				Kindly, find the attached bonafide certificate.
				<br>
				<br>
				Regards,<br>
				Human Resources Department. <br>
				Voltech Engineers Pvt. Ltd. <br>
				2/429, Mount Poonamallee Road, Ayyapanthangal,<br>
				Chennai-600056. Ph:8754417008, Tel : +91-44-43978000,Ext : 286.
				';
				$mailmodel->bcc = "pr@voltechgroup.com";
				} else if($model->type==2) {
				$mailmodel->from = "pr@voltechgroup.com";
				$mailmodel->password = "Vepl@4321";
				$mailmodel->subject = 'Reliving Order';
				$mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>
				<br>
				Greetings!!<br><br>
				Kindly, find the attached Reliving Order.
				<br>
				<br>
				Regards,<br>
				Human Resources Department. <br>
				Voltech Engineers Pvt. Ltd. <br>
				2/429, Mount Poonamallee Road, Ayyapanthangal,<br>
				Chennai-600056. Ph:8754417008, Tel : +91-44-43978000,Ext : 286.
				';
				$mailmodel->bcc = "pr@voltechgroup.com";
				} else if($model->type==3) {
				$mailmodel->from = "careers@voltechgroup.com";
				$mailmodel->password = "ya74qs";
				$mailmodel->subject = 'Show Cause Notice';
				$mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>
				<br>
				It is reported that you&rsquo;ve left from office/site. you&rsquo;ve neither reported to job nor we got any
				response from your end. You&rsquo;re expected to contact your reporting Boss & Management through phone or mail as
				soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.
				If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter,
				which may lead to the closure of your service from our concern.
				<br>
				<br>
				<br>
				Regards,<br>
				Human Resources Department. <br>
				Voltech Engineers Pvt. Ltd. <br>
				2/429, Mount Poonamallee Road,<br>
                Ayyapanthangal,<br>
				Chennai-600056.<br>
                Ph:9940518844, Ext : 287.
				';
				$mailmodel->bcc = "careers@voltechgroup.com";
				}
				$mailmodel->fromName = 'VEPL HRD';
				$mailmodel->cc = "kumaresan.e@voltechgroup.com";
				$mailmodel->attachment ='doc_file/'.$filename;
				
				if($mailmodel->sendEmail($Emp->email)){
				unlink('doc_file/'.$filename);
				Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
				return $this->redirect(['index', 'id' =>$Emp->id,'type'=>$model->type]);
				}
				}
				
				}
				
				
				
				public function actionDelete($id)
				{
				$model = $this->findModel($id);
				$empid = $model->empid;
				$type = $model->type;
				if($model->type == 3) {
				unlink('doc_file/'.$model->file_name);
				}
				$model->delete();
				return $this->redirect(['index', 'id' => $empid,'type'=>$type]);
				}
				/*
				public function actionShowcauseMail($id)
				{
				$model = $this->findModel($id);
				$mailmodel = new MailForm();
				$Emp = EmpDetails::findOne($model->empid);
				$empadd = EmpAddress::find()->where(['empid' => $Emp->id])->one();
				$div = Division::find()->where(['id' => $Emp->division_id])->one();
				
				$EmpPersonal = EmpPersonaldetails::find()->where(['empid' => $Emp->id])->one();
				
				if($EmpPersonal->gender == 'Male') {
				$salutation ='Mr.';
				} elseif($EmpPersonal->gender == 'Female') {
				$salutation ='Ms.';
				} else {
				$salutation = '';
				}
				
				
				if(empty($model->file_name)){
				$t=time();
				$filename = 'Show Cause Notice-'.$Emp->empcode.'-'.date('d-m-Y H:i:s').'.pdf';
				$model->file_name=$filename;
				$content ='
			    <p>'.Html::img("@web/img/letterpad.png").'</p>
				<br></br>
				<h2><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SHOW CAUSE NOTICE</strong></h2>
				
				<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;<b>Date: '.date('d/m/Y').'</b></p>
				
				<p>&nbsp;</p>
				
				<p><strong>'.$salutation.'. '.$Emp->empname.' ('.$Emp->empcode.'),</strong><br>
				<strong>'.$Emp->designation->designation.'</strong><br>
				<strong>'.$div->division_name.'.</strong></p>
				
				<p>&nbsp;</p>
				
				<p>Dear <strong>'.$salutation.'. '.$Emp->empname.'</strong>,</p>';
				
				$content .= $model->document;
				
				$content .='<p>&nbsp;</p>
				
				<p>For <strong>VOLTECH Engineers Private Limited,</strong><br>
				
				'.Html::img("@web/img/seal.png").' <br>
				
				<strong>E.Kumaresan</strong></p>
				
				<p><strong>Asst. General Manger &ndash; HR &amp; IR.</strong></p>
				';
				
				
				$pdf = new Pdf();
				$mpdf = $pdf->api;
				$mpdf->WriteHtml($content);
				$mpdf->Output('doc_file/'.$filename, 'F');
				}
				$mailmodel->from = "careers@voltechgroup.com";
				$mailmodel->fromName = 'VEPL HRD';
				$mailmodel->subject = 'Show Cause Notice';
				$mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>
				
				It is reported that you&rsquo;ve left from office/site. you&rsquo;ve neither reported to job nor we got any
				response from your end. You&rsquo;re expected to contact your reporting Boss & Management through phone or mail as
				soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.
				If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter,
				which may lead to the closure of your service from our concern.
				<br>
				<br>
				<br>
				Regards,<br>
				Human Resources Department.
				
				';
				//$mailmodel->cc = "kumaresan.e@voltechgroup.com";
				//$mailmodel->bcc = "careers@voltechgroup.com";
				$mailmodel->attachment ='doc_file/'.$model->file_name;
				
				if($mailmodel->sendEmail($Emp->email)){
				$model->mail=1;
				$model->save();
				$type =3;
				Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
				return $this->redirect(['index', 'id' =>$Emp->id,'type'=>$type]);
				}
				//  }
				}
				
				public function actionShowcauseMailResend($id){
				$model = $this->findModel($id);
				$mailmodel = new MailForm();
				$Emp = EmpDetails::findOne($model->empid);
				
				$mailmodel->from = "careers@voltechgroup.com";
				$mailmodel->fromName = 'VEPL HRD';
				$mailmodel->subject = 'Show Cause Notice';
				$mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>
				
				It is reported that you&rsquo;ve left from office/site. you&rsquo;ve neither reported to job nor we got any
				response from your end. You&rsquo;re expected to contact your reporting Boss & Management through phone or mail as
				soon as you get this letter. The company seeks your explanation for the same on receipt of this letter immediately.
				If you fail to respond to this letter, it will be treated as you have no valid and convincing reason against this letter,
				which may lead to the closure of your service from our concern.
				<br>
				<br>
				<br>
				Regards,<br>
				Human Resources Department.';
				
				$mailmodel->cc = "kumaresan.e@voltechgroup.com";
				$mailmodel->attachment ='doc_file/'.$model->file_name;
				$mailmodel->sendEmail($Emp->email);
				} */
				
				protected function findModel($id)
				{
				if (($model = Document::findOne($id)) !== null) {
				return $model;
				}
				
				throw new NotFoundHttpException('The requested page does not exist.');
				}
				}
					
					
					/*'.Html::img("@web/img/signature.png").'
				
				<p><strong>M.UMAPATHI,</strong><br />
				<strong>Managing Director.</strong></p>*/ 
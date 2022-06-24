<?php
use yii\helpers\Html;
use common\models\Document;
use kartik\mpdf\Pdf;
use common\models\MailForm;
use common\models\EmpDetails;

$id = $_GET['id']; 
$mailflag =0;

	$mailmodel = new MailForm();
    $model = Document::find()
              ->where(['id' =>$id])
              ->one();
			 
			$Emp = EmpDetails::findOne($model->empid);
			if($model->type==1) { 
			$filename = 'Bonafide-'.$Emp->empcode.'-'.date('d-m-Y H:i:s').'.pdf';
			} else if($model->type==2) {
			$filename = 'relivingoreder-'.$Emp->empcode.'-'.date('d-m-Y H:i:s').'.pdf';	
			} else if($model->type==3) {
			$filename = 'showcausenotice-'.$Emp->empcode.'-'.date('d-m-Y H:i:s').'.pdf';
			}
			
			$content ='<p>'.Html::img("@web/img/letterpad.png").'</p>'.$model->document;
			
			$pdf = new Pdf(); 
			$mpdf = $pdf->api;
			$mpdf->WriteHTML($content);
			if($mpdf->Output('@web/doc_file/'.$filename, 'F')){
				$mailflag = 1;
			}
			if($mailflag == 1) {
				 $mailmodel->from = "careers@voltechgroup.com";
				 $mailmodel->fromName = 'VEPL HRD';
				 $mailmodel->subject = 'Bonafide Certificate';
				 $mailmodel->body = 'Dear '. $Emp->empname.' ('.$Emp->empcode.'),<br>	<br>			 
				 
							Your Message.
							<br>
							<br>
							<br>
							Regards,<br>
							Human Resources Department. 
							
				 ';
				//$mailmodel->cc = "kumaresan.e@voltechgroup.com";
				//$mailmodel->bcc = "careers@voltechgroup.com";
				$mailmodel->attachment ='@web/doc_file/'.$model->file_name;
				
					if($mailmodel->sendEmail($Emp->email)){
						//$model->mail=1;
						//$model->save();
						//$type =3;
						Yii::$app->session->setFlash('success', 'Successfully Sent your message. ');
						return $this->redirect(['index', 'id' =>$Emp->id,'type'=>$model->type]);
					} 
			} else {
			echo 'mail not Send';
			}
?>
<?php
use yii\helpers\Html;
use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpAddress;
use common\models\EmpFamilydetails;
use app\models\AppointmentLetter;
use Mpdf\Mpdf;

	$id = $_GET['id'];
	
	$emp = EmpDetails::findOne($id); 
	$model = AppointmentLetter::find()
              ->where(['empid' =>$id])
              ->one();		
			  
	$filename = 'Appointment Order-'.$emp->empcode.'.pdf';
	
	
	$header = '<!--mpdf
		<htmlpageheader name="letterheader1">
		   '.Html::img("@web/img/letterpad.png").'
		</htmlpageheader>
		
		<htmlpageheader name="letterheader2">
		   '.Html::img("@web/img/logo.jpg").'
		</htmlpageheader>
		
		<htmlpagefooter name="letterfooter1">
		  '.Html::img("@web/img/Appointment footer.png").'
		</htmlpagefooter>
		
		<htmlpagefooter name="letterfooter2">
			<div style="font-size: 9pt; text-align: right; padding-top: 3mm; font-family: sans-serif; ">
				Page {PAGENO} of {nbpg}
			</div>
		</htmlpagefooter>
	mpdf-->

	<style>
		@page {
			margin-top: 3cm;
			margin-bottom: 2.5cm;
			margin-left: 1cm;
			margin-right: 1cm;
			header: html_letterheader2;
			footer: _blank;
		}
	  
		@page :first {
			margin-top: 6cm;
			margin-bottom: 6cm; 
			header: html_letterheader1;
			footer: letterfooter1;
			resetpagenum: 1;
		}	  
	</style>';
 
    $arrstrlen = 0;
	$id = Yii::$app->getRequest()->getQueryParam('id');
	$html ='<style>@page {
     margin-top: 10px;
    }</style>'.Html::img("@web/img/letterpad.png");
			

			
			$arr_order = explode('</li>',$model->letter,-1);
			$arr_len = Count($arr_order);
			
			
		if( $emp->remuneration->salary_structure =='Contract') {
			for ($i=0;$i<=$arr_len;$i++){
				if($i == 3){
				$html .= $arr_order[$i];
				 $html .= Html::img("@web/img/Appointment footer.png").'<br>';
				} else {			
					$html .= $arr_order[$i];
				}
				$arrstrlen += strlen($arr_order[$i]);
			}
			
		} else {
		for ($i=0;$i<=$arr_len;$i++){
				if($i == 5){
				$html .= $arr_order[$i];
				 $html .= Html::img("@web/img/Appointment footer.png").'<p><br><br><br></p><p><br><br><br></p>';
				} else {			
					$html .= $arr_order[$i];
				}
				$arrstrlen += strlen($arr_order[$i]);
			}		
		}
		
		
			//$html .= substr($model->letter,$arrstrlen);
					
			
		
			
			$mpdf = new mPDF();				
			$mpdf->SetWatermarkText("VOLTECH",0.1);
			$mpdf->showWatermarkText = true;
			//$mpdf->showImageErrors = true;
			$mpdf->WriteHTML($header);
			$mpdf->WriteHTML($model->letter);
			$mpdf->Output();
			$mpdf->Output('doc_file/'.$filename, 'F');
			exit; 
?>
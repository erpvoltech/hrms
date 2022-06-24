<?php
use yii\helpers\Html;
use common\models\Document;
use Mpdf\Mpdf;

$id = $_GET['id']; 
	
    $model = Document::find()
              ->where(['id' =>$id])
              ->one();
			
			$content = $model->document;
			
			$mpdf = new mPDF();
		
			$mpdf->WriteHTML($content);
			
			$mpdf->Output();
			exit; 
?>
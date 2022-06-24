<?php
use yii\helpers\Html;
use common\models\Document;
use Mpdf\Mpdf;

$id = $_GET['id']; 
	
    $model = Document::find()
              ->where(['id' =>$id])
              ->one();
			$content ='<p>'.Html::img("@web/img/letterpad.png").'</p>'.$model->document;
			
			$mpdf = new mPDF();	
			$mpdf->WriteHTML($content);
			$mpdf->Output();
			exit; 
?>
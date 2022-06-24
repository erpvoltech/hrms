<?php

namespace backend\controllers;

use Yii;
use kartik\mpdf\Pdf;
use common\models\EmpSalary;

class PayslipController extends \yii\web\Controller
{
    public function actionSalarypdf($id) {
	   $model = EmpSalary::find()->where(['email_hash'=>$id])->one(); 
	   $content = $this->renderPartial('salarypdf',[ 'model' => $model,]);  
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
		]);    
		return $pdf->render();
	}

}

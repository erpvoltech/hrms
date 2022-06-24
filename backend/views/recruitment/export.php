<?php
ob_start();

use app\models\Recruitment;
use app\models\RecruitmentBatch;

error_reporting(E_ALL);
$objPHPExcel = new PHPExcel();

$sharedStyle1 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();
$sharedStyle3 = new PHPExcel_Style();
$sharedStyle4 = new PHPExcel_Style();
$sharedStyle1->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'FFE5E5E5')
            ),
            'borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
            )
));

$sharedStyle2->applyFromArray(
        array('borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED)
            )
));

$sharedStyle3->applyFromArray(
        array('borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000'),
                ),
            )
));
$sharedStyle4->applyFromArray(
        array('borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000'),
                ),
            )
));


$objPHPExcel->getActiveSheet()
        ->setCellValue('A1', 'register_no')
        ->setCellValue('B1', 'type')
        ->setCellValue('C1', 'batch')
        ->setCellValue('D1', 'name')
        ->setCellValue('E1', 'qualification')
        ->setCellValue('F1', 'specialization')
        ->setCellValue('G1', 'year_of_passing')
        ->setCellValue('H1', 'source')
        #->setCellValue('H1', 'selection_mode')
        ->setCellValue('I1', 'referred_by')
        ->setCellValue('J1', 'other_selection_mode')
        ->setCellValue('K1', 'position')       
        ->setCellValue('L1', 'contact_no')
        ->setCellValue('M1', 'email')
        ->setCellValue('N1', 'community')
        ->setCellValue('O1', 'caste')
        ->setCellValue('P1', 'status')
        ->setCellValue('Q1', 'rejected_reason')
		->setCellValue('R1', 'Process Status');
		
		$searchparams 	= 	Yii::$app->getRequest()->getQueryParam('search');
        $typeparams		=	Yii::$app->getRequest()->getQueryParam('type');
		$batchparams	=	Yii::$app->getRequest()->getQueryParam('batch');
		
		/*if(!empty($typeparams)){
			$typewhere	=	"where(['type' => $typeparams])";
		}else{
			$typewhere	=	"";
		}
		if(!empty($searchparams)){
			$searchwhere	=	"orwhere(['like', 'type', $searchparams])
								->orwhere(['like', 'register_no', $searchparams])
								->orwhere(['like', 'name', $searchparams])
								->orwhere(['like', 'position', $searchparams])
								->orwhere(['like', 'contact_no', $searchparams])
								->orwhere(['like', 'status', $searchparams])
								->orwhere(['like', 'selection_mode', $searchparams])";
		}else{
			$searchwhere	=	"";
		}
		if(!empty($batchparams)){
			$batchwhere	=	"where(['batch_id' => $batchparams])";
		}else{
			$batchwhere	=	"";
		}*/
		
		if(!empty($searchparams) && !empty($typeparams) && !empty($batchparams)){
			$model = Recruitment::find()
							->orwhere(['like', 'type', $searchparams])
							->orwhere(['like', 'register_no', $searchparams])
							->orwhere(['like', 'name', $searchparams])
							->orwhere(['like', 'position', $searchparams])
							->orwhere(['like', 'contact_no', $searchparams])
							->orwhere(['like', 'status', $searchparams])
							->orwhere(['like', 'selection_mode', $searchparams])
							->andwhere(['type' => $typeparams])
							->andwhere(['batch_id' => $batchparams])->all();			
		
		}else if(!empty($searchparams) && !empty($typeparams)){
			$model = Recruitment::find()
							->orwhere(['like', 'type', $searchparams])
							->orwhere(['like', 'register_no', $searchparams])
							->orwhere(['like', 'name', $searchparams])
							->orwhere(['like', 'position', $searchparams])
							->orwhere(['like', 'contact_no', $searchparams])
							->orwhere(['like', 'status', $searchparams])
							->orwhere(['like', 'selection_mode', $searchparams])
							->andwhere(['type' => $typeparams])->all();
		}else if(!empty($searchparams) && !empty($batchparams)){
			$model = Recruitment::find()
							->orwhere(['like', 'type', $searchparams])
							->orwhere(['like', 'register_no', $searchparams])
							->orwhere(['like', 'name', $searchparams])
							->orwhere(['like', 'position', $searchparams])
							->orwhere(['like', 'contact_no', $searchparams])
							->orwhere(['like', 'status', $searchparams])
							->orwhere(['like', 'selection_mode', $searchparams])
							->andwhere(['batch_id' => $batchparams])->all();
		}else if(!empty($searchparams)){
			$model = Recruitment::find()
							->orwhere(['like', 'type', $searchparams])
							->orwhere(['like', 'register_no', $searchparams])
							->orwhere(['like', 'name', $searchparams])
							->orwhere(['like', 'position', $searchparams])
							->orwhere(['like', 'contact_no', $searchparams])
							->orwhere(['like', 'status', $searchparams])
							->orwhere(['like', 'selection_mode', $searchparams])->all();	
		}elseif(!empty($typeparams) && !empty($batchparams)){
			$model = Recruitment::find()->where(['type' => $typeparams,'batch_id' => $batchparams])
							->all();			
		
		}elseif(!empty($typeparams)){
			$model = Recruitment::find()->where(['type' => $typeparams])
							->all();			
		
		}elseif(!empty($batchparams)){
			$model = Recruitment::find()->where(['batch_id' => $batchparams])
							->all();			
		}else{
			$model = Recruitment::find()->all();
		}
		/*$where	=	$searchwhere.$typewhere.$batchwhere;
		$model = Recruitment::find()->$where->all();*/
#echo "<pre>";print_r($dataProvider);echo "</pre>";
#exit;
$row = 2;
foreach ($model as $data) {
		#echo $data->batch_id;
		$recBatchModel	=	RecruitmentBatch::find()->where(['id' => $data->batch_id])->one();
		#echo $recBatchModel->batch_name;
		#echo "<pre>";print_r($recBatchModel);echo "</pre>";
		#exit;
		#echo $recBatchModel->batch_name;
		#exit;
	   $dataArray = array(
       $data->register_no,
       $data->type,
       $recBatchModel['batch_name'],
       $data->name,
       $data->qualification,
       $data->specialization,
       $data->year_of_passing,
       $data->selection_mode,      
       $data->referred_by,
       $data->other_selection_mode,
       $data->position,
       $data->contact_no,
       $data->email,
       $data->community,
       $data->caste,
       $data->status,
       $data->rejected_reason,
	   $data->process_status,
   );
   $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:R1");
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
#$objPHPExcel->getActiveSheet()->setAutoFilter('A1:Q1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

$j = 2;
$k = 2;

foreach ($model as $data) {
   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $j++ . ':R' . $k++);
}
$j--;
$k--;
foreach (range('A', 'Z') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension('A' . $columnID)->setAutoSize(true);
}

/* $l=2;
  foreach($model as $data ) {
  $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, "BI".$l++);
  }
  $l--;
  //$lastcol = $objPHPExcel->getActiveSheet()->getHighestRow();
  //$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "A".$lastcol.":BI".$lastcol);
  //$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, "BI".$lastcol); */
  $objPHPExcel->setActiveSheetIndex(0);
$callStartTime = microtime(true);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Recruitment.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>
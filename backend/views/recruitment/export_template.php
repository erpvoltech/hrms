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
        #->setCellValue('J1', 'other_selection_mode')
        ->setCellValue('J1', 'position')       
        ->setCellValue('K1', 'contact_no')
        ->setCellValue('L1', 'email')
        ->setCellValue('M1', 'community')
        ->setCellValue('N1', 'caste')
        ->setCellValue('O1', 'status');
        #->setCellValue('Q1', 'rejected_reason');

#$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:O1");
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
#$objPHPExcel->getActiveSheet()->setAutoFilter('A1:Q1');
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->setActiveSheetIndex(0);
$j = 2;
$k = 2;
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
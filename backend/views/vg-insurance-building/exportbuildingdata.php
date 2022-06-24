<?php

ob_start();

use app\models\VgInsuranceBuilding;
use app\models\VgInsuranceCompany;
use app\models\VgInsuranceAgents;

error_reporting(0);

$objPHPExcel = new PHPExcel();

$sharedStyle1 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();
$sharedStyle3 = new PHPExcel_Style();
$sharedStyle4 = new PHPExcel_Style();
$sharedStyle1->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('argb' => 'C4D79B')
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
        ->setCellValue('A1', 'Insurance Company Name')
        ->setCellValue('B1', 'Agent Name')
        ->setCellValue('C1', 'Property Type')
        ->setCellValue('D1', 'Insurance No')
        ->setCellValue('E1', 'Property Name')
        ->setCellValue('F1', 'Property No')
        ->setCellValue('G1', 'Property Value')
        ->setCellValue('H1', 'Sum Insured')
        ->setCellValue('I1', 'Premium Paid')
        ->setCellValue('J1', 'Valid From')
        ->setCellValue('K1', 'Valid To')
        ->setCellValue('L1', 'Year')
        ->setCellValue('M1', 'Location')
        ->setCellValue('N1', 'Insured To')
        ->setCellValue('O1', 'Remarks');

$exporttype = Yii::$app->getRequest()->getQueryParam('type');

$conditions = [];

$query = 'SELECT * FROM vg_insurance_building';
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
    $model = VgInsuranceBuilding::findBySql($query)->all();
} else {
    $model = VgInsuranceBuilding::find()->all();
}

$row = 2;
foreach ($model as $data) {
    $ispName = VgInsuranceCompany::find()->where(['id' => $data->icn_id])->one();
    $ispAgentName = VgInsuranceAgents::find()->where(['id' => $data->insurance_agent_id])->one();
    
    if ($exporttype == 2) {
        
    } else if ($exporttype == 1) {
        $dataArray = array(
            $ispName['company_name'],
            $ispAgentName['agent_name'],
            $data->property_type,
            $data->insurance_no,
            $data->property_name,
            $data->property_no,
            $data->property_value,
            $data->sum_insured,
            $data->premium_paid,
            Yii::$app->formatter->asDate($data->valid_from, "dd-MM-yyyy"),
            Yii::$app->formatter->asDate($data->valid_to, "dd-MM-yyyy"),
			$data->financial_year,
            $data->location,
            $data->insured_to,
            $data->remarks,
        );
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
    }
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:O1");
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:O1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

foreach (range('A', 'O') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);

$callStartTime = microtime(true);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Building Policy.xlsx"');
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
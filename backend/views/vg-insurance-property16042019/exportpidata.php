<?php

ob_start();

use app\models\VgInsuranceProperty;
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
        ->setCellValue('A1', 'Property Type')
        ->setCellValue('B1', 'Insurance No')
        ->setCellValue('C1', 'Property Name')
        ->setCellValue('D1', 'Property No')
        ->setCellValue('E1', 'Property Value')
        ->setCellValue('F1', 'Sum Insured')
        ->setCellValue('G1', 'Premium Paid')
        ->setCellValue('H1', 'Valid From')
        ->setCellValue('I1', 'Valid To')
        ->setCellValue('J1', 'Location')
        ->setCellValue('K1', 'User')
        ->setCellValue('L1', 'User Division')
        ->setCellValue('M1', 'Insured To')
        ->setCellValue('N1', 'Equipment Service')
        ->setCellValue('O1', 'Insurance Company Name')
        ->setCellValue('P1', 'Agent Name')
        ->setCellValue('Q1', 'Remarks');

$exporttype = Yii::$app->getRequest()->getQueryParam('type');

$conditions = [];

$query = 'SELECT * FROM vg_insurance_property';
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
    $model = VgInsuranceProperty::findBySql($query)->all();
} else {
    $model = VgInsuranceProperty::find()->all();
}

$row = 2;
foreach ($model as $data) {
    $ispName = VgInsuranceCompany::find()->where(['id' => $data->icn_id])->one();
    $ispAgentName = VgInsuranceAgents::find()->where(['id' => $data->insurance_agent_id])->one();
    
    if ($exporttype == 2) {
        
    } else if ($exporttype == 1) {
        $dataArray = array(
            $data->property_type,
            $data->insurance_no,
            $data->property_name,
            $data->property_no,
            $data->property_value,
            $data->sum_insured,
            $data->premium_paid,
            Yii::$app->formatter->asDate($data->valid_from, "dd-MM-yyyy"),
            Yii::$app->formatter->asDate($data->valid_to, "dd-MM-yyyy"),
            $data->location,
            $data->user,
            $data->user_division,
            $data->insured_to,
            $data->equipment_service,
            $ispName['company_name'],
            $ispAgentName['agent_name'],
            $data->remarks,
        );
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
    }
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:Q1");
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:Q1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

foreach (range('A', 'Q') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);

$callStartTime = microtime(true);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="PIS.xlsx"');
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
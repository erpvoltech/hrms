<?php

ob_start();

use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
use common\models\EmpDetails;
use common\models\EmpStatutorydetails;
use common\models\Designation;
use common\models\Division;
use common\models\Unit;

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
        ->setCellValue('A1', 'Employee Code')
        ->setCellValue('B1', 'Employee Name')
        ->setCellValue('C1', 'Designation')
        ->setCellValue('D1', 'Division')
        ->setCellValue('E1', 'Unit')
        ->setCellValue('F1', 'Policy No')
        ->setCellValue('G1', 'Valid From')
        ->setCellValue('H1', 'Valid To')
        ->setCellValue('I1', 'Sum Insured')
        ->setCellValue('J1', 'Fellow Share');

$row = 2;
foreach ($endoStatuory as $statuoryModel) {
    $emp = EmpDetails::find()->where(['id' => $statuoryModel->empid])->one();
    $designation = Designation::find()->where(['id' => $emp->designation_id])->one();
    $division = Division::find()->where(['id' => $emp->division_id])->one();
    $unit = Unit::find()->where(['id' => $emp->unit_id])->one();
    $gpaModel = VgGpaEndorsement::find()->where(['endorsement_no' => $statuoryModel->gpa_no])->one();
    $gpaHierarchy = VgGpaEndorsementHierarchy::find()->where(['endorsement_sum_insured' => $statuoryModel->gpa_sum_insured])->one();
       
        $dataArray = array(
            $emp->empcode,
            $emp->empname,
            $designation->designation,
            $division->division_name,
            $unit->name,
            $statuoryModel->gpa_no,
            Yii::$app->formatter->asDate($gpaModel->start_date, "dd-MM-yyyy"),
            Yii::$app->formatter->asDate($gpaModel->end_date, "dd-MM-yyyy"),
            $statuoryModel->gpa_sum_insured,
            $gpaHierarchy->endorsement_fellow_share,
        );
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
    
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:J1");
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:J1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

foreach (range('A', 'J') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);

$callStartTime = microtime(true);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="GPA Endorsement Annexure.xlsx"');
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
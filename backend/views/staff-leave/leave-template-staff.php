<?php

ob_start();

use common\models\EmpDetails;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;

error_reporting(E_ALL);
$objPHPExcel = new PHPExcel();

$sharedStyle1 = new PHPExcel_Style();
$sharedStyle2 = new PHPExcel_Style();

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


$objPHPExcel->getActiveSheet()
        ->setCellValue('A1', 'Emp. Code')
        ->setCellValue('B1', 'Emp. Name')
        ->setCellValue('C1', 'Designation')
        ->setCellValue('D1', 'Unit')
        ->setCellValue('E1', 'Department')
        ->setCellValue('F1', 'Eligible I Quarter')
        ->setCellValue('G1', 'Eligible II Quarter')
        ->setCellValue('H1', 'Eligible III Quarter')
        ->setCellValue('I1', 'Eligible IV Quarter')
        ->setCellValue('J1', 'Leave Taken I Quarter')
        ->setCellValue('K1', 'Leave Taken II Quarter')
        ->setCellValue('L1', 'Leave Taken III Quarter')
        ->setCellValue('M1', 'Leave Taken IV Quarter')
        ->setCellValue('N1', 'Balance Leave I Quarter')
        ->setCellValue('O1', 'Balance Leave II Quarter')
        ->setCellValue('P1', 'Balance Leave III Quarter')
        ->setCellValue('Q1', 'Balance Leave IV Quarter');

$model = EmpDetails::find()->joinWith('remuneration', 'remuneration.empid=empDetails.id')
        ->where(['=', 'emp_remuneration_details.attendance_type', 'Permanent'])
        ->all();
$row = 2;
foreach ($model as $data) {
   $payScale = EmpSalarystructure::find()->where(['salarystructure' => $data->remuneration->salary_structure])->all();
   if (!$payScale) {
      $deptname = Department::find()->where(['id' => $data->department_id])->one();
      $dataArray = array(
          $data->empcode,
          $data->empname,
          $data->designation->designation,
          $data->units->name,
          $deptname['name'],
      );
      $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
   }
}
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:Q1");
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:Q1');
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->setActiveSheetIndex(0);

foreach (range('A', 'Q') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
   $objPHPExcel->getActiveSheet()->getColumnDimension('A' . $columnID)->setAutoSize(true);
}
$callStartTime = microtime(true);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Leave_staff.xlsx"');
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

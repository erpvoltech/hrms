<?php

ob_start();

use common\models\EmpDetails;
use common\models\Department;
use common\models\Unit;
use app\models\EmpStaffPayScale;
use common\models\Customer;
use common\models\Division;

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

// Unit row CB
$cust = Customer::find()->all();
$custrow = 2;
foreach ($cust as $custdata) {
   $custArray = array(
       $custdata->customer_name,
   );
   $objPHPExcel->getActiveSheet()->fromArray($custArray, NULL, 'AJ' . $custrow++);
}
$custrow--;
$custcounter = $custrow;


//if ($id == 1) {
   $filename = 'salary_process.xlsx';
   $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Emp. Code')
           ->setCellValue('B1', 'Emp. Name')
           ->setCellValue('C1', 'Designation')
           ->setCellValue('D1', 'Unit')
           ->setCellValue('E1', 'Division')
           ->setCellValue('F1', 'Salary Structure')
           ->setCellValue('G1', 'Work Level')
           ->setCellValue('H1', 'Grade')
           ->setCellValue('I1', 'Statutory Rate')
           ->setCellValue('J1', 'Leave')
           ->setCellValue('K1', 'LOP')
           ->setCellValue('L1', 'Allowance')
           ->setCellValue('M1', 'OT')
           ->setCellValue('N1', 'Holiday Pay')
           ->setCellValue('O1', 'Arrear')
           ->setCellValue('P1', 'Special Allowance')
           ->setCellValue('Q1', 'Advance')
           ->setCellValue('R1', 'Mobile Deduction')
           ->setCellValue('S1', 'Loan')
           ->setCellValue('T1', 'Insurance')
           ->setCellValue('U1', 'Rent')
           ->setCellValue('V1', 'TDS')
           ->setCellValue('W1', 'LWF')
           ->setCellValue('X1', 'Other Deduction')
           ->setCellValue('Y1', 'Customer')
           ->setCellValue('Z1', 'Priority');

   $model = EmpDetails::find()->where(['status' =>['Paid and Relieved','Active','']])
		  ->orWhere(['status' => null])
		  ->joinWith('remuneration')		  
          ->orderBy([new \yii\db\Expression("FIELD (emp_remuneration_details.salary_structure, 'Manager','Assistant Manager','Sr. Engineer - I','Sr. Engineer - II','Engineer','Trainee','Consolidated pay','Contract','Conventional','Moderan')")])    
        ->all();
  
   $row = 2;
   foreach ($model as $data) {
      $divname = Division::find()->where(['id' => $data->division_id])->one();
      $dataArray = array(
          $data->empcode,
          $data->empname,
          $data->designation->designation,
          $data->units->name,
          $divname['division_name'],
          $data->remuneration->salary_structure,
          $data->remuneration->work_level,
          $data->remuneration->grade,
      );
      $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
   }
   $i = 2;
   foreach ($model as $data) {
      $objValidation = $objPHPExcel->getActiveSheet()->getCell('Y' . $i)->getDataValidation();
      $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
      $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
      $objValidation->setAllowBlank(true);
      $objValidation->setShowInputMessage(true);
      $objValidation->setShowErrorMessage(true);
      $objValidation->setShowDropDown(true);
      $objValidation->setFormula1('=$AJ2:$AJ' . $custcounter);

      $objValidatio1 = $objPHPExcel->getActiveSheet()->getCell('Z' . $i)->getDataValidation();
      $objValidatio1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
      $objValidatio1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
      $objValidatio1->setAllowBlank(true);
      $objValidatio1->setShowInputMessage(true);
      $objValidatio1->setShowErrorMessage(true);
      $objValidatio1->setShowDropDown(true);
      $objValidatio1->setFormula1('"Yes,No"');
      $i++;
   }

   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:Z1");
   $objPHPExcel->getActiveSheet()->getStyle('A1:Y1')->getFont()->setBold(true);
   $objPHPExcel->getActiveSheet()->setAutoFilter('A1:Y1');
   $objPHPExcel->getActiveSheet()->freezePane('A2');
   $j = 2;
   $k = 2;

   foreach ($model as $data) {
      $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $j++ . ':Z' . $k++);
   }
   foreach (range('A', 'Z') as $columnID) {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
   }
/*} else if ($id == 2) {
   $filename = 'salary_process_staff.xlsx';
   $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Emp. Code')
           ->setCellValue('B1', 'Emp. Name')
           ->setCellValue('C1', 'Designation')
           ->setCellValue('D1', 'Unit')
           ->setCellValue('E1', 'Department')
           ->setCellValue('F1', 'Pay Scale')
           ->setCellValue('G1', 'Gross Amount')
           ->setCellValue('H1', 'Leave')
           ->setCellValue('I1', 'LOP')
           ->setCellValue('J1', 'OT')
           ->setCellValue('K1', 'Holiday Pay')
           ->setCellValue('L1', 'Arrear')
           ->setCellValue('M1', 'Other Allowance')
           ->setCellValue('N1', 'Advance')
           ->setCellValue('O1', 'Mobile Deductiono')
           ->setCellValue('P1', 'Loan')
           ->setCellValue('Q1', 'Insurance')
           ->setCellValue('R1', 'Rent')
           ->setCellValue('S1', 'TDS')
           ->setCellValue('T1', 'LWF')
           ->setCellValue('U1', 'Other deduction');

   $model = EmpDetails::find()->where(['and', 'etype = "Staff"', ['or', 'status="Active"', 'status="Paid and Relieved"']])->all();

   $row = 2;
   foreach ($model as $data) {
      $deptname = Department::find()->where(['id' => $data->department_id])->one();
      $dataArray = array(
          $data->ecode,
          $data->empname,
          $data->designation->designation,
          $data->units->name,
          $deptname['name'],
          $data->employeePayScale->package_name,
          $data->remuneration->gross_salary,
      );
      $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
   }

   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:U1");
   $objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
   $objPHPExcel->getActiveSheet()->setAutoFilter('A1:U1');
   $objPHPExcel->getActiveSheet()->freezePane('A2');
   $j = 2;
   $k = 2;

   foreach ($model as $data) {
      $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $j++ . ':U' . $k++);
   }
   foreach (range('A', 'U') as $columnID) {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
   }
} */

foreach (range('A', 'Z') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension('A' . $columnID)->setVisible(false);
}

$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
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

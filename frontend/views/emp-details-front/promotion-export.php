<?php

ob_start();

use common\models\EmpDetails;
use common\models\EmpPersonaldetails;
use common\models\EmpBankdetails;
use common\models\EmpCertificates;
use common\models\EmpStatutorydetails;
use common\models\EmpEducationdetails;
use common\models\Designation;
use common\models\Department;
use common\models\EmpAddress;
use common\models\Unit;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;

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
        ->setCellValue('A1', 'Emp. Code')
        ->setCellValue('B1', 'Emp. Name')    
        ->setCellValue('C1', 'Division')
        ->setCellValue('D1', 'Unit')
        ->setCellValue('E1', 'Department')
        ->setCellValue('F1', 'Latest Promotion Date')
        ->setCellValue('G1', 'Designation')
        ->setCellValue('H1', 'Salary Structure')
        ->setCellValue('I1', 'Work Level')
        ->setCellValue('J1', 'Grade')
        ->setCellValue('K1', 'Gross Salary');
$model = EmpDetails::find()->all();

// Designation row p 
$designation = Designation::find()->all();
$drow = 2;
foreach ($designation as $design) {
   $designationArray = array(
       $design->designation,
   );
   $objPHPExcel->getActiveSheet()->fromArray($designationArray, NULL, 'P' . $drow++);
}
$drow--;
$designationcounter = $drow;

// Unit row q
$unit = Unit::find()->all();
$urow = 2;
foreach ($unit as $unitdata) {
   $unitArray = array(
       $unitdata->name,
   );
   $objPHPExcel->getActiveSheet()->fromArray($unitArray, NULL, 'Q' . $urow++);
}
$urow--;
$unitcounter = $urow;

// Dept row r
$dept = Department::find()->all();
$deptrow = 2;
foreach ($dept as $department) {
   $deptArray = array(
       $department->name,
   );
   $objPHPExcel->getActiveSheet()->fromArray($deptArray, NULL, 'R' . $deptrow++);
}
$deptrow--;
$deptcounter = $deptrow;

// Staff PayScale

$PayScale = EmpStaffPayScale::find()->select('salarystructure')->all();
$structure = EmpSalarystructure::find()->select('salarystructure')->distinct()->all();

$salaryStructure = '';

foreach ($structure as $Scale) {
   $salaryStructure .=$Scale->salarystructure . ',';
}
$salaryStructure .='Consolidated pay,';
$salaryStructure .='Contract,';
foreach ($PayScale as $ss) {
   $salaryStructure .=$ss->salarystructure . ',';
}

$row = 2;
foreach ($model as $data) {
   $deptname = Department::find()->where(['id' => $data->department_id])->one();
   $modelRemu = EmpStaffPayScale::find()->where(['salarystructure' => $data->remuneration->salary_structure])->one();
   if ($modelRemu) {
      $gross = $data->remuneration->gross_salary;
   } else {
      $gross = '';
   }

   
   
   $dataArray = array(
       $data->empcode,
       $data->empname,
	   $data->division,
       $data->units->name,
       $deptname['name'],
	   $data->recentdop,
       $data->designation->designation,
       $data->remuneration->salary_structure,
       $data->remuneration->work_level,
       $data->remuneration->grade,
       $gross,     
   );
   $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:K1");
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:K1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

$i = 2;
foreach ($model as $data) {

  /* $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getDataValidation();
   $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation->setAllowBlank(true);
   $objValidation->setShowInputMessage(true);
   $objValidation->setShowErrorMessage(true);
   $objValidation->setShowDropDown(true);
   $objValidation->setFormula1('=$R2:$R' . $deptcounter);*/



   $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
   $objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation1->setAllowBlank(true);
   $objValidation1->setShowInputMessage(true);
   $objValidation1->setShowErrorMessage(true);
   $objValidation1->setShowDropDown(true);
   $objValidation1->setFormula1('=$P2:$P' . $designationcounter);


  /* $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
   $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation2->setAllowBlank(true);
   $objValidation2->setShowInputMessage(true);
   $objValidation2->setShowErrorMessage(true);
   $objValidation2->setShowDropDown(true);
   $objValidation2->setFormula1('=$Q2:$Q' . $unitcounter);*/

   $objValidation3 = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
   $objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation3->setAllowBlank(true);
   $objValidation3->setShowInputMessage(true);
   $objValidation3->setShowErrorMessage(true);
   $objValidation3->setShowDropDown(true);
   $objValidation3->setFormula1('"WL5,WL4C,WL4B,WL4A,WL3B,WL3A"');

   $objValidation4 = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
   $objValidation4->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation4->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation4->setAllowBlank(true);
   $objValidation4->setShowInputMessage(true);
   $objValidation4->setShowErrorMessage(true);
   $objValidation4->setShowDropDown(true);
   $objValidation4->setFormula1('"A,B,C,D"');



   $objValidation16 = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
   $objValidation16->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation16->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation16->setAllowBlank(true);
   $objValidation16->setShowInputMessage(true);
   $objValidation16->setShowErrorMessage(true);
   $objValidation16->setShowDropDown(true);
   $objValidation16->setFormula1('"' . $salaryStructure . '"');

   $i++;
}


$j = 2;
$k = 2;

foreach ($model as $data) {
   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $j++ . ':K' . $k++);
}
$j--;
$k--;
foreach (range('A', 'K') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); 
}
foreach (range('M', 'Z') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setVisible(false);
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
header('Content-Disposition: attachment;filename="EmployeeMaster.xlsx"');
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

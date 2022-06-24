<?php
ob_start();
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Department;
use common\models\Division;
use common\models\Unit;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

error_reporting(0);

$objPHPExcel = new Spreadsheet();

$sharedStyle1 = new Style();
$sharedStyle2 = new Style();
$sharedStyle3 = new Style();
$sharedStyle4 = new Style();

$sharedStyle1->applyFromArray(
    ['fill' => [
      'fillType' => Fill::FILL_SOLID,
      'color' => ['argb' => 'FFE5E5E5'],
    ],
    'borders' => [
      'bottom' => ['borderStyle' => Border::BORDER_THIN],
      'right' => ['borderStyle' => Border::BORDER_MEDIUM],
    ],
  ]
);

$sharedStyle2->applyFromArray(
  ['borders' => [
    'bottom' => ['borderStyle' => Border::BORDER_DOTTED],
    'right' => ['borderStyle' => Border::BORDER_DOTTED],
  ],
]);

	$sharedStyle3->applyFromArray(
	  ['borders' => [
		'bottom' => ['borderStyle' => Border::BORDER_THIN],
		'color' => ['argb' => 'FFFF0000'],
	  ],
	]);

	$sharedStyle4->applyFromArray(
	  ['borders' => [
		'right' => ['borderStyle' => Border::BORDER_THIN],
		'color' => ['argb' => 'FFFF0000'],
	  ],
	]);


	$objPHPExcel->getActiveSheet()
	->setCellValue('A1', 'Emp. Code')
	->setCellValue('B1', 'Emp. Name')
	->setCellValue('C1', 'Designation')
	->setCellValue('D1', 'Unit')
	->setCellValue('E1', 'Department')
	->setCellValue('F1', 'Bonus');
		
		$model = EmpDetails::find()->Where(['status'=>'Active'])->all();

	$row = 2;
	foreach ($model as $data) {
	   $deptname = Department::find()->where(['id' => $data->department_id])->one();
	   $divname = Division::find()->where(['id' => $data->division_id])->one();
	   $design = Designation::find()->where(['id' =>$data->designation_id])->one();
	   
		if($design){
			$designationdata = $design->designation;
			} else {
			$designationdata = '';
			}
		
		$Unitmodel = Unit::find()->where(['id' =>$data->unit_id])->one();		
			if($Unitmodel){
				$unitdata = $Unitmodel->name;
				} else {
				$unitdata = '';
				}
	  
	   $dataArray = array(
		   $data->empcode,
		   $data->empname,	 
		   $designationdata,      
		   $unitdata .'/'.$divname['division_name'],
		   $deptname['name'],	  
	   );
	   $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
	}
$row--;

$objPHPExcel->getActiveSheet()->duplicateStyle($sharedStyle1, "A1:F1");
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:F1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);


foreach (range('A', 'F') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true); 
}

$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
$writer->save('php://output');
exit;
?>

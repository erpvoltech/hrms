<?php

ob_start();

use common\models\EmpDetails;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;

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
        ->setCellValue('C1', 'DoJ')
        ->setCellValue('D1', 'Y M D')
        ->setCellValue('E1', 'Experience')       
	    ->setCellValue('F1', 'Division')
		 ->setCellValue('G1', 'Unit');

$exporttype = Yii::$app->getRequest()->getQueryParam('type');

/* $conditions = [];

  $query = 'SELECT * FROM emp_details';
  if (count($conditions) > 0) {
  $query .= " WHERE " . implode(' AND ', $conditions);
  $model = EmpDetails::findBySql($query)->all();
  } else {
  $model = EmpDetails::find()->all();
  } */


$model = EmpDetails::find()->
		Where(['=','status','Active'])
		->orderBy(['doj'=>SORT_ASC,])
		->all();

$row = 2;

foreach ($model as $data) {

    $flag = 1;

    $unit = Unit::find()->where(['id' => $data->unit_id])->one();
    $division = Division::find()->where(['id' => $data->division_id])->one();
    $currentDt = date('Y-m-d');
    $cd = date_create($currentDt);

    $doj = date_create(date('Y-m-d', strtotime($data['doj'])));
    $diff = date_diff($cd, $doj);
    $totalYears = $diff->format("%y");
	$totalMonths = $diff->format("%m");
	$totalDays = $diff->format("%d");

	$totalExp = $totalYears.' Years '.$totalMonths.' Months '.$totalDays.' Days';
	$totalYr = $totalYears.'.'.$totalMonths;

  
        $dataArray = array(
            $data->empcode,
            $data->empname,          
            Yii::$app->formatter->asDate($data->doj, "dd-MM-yyyy"),
            $totalExp,
			$totalYr,            
		    $division['division_name'],
			$unit['name'],
        );
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
  

}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:G1");
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:G1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

foreach (range('A', 'I') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);

$callStartTime = microtime(true);


// Redirect output to a client???s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Probation Expired List.xlsx"');
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
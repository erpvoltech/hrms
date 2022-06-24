<?php

ob_start();

use app\models\VgInsuranceVehicle;
use app\models\VgInsuranceCompany;
use app\models\VgInsuranceAgents;
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Department;
use common\models\EmpPersonaldetails;
use common\models\EmpFamilydetails;
use common\models\EmpAddress;

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
        ->setCellValue('A1', 'Name')
        ->setCellValue('B1', 'Calling Name')
        ->setCellValue('C1', 'Father`s Name')
        ->setCellValue('D1', 'Designation')
        ->setCellValue('E1', 'Project Name')
        ->setCellValue('F1', 'Other Company')
        ->setCellValue('G1', 'Department')
        ->setCellValue('H1', 'Blood Group')
        ->setCellValue('I1', 'Date of Birth')
        ->setCellValue('J1', 'Date of Joining')
        ->setCellValue('K1', 'Contact Number')
		->setCellValue('L1', 'Emergency Contact Number')
        ->setCellValue('M1', 'Identification Marks')
		->setCellValue('N1', 'Permanent Address')
		->setCellValue('O1', 'Ecode');
      



    $model = EmpDetails::find()->where(['status'=>'active'])->orderBy('doj DESC')->all();


$row = 2;
foreach ($model as $data) {
    $emp_person = EmpPersonaldetails::find()->where(['empid'=>$data->id])->one();
	$emp_family = EmpFamilydetails::find()->where(['empid'=>$data->id,'relationship'=>'father'])->one();
    $emp_address = EmpAddress::find()->where(['empid'=>$data->id])->one();
	
	if($emp_address->addfield1){
		$address1 = $emp_address->addfield1;
	}
	if($emp_address->addfield2){
		$address2 = $emp_address->addfield2;
	}
	if($emp_address->addfield3){
		$address3 = $emp_address->addfield3;
	}
	if($emp_address->addfield4){
		$address4 = $emp_address->addfield4;
	}
	if($emp_address->addfield4){
		$address5 = $emp_address->addfield5;
	}
   
        $address = $address1 .', ' .$address2 .', ' .$address3.', ' .$address4.', ' .$address5.', ' .$emp_address->district.', ' .$emp_address->state.' - ' .$emp_address->pincode;
		
  
        $dataArray = array(
          
            strtoupper($data->empname),
			'',
            $emp_family->name,
            $data->designation->designation,
            '',
			'',
            $data->department->name,
            $emp_person->blood_group,
			Yii::$app->formatter->asDate($emp_person->dob, "dd-MM-yyyy"),            
			Yii::$app->formatter->asDate($data->doj, "dd-MM-yyyy"),         	
            $emp_person->mobile_no,
			'',
           '',
            $address,
            $data->empcode,
        );
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
   
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:O1");
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:O1');
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setVisible(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setVisible(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setVisible(false);
$objPHPExcel->setActiveSheetIndex(0);

foreach (range('A', 'O') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);

$callStartTime = microtime(true);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Id Card.xlsx"');
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
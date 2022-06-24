<?php
ob_start();
use common\models\EmpDetails;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use common\models\ProjectEmp;
use app\models\SkillSet;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;

error_reporting(0);

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
						'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
					
		));

		$sharedStyle2->applyFromArray(
				array('borders' => array(
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
		));
		
		$sharedStyle3->applyFromArray(
				array('borders' => array(
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),						
						'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
		));
		
		$sharedStyle4->applyFromArray(
				array('fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('argb' => 'FFE5E5E5')
					),
					'borders' => array(
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),						
						'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
					
		));

$objPHPExcel = new \PHPExcel();

$projectEmp = ProjectEmp::find()->Where(['project_id'=>$model->id,'date_of_exit' => NULL])->all();
$Skill= SkillSet::find()->Where(['zone'=>$model->zone])->one();
		
								
$objPHPExcel->getActiveSheet()
        ->setCellValue('A1', 'Sl. No')
        ->setCellValue('B1', 'E Code')
        ->setCellValue('C1', 'Name')
		->setCellValue('D1', 'D1 IN')
		->setCellValue('E1', 'D1 OUT')
		->setCellValue('F1', 'D2 IN')
		->setCellValue('G1', 'D2 OUT')
		->setCellValue('H1', 'D3 IN')
		->setCellValue('I1', 'D3 OUT')
		->setCellValue('J1', 'D4 IN')
		->setCellValue('K1', 'D4 OUT')	
		->setCellValue('L1', 'D5 IN')	
		->setCellValue('M1', 'D5 OUT')
		->setCellValue('N1', 'D6 IN')
		->setCellValue('O1', 'D6 OUT')
		->setCellValue('P1', 'D7 IN')
		->setCellValue('Q1', 'D7 OUT')
		->setCellValue('R1', 'D8 IN')
		->setCellValue('S1', 'D8 OUT')
		->setCellValue('T1', 'D9 IN')			
		->setCellValue('U1', 'D9 OUT')
		->setCellValue('V1', 'D10 IN')
		->setCellValue('W1', 'D10 OUT')
		->setCellValue('X1', 'D11 IN')
		->setCellValue('Y1', 'D11 OUT')
		->setCellValue('Z1', 'D12 IN')
		->setCellValue('AA1', 'D12 OUT')
		->setCellValue('AB1', 'D13 IN')
		->setCellValue('AC1', 'D13 OUT')
		->setCellValue('AD1', 'D14 IN')
		->setCellValue('AE1', 'D14 OUT')
		->setCellValue('AF1', 'D15 IN')
		->setCellValue('AG1', 'D15 OUT')
		->setCellValue('AH1', 'D16 IN')
		->setCellValue('AI1', 'D16 OUT')
		->setCellValue('AJ1', 'D17 IN')
		->setCellValue('AK1', 'D17 OUT')
		->setCellValue('AL1', 'D18 IN')
		->setCellValue('AM1', 'D18 OUT')
		->setCellValue('AN1', 'D19 IN')
		->setCellValue('AO1', 'D19 OUT')
		->setCellValue('AP1', 'D20 IN')
		->setCellValue('AQ1', 'D20 OUT')
		->setCellValue('AR1', 'D21 IN')
		->setCellValue('AS1', 'D21 OUT')
		->setCellValue('AT1', 'D22 IN')			
		->setCellValue('AU1', 'D22 OUT')
		->setCellValue('AV1', 'D23 IN')
		->setCellValue('AW1', 'D23 OUT')
		->setCellValue('AX1', 'D24 IN')
		->setCellValue('AY1', 'D24 OUT')
		->setCellValue('AZ1', 'D25 IN')
		->setCellValue('BA1', 'D25 OUT')
		->setCellValue('BB1', 'D26 IN')
		->setCellValue('BC1', 'D26 OUT')
		->setCellValue('BD1', 'D27 IN')
		->setCellValue('BE1', 'D27 OUT')
		->setCellValue('BF1', 'D28 IN')
		->setCellValue('BG1', 'D28 OUT')
		->setCellValue('BH1', 'D29 IN')
		->setCellValue('BI1', 'D29 OUT')
		->setCellValue('BJ1', 'D30 IN')
		->setCellValue('BK1', 'D30 OUT')
		->setCellValue('BL1', 'D31 IN')
		->setCellValue('BM1', 'D31 OUT')
		->setCellValue('BN1', 'Days')
		->setCellValue('BO1', 'Hours');
		
		$row = 2;
		$sl_no = 1;
		foreach ($projectEmp as $data) {
		$Emp = EmpDetails::find()->Where(['id'=>$data->emp_id])->one();
		
		$dataArray = array(
					   $sl_no,
					   $Emp->empcode,
					   $Emp->empname,					  
				   );
				   
		$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++); 
		$sl_no++;
		}
		$row--;
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:BO1");
//$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:BO1')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->setAutoFilter('A1:O1');
$objPHPExcel->getActiveSheet()->freezePane('A2');
foreach (range('A', 'Z') as $columnID) {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
   }
foreach (range('A', 'Z') as $columnID) {
      $objPHPExcel->getActiveSheet()->getColumnDimension('A'.$columnID)->setAutoSize(true);
   }
   
   foreach (range('A', 'O') as $columnID) {
      $objPHPExcel->getActiveSheet()->getColumnDimension('B'.$columnID)->setAutoSize(true);
   }
$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="template_att_IR.xlsx"');
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
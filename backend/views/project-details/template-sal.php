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
        ->setCellValue('D1', 'Rate of Wages')
        ->setCellValue('E1', 'Special Basic')
        ->setCellValue('F1', 'HRA')
        ->setCellValue('G1', 'Canteen Allowance')       
        ->setCellValue('H1', 'Transport Allowance')
		->setCellValue('I1', 'Washing Allowance')
        ->setCellValue('J1', 'Others Allowance')
        ->setCellValue('K1', 'Society')
        ->setCellValue('L1', 'Income Tax')
        ->setCellValue('M1', 'Insurance')
        ->setCellValue('N1', 'Others')
        ->setCellValue('O1', 'Recoveries');      
		
		$row = 2;
		$sl_no = 1;
		foreach ($projectEmp as $data) {
		$Emp = EmpDetails::find()->Where(['id'=>$data->emp_id])->one();
		$wage_skill = $data->category;
		$present_days = 27;
			 $dataArray = array(
					   $sl_no,
					   $Emp->empcode,
					   $Emp->empname,
					   $Skill[$wage_skill],
				   );
				   
				    $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++); 
		$sl_no++;
		}
		$row--;
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:O1");
//$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:O1');
$objPHPExcel->getActiveSheet()->freezePane('A1');
foreach (range('A', 'O') as $columnID) {
      $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
   }

$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="template_sal_HR.xlsx"');
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
<?php
use yii\helpers\Html;
use common\models\Unit;
use common\models\UnitGroup;
use common\models\EmpDetails;
use common\models\Division;
use common\models\EmpSalary;
use yii\jui\DatePicker;	
use common\models\SalaryMonth;
use common\models\EmpRemunerationDetails;
error_reporting(0);

$modelUnit = Unit::find()->orderBy('id')->all();
$ModelEmp = EmpDetails::find()->one();
$salmonth = SalaryMonth::find()->orderBy(['id'=> SORT_DESC])->one();

	if($_GET['dt']){		
		$value = Yii::$app->formatter->asDate($_GET['dt'], "dd-MM-yyyy");		
	} else {	
		$value = Yii::$app->formatter->asDate($salmonth->month, "dd-MM-yyyy");		
	}
	
	
	$styleArray = array(
		'font'  => array(
		'size'  => 12,
		'name'  => 'Century Gothic'
	));
	
	$outlineArray = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('argb' => '4c4c4c'),
				),
			),
		);
	
	
	$sharedStyle1 = new PHPExcel_Style();
	$sharedStyle2 = new PHPExcel_Style();
	$sharedStyle3 = new PHPExcel_Style();
	$sharedStyle4 = new PHPExcel_Style();

		$sharedStyle1->applyFromArray(
				array('fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('argb' => '4c4c4c')
					),
					'borders' => array(
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
					)
		));		

		$sharedStyle2->applyFromArray(
				array('borders' => array(
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
						'top' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED)
					)
		));
		
		$sharedStyle3->applyFromArray(
				array('fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('argb' => 'f5f5f5')
					),
					'borders' => array(
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
						'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
		));
		
		$sharedStyle4->applyFromArray(
				array('fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('argb' => '4c4c4c')
					),
					'borders' => array(						
						'right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED)						
					)
		));
		
		$filename = 'MDReport.xlsx';
		$objPHPExcel = new PHPExcel();
		$sheet = 0;	
		foreach ($modelUnit as $unit){
			$row =4;
			$objPHPExcel->createSheet();
			$objPHPExcel->setActiveSheetIndex($sheet);
 	
			$objPHPExcel->getActiveSheet()->mergeCells('B1:H1')
										->mergeCells('B2:H2');
			$monthtxt = $unit->name. ' UNIT WISE ENGINEERS SALARY REPORT - '.date('F Y',strtotime($value));
			$objPHPExcel->getActiveSheet() ->setCellValue('B1', 'VOLTECH ENGINEERS PRIVATE LIMITED')						
						->setCellValue('B2', $monthtxt);
			
			$objPHPExcel->getActiveSheet()
						->setCellValue('B3', 'Sl.No')
						->setCellValue('C3', 'Unit')
						->setCellValue('D3', 'Engg. Strength')
						->setCellValue('E3', 'Gross Salary')
						->setCellValue('F3', 'Nett Salary')
						->setCellValue('G3', 'Nett Allowance Paid')
						->setCellValue('H3', 'CTC');
			
			$objPHPExcel->getActiveSheet()->setTitle($unit->name);			
			foreach (range('B', 'H') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
					}
					
			$divarry = array("Cluster A", "Cluster B", "Cluster C","Cluster D");
			$arrlength = count($divarry);
			
			$totengg = 0;
			$totengg_gross = 0;
			$totengg_net = 0;
			$totengg_allowance = 0;
			$totengg_ctc = 0;
			$i=1;
			$fstratrow =4;
			//for($x = 0; $x < $arrlength; $x++) {
			$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();
			foreach($UnitGroupModel as $groupmodel){
				//$division = Division::find()->where(['LIKE', 'division_name', $divarry[$x]])->all();
				$div = Division::find()->Where(['id'=>$groupmodel->division_id])->One();
				//foreach($division as $div){			
					$engg_count =0;
					$engg_grossamt = 0;
					$engg_netamt = 0;
					$engg_paidallowance = 0;
					$engg_ctc = 0;
					
						$queryengg = EmpSalary::find()->joinWith('employee')
						->where(['emp_salary.division_id' => $div->id,'emp_salary.unit_id'=>$unit->id,'month'=>Yii::$app->formatter->asDate($value, "yyyy-MM-dd"),'emp_details.category'=>['International Engineer','Domestic Engineer']])				
						->all();
						
						foreach($queryengg as $EnggReport){
							$engg_count +=1;
							$remu = EmpRemunerationDetails::find()->where(['empid'=>$EnggReport->empid])->one();
							$engg_grossamt +=$remu->gross_salary;
							$engg_netamt += $EnggReport->net_amount;
							$engg_paidallowance += $EnggReport->paidallowance;
							$engg_ctc += $EnggReport->earned_ctc;					
							}
						$totengg += $engg_count;
						$totengg_gross += $engg_grossamt;
						$totengg_net += $engg_netamt;
						$totengg_allowance += $engg_paidallowance;
						$totengg_ctc += $engg_ctc;
						if(!empty($engg_count)){
							$dataArray = array(
								$i,
								$div->division_name,
								$engg_count,
								$engg_grossamt,
								$engg_netamt,
								$engg_paidallowance,
								$engg_ctc,
							);	
							$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'B'.$row.':H'.$row);
							$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'B' . $row++);							
							$i++;
						}		
				}
				$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
				$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, 'B'.$row.':H'.$row);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$fstratrow.':H'.$row)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Sub Total')												
												->setCellValue('D'.$row, '=SUM(D'.$fstratrow.':D'.($row-1).')')												
												->setCellValue('E'.$row, '=SUM(E'.$fstratrow.':E'.($row-1).')')
												->setCellValue('F'.$row, '=SUM(F'.$fstratrow.':F'.($row-1).')')
												->setCellValue('G'.$row, '=SUM(G'.$fstratrow.':G'.($row-1).')')
												->setCellValue('H'.$row, '=SUM(D'.$fstratrow.':H'.($row-1).')');												
																					
				$row++;
				$fstratrow = $row;
			//}
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, 'B'.$row.':H'.$row);		
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Grand Total')												
												->setCellValue('D'.$row, $totengg)												
												->setCellValue('E'.$row, $totengg_gross)
												->setCellValue('F'.$row, $totengg_net)
												->setCellValue('G'.$row, $totengg_allowance)
												->setCellValue('H'.$row, $totengg_ctc);
			
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':H'.$row)->applyFromArray($styleArray);
			
			$objPHPExcel->getActiveSheet()->getStyle('B3:H'.$row)->applyFromArray($outlineArray);
			
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "B3:H3");			 
			$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('B3:H3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
			$objPHPExcel->getActiveSheet()->getStyle('B1:H3')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getRowDimension('B3:H3')->setRowHeight(50);
			$sheet++;
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

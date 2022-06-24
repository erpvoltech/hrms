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
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objPHPExcel->getActiveSheet()->setTitle('STAFF');
		// Staff Report
			$row =4;
			$objPHPExcel->getActiveSheet()->mergeCells('B1:G1')
										->mergeCells('B2:G2');
			$monthtxt = ' UNIT WISE STAFF SALARY REPORT - '.date('F Y',strtotime($value));
			$objPHPExcel->getActiveSheet() ->setCellValue('B1', 'VOLTECH ENGINEERS PRIVATE LIMITED')						
						->setCellValue('B2', $monthtxt);
			
			$objPHPExcel->getActiveSheet()
						->setCellValue('B3', 'Sl.No')
						->setCellValue('C3', 'Unit')
						->setCellValue('D3', 'Staff Strength')
						->setCellValue('E3', 'Gross Salary')
						->setCellValue('F3', 'Net Salary')						
						->setCellValue('G3', 'CTC');
						
			foreach (range('B', 'G') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
					}
			
			$totengg = 0;
			$totengg_gross = 0;
			$totengg_net = 0;
			$totengg_allowance = 0;
			$totengg_ctc = 0;
			$i=1;
			
			foreach ($modelUnit as $unit){
				$engg_count =0;
				$engg_grossamt = 0;
				$engg_netamt = 0;
				$engg_paidallowance = 0;
				$engg_ctc = 0;
				
					$queryengg = EmpSalary::find()->joinWith('employee')
					->where(['emp_salary.unit_id'=>$unit->id,'month'=>Yii::$app->formatter->asDate($value, "yyyy-MM-dd"),'emp_details.category'=>['HO Staff','BO Staff']])				
					->all();
					
					foreach($queryengg as $EnggReport){
						$engg_count +=1;
						$remu = EmpRemunerationDetails::find()->where(['empid'=>$EnggReport->empid])->one();
						//$engg_grossamt +=$remu->gross_salary;
						$engg_grossamt +=$EnggReport->earnedgross;
						$engg_netamt += $EnggReport->net_amount;
						$engg_ctc += $EnggReport->earned_ctc;					
						}
					$totengg += $engg_count;
					$totengg_gross += $engg_grossamt;
					$totengg_net += $engg_netamt;
					$totengg_ctc += $engg_ctc;
					$dataArray = array(
						$i,
						$unit->name,
						$engg_count,
						$engg_grossamt,
						$engg_netamt,
						$engg_ctc,
					);	
					$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'B'.$row.':G'.$row);
					$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'B' . $row++);							
					$i++;
			}
		
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
		$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, 'B'.$row.':G'.$row);		
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Grand Total')												
											->setCellValue('D'.$row, $totengg)												
											->setCellValue('E'.$row, $totengg_gross)
											->setCellValue('F'.$row, $totengg_net)
											->setCellValue('G'.$row, $totengg_ctc);
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getStyle('B3:G'.$row)->applyFromArray($outlineArray);
		
		$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "B3:G3");			 
		$objPHPExcel->getActiveSheet()->getStyle('B3:G3')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B3:G3')->getAlignment()->setWrapText(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('B3:G3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle('B1:G3')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getRowDimension('B3:G3')->setRowHeight(50);
		$sheet++;
		
		// Overall Report
		
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objPHPExcel->getActiveSheet()->setTitle('OVERALL');
		
			$row =5;
			$objPHPExcel->getActiveSheet()->mergeCells('B1:K1')
										->mergeCells('B2:K2');
			$monthtxt = 'INDEPENDENT COMPANYWISE SALARY REPORT - '.date('F Y',strtotime($value));
			$objPHPExcel->getActiveSheet() ->setCellValue('B1', 'VOLTECH ENGINEERS PRIVATE LIMITED')						
						->setCellValue('B2', $monthtxt);
			$objPHPExcel->getActiveSheet()						
						->setCellValue('D3', 'Staff')
						->setCellValue('H3', 'Engineer');
			$objPHPExcel->getActiveSheet()
						->setCellValue('B4', 'Sl.No')
						->setCellValue('C4', 'Unit')
						->setCellValue('D4', 'Manpower')
						->setCellValue('E4', 'Gross Salary')
						->setCellValue('F4', 'Nett Salary')						
						->setCellValue('G4', 'CTC')
						->setCellValue('H4', 'Manpower')
						->setCellValue('I4', 'Gross Salary')
						->setCellValue('J4', 'Nett Salary')						
						->setCellValue('K4', 'CTC');
			$objPHPExcel->getActiveSheet()->mergeCells('D3:G3');
			$objPHPExcel->getActiveSheet()->mergeCells('H3:K3');
			foreach (range('B', 'K') as $columnID) {
						$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
					}
			
			$totengg = 0;
			$totengg_gross = 0;
			$totengg_net = 0;
			$totengg_ctc = 0;
			
			$totengg2 = 0;
			$totengg_gross2 = 0;
			$totengg_net2 = 0;
			$totengg_ctc2 = 0;
			$i=1;
			
			foreach ($modelUnit as $unit){
				$engg_count =0;
				$engg_grossamt = 0;
				$engg_netamt = 0;
				$engg_paidallowance = 0;
				$engg_ctc = 0;				
				
				$engg_count2 =0;
				$engg_grossamt2 = 0;
				$engg_netamt2 = 0;
				$engg_paidallowance2 = 0;
				$engg_ctc2 = 0;
				
					$queryengg = EmpSalary::find()->joinWith('employee')
					->where(['emp_salary.unit_id'=>$unit->id,'month'=>Yii::$app->formatter->asDate($value, "yyyy-MM-dd"),'emp_details.category'=>['HO Staff','BO Staff']])				
					->all();
					
					$queryengg2 = EmpSalary::find()->joinWith('employee')
					->where(['emp_salary.unit_id'=>$unit->id,'month'=>Yii::$app->formatter->asDate($value, "yyyy-MM-dd"),'emp_details.category'=>['International Engineer','Domestic Engineer']])				
					->all();
					
					foreach($queryengg as $EnggReport){
						$engg_count +=1;
						$remu = EmpRemunerationDetails::find()->where(['empid'=>$EnggReport->empid])->one();
						//$engg_grossamt +=$remu->gross_salary;
						$engg_grossamt +=$EnggReport->earnedgross;
						$engg_netamt += $EnggReport->net_amount;
						$engg_ctc += $EnggReport->earned_ctc;					
						}
					foreach($queryengg2 as $EnggReport2){
						$engg_count2 +=1;
						$remu2 = EmpRemunerationDetails::find()->where(['empid'=>$EnggReport2->empid])->one();
						//$engg_grossamt2 +=$remu2->gross_salary;
						$engg_grossamt2 +=$EnggReport2->earnedgross;
						$engg_netamt2 += $EnggReport2->net_amount;
						$engg_ctc2 += $EnggReport2->earned_ctc;					
						}
					$totengg += $engg_count;
					$totengg_gross += $engg_grossamt;
					$totengg_net += $engg_netamt;
					$totengg_ctc += $engg_ctc;
					
					$totengg2 += $engg_count2;
					$totengg_gross2 += $engg_grossamt2;
					$totengg_net2 += $engg_netamt2;
					$totengg_ctc2 += $engg_ctc2;
		
					$dataArray = array(
						$i,
						$unit->name,
						$engg_count,
						$engg_grossamt,
						$engg_netamt,
						$engg_ctc,
						$engg_count2,
						$engg_grossamt2,
						$engg_netamt2,
						$engg_ctc2,
					);	
					$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'B'.$row.':K'.$row);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':K'.$row)->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'B' . $row++);							
					$i++;
			}
		
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':C'.$row);
		$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, 'B'.$row.':K'.$row);		
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Grand Total')												
											->setCellValue('D'.$row, $totengg)												
											->setCellValue('E'.$row, $totengg_gross)
											->setCellValue('F'.$row, $totengg_net)
											->setCellValue('G'.$row, $totengg_ctc)
											->setCellValue('H'.$row, $totengg2)												
											->setCellValue('I'.$row, $totengg_gross2)
											->setCellValue('J'.$row, $totengg_net2)
											->setCellValue('K'.$row, $totengg_ctc2);
		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':K'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':K'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':K'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':K'.$row)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getStyle('B3:K'.$row)->applyFromArray($outlineArray);
		
		$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "B3:K4");			 
		$objPHPExcel->getActiveSheet()->getStyle('B3:K4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B3:K4')->getAlignment()->setWrapText(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('B3:K4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
		$objPHPExcel->getActiveSheet()->getStyle('B1:K4')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B1:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet++;
		
		// Engineer Report
		
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
					
			$divarry = array("BU I", "BU II", "BU III");
			$arrlength = count($divarry);
			
			$totengg = 0;
			$totengg_gross = 0;
			$totengg_net = 0;
			$totengg_allowance = 0;
			$totengg_ctc = 0;
			$i=1;
			$fstratrow =4;
			if($unit->name == 'IC D1' || $unit->name == 'IC D2'){				
				
				for($x = 0; $x < $arrlength; $x++) {
						$division = Division::find()->where(['LIKE', 'division_name', $divarry[$x]])->all();
						foreach($division as $div){			
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
									//$engg_grossamt +=$remu->gross_salary;
									$engg_grossamt +=$EnggReport->earnedgross;
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
														->setCellValue('H'.$row, '=SUM(H'.$fstratrow.':H'.($row-1).')');												
																							
						$row++;
						$fstratrow = $row;
					}
				
			} else {
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
							//$engg_grossamt +=$remu->gross_salary;
							$engg_grossamt +=$EnggReport->earnedgross;
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
												->setCellValue('H'.$row, '=SUM(H'.$fstratrow.':H'.($row-1).')');												
																					
				$row++;
				$fstratrow = $row;
			}
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

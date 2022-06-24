<?php
use common\models\EmpDetails;
use common\models\EmpBankdetails;
use common\models\EmpStatutorydetails;
use common\models\EmpSalary;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use app\models\SalaryStatementsearch;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\UnitGroup;
error_reporting(0);
	   if (Yii::$app->getRequest()->getQueryParam('month'))
		   $month = Yii::$app->getRequest()->getQueryParam('month');
		else
		   $month = '';  
		   
		if (Yii::$app->getRequest()->getQueryParam('group')) {
		   $group = Yii::$app->getRequest()->getQueryParam('group');
		   $groupdata = Yii::$app->getRequest()->getQueryParam('group');
		   $groupda = serialize($groupdata);
		} else {  
		   $group ='';
		}

		if (Yii::$app->getRequest()->getQueryParam('unit')) {
		   $unit = Yii::$app->getRequest()->getQueryParam('unit');
		   $unitdata = Yii::$app->getRequest()->getQueryParam('unit');
		   $unitda = serialize($unitdata);
		} else {  
		   $unit ='';
		}
		   
		
		$styleArray = array(
			'font'  => array(
			'size'  => 12,
			'name'  => 'Century Gothic'
			));
	
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
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
		));
		
		$filename = 'salary_statement.xlsx';
		$objPHPExcel = new PHPExcel();
		
		
		
		if($dataunit = unserialize($unitda)){
		$modelUnit = Unit::find()->Where(['IN','id',$dataunit])->orderBy('id')->all();
		} else {		
			$modelUnit = Unit::find()->orderBy('id')->all();  
		}
		//$modelUnit = Unit::find()->orderBy('id')->all();
		$sheet = 0;	
		$cslno = 1;
		foreach ($modelUnit as $unit){
		
		$grand_paidallowance = 0;
		$grand_basic = 0;
		$grand_hra = 0;
		$grand_da = 0;
		$grand_otherallownace = 0;
		$grand_conveyance = 0;
		$grand_ot = 0;
		$grand_arrear = 0;
		$grand_adv_arr_tes = 0;
		$grand_lta = 0;
		$grand_med = 0;
		$grand_guaranted = 0;
		$grand_misc = 0;
		$grand_special = 0;
		$grand_total_earning = 0;
		$grand_pf = 0;	$grand_esi = 0; $grand_pt = 0; $grand_tes = 0; $grand_mobile = 0; $grand_loan = 0; 
		$grand_rent = 0; $grand_tds = 0; $grand_lwf = 0; $grand_otherdeduction = 0; $grand_total_deduction = 0; $grand_netamt = 0; 
		$grand_er_pf = 0; $grand_er_esi = 0; $grand_er_ltd = 0; $grand_er_med = 0;$grand_er_pli = 0;
		$grand_ctc = 0;
			
			$row =6;
			$fstratrow =6;
			$objPHPExcel->createSheet();
			$objPHPExcel->setActiveSheetIndex($sheet);		
			
			$objPHPExcel->getActiveSheet()->mergeCells('A1:AX1');	
			$objPHPExcel->getActiveSheet()->mergeCells('A2:AX2');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Voltech Engineers Pvt. Ltd');
			$objPHPExcel->getActiveSheet()->mergeCells('A3:AX3');
			$objPHPExcel->getActiveSheet()->setCellValue('A3',date("F", strtotime($month))." Salary Summary -".$unit->name);
			$objPHPExcel->getActiveSheet()->mergeCells('A4:AX4');
			$objPHPExcel->getActiveSheet()->getStyle('A1:AX4')->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A2:AX3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2:AX3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
			$objPHPExcel->getActiveSheet()
			->setCellValue('A5', 'Sl.No')
			->setCellValue('B5', 'Sl.No')
			->setCellValue('C5', 'Sl.No')
			->setCellValue('D5', 'Emp. Code')
			->setCellValue('E5', 'Emp. Name')    
			->setCellValue('F5', 'Designation')
			->setCellValue('G5', 'DoJ')
			->setCellValue('H5', 'Paid Days')
			->setCellValue('I5', 'Paid Allowance')
			->setCellValue('J5', 'Basic')
			->setCellValue('K5', 'HRA')
			->setCellValue('L5', 'DA')
			->setCellValue('M5', 'Other Allowance')
			->setCellValue('N5', 'Conveyance Allowance')
			->setCellValue('O5', 'Over Time')
			->setCellValue('P5', 'Arrear')
			->setCellValue('Q5', 'Advance/Arrear TES')
			->setCellValue('R5', 'LTA Earning')
			->setCellValue('S5', 'Medical Earning')
			->setCellValue('T5', 'Person pay')
			->setCellValue('U5', 'Guaranteed Benefit')
			->setCellValue('V5', 'Holiday Pay')
			->setCellValue('W5', 'Washing Allowance')
			->setCellValue('X5', 'Dust Allowance')
			->setCellValue('Y5', 'Miscellaneous')
			->setCellValue('Z5', 'Special Allowance')			
			->setCellValue('AA5', 'Total Earning')
			->setCellValue('AB5', 'PF')
			->setCellValue('AC5', 'ESI')
			->setCellValue('AD5', 'PT')
			->setCellValue('AE5', 'TES')
			->setCellValue('AF5', 'Caution Deposit')
			->setCellValue('AG5', 'Mobile')
			->setCellValue('AH5', 'Loan')
			->setCellValue('AI5', 'Rent')
			->setCellValue('AJ5', 'TDS')
			->setCellValue('AK5', 'LWF')
			->setCellValue('AL5', 'Advance')
			->setCellValue('AM5', 'Insurance')
			->setCellValue('AN5', 'Other Deduction')
			->setCellValue('AO5', 'Total Deduction')
			->setCellValue('AP5', 'Net Amount')
			->setCellValue('AQ5', 'PF Employer Contribution')
			->setCellValue('AR5', 'ESI Employer Contribution')		
			->setCellValue('AS5', 'LTA Employer Contribution')
			->setCellValue('AT5', 'MED Employer Contribution')
			->setCellValue('AU5', 'PLI Employer Contribution')
			->setCellValue('AV5', 'Food Allowance')
			->setCellValue('AW5', 'Earned CTC')
			->setCellValue('AX5', 'Bank Transfer');
		
			$objPHPExcel->getActiveSheet()->setTitle($unit->name);			
			foreach (range('A', 'Z') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
			}	
			foreach (range('A', 'X') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension('A' . $columnID)->setAutoSize(true);  
			}
			
			$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();
			$slno = 1;
			foreach ($UnitGroupModel as $groupmodel){
				if($data = unserialize($groupda)){
				$modelSal = EmpSalary::find()->joinWith(['employee'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])				 
				 ->andWhere(['IN','emp_details.category',$data])
				 ->andWhere(['NOT IN', 'emp_details.status', ['Non-paid Leave']])
				 ->orderBy(['net_amount' => SORT_DESC])->all();
				 
				  $modelSalcount =  EmpSalary::find()->joinWith(['employee'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])				 
				 ->andWhere(['IN','emp_details.category',$data])
				 ->andWhere(['NOT IN', 'emp_details.status', ['Non-paid Leave']])
				 ->count();	
				 } else {
				 $modelSal = EmpSalary::find()->joinWith(['employee'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				 ->andWhere(['NOT IN', 'emp_details.status', ['Non-paid Leave']])
				 ->orderBy(['net_amount' => SORT_DESC])->all();
				 
				  $modelSalcount = EmpSalary::find()->joinWith(['employee'])
				  ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				  ->andWhere(['NOT IN', 'emp_details.status', ['Non-paid Leave']])
				 ->count();				 
				}
				if($modelSalcount > 0) {
				
				 $division = Division::find()->Where(['id'=>$groupmodel->division_id])->One();	
				 
				 $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':AX'.$row);
				 $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
				 $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
				 $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':AX'.$row)->applyFromArray($styleArray);
				 $objPHPExcel->getActiveSheet()->setCellValue( 'A'.$row++, $unit->name.'/'.$division->division_name);	
				
				  $divslno = 1;
				 foreach ($modelSal as $data) {
				if($data->total_earning>0) {
				$dedu =0;
				$net =0;
				$bank_amt = 0; 
				$Remu = EmpRemunerationDetails::find()->where(['empid'=>$data->empid])->one();	
				 
				 $PayScale = EmpStaffPayScale::find()
                 ->where(['salarystructure' => $Remu->salary_structure])
                 ->one();

					$Salarystructure = EmpSalarystructure::find()
                 ->where(['salarystructure' => $Remu->salary_structure])
                 ->one();
				 					
					
					if($Salarystructure){
					if($data->unit_id == 12){
						$bank_amt = $data->net_amount;	
						} else {
						 $bank_amt = ($data->net_amount + $data->tes) - ($data->dearness_allowance + $data->advance_arrear_tes);
						}					
					} else {
					 $bank_amt = $data->net_amount;	
					} 
					if($bank_amt == NULL){
						$bank_amt =0;
					} 
				 
				 
				 $Emp = EmpDetails::find()->where(['id'=>$data->empid])->one();				 
				 $dataArray = array(
					  $cslno,
					  $slno,
					  $divslno,
					  $Emp->empcode,
					  $Emp->empname,
					  $Emp->designation->designation,
					  Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy"),
					  $data->paiddays,
					  $data->paidallowance,
					  $data->basic,
					  $data->hra,
					  $data->dearness_allowance,
					  $data->other_allowance,
					  $data->conveyance_allowance,
					  $data->over_time,
					  $data->arrear,
					  $data->advance_arrear_tes,
					  $data->lta_earning,
					  $data->medical_earning,
					  $data->performance_pay,
					  $data->guaranted_benefit,
					  $data->holiday_pay,
					  $data->washing_allowance,
					  $data->dust_allowance,
					  $data->misc,
					  $data->spl_allowance,					 
					  $data->total_earning,
					  
					  $data->pf,
					  $data->esi,
					  $data->professional_tax,
					  $data->tes,
					  $data->caution_deposit,
					  $data->mobile,
					  $data->loan,
					  $data->rent,
					  $data->tds,
					  $data->lwf,
					  $data->advance,
					  $data->insurance,
					  $data->other_deduction,
					  $data->total_deduction,
					  $data->net_amount,
					  
					  $data->pf_employer_contribution,
					  $data->esi_employer_contribution,					  
					  $data->lta_employer_contribution,
					  $data->med_employer_contribution,
					  $data->pli_employer_contribution,
					  $data->food_allowance,
					  $data->earned_ctc,
					  $bank_amt,
					 
				  );				 
				  $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
				   $divslno++;
				   $slno++;
				   $cslno++;
				 }	
				 } 
				  $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $fstratrow . ':AX' . $row);
				  $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':E'.$row);				  
				  $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':AX'.$row)->getFont()->setBold(true);	
				  $objPHPExcel->getActiveSheet()->getStyle('A'.$fstratrow.':AX'.$row)->applyFromArray($styleArray);
				  $objPHPExcel->getActiveSheet()->getRowDimension('A'.$fstratrow.':AX'.$row)->setRowHeight(30);				 
				  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, 'Sub Total')												
												->setCellValue('I'.$row, '=SUM(I'.$fstratrow.':I'.($row-1).')')	
												->setCellValue('J'.$row, '=SUM(J'.$fstratrow.':J'.($row-1).')')	
												->setCellValue('K'.$row, '=SUM(K'.$fstratrow.':K'.($row-1).')')	
												->setCellValue('L'.$row, '=SUM(L'.$fstratrow.':L'.($row-1).')')	
												->setCellValue('M'.$row, '=SUM(M'.$fstratrow.':M'.($row-1).')')	
												->setCellValue('N'.$row, '=SUM(N'.$fstratrow.':N'.($row-1).')')	
												->setCellValue('O'.$row, '=SUM(O'.$fstratrow.':O'.($row-1).')')	
												->setCellValue('P'.$row, '=SUM(P'.$fstratrow.':P'.($row-1).')')	
												->setCellValue('Q'.$row, '=SUM(Q'.$fstratrow.':Q'.($row-1).')')	
												->setCellValue('R'.$row, '=SUM(R'.$fstratrow.':R'.($row-1).')')	
												->setCellValue('S'.$row, '=SUM(S'.$fstratrow.':S'.($row-1).')')	
												->setCellValue('T'.$row, '=SUM(T'.$fstratrow.':T'.($row-1).')')	
												->setCellValue('U'.$row, '=SUM(U'.$fstratrow.':U'.($row-1).')')	
												->setCellValue('V'.$row, '=SUM(V'.$fstratrow.':V'.($row-1).')')	
												->setCellValue('W'.$row, '=SUM(W'.$fstratrow.':W'.($row-1).')')	
												->setCellValue('X'.$row, '=SUM(X'.$fstratrow.':X'.($row-1).')')	
												->setCellValue('Y'.$row, '=SUM(Y'.$fstratrow.':Y'.($row-1).')')	
												->setCellValue('Z'.$row, '=SUM(Z'.$fstratrow.':Z'.($row-1).')')	
												->setCellValue('AA'.$row, '=SUM(AA'.$fstratrow.':AA'.($row-1).')')	
												->setCellValue('AB'.$row, '=SUM(AB'.$fstratrow.':AB'.($row-1).')')	
												->setCellValue('AC'.$row, '=SUM(AC'.$fstratrow.':AC'.($row-1).')')	
												->setCellValue('AD'.$row, '=SUM(AD'.$fstratrow.':AD'.($row-1).')')	
												->setCellValue('AE'.$row, '=SUM(AE'.$fstratrow.':AE'.($row-1).')')	
												->setCellValue('AF'.$row, '=SUM(AF'.$fstratrow.':AF'.($row-1).')')	
												->setCellValue('AG'.$row, '=SUM(AG'.$fstratrow.':AG'.($row-1).')')	
												->setCellValue('AH'.$row, '=SUM(AH'.$fstratrow.':AH'.($row-1).')')	
												->setCellValue('AI'.$row, '=SUM(AI'.$fstratrow.':AI'.($row-1).')')
												->setCellValue('AJ'.$row, '=SUM(AJ'.$fstratrow.':AJ'.($row-1).')')
												->setCellValue('AK'.$row, '=SUM(AK'.$fstratrow.':AK'.($row-1).')')	
												->setCellValue('AL'.$row, '=SUM(AL'.$fstratrow.':AL'.($row-1).')')
												->setCellValue('AM'.$row, '=SUM(AM'.$fstratrow.':AM'.($row-1).')')
												->setCellValue('AN'.$row, '=SUM(AN'.$fstratrow.':AN'.($row-1).')')
												->setCellValue('AO'.$row, '=SUM(AO'.$fstratrow.':AO'.($row-1).')')
												->setCellValue('AP'.$row, '=SUM(AP'.$fstratrow.':AP'.($row-1).')')
												->setCellValue('AQ'.$row, '=SUM(AQ'.$fstratrow.':AQ'.($row-1).')')
												->setCellValue('AR'.$row, '=SUM(AR'.$fstratrow.':AR'.($row-1).')')
												->setCellValue('AS'.$row, '=SUM(AS'.$fstratrow.':AS'.($row-1).')')
												->setCellValue('AT'.$row, '=SUM(AT'.$fstratrow.':AT'.($row-1).')')
												->setCellValue('AU'.$row, '=SUM(AU'.$fstratrow.':AU'.($row-1).')')
												->setCellValue('AV'.$row, '=SUM(AV'.$fstratrow.':AV'.($row-1).')')
												->setCellValue('AW'.$row, '=SUM(AW'.$fstratrow.':AW'.($row-1).')')
												->setCellValue('AX'.$row, '=SUM(AX'.$fstratrow.':AX'.($row-1).')');
					//$cellValue = $objPHPExcel->getActiveSheet()->getCell('J14')->getValue();
					
				/* $grand_paidallowance += (double) $objPHPExcel->getActiveSheet()->getCell('I'.$row)->getValue();
					$grand_basic += (double)$objPHPExcel->getActiveSheet()->getCell('I'.$row)->getValue();
					$grand_hra += (double)$objPHPExcel->getActiveSheet()->getCell('J'.$row)->getValue();
					$grand_da += (double)$objPHPExcel->getActiveSheet()->getCell('K'.$row)->getValue();
					$grand_otherallownace += (double)$objPHPExcel->getActiveSheet()->getCell('L'.$row)->getValue();;
					$grand_conveyance += (double)$objPHPExcel->getActiveSheet()->getCell('M'.$row)->getValue();
					$grand_ot += (double)$objPHPExcel->getActiveSheet()->getCell('N'.$row)->getValue();
					$grand_arrear += (double)$objPHPExcel->getActiveSheet()->getCell('O'.$row)->getValue();
					$grand_adv_arr_tes += (double)$objPHPExcel->getActiveSheet()->getCell('P'.$row)->getValue();
					$grand_lta += (double)$objPHPExcel->getActiveSheet()->getCell('Q'.$row)->getValue();
					$grand_med += (double)$objPHPExcel->getActiveSheet()->getCell('R'.$row)->getValue();
					$grand_guaranted += (double)$objPHPExcel->getActiveSheet()->getCell('S'.$row)->getValue();
					$grand_special += (double)$objPHPExcel->getActiveSheet()->getCell('T'.$row)->getValue();
					$grand_total_earning += (double)$objPHPExcel->getActiveSheet()->getCell('U'.$row)->getValue();
					$grand_pf += (double)$objPHPExcel->getActiveSheet()->getCell('V'.$row)->getValue();	
					$grand_esi += (double)$objPHPExcel->getActiveSheet()->getCell('W'.$row)->getValue(); 
					$grand_pt += (double)$objPHPExcel->getActiveSheet()->getCell('X'.$row)->getValue(); 
					$grand_tes += (double)$objPHPExcel->getActiveSheet()->getCell('Y'.$row)->getValue(); 
					$grand_mobile += (double)$objPHPExcel->getActiveSheet()->getCell('Z'.$row)->getValue(); 
					$grand_loan += (double)$objPHPExcel->getActiveSheet()->getCell('AA'.$row)->getValue(); 
					$grand_rent += (double)$objPHPExcel->getActiveSheet()->getCell('AB'.$row)->getValue(); 
					$grand_tds += (double)$objPHPExcel->getActiveSheet()->getCell('AC'.$row)->getValue();
					$grand_lwf += (double)$objPHPExcel->getActiveSheet()->getCell('AD'.$row)->getValue();
					$grand_otherdeduction += (double)$objPHPExcel->getActiveSheet()->getCell('AE'.$row)->getValue();
					$grand_total_deduction += (double)$objPHPExcel->getActiveSheet()->getCell('AF'.$row)->getValue();
					$grand_netamt += (double)$objPHPExcel->getActiveSheet()->getCell('AG'.$row)->getValue(); 
					$grand_er_pf += (double)$objPHPExcel->getActiveSheet()->getCell('AH'.$row)->getValue();
					$grand_er_esi += (double)$objPHPExcel->getActiveSheet()->getCell('AI'.$row)->getValue(); 
					$grand_er_ltd += (double)$objPHPExcel->getActiveSheet()->getCell('AJ'.$row)->getValue();
					$grand_er_med += (double)$objPHPExcel->getActiveSheet()->getCell('AK'.$row)->getValue();
					$grand_er_pli += (double)$objPHPExcel->getActiveSheet()->getCell('AL'.$row)->getValue();
					$grand_ctc += (double)$objPHPExcel->getActiveSheet()->getCell('AM'.$row)->getValue(); */
				   $row++;
				  $fstratrow = $row+1;
				}
			}
				/*$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, 'Grand Total');
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $cellValue);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':E'.$row);	
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $grand_paidallowance)
												->setCellValue('I'.$row, $grand_basic)
												->setCellValue('J'.$row, $grand_hra)
												->setCellValue('K'.$row, $grand_da)
												->setCellValue('L'.$row, $grand_otherallownace)
												->setCellValue('M'.$row, $grand_conveyance)
												->setCellValue('N'.$row, $grand_ot)
												->setCellValue('O'.$row, $grand_arrear)
												->setCellValue('P'.$row, $grand_adv_arr_tes)
												->setCellValue('Q'.$row, $grand_lta)
												->setCellValue('R'.$row, $grand_med)
												->setCellValue('S'.$row, $grand_guaranted)
												->setCellValue('T'.$row, $grand_special)
												->setCellValue('U'.$row, $grand_total_earning)
												->setCellValue('V'.$row, $grand_pf)
												->setCellValue('W'.$row, $grand_esi)
												->setCellValue('X'.$row, $grand_pt)
												->setCellValue('Y'.$row, $grand_tes)
												->setCellValue('Z'.$row, $grand_mobile)
												->setCellValue('AA'.$row, $grand_loan)
												->setCellValue('AB'.$row, $grand_rent)
												->setCellValue('AC'.$row, $grand_tds)
												->setCellValue('AD'.$row, $grand_lwf)
												->setCellValue('AE'.$row, $grand_otherdeduction)
												->setCellValue('AF'.$row, $grand_total_deduction)
												->setCellValue('AG'.$row, $grand_netamt)
												->setCellValue('AH'.$row, $grand_er_pf)
												->setCellValue('AI'.$row, $grand_er_esi)
												->setCellValue('AJ'.$row, $grand_er_ltd)
												->setCellValue('AK'.$row, $grand_er_med)
												->setCellValue('AL'.$row, $grand_er_pli)
												->setCellValue('AM'.$row, $grand_ctc); */
			 
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A5:AX5");
			   $objPHPExcel->getActiveSheet()->getStyle('A5:AX5')->getFont()->setBold(true);
			   $objPHPExcel->getActiveSheet()->getStyle('A5:AX5')->applyFromArray($styleArray);
			   $objPHPExcel->getActiveSheet()->getRowDimension('A5:AX5')->setRowHeight(30);
			   $objPHPExcel->getActiveSheet()->freezePane('A5');
			$sheet++;
		}
		
 $objPHPExcel->removeSheetByIndex($sheet);			
		
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
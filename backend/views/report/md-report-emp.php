<?php
use common\models\EmpDetails;
use common\models\EmpBankdetails;
use common\models\EmpStatutorydetails;
use common\models\EmpEducationdetails;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use app\models\SalaryStatementsearch;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\UnitGroup;
use common\models\EmpCertificates;
use common\models\Course;
use common\models\Qualification;
use app\models\VgGpaPolicy;
use app\models\VgGpaHierarchy;
use app\models\VgGpaEndorsement;
use app\models\VgGpaEndorsementHierarchy;
use app\models\VgGmcPolicy;
use app\models\VgGmcHierarchy;
use app\models\VgGmcEndorsement;
use app\models\VgGmcEndorsementHierarchy;
use common\models\StatutoryRates;
error_reporting(0);
$pf_esi_rates = StatutoryRates::find()->where(['id' => 1])->one();

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
		
		$filename = 'mdreport_employee.xlsx';
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
	
			$row =2;
			$fstratrow =2;
			$objPHPExcel->createSheet();
			$objPHPExcel->setActiveSheetIndex($sheet);			
			$objPHPExcel->getActiveSheet()
			->setCellValue('A1', 'Sl.No')
			->setCellValue('B1', 'Sl.No')
			->setCellValue('C1', 'Sl.No')
			->setCellValue('D1', 'Emp. Code')
			->setCellValue('E1', 'Emp. Name')    
			->setCellValue('F1', 'Designation')
			->setCellValue('G1', 'Degree')
			->setCellValue('H1', 'YOP')
			->setCellValue('I1', 'DoJ')
			->setCellValue('J1', 'DoP')
			->setCellValue('K1', 'Work Level')
			->setCellValue('L1', 'Grade')			
			->setCellValue('M1', 'Actual Salary')			
			->setCellValue('N1', 'Allowance')			
			->setCellValue('O1', 'Actual Gross')
			->setCellValue('P1', 'Actual Net Sal')
			->setCellValue('Q1', 'Actual CTC')
			->setCellValue('R1', 'ER PF')
			->setCellValue('S1', 'ER ESI')
			->setCellValue('T1', 'ER LTA')
			->setCellValue('U1', 'ER Med.')			
			->setCellValue('V1', 'GPA')
			->setCellValue('W1', 'GMC')
			->setCellValue('X1', 'Bonus')
			->setCellValue('Y1', 'Food Allowance')
			->setCellValue('Z1', 'Certificate')
			->setCellValue('AA1', 'Reference');
		
			$objPHPExcel->getActiveSheet()->setTitle($unit->name);			
			foreach (range('A', 'Z') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
			}	
			foreach (range('A', 'A') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension('A'.$columnID)->setAutoSize(true);  
			}
			$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();
			$slno = 1;
			foreach ($UnitGroupModel as $groupmodel){
				if($data = unserialize($groupda)){				
				 $Emp = EmpDetails::find()->joinWith(['remuneration'])
				 ->where(['emp_details.unit_id'=>$groupmodel->unit_id,'emp_details.division_id'=>$groupmodel->division_id])				 
				 ->andWhere(['IN','emp_details.category',$data])
				 ->andWhere(['emp_details.status'=>'Active'])
				 ->orderBy(['emp_remuneration_details.ctc' => SORT_DESC])->all();	
				 
				 $modelcount = EmpDetails::find()->joinWith(['remuneration'])
				 ->where(['emp_details.unit_id'=>$groupmodel->unit_id,'emp_details.division_id'=>$groupmodel->division_id])				 
				 ->andWhere(['IN','emp_details.category',$data])
				 ->andWhere(['emp_details.status'=>'Active'])
				 ->count();	
				} else {
				 $Emp = EmpDetails::find()->joinWith(['remuneration'])
				 ->where(['emp_details.unit_id'=>$groupmodel->unit_id,'emp_details.division_id'=>$groupmodel->division_id])	
				 ->andWhere(['emp_details.status'=>'Active'])
				 ->orderBy(['emp_remuneration_details.ctc' => SORT_DESC])->all();	
				
				$modelcount =  EmpDetails::find()->joinWith(['remuneration'])
				 ->where(['emp_details.unit_id'=>$groupmodel->unit_id,'emp_details.division_id'=>$groupmodel->division_id])	
				 ->andWhere(['emp_details.status'=>'Active'])
				 ->count();
				}
				if($modelcount > 0) {
				
				 $division = Division::find()->Where(['id'=>$groupmodel->division_id])->One();	
				 
				 $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':W'.$row);
				 $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
				 $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
				 $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':W'.$row)->applyFromArray($styleArray);
				 $objPHPExcel->getActiveSheet()->setCellValue( 'A'.$row++, $unit->name.'/'.$division->division_name);	
				
				$divslno = 1;
				foreach ($Emp as $data) {
				$salary =0;
				$allowance = '';	
				$netsal = 0;
				$cetificate = '';
				$degree ='';
				$yop ='';
				 $PayScale = EmpStaffPayScale::find()
                 ->where(['salarystructure' => $data->remuneration->salary_structure])
                 ->one();

				$Salarystructure = EmpSalarystructure::find()
                 ->where(['salarystructure' => $data->remuneration->salary_structure,'grade'=>$data->remuneration->grade])
                 ->one();				 
				
					if($Salarystructure){
					 $salary = $Salarystructure->netsalary - $Salarystructure->dapermonth;
					 $allowance = $Salarystructure->dapermonth;
					} else {
					 $salary = $data->remuneration->gross_salary;
					 $allowance = '';
					} 	
					
					if($allowance != ''|| $allowance != 0){
					$netsal = $salary + $allowance;
					} else {
					$netsal = $salary;
					}
					
					$education = EmpEducationdetails::find()->where(['empid'=>$data->id])->all();
					foreach ($education as $edu) {
					$course = Course::find()->where(['id'=>$edu->course])->one();
					$quali = Qualification::find()->where(['id'=>$edu->qualification])->one();
					$yop = $edu->yop;
					
					if($course)
						$degree .= $quali->qualification_name."-".$course->coursename.",";
					else if($quali->qualification_name)
						$degree .= $quali->qualification_name.",";
					}
					$certificates = EmpCertificates::find()->where(['empid'=>$data->id])->all();
					foreach ($certificates as $cert) {	
					if($cert->certificatesname)
						$cetificate .=$cert->certificatesname.",";
					}	
					$statutoryModel = EmpStatutorydetails::find()->where(['empid' => $data->id])->one();
						/*(if($statutoryModel->gpa_no){
							$gpa = VgGpaPolicy::find()->where(['policy_no'=>$statutoryModel->gpa_no])->one();
							$gpahierarch = VgGpaHierarchy::find()->where(['sum_insured' =>$statutoryModel->gpa_sum_insured,'gpa_policy_id'=>$gpa->id])->one();
							if ($gpahierarch) {		
							 $gpa_amt = round($gpahierarch->fellow_share/12);	 
							} else{
								$gpaendo = VgGpaEndorsement::find()->where(['endorsement_no'=>$statutoryModel->gpa_no])->one();
								$gpaendohierarch = VgGpaEndorsementHierarchy::find()->where(['endorsement_sum_insured' =>$statutoryModel->gpa_sum_insured,'gpa_endorsement_id'=>$gpaendo->id])->one();
								
								$gpa_amt = round($gpaendohierarch->endorsement_fellow_share /12 );
								
							}	
						} else if($statutoryModel->gpa_applicability == 'Yes') {	
							$gpa_amt = 125;
						} else {
						   $gpa_amt = 0;
						}	
						
						if($statutoryModel->gmc_no){
							$gmc = VgGmcPolicy::find()->where(['policy_no'=>$statutoryModel->gmc_no])->one();
							$gmchierarch = VgGmcHierarchy::find()->where(['sum_insured' =>$statutoryModel->gmc_sum_insured,'gmc_policy_id'=>$gmc->id,'age_group'=>$statutoryModel->age_group])->one();
							if ($gmchierarch) {		
							 $gmc_amt = round($gmchierarch->fellow_share/24);	 
							} else {
								$gmcendo = VgGmcEndorsement::find()->where(['endorsement_no'=>$statutoryModel->gmc_no])->one();
								$gmcendohierarch = VgGmcEndorsementHierarchy::find()->where(['endorsement_sum_insured' =>$statutoryModel->gmc_sum_insured,'gmc_endorsement_id'=>$gmcendo->id,'endorsement_age_group'=>$statutoryModel->age_group])->one();
								
								 $gmc_amt = round($gmcendohierarch->endorsement_fellow_share /24 );
								
							}	
						} else if($statutoryModel->gmc_applicability == 'Yes') {	
							$gmc_amt = 150;
						} else {
						   $gmc_amt = 0;
						}	*/
							
					if($data->remuneration->food_allowance == 'Yes'){
						$food_allowance = 1500;		
						} else {	
						$food_allowance = 0;		
						}
						
						if ($statutoryModel->professionaltax == 'Yes') {
						 if ($data->remuneration->gross_salary > 12500) {
							  $professional_tax = 209;
						   } else if ($data->remuneration->gross_salary <= 12500 && $data->remuneration->gross_salary > 10000) {
							  $professional_tax = 171;
						   } else if ($data->remuneration->gross_salary <= 10000 && $data->remuneration->gross_salary > 7500) {
							  $professional_tax = 115;
						   } else if ($data->remuneration->gross_salary <= 7500 && $data->remuneration->gross_salary > 5000) {
							  $professional_tax = 53;
						   } else if ($data->remuneration->gross_salary <= 5000 && $data->remuneration->gross_salary > 3500) {
							  $professional_tax = 23;
						   } else {
							  $professional_tax = 0;
						   } 			  
						}else {
							 $professional_tax = 0;
						}
						
						
						$statutory_rate_pf_esi = $data->remuneration->gross_salary - $data->remuneration->hra;

  
					if ($data->remuneration->pf_applicablity == 'Yes') {
						if ($data->remuneration->restrict_pf == 'Yes') {
							if ($statutory_rate_pf_esi > 15000) {     
								$provident_fund = round(15000 * ($pf_esi_rates->epf_ac_1_ee / 100));
								//$provident_fund_er = round((15000 * ($pf_esi_rates->epf_ac_1_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_10_er / 100)) + (15000 * ($pf_esi_rates->epf_ac_2_er / 100))+ (15000 * ($pf_esi_rates->epf_ac_21_er / 100)));				
						
							} else {
								$provident_fund = round($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_ee / 100));
								//$provident_fund_er = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100))+ ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));			
								
							}
						} else {
							$provident_fund = round($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_ee / 100));
							//$provident_fund_er = round(($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_1_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_10_er / 100)) + ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_2_er / 100))+ ($statutory_rate_pf_esi * ($pf_esi_rates->epf_ac_21_er / 100)));			
						
						}
					} else {
						$provident_fund = 0;
					}
					
					if ($data->remuneration->esi_applicability == 'Yes') {
						if ($data->remuneration->gross_salary <= 21000) {
							$employee_state_insurance = ceil(number_format(( $data->remuneration->gross_salary * ($pf_esi_rates->esi_ee / 100)), 2, '.', ''));
							 } else {
							$employee_state_insurance = 0;      
						}
					} else {
						$employee_state_insurance = 0;   
					}
										
					$total_detection = $professional_tax + $provident_fund + $employee_state_insurance;
					
				 $dataArray = array(
					  $cslno,
					  $slno,
					  $divslno,
					  $data->empcode,
					  $data->empname,
					  $data->designation->designation,
					  $degree,
					  $yop,				  
					  $data->doj,
					  $data->recentdop,
					  $data->remuneration->work_level,
					  $data->remuneration->grade,
					  $salary,					 
					  $allowance,
					  $netsal,
					  ($netsal - $total_detection),
					  round($data->remuneration->ctc +  ($statutoryModel->gpa_premium/12) + ($statutoryModel->gmc_premium/24) +  $food_allowance ),
					  $data->remuneration->employer_pf_contribution, 				  
					  $data->remuneration->employer_esi_contribution,
					  $data->remuneration->employer_lta_contribution,
					  $data->remuneration->employer_medical_contribution,
					  round($statutoryModel->gpa_premium/12),
					  round($statutoryModel->gmc_premium/24),
					  $data->remuneration->employer_pli_contribution,
					  $food_allowance,
					  $cetificate,	
					  $data->referedby,	
				  );				 
				  $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
				   $divslno++;
				   $slno++;
				   $cslno++;
				 }	
				 
				  $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $fstratrow . ':AA' . $row);
				  $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':E'.$row);				  
				  $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':AA'.$row)->getFont()->setBold(true);	
				  $objPHPExcel->getActiveSheet()->getStyle('A'.$fstratrow.':AA'.$row)->applyFromArray($styleArray);
				  $objPHPExcel->getActiveSheet()->getRowDimension('A'.$fstratrow.':AA'.$row)->setRowHeight(30);
				   $row++;
				  $fstratrow = $row+1;
				}
			}			
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:AA1");
			   $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);
			   $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->applyFromArray($styleArray);
			   $objPHPExcel->getActiveSheet()->getRowDimension('A1:AA1')->setRowHeight(30);
			   $objPHPExcel->getActiveSheet()->freezePane('A2');
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
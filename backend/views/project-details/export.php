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
use common\models\Division;
use common\models\College;
use common\models\ProjectEmp;
use app\models\SkillSet;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\EmpFamilydetails;
use common\models\ProjectDetails;
use common\models\ProjectSalary;
use common\models\ProjectEmpAttendance;
error_reporting(0);

$model =ProjectDetails::findOne($id); 

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

	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex(0);	
	$objPHPExcel->getActiveSheet()->setTitle('FORM A');
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
	//$objPHPExcel->getActiveSheet()->setShowGridlines(true);
	
	$objPHPExcel->getActiveSheet()->mergeCells('A1:AE1')
									->mergeCells('A2:AE2')
									->mergeCells('A3:AE3')
									->mergeCells('A4:AE4')
									->mergeCells('A5:AE5');
									
		$objPHPExcel->getActiveSheet() ->setCellValue('A1', 'SCHEDULE ')
			->setCellValue('A2', '[See Rule2(1)]')
			->setCellValue('A3', 'FORM A')
			->setCellValue('A4', 'EMPLOYEE REGISTER')
			->setCellValue('A5', '[Part A: For all Establishments]');
				
		$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "A1:AE5");
		$objPHPExcel->getActiveSheet()->getStyle('A1:AE5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AE5')->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->mergeCells('A6:C6')
									->mergeCells('D6:K6')
									->mergeCells('L6:S6')
									->mergeCells('T6:V6')
									->mergeCells('W6:X6')
									->mergeCells('Y6:AB6')
									->mergeCells('AD6:AE6')
									->mergeCells('A7:C7')
									->mergeCells('D7:K7')
									->mergeCells('L7:S7')
									->mergeCells('T7:V7')
									->mergeCells('W7:X7')
									->mergeCells('Y7:AB7')
									->mergeCells('AD7:AE7'); 
									
$objPHPExcel->getActiveSheet() ->setCellValue('A6', 'Name of the Establishment')
							   ->setCellValue('D6', 'M/s Voltech Engineers Private Limited')
							   ->setCellValue('L6', 'Name of the Owner')
							   ->setCellValue('T6', 'M.Umapathi')
							   ->setCellValue('W6', 'LIN')
							   ->setCellValue('Y6', '1600562369')
							   ->setCellValue('AC6', 'Month')
							   ->setCellValue('AD6', 'Month');
							   
							   
							   $objPHPExcel->getActiveSheet() ->setCellValue('A7', 'Name of the Establishment')
							   ->setCellValue('D7', 'M/s Voltech Engineers Private Limited')
							   ->setCellValue('L7', 'Name of the Owner')
							   ->setCellValue('T7', 'M.Umapathi')
							   ->setCellValue('W7', 'LIN')
							   ->setCellValue('Y7', '1600562369')
							   ->setCellValue('AC7', 'Month')
							   ->setCellValue('AD7', 'Month');
							   
							   

$objPHPExcel->getActiveSheet()
        ->setCellValue('A8', 'Sl. No.')
        ->setCellValue('B8', 'Emp. Code')
        ->setCellValue('C8', 'Name')
        ->setCellValue('D8', 'Sur name')
        ->setCellValue('E8', 'Gender')
        ->setCellValue('F8', "Father's/Spouse Name")
        ->setCellValue('G8', 'Date of Birth')
        ->setCellValue('H8', 'Nationality')
        ->setCellValue('I8', 'Education Level')
        ->setCellValue('J8', 'Date of Joining')
        ->setCellValue('K8', 'Designation')       
        ->setCellValue('L8', 'Category Address (HS/S/SS/US)')
		->setCellValue('M8', 'Type of Employment')
        ->setCellValue('N8', 'Mobile')
        ->setCellValue('O8', 'UAN')
        ->setCellValue('P8', 'PAN')
        ->setCellValue('Q8', 'ESIC IP')
        ->setCellValue('R8', 'LWF')
        ->setCellValue('S8', 'AADHAR')
        ->setCellValue('T8', 'Bank A/c Number')
        ->setCellValue('U8', 'Bank')
        ->setCellValue('V8', 'Branch (IFSC)')
        ->setCellValue('W8', 'Present Address')
        ->setCellValue('X8', 'Permanent Address')
        ->setCellValue('Y8', 'Service Book No.')
        ->setCellValue('Z8', 'Date of Exit')
        ->setCellValue('AA8', 'Reason for Exit')
        ->setCellValue('AB8', 'Mark of Identification')
        ->setCellValue('AC8', 'Photo')
        ->setCellValue('AD8', 'Specimen Signature/Thumb Impression')
        ->setCellValue('AE8', 'Remarks');  
       
		
		$address =NULL;
		$row = 9;
		$sl_no = 1;
		foreach ($projectEmp as $data) {
		$address =NULL;
		$Emp = EmpDetails::find()->Where(['id'=>$data->emp_id])->one();
		$empadd = EmpAddress::find()->where(['empid' => $data->emp_id])->one();
		if ($empadd->addfield1 != '')
            $address .= $empadd->addfield1 . ',';
         if ($empadd->addfield2 != '')
            $address .=$empadd->addfield2 . ',';
         if ($empadd->addfield3 != '')
            $address .= $empadd->addfield3 . ',';
         if ($empadd->addfield4 != '')
            $address .= $empadd->addfield4 . ',';
         if ($empadd->addfield5 != '')			 
            $address .= $empadd->addfield5 . ',';
		
		    $address .= $empadd->district . ','.$empadd->state.',' . $empadd->pincode;
		
		if(!empty($Emp->employeePersonalDetail->dob) && $Emp->employeePersonalDetail->dob !='0000-00-00' && $Emp->employeePersonalDetail->dob !='1970-01-01'){
			$dob = Yii::$app->formatter->asDate($Emp->employeePersonalDetail->dob, "dd-MM-yyyy");
			} else {
			$dob =''; 
			}  
						
			 $dataArray = array(
					   $sl_no,
					   $Emp->empcode,
					   $Emp->empname,
					   '',
					   $Emp->employeePersonalDetail->gender,
					   '',
					   $dob,
					   'Indian',
					   '',
					   Yii::$app->formatter->asDate($Emp->doj, "dd-MM-yyyy"),
					   $Emp->designation->designation,
					   $data->category,
					   $Emp->remuneration->attendance_type,
					   $Emp->mobileno,
					   $Emp->employeeStatutoryDetail->epfuanno,
					   $Emp->employeePersonalDetail->panno,
					   $Emp->employeeStatutoryDetail->esino,
					   '',
					   $Emp->employeePersonalDetail->aadhaarno,
					   $Emp->employeeBankDetail->acnumber,
					   $Emp->employeeBankDetail->branch,
					   $Emp->employeeBankDetail->ifsc,
					   $address,
					   $address,
				   );
				   
				    $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++); 
		} 
 
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A8:AE8");
$objPHPExcel->getActiveSheet()->getStyle('A1:AE8')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:AE8')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A8:AE8');
$objPHPExcel->getActiveSheet()->freezePane('A9');
$objPHPExcel->getActiveSheet()->getStyle('W9:W'.$row)->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('X9:X'.$row)->getAlignment()->setWrapText(TRUE);



$projectsal = ProjectSalary::find()->Where(['project_id'=>$id,'month' => $month])->all();


$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(1);	
$objPHPExcel->getActiveSheet()->setTitle('FORM B');

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
$objPHPExcel->getActiveSheet()->setShowGridlines(true);

	$objPHPExcel->getActiveSheet()->mergeCells('J1:S1')
									->mergeCells('J2:S2')
									->mergeCells('J3:S3')
									
									->mergeCells('J4:K4')
									->mergeCells('L4:M4')
									->mergeCells('N4:O4')
									->mergeCells('P4:Q4')
									->mergeCells('R4:S4')
									
									->mergeCells('J5:K5')									
									->mergeCells('L5:M5')
									->mergeCells('N5:O5')
									->mergeCells('P5:Q5')
									->mergeCells('R5:S5')
									
									->mergeCells('J6:K6')									
									->mergeCells('L6:M6')
									->mergeCells('N6:O6')
									->mergeCells('P6:Q6')
									->mergeCells('R6:S6')
									
									->mergeCells('J7:K7')									
									->mergeCells('L7:M7')
									->mergeCells('N7:O7')
									->mergeCells('P7:Q7')
									->mergeCells('R7:S7')
									
									->mergeCells('J8:S8');
									
		
									
		$objPHPExcel->getActiveSheet() ->setCellValue('J1', 'FORM B ')
			->setCellValue('J2', 'WAGE REGISTER')
			->setCellValue('J3', 'Rate of Minimum Wages and since the date 01/10/2019')
			->setCellValue('L4', 'Highly skilled')
			->setCellValue('N4', 'Skilled')
			->setCellValue('P4', 'Semi Skilled')
			->setCellValue('R4', 'Un Skilled')
			->setCellValue('J5', 'Minimum Basic')
			->setCellValue('J6', 'DA')
			->setCellValue('J7', 'Overtime')
			->setCellValue('L5', $Skill->highly_skilled)
			->setCellValue('N5', $Skill->skilled)
			->setCellValue('P5', $Skill->semi_skilled)
			->setCellValue('R5', $Skill->un_skilled)
			->setCellValue('L7', 'Double Wages')
			->setCellValue('N7', 'Double Wages')
			->setCellValue('P7', 'Double Wages')
			->setCellValue('R7', 'Double Wages');
			
			
			
		$objPHPExcel->getActiveSheet() ->setCellValue('A9', 'Name of the Establishment')
							   ->setCellValue('D9', 'M/s Voltech Engineers Private Limited')
							   ->setCellValue('J9', 'Name of the Owner')
							   ->setCellValue('P9', 'M.Umapathi')
							   ->setCellValue('S9', 'LIN')
							   ->setCellValue('W9', '1600562369')
							   ->setCellValue('AA9', 'Month')
							   ->setCellValue('AB9', 'Month');
							   
							   
		$objPHPExcel->getActiveSheet() ->setCellValue('A10', 'Nature and location of work')
							   ->setCellValue('D10', '')
							   ->setCellValue('J10', 'Name and address of establishment in/under which contract is carried on')
							   ->setCellValue('P10', '')
							   ->setCellValue('S10', 'Name and address of principal employer')
							   ->setCellValue('W10', '')
							   ->setCellValue('AA10', 'Month')
							   ->setCellValue('AB10', 'Month');
							   
		$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "J4:S7");
		$objPHPExcel->getActiveSheet()->getStyle('A1:AB7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('J1:S7')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()
        ->setCellValue('A11', 'Sl. No. in Emp. Reg.')
        ->setCellValue('B11', 'E Code')
        ->setCellValue('C11', 'Name')
        ->setCellValue('D11', 'Rate of Wages')
        ->setCellValue('E11', 'No. of Days Worked')
        ->setCellValue('F11', "Overtime hours worked")
        ->setCellValue('G11', 'Basic + DA')
        ->setCellValue('H11', 'Special Basic')
        ->setCellValue('I11', 'Payments Overtime')
        ->setCellValue('J11', 'HRA')
        ->setCellValue('K11', 'Canteen Allowance')       
        ->setCellValue('L11', 'Transport Allowance')
		->setCellValue('M11', 'Washing Allowance')
        ->setCellValue('N11', 'Others Allowance')
        ->setCellValue('O11', 'Total')
        ->setCellValue('P11', 'PF')
        ->setCellValue('Q11', 'ESI')
        ->setCellValue('R11', 'Society')
        ->setCellValue('S11', 'Income Tax')
        ->setCellValue('T11', 'Insurance')
        ->setCellValue('U11', 'Others')
        ->setCellValue('V11', 'Recoveries')
        ->setCellValue('W11', 'Total')
        ->setCellValue('X11', 'Net Payment')
        ->setCellValue('Y11', 'Employer Share PF Welfare found')
        ->setCellValue('Z11', 'Receipt by Employee/ Bank Transaction ID')
        ->setCellValue('AA11', 'Date of Payment')
        ->setCellValue('AB11', 'Remarks');
		
		$row = 12;
		foreach ($projectsal as $data) {
		$proj_Emp = ProjectEmp::find()->Where(['project_id'=>$data->project_id,'id'=>$data->emp_id])->one();
		$Emp = EmpDetails::find()->Where(['id'=>$proj_Emp->emp_id])->one();
		
		$present_days = 27;
			 $dataArray = array(
					   $data->emp_id,
					   $Emp->empcode,
					   $Emp->empname,
					   $data->wages,
					   $data->days,
					   $data->overtime_hours,
					   $data->basic_da,
					   $data->spacial_basic,
					   $data->overtime_payment,
					   $data->hra,
					   $data->canteen_allowance,
					   $data->transport_allowance,
					   $data->washing_allowance,
					   $data->other_allowance,
					   $data->total,
					   $data->pf,
					   $data->esi,
					   $data->society,
					   $data->income_tax,
					   $data->insurance,
					   $data->others,
					   $data->recoveries,
					   $data->deduction_total,
					   $data->netpayment,
					   $data->employer_pf,
					   '',
					   '',
					   '',
				   );				   
				    $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++); 
		}
		$row--;
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A11:AB11");
$objPHPExcel->getActiveSheet()->getStyle('A11:AB11')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A9:AB11')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A11:AB11');
$objPHPExcel->getActiveSheet()->freezePane('A11');

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(2);	
$objPHPExcel->getActiveSheet()->setTitle('FORM C');

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
$objPHPExcel->getActiveSheet()->setShowGridlines(true);

	$objPHPExcel->getActiveSheet()->mergeCells('A1:M1')
									->mergeCells('A2:M2');
									
		$objPHPExcel->getActiveSheet() ->setCellValue('A1', 'FORM C ')
			->setCellValue('A2', 'REGISTER OF LOAN/ RECOVERIES');
			
			
			
		$objPHPExcel->getActiveSheet() ->setCellValue('A3', 'Name of the Establishment')
							   ->setCellValue('D3', 'M/s Voltech Engineers Private Limited')
							   ->setCellValue('H3', 'Name and address of establishment in / under which contract is carried on')
							   ->setCellValue('K3', '')
							   ->setCellValue('A4', 'Nature and location of work')
							   ->setCellValue('D4', 'Testing & Commissioning')
							   ->setCellValue('H4', 'Name and address of principal employer')
							   ->setCellValue('K4', '')
							   ->setCellValue('A5', 'Name of the Owner')
							   ->setCellValue('D5', 'M.Umapathi')
							   ->setCellValue('H5', 'LIN')
							   ->setCellValue('I5', '1600562369')
							   ->setCellValue('I5', '')
							   ->setCellValue('K5', 'Month')
							   ->setCellValue('L5', 'Month');
		

$objPHPExcel->getActiveSheet()
        ->setCellValue('A6', 'Sl. No. in Emp. Reg.')
        ->setCellValue('B6', 'E Code')
        ->setCellValue('C6', 'Name')
        ->setCellValue('D6', 'Recovery Type (Damage/ Loss/ Fine/ Advances/ Loans)')
        ->setCellValue('E6', 'Particulars')
        ->setCellValue('F6', "Date of Damages / Loss")
        ->setCellValue('G6', 'Amount')
        ->setCellValue('H6', 'Whether Show Cause Issued')
        ->setCellValue('I6', 'Explanation heard in presence of*')
        ->setCellValue('J6', 'No. of Installments')		
        ->setCellValue('K6', 'First Month /Year')       
        ->setCellValue('L6', 'Date of Complete Recovery')
		->setCellValue('M6', 'Remarks');
      
		
		$row = 7;
		$sl_no = 1;
		foreach ($projectEmp as $data) {
		$Emp = EmpDetails::find()->Where(['id'=>$data->emp_id])->one();
		$wage_skill = $data->category;
		$present_days = 27;
			 $dataArray = array(
					   $sl_no,
					   $Emp->empcode,
					   $Emp->empname,
						'NIL',
						'NIL',
						'NIL',
						'NIL',
						'NIL',
						'NIL',
						'NIL',
						'NIL',
						'NIL',
						'NIL',					  
				   );
				   
				    $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++); 
		
		}
		$row--;
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A6:M6");
$objPHPExcel->getActiveSheet()->getStyle("A6:M6")->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle("A6:M6")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter("A6:M6");
$objPHPExcel->getActiveSheet()->freezePane('A6');

	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex(3);	
	$objPHPExcel->getActiveSheet()->setTitle('FORM D');

	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
	$objPHPExcel->getActiveSheet()->setShowGridlines(true);

	$objPHPExcel->getActiveSheet()->mergeCells('A1:AN1')
								  ->mergeCells('A2:AN2');
									
	$objPHPExcel->getActiveSheet() ->setCellValue('A1', 'FORM D')
			->setCellValue('A2', 'ATTENDANCE REGISTER');
			
	$objPHPExcel->getActiveSheet()->mergeCells('A3:C3')
									->mergeCells('D3:K3')
									->mergeCells('L3:S3')
									->mergeCells('T3:V3')
									->mergeCells('W3:X3')
									->mergeCells('Y3:AB3')
									->mergeCells('AD3:AE3')
									->mergeCells('A4:C4')
									->mergeCells('D4:K4')
									->mergeCells('L4:S4')
									->mergeCells('T4:V4')
									->mergeCells('W4:X4')
									->mergeCells('Y4:AB4')
									->mergeCells('AD4:AE4'); 
									
	$objPHPExcel->getActiveSheet() ->setCellValue('A3', 'Name of the Establishment')
							   ->setCellValue('D3', 'M/s Voltech Engineers Private Limited')
							   ->setCellValue('L3', 'Name of the Owner')
							   ->setCellValue('T3', 'M.Umapathi')
							   ->setCellValue('W3', 'LIN')
							   ->setCellValue('Y3', '1600562369')
							   ->setCellValue('AC3', 'Month')
							   ->setCellValue('AD3', 'Month');
							   
							   
							   $objPHPExcel->getActiveSheet() ->setCellValue('A4', 'Nature and location of work')
							   ->setCellValue('D4', 'M/s Voltech Engineers Private Limited')
							   ->setCellValue('L4', 'Name and address of establishment in/under which contract is carried on')
							   ->setCellValue('T4', 'M.Umapathi')
							   ->setCellValue('W4', 'Name and address of principal employer')
							   ->setCellValue('Y4', '1600562369');
							  
							   
	$objPHPExcel->getActiveSheet()
        ->setCellValue('A5', 'Sl. No. in Emp. Reg.')
        ->setCellValue('B5', 'E Code')
        ->setCellValue('C5', 'Name')
        ->setCellValue('D5', 'Relay# or set work')
        ->setCellValue('E5', 'Place of Work')
        ->setCellValue('F5', "IN/OUT")
        ->setCellValue('G5', '1')
        ->setCellValue('H5', '2')
        ->setCellValue('I5', '3')
        ->setCellValue('J5', '4')
        ->setCellValue('K5', '5')       
        ->setCellValue('L5', '6')
		->setCellValue('M5', '7')
        ->setCellValue('N5', '8')
        ->setCellValue('O5', '9')
        ->setCellValue('P5', '10')
        ->setCellValue('Q5', '11')
        ->setCellValue('R5', '12')
        ->setCellValue('S5', '13')
        ->setCellValue('T5', '14')
        ->setCellValue('U5', '15')
        ->setCellValue('V5', '16')
        ->setCellValue('W5', '17')
        ->setCellValue('X5', '18')
        ->setCellValue('Y5', '19')
        ->setCellValue('Z5', '20')
        ->setCellValue('AA5', '21')
        ->setCellValue('AB5', '22')
        ->setCellValue('AC5', '23')
        ->setCellValue('AD5', '24')
        ->setCellValue('AE5', '25')       
        ->setCellValue('AF5', '26')
		->setCellValue('AG5', '27')
        ->setCellValue('AH5', '28')
        ->setCellValue('AI5', '29')
        ->setCellValue('AJ5', '30')
        ->setCellValue('AK5', '31')
		->setCellValue('AL5', 'Summary No. of Days')
		->setCellValue('AM5', 'Remarks No. of Hours')
		->setCellValue('AN5', '**Signature of Register Keeper');
	
			$row = 6;	
			$rowNxt = 7;
			$slno = 1;
		foreach ($projectEmp as $data) {	
			
		$proj_Att = ProjectEmpAttendance::find()->Where(['project_id'=>$data->project_id,'project_emp_id'=>$data->id,'month'=>$month])->one();
		$EmpName = EmpDetails::find()->Where(['id'=>$data->emp_id])->one();
			$objPHPExcel->getActiveSheet() ->setCellValue('F'.$row, 'IN')
										   ->setCellValue('F'.$rowNxt, 'OUT')
										   ->setCellValue('G'.$row, $proj_Att->day1_in)
										   ->setCellValue('G'.$rowNxt, $proj_Att->day1_out)
										   ->setCellValue('H'.$row, $proj_Att->day2_in )
										   ->setCellValue('H'.$rowNxt, $proj_Att->day2_out)
										   ->setCellValue('I'.$row, $proj_Att->day3_in)
										   ->setCellValue('I'.$rowNxt, $proj_Att->day3_out)
										   ->setCellValue('J'.$row, $proj_Att->day4_in)
										   ->setCellValue('J'.$rowNxt, $proj_Att->day4_out)
										   ->setCellValue('K'.$row, $proj_Att->day5_in)
										   ->setCellValue('K'.$rowNxt, $proj_Att->day5_out)
										   ->setCellValue('L'.$row, $proj_Att->day6_in)
										   ->setCellValue('L'.$rowNxt, $proj_Att->day6_out)
										   ->setCellValue('M'.$row, $proj_Att->day7_in)
										   ->setCellValue('M'.$rowNxt, $proj_Att->day7_out)
										   ->setCellValue('N'.$row, $proj_Att->day8_in)
										   ->setCellValue('N'.$rowNxt, $proj_Att->day8_out)
										   ->setCellValue('O'.$row, $proj_Att->day9_in)
										   ->setCellValue('O'.$rowNxt, $proj_Att->day9_out)
										   ->setCellValue('P'.$row, $proj_Att->day10_in)
										   ->setCellValue('P'.$rowNxt, $proj_Att->day10_out)
										   ->setCellValue('Q'.$row, $proj_Att->day11_in)
										   ->setCellValue('Q'.$rowNxt, $proj_Att->day11_out)
										   ->setCellValue('R'.$row, $proj_Att->day12_in)
										   ->setCellValue('R'.$rowNxt, $proj_Att->day12_out)
										   ->setCellValue('S'.$row, $proj_Att->day13_in)
										   ->setCellValue('S'.$rowNxt, $proj_Att->day13_out)
										   ->setCellValue('T'.$row, $proj_Att->day14_in)
										   ->setCellValue('T'.$rowNxt, $proj_Att->day14_out)
										   ->setCellValue('U'.$row, $proj_Att->day15_in)
										   ->setCellValue('U'.$rowNxt, $proj_Att->day15_out)
										   ->setCellValue('V'.$row, $proj_Att->day16_in)
										   ->setCellValue('V'.$rowNxt, $proj_Att->day16_out)
										   ->setCellValue('W'.$row, $proj_Att->day17_in)
										   ->setCellValue('W'.$rowNxt, $proj_Att->day17_out)
										   ->setCellValue('X'.$row, $proj_Att->day18_in)
										   ->setCellValue('X'.$rowNxt, $proj_Att->day18_out)
										   ->setCellValue('Y'.$row, $proj_Att->day19_in)
										   ->setCellValue('Y'.$rowNxt, $proj_Att->day19_out)
										   ->setCellValue('Z'.$row, $proj_Att->day20_in)
										   ->setCellValue('Z'.$rowNxt, $proj_Att->day20_out)
										   ->setCellValue('AA'.$row, $proj_Att->day21_in)
										   ->setCellValue('AA'.$rowNxt, $proj_Att->day21_out)
										   ->setCellValue('AB'.$row, $proj_Att->day22_in)
										   ->setCellValue('AB'.$rowNxt, $proj_Att->day22_out)
										   ->setCellValue('AC'.$row, $proj_Att->day23_in)
										   ->setCellValue('AC'.$rowNxt, $proj_Att->day23_out)
										   ->setCellValue('AD'.$row, $proj_Att->day24_in)
										   ->setCellValue('AD'.$rowNxt, $proj_Att->day24_out)
										   ->setCellValue('AE'.$row, $proj_Att->day25_in)
										   ->setCellValue('AE'.$rowNxt, $proj_Att->day25_out)
										   ->setCellValue('AF'.$row, $proj_Att->day26_in)
										   ->setCellValue('AF'.$rowNxt, $proj_Att->day26_out)
										   ->setCellValue('AG'.$row, $proj_Att->day27_in)
										   ->setCellValue('AG'.$rowNxt, $proj_Att->day27_out)
										   ->setCellValue('AH'.$row, $proj_Att->day28_in)
										   ->setCellValue('AH'.$rowNxt, $proj_Att->day28_out)
										   ->setCellValue('AI'.$row, $proj_Att->day29_in)
										   ->setCellValue('AI'.$rowNxt, $proj_Att->day29_out)
										   ->setCellValue('AJ'.$row, $proj_Att->day30_in)
										   ->setCellValue('AJ'.$rowNxt, $proj_Att->day30_out)
										   ->setCellValue('AK'.$row, $proj_Att->day31_in)
										   ->setCellValue('AK'.$rowNxt, $proj_Att->day31_out);
										  
										   
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':A'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('A'.$row, $slno);
				$objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':B'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('B'.$row, $EmpName->empcode);
				$objPHPExcel->getActiveSheet()->mergeCells('C'.$row.':C'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('C'.$row, $EmpName->empname);
				$objPHPExcel->getActiveSheet()->mergeCells('D'.$row.':D'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('D'.$row, '');
				$objPHPExcel->getActiveSheet()->mergeCells('E'.$row.':E'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('E'.$row, '');
				
				$objPHPExcel->getActiveSheet()->mergeCells('AL'.$row.':AL'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('AL'.$row, $proj_Att->days);
				$objPHPExcel->getActiveSheet()->mergeCells('AM'.$row.':AM'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('AM'.$row, $proj_Att->hours);
				$objPHPExcel->getActiveSheet()->mergeCells('AN'.$row.':AN'.$rowNxt);
				$objPHPExcel->getActiveSheet() ->setCellValue('AN'.$row, '');
				
										   
			$row +=  2;	
			$rowNxt += 2;
			$slno++;
			
		}	
		
		$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "A1:AN".($rowNxt-2));
		$objPHPExcel->getActiveSheet()->getStyle('A1:AN2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A5:AN5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F6:AN'.($rowNxt-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AN5')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("A1:AN5")->getAlignment()->setWrapText(TRUE);
		
		foreach (range('A', 'Z') as $columnID) {
		   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
		}
		foreach (range('A', 'N') as $columnID) {
		   $objPHPExcel->getActiveSheet()->getColumnDimension('A' . $columnID)->setAutoSize(true);  
		}
	
$objPHPExcel->setActiveSheetIndex(0);



$callStartTime = microtime(true);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Stu_doc.xlsx"');
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
<?php
use common\models\EmpDetails;
use common\models\EmpBankdetails;
use common\models\EmpStatutorydetails;
use common\models\EmpSalary;
use common\models\Designation;
use common\models\Department;
use common\models\Unit;
use common\models\Division;
use common\models\Customer;
use app\models\SalaryStatementsearch;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\UnitGroup;	

		if (Yii::$app->getRequest()->getQueryParam('month'))
		   $month = Yii::$app->getRequest()->getQueryParam('month');
		else
		   $month = '';  
		   
		
		$styleArray = array(
			'font'  => array(
			'size'  => 8,
			'name'  => 'Century Gothic'
			));
	
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
		
		$filename = 'salary_components.xlsx';
		$objPHPExcel = new PHPExcel();			
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex(0);	
		$objPHPExcel->getActiveSheet()->setTitle('Salary');
		if($dataunit = unserialize($_GET['unit'])){
		$modelUnit = Unit::find()->Where(['IN','id',$dataunit])->orderBy('id')->all();
		} else {		
			$modelUnit = Unit::find()->orderBy('id')->all();  
		}	
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$objPHPExcel->getActiveSheet()->setShowGridlines(true);
		
		
		
		$objPHPExcel->getActiveSheet() ->setCellValue('B2', 'VOLTECH ENGINEERS PRIVATE LIMITED')
			->setCellValue('B3', 'Bank Statement')
			->setCellValue('B4', 'To')
			->setCellValue('B5', 'The Branch Manager')
			->setCellValue('B6', 'BANK OF BARODA')
			->setCellValue('B9', 'Please credit the following SB Accounts maintained with you by the amounts mentioned against the')
			->setCellValue('B10', $monthtxt);						
				
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "B3:K3");	
			$objPHPExcel->getActiveSheet()->getStyle('B3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B2:K10')->getFont()->setBold(true);
		
		$row =13;								
			$objPHPExcel->getActiveSheet()
			->setCellValue('B12', 'Sl.No')			
			->setCellValue('C12', 'Emp Code')
			->setCellValue('D12', 'Emp Name') 
			->setCellValue('E12', 'Account No.') 
			->setCellValue('F12', 'IFSC') 
			->setCellValue('G12', 'Net Amount') 
			->setCellValue('H12', 'Unit') 
			->setCellValue('I12', 'Division') 
			->setCellValue('J12', 'Customer') 
			->setCellValue('K12', 'Priority');
					
		foreach ($modelUnit as $unit){
			
			$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();			
			foreach ($UnitGroupModel as $groupmodel){
				if($data = unserialize($_GET['group'])){
				 $modelSal = EmpSalary::find()->joinWith(['employee','bank'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				 ->andWhere(['IN','emp_details.category',$data])
				 ->andWhere(['IN','emp_bankdetails.bankname',['Bank of Baroda','BOB','Baroda','Baroda bank']])
				 ->orderBy(['net_amount' => SORT_DESC])->all();
				 
				 $modelCount = EmpSalary::find()->joinWith(['employee','bank'])
				 ->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				 ->andWhere(['IN','emp_details.category',$data])
				 ->andWhere(['IN','emp_bankdetails.bankname',['Bank of Baroda','BOB','Baroda','Baroda bank']])
				 ->orderBy(['net_amount' => SORT_DESC])
				 ->count();	
				 } else {
				 $modelSal = EmpSalary::find()->joinWith(['bank'])->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				 ->andWhere(['IN','emp_bankdetails.bankname',['Bank of Baroda','BOB','Baroda','Baroda bank']])
				 ->orderBy(['net_amount' => SORT_DESC])->all();	
				 
				 $modelCount = EmpSalary::find()->joinWith(['bank'])->where(['month'=>$month,'emp_salary.unit_id'=>$groupmodel->unit_id,'emp_salary.division_id'=>$groupmodel->division_id])
				 ->andWhere(['IN','emp_bankdetails.bankname',['Bank of Baroda','BOB','Baroda','Baroda bank']])
				 ->orderBy(['net_amount' => SORT_DESC])->count();	
				}
				if($modelCount > 0) {
				 $division = Division::find()->Where(['id'=>$groupmodel->division_id])->One();
				 
				 foreach ($modelSal as $data) {	
				 $netamt = 0;
				/* $cust = Customer::find()->where(['id'=>$data->customer_id])->one();
					if($data->employee->category == 'International Engineer'|| $data->employee->category == 'Domestic Engineer'){
					 $netamt = ($data->net_amount + $data->tes) - ($data->dearness_allowance + $data->advance_arrear_tes);
					 } else {
					  $netamt = $data->net_amount;			 
					 } */
					
					$Remu = EmpRemunerationDetails::find()->where(['empid'=>$data->empid])->one();	
					  
					$Salarystructure = EmpSalarystructure::find()
					->where(['salarystructure' => $Remu->salary_structure])
					->one();
					 
					 if($Salarystructure){
						if($data->unit_id == 12){
						$netamt = $data->net_amount;	
						} else {
						 $netamt = ($data->net_amount + $data->tes) - ($data->dearness_allowance + $data->advance_arrear_tes);
						}					
					} else {
					 $netamt = $data->net_amount;	
					}
					
					$cust = Customer::find()->where(['id'=>$data->customer_id])->one();
					if($cust){
					$custname =$cust->customer_name;
					}else {
					$custname ='';	
					}
					 
					 
				 $dataArray = array(
					  ($row-12),
					  $data->employee->empcode,
					  $data->employee->empname,
					  $data->bank->acnumber,
					  $data->bank->ifsc,
					  $netamt,
					  $unit->name,
					  $division->division_name,
					   $custname,
					  $data->priority,
					 
				  );				 
				  $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'B' . $row++);				  
				  
				 }	
				}
				}			 
		}		
		       $objPHPExcel->getActiveSheet()->mergeCells('B'.$row.':F'.$row);
			   $objPHPExcel->getActiveSheet()->mergeCells('H'.$row.':K'.$row);			   
			   $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, 'Grand Total')
										     ->setCellValue('G'.$row, '=SUM(G13:G'.($row-1).')')											 
											 ->setCellValue('B'.($row+2), 'Cheque No.:')
											 ->setCellValue('B'.($row+3), 'Kindly acknowledge receipt')
											 ->setCellValue('G'.($row+2), 'Drawn On:')
											 ->setCellValue('G'.($row+3), 'For  VOLTECH ENGINEERS PRIVATE LIMITED')
											 ->setCellValue('G'.($row+6), 'Authorised Signatory');
											 
			   $objPHPExcel->getActiveSheet()->mergeCells('B'.($row+2).':F'.($row+2))
											 ->mergeCells('B'.($row+3).':F'.($row+3))
											 ->mergeCells('G'.($row+2).':K'.($row+2))
											 ->mergeCells('G'.($row+3).':K'.($row+3))
											 ->mergeCells('G'.($row+6).':K'.($row+6));
											 
			   $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.($row+6))->getFont()->setBold(true);
			   $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getFont()->setBold(true);
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, "B".$row.":K".$row);
			   $objPHPExcel->getActiveSheet()->getStyle("B".$row.":K".$row)->getFont()->setBold(true);
			   
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "B12:K12");
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "B13:K".($row-1));
			   $objPHPExcel->getActiveSheet()->getStyle('B12:K12')->getFont()->setBold(true);
			   $objPHPExcel->getActiveSheet()->getStyle('B2:K'.$row)->applyFromArray($styleArray);
			   
			   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(9);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
			   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(19);
			   foreach (range('J', 'K') as $columnID) {
					$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
			   }
			   
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:K1");
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:K".($row-1));
			   $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
			   $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);
			   $objPHPExcel->getActiveSheet()->getRowDimension('A1:K1')->setRowHeight(30);
			   $objPHPExcel->getActiveSheet()->freezePane('A2');
			 //  $objPHPExcel->removeSheetByIndex(4);		
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
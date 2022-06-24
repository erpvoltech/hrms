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

		if (Yii::$app->getRequest()->getQueryParam('month'))
		   $month = Yii::$app->getRequest()->getQueryParam('month');
		else
		   $month = '';  
		   
		if (Yii::$app->getRequest()->getQueryParam('group')) {
		   $group = Yii::$app->getRequest()->getQueryParam('group');
		} else {  
		   $group ='';
		}
		$pay =[];
		$structure = EmpStaffPayScale::find()->select('salarystructure')->all();
		foreach($structure as $stru){
			$pay[] = $stru->salarystructure;
			}
		$payscale = serialize($pay);
		$data = unserialize($payscale);
		
				
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
						'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED),
						'right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED)
					)
		));
		
		$filename = 'salary_statement.xlsx';
		$objPHPExcel = new PHPExcel();
				
		$structure = EmpStaffPayScale::find()->select('salarystructure')->all();
		$payscale = serialize($structure);
		
		$modelUnit = Unit::find()->orderBy('id')->all();
		$sheet = 0;	
		
		foreach ($modelUnit as $unit){
			$row =2;
			$fstratrow =2;
			$objPHPExcel->createSheet();
			$objPHPExcel->setActiveSheetIndex($sheet);			
			$objPHPExcel->getActiveSheet()
			->setCellValue('A1', 'Sl.No')
			->setCellValue('B1', 'Units')    
			->setCellValue('C1', 'Engrs Strength')
			->setCellValue('D1', 'Gross Amount')
			->setCellValue('E1', 'Nett Allowance Paid')
			->setCellValue('F1', 'Nett Salary Payable')
			->setCellValue('G1', 'CTC');			
			
			$objPHPExcel->getActiveSheet()->setTitle($unit->name);			
			foreach (range('A', 'G') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
			}	
			
			$UnitGroupModel = UnitGroup::find()->Where(['unit_id'=>$unit->id])->orderBy('priority')->all();
			
			     $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':B'.$row);
				 $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
				 $objPHPExcel->getActiveSheet()->setCellValue( 'A'.$row++, $unit->name);
				 
			foreach ($UnitGroupModel as $groupmodel){	
				 $division = Division::find()->Where(['id'=>$groupmodel->division_id])->One();	
				 $data = unserialize($payscale);
				 $modelcount = EmpSalary::find()
					->where(['month'=>$month,'unit_id'=>$groupmodel->unit_id,'division_id'=>$groupmodel->division_id])
					->andWhere(['IN','salary_structure',$data])
					->count();
				// $modelSal = EmpSalary::find()->where(['month'=>$month,'unit_id'=>$groupmodel->unit_id,'division_id'=>$groupmodel->division_id],['in','salary_structure',$structure ])->orderBy(['net_amount' => SORT_DESC])->all();
				 
				 /*$PayScale = EmpStaffPayScale::find()
                    ->where(['salarystructure' => $remunerationmodel->salary_structure])
                    ->one();

				 $Salarystructure = EmpSalarystructure::find()
                    ->where(['salarystructure' => $remunerationmodel->salary_structure])
                    ->one();
					
				 $netSal = EmpSalary::find()->where(['month'=>$month,'unit_id'=>$groupmodel->unit_id,'division_id'=>$groupmodel->division_id])->sum('net_amount');				 
				 $allowancepaid = EmpSalary::find()->where(['month'=>$month,'unit_id'=>$groupmodel->unit_id,'division_id'=>$groupmodel->division_id])->sum('paidallowance');
				 $ctc = EmpSalary::find()->where(['month'=>$month,'unit_id'=>$groupmodel->unit_id,'division_id'=>$groupmodel->division_id])->sum('earned_ctc');
					
				 $objPHPExcel->getActiveSheet()->setCellValue( 'B'.$row,$division->division_name);
				 $objPHPExcel->getActiveSheet()->setCellValue( 'C'.$row,$modelcount);
				 $objPHPExcel->getActiveSheet()->setCellValue( 'D'.$row,$netSal);				 
				 $objPHPExcel->getActiveSheet()->setCellValue( 'E'.$row,$allowancepaid);
				 $objPHPExcel->getActiveSheet()->setCellValue( 'F'.$row,$netSal);
				 $objPHPExcel->getActiveSheet()->setCellValue( 'G'.$row,$ctc);
				 $row++;
			} 
				
			   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:G1");
			   $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
			  // $objPHPExcel->getActiveSheet()->setAutoFilter('A1:AL1');
			  // $objPHPExcel->getActiveSheet()->freezePane('A2');
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
	 */
?>
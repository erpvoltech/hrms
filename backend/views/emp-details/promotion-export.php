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
use common\models\Course;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\EmpFamilydetails;

error_reporting(0);

$objPHPExcel = new PHPExcel();

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
        ->setCellValue('A1', 'Emp. Code')
        ->setCellValue('B1', 'Emp. Name')
        ->setCellValue('C1', 'Date of Joining')
        ->setCellValue('D1', 'Confirmation Date')
		->setCellValue('E1', 'Latest Promotion Date')
		->setCellValue('F1', 'Unit')
		->setCellValue('G1', 'Division')       
        ->setCellValue('H1', 'Department')
        ->setCellValue('I1', 'Current Designation')
        ->setCellValue('J1', 'Current SS')
        ->setCellValue('K1', 'Current Work Level')
        ->setCellValue('L1', 'Current Grade')
        ->setCellValue('M1', 'Current Gross')   
		->setCellValue('N1', 'Current PLI')
        ->setCellValue('O1', 'Effective Date')
		->setCellValue('P1', 'New Designation')
        ->setCellValue('Q1', 'New Salary Structure')
        ->setCellValue('R1', 'New Work Level')
        ->setCellValue('S1', 'New Grade')
        ->setCellValue('T1', 'New Gross')
		->setCellValue('U1', 'New PLI') 
		->setCellValue('V1', 'Status');
        
		
		$unitparams = Yii::$app->getRequest()->getQueryParam('unit');
        $designparams=Yii::$app->getRequest()->getQueryParam('design');
		$deptparams= Yii::$app->getRequest()->getQueryParam('dept');
		$categparams= Yii::$app->getRequest()->getQueryParam('categ');
		$divparams= Yii::$app->getRequest()->getQueryParam('division');		 
		$exporttype= Yii::$app->getRequest()->getQueryParam('type');
		
        $conditions = [];	
		
		if($unitparams !=''){
			$conditions[] = "unit_id =$unitparams";
		}
		if($designparams !=''){
			$conditions[] = "designation_id = $designparams";
		}		
		if($deptparams !=''){
			$conditions[] = "department_id = $deptparams";
		}
		if($divparams !=''){
			$conditions[] = "division_id = $divparams";
		}
		if($categparams !=''){
			$conditions[] = "category = '$categparams'";
		}		
		$query = 'SELECT * FROM emp_details';
		if(count($conditions) > 0) {
		 $query .= " WHERE " . implode (' AND ', $conditions);
		
		$model = EmpDetails::findBySql($query)->all();
		
		} else {
		$model = EmpDetails::find()->all();
		}
		
		

// Designation row DA 
$designation = Designation::find()->all();
$drow = 2;
foreach ($designation as $design) {
   $designationArray = array(
       $design->designation,
   );
   $objPHPExcel->getActiveSheet()->fromArray($designationArray, NULL, 'DA' . $drow++);
}
$drow--;
$designationcounter = $drow;

// Unit row DB
$unit = Unit::find()->all();
$urow = 2;
foreach ($unit as $unitdata) {
   $unitArray = array(
       $unitdata->name,
   );
   $objPHPExcel->getActiveSheet()->fromArray($unitArray, NULL, 'DB' . $urow++);
}
$urow--;
$unitcounter = $urow;

// Unit row DC
$dept = Department::find()->all();
$deptrow = 2;
foreach ($dept as $department) {
   $deptArray = array(
       $department->name,
   );
   $objPHPExcel->getActiveSheet()->fromArray($deptArray, NULL, 'DC' . $deptrow++);
}
$deptrow--;
$deptcounter = $deptrow;

// Divsion Row
$div = Division::find()->all();
$divrow = 2;
foreach ($div as $divsion) {
   $deptArray = array(
       $divsion->division_name,
   );
   $objPHPExcel->getActiveSheet()->fromArray($deptArray, NULL, 'DD' . $divrow++);
}
$divrow--;
$divcounter = $divrow;

// Staff PayScale

$PayScale = EmpStaffPayScale::find()->select('salarystructure')->all();
$structure = EmpSalarystructure::find()->select('salarystructure')->distinct()->all();

$salaryStructure = '';

foreach ($structure as $Scale) {
   $salaryStructure .=$Scale->salarystructure . ',';
}
$salaryStructure .='Consolidated pay,';
$salaryStructure .='Contract,';
foreach ($PayScale as $ss) {
   $salaryStructure .=$ss->salarystructure . ',';
}

$row = 2;
foreach ($model as $data) {
 if($data->remuneration->salary_structure != 'Contract') {
   $deptname = Department::find()->where(['id' => $data->department_id])->one();
   $divname = Division::find()->where(['id' => $data->division_id])->one();
   $modelRemu = EmpStaffPayScale::find()->where(['salarystructure' => $data->remuneration->salary_structure])->one();
   if ($modelRemu) {
      $gross = $data->remuneration->gross_salary;
   } else if($data->remuneration->salary_structure == 'Consolidated pay'){
      $gross = $data->remuneration->gross_salary;
   } else {
    $gross = '';
   }
 $edu = EmpEducationdetails::find()->where(['empid' => $data->id])->one();
   
    $coursemodel = Course::find()->where(['id' =>  $edu->course])->one();
	if($coursemodel){
		$coursename =  $coursemodel->coursename;
		} else {
		$coursename ='';
		}
	$collegemodel = College::find()->where(['id' => $edu->institute])->one();
    if($collegemodel){
		$collgename =  $collegemodel->collegename;
		} else {
		$collgename = '';
		}
	
	$design = Designation::find()->where(['id' =>$data->designation_id])->one();		
	if($design){
		$designationdata = $design->designation;
		} else {
		$designationdata = '';
		}
	
	$Unitmodel = Unit::find()->where(['id' =>$data->unit_id])->one();		
	if($Unitmodel){
		$unitdata = $Unitmodel->name;
		} else {
		$unitdata = '';
		}
	if(!empty($data->confirmation_date) && $data->confirmation_date !='0000-00-00' && $data->confirmation_date !='1970-01-01'){
				$confirmation_date = Yii::$app->formatter->asDate($data->confirmation_date, "dd-MM-yyyy");
				} else {
				$confirmation_date =''; 
				} 
	if(!empty($data->recentdop) && $data->recentdop !='0000-00-00' && $data->recentdop !='1970-01-01'){
		$recentdop = Yii::$app->formatter->asDate($data->recentdop, "dd-MM-yyyy");
				} else {
				$recentdop =''; 
				} 	
   $dataArray = array(
       $data->empcode,
       $data->empname,  
	   Yii::$app->formatter->asDate($data->doj, "dd-MM-yyyy"),	   
       $confirmation_date,
	   $recentdop,
	   $unitdata,
       $divname['division_name'],      
       $deptname['name'],
       $designationdata,
       $data->remuneration->salary_structure,
       $data->remuneration->work_level,
       $data->remuneration->grade,
       $gross,
	   $data->remuneration->pli,
   );
   $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);  

}
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:V1");
$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:V1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

$i = 2;
foreach ($model as $data) {


   $objValidation = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
   $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation->setAllowBlank(true);
   $objValidation->setShowInputMessage(true);
   $objValidation->setShowErrorMessage(true);
   $objValidation->setShowDropDown(true);
   $objValidation->setFormula1('=$DA2:$DA' . $designationcounter);

   $objValidation5 = $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getDataValidation();
   $objValidation5->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation5->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation5->setAllowBlank(true);
   $objValidation5->setShowInputMessage(true);
   $objValidation5->setShowErrorMessage(true);
   $objValidation5->setShowDropDown(true);
   $objValidation5->setFormula1('=$DA2:$DA' . $designationcounter);

   $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
   $objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation1->setAllowBlank(true);
   $objValidation1->setShowInputMessage(true);
   $objValidation1->setShowErrorMessage(true);
   $objValidation1->setShowDropDown(true);
   $objValidation1->setFormula1('=$DC2:$DC' . $deptcounter);


   $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getDataValidation();
   $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation2->setAllowBlank(true);
   $objValidation2->setShowInputMessage(true);
   $objValidation2->setShowErrorMessage(true);
   $objValidation2->setShowDropDown(true);
   $objValidation2->setFormula1('=$DB2:$DB' . $unitcounter);
   
   $objValidation3 = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
   $objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation3->setAllowBlank(true);
   $objValidation3->setShowInputMessage(true);
   $objValidation3->setShowErrorMessage(true);
   $objValidation3->setShowDropDown(true);
   $objValidation3->setFormula1('=$DD2:$DD' . $divcounter);

   $objValidation4 = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getDataValidation();
   $objValidation4->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation4->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation4->setAllowBlank(true);
   $objValidation4->setShowInputMessage(true);
   $objValidation4->setShowErrorMessage(true);
   $objValidation4->setShowDropDown(true);
   $objValidation4->setFormula1('"WL4C,WL4B,WL4A,WL3B,WL3A,WL5,WL4,WL3,WL2,WL1"');
   
   
   $objValidation5 = $objPHPExcel->getActiveSheet()->getCell('R' . $i)->getDataValidation();
   $objValidation5->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation5->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation5->setAllowBlank(true);
   $objValidation5->setShowInputMessage(true);
   $objValidation5->setShowErrorMessage(true);
   $objValidation5->setShowDropDown(true);
   $objValidation5->setFormula1('"WL4C,WL4B,WL4A,WL3B,WL3A,WL5,WL4,WL3,WL2,WL1"');

   $objValidation6 = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getDataValidation();
   $objValidation6->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation6->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation6->setAllowBlank(true);
   $objValidation6->setShowInputMessage(true);
   $objValidation6->setShowErrorMessage(true);
   $objValidation6->setShowDropDown(true);
   $objValidation6->setFormula1('"AA,A,A1,B,B1,C,C1,D,E"');   
    
   
   $objValidation7 = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
   $objValidation7->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation7->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation7->setAllowBlank(true);
   $objValidation7->setShowInputMessage(true);
   $objValidation7->setShowErrorMessage(true);
   $objValidation7->setShowDropDown(true);
   $objValidation7->setFormula1('"' . $salaryStructure . '"');  
   
   $objValidation8 = $objPHPExcel->getActiveSheet()->getCell('Q' . $i)->getDataValidation();
   $objValidation8->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation8->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation8->setAllowBlank(true);
   $objValidation8->setShowInputMessage(true);
   $objValidation8->setShowErrorMessage(true);
   $objValidation8->setShowDropDown(true);
   $objValidation8->setFormula1('"' . $salaryStructure . '"');  
   
   $objValidation9 = $objPHPExcel->getActiveSheet()->getCell('S' . $i)->getDataValidation();
   $objValidation9->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation9->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation9->setAllowBlank(true);
   $objValidation9->setShowInputMessage(true);
   $objValidation9->setShowErrorMessage(true);
   $objValidation9->setShowDropDown(true);
   $objValidation9->setFormula1('"AA,A,A1,B,B1,C,C1,D,E"');  
   
   $objValidation10 = $objPHPExcel->getActiveSheet()->getCell('N' . $i)->getDataValidation();
   $objValidation10->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation10->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation10->setAllowBlank(true);
   $objValidation10->setShowInputMessage(true);
   $objValidation10->setShowErrorMessage(true);
   $objValidation10->setShowDropDown(true);
   $objValidation10->setFormula1('"0,8.33,16.67"');
   
   $objValidation11 = $objPHPExcel->getActiveSheet()->getCell('U' . $i)->getDataValidation();
   $objValidation11->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation11->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation11->setAllowBlank(true);
   $objValidation11->setShowInputMessage(true);
   $objValidation11->setShowErrorMessage(true);
   $objValidation11->setShowDropDown(true);
   $objValidation11->setFormula1('"0,8.33,16.67"');
   
   $objValidation12 = $objPHPExcel->getActiveSheet()->getCell('V' . $i)->getDataValidation();
   $objValidation12->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation12->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation12->setAllowBlank(true);
   $objValidation12->setShowInputMessage(true);
   $objValidation12->setShowErrorMessage(true);
   $objValidation12->setShowDropDown(true);
   $objValidation12->setFormula1('"Promotion,Increment,Confirmation"');
  

   $i++;
}


$j = 2;
$k = 2;

foreach ($model as $data) {
   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $j++ . ':V' . $k++);
}
$j--;
$k--;
foreach (range('A', 'V') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);     
}
foreach (range('X', 'Z') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setVisible(false);  
}
foreach (range('A', 'Z') as $columnID) {
	 $objPHPExcel->getActiveSheet()->getColumnDimension('A' . $columnID)->setVisible(false); 
	 $objPHPExcel->getActiveSheet()->getColumnDimension('B' . $columnID)->setVisible(false);
	 $objPHPExcel->getActiveSheet()->getColumnDimension('C' . $columnID)->setVisible(false); 
	 $objPHPExcel->getActiveSheet()->getColumnDimension('D' . $columnID)->setVisible(false);  
}

/* $l=2;
  foreach($model as $data ) {
  $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, "BI".$l++);
  }
  $l--;
  //$lastcol = $objPHPExcel->getActiveSheet()->getHighestRow();
  //$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle3, "A".$lastcol.":BI".$lastcol);
  //$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle4, "BI".$lastcol); */
$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="EmployeePromotion.xlsx"');
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
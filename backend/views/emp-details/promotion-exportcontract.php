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
        ->setCellValue('D1', 'Latest Promotion Date')		
		->setCellValue('E1', 'Unit')
		->setCellValue('F1', 'Division')       
        ->setCellValue('G1', 'Department')
        ->setCellValue('H1', 'Current Designation')
        ->setCellValue('I1', 'Current SS')
        ->setCellValue('J1', 'Current Work Level')
        ->setCellValue('K1', 'Current Grade')
		->setCellValue('L1', 'Effective Date')
        ->setCellValue('M1', 'New Work Level')
        ->setCellValue('N1', 'New Grade');
		
		       
	   /*->setCellValue('O1', 'Basic')
        ->setCellValue('P1', 'HRA')
        ->setCellValue('Q1', 'DA')
        ->setCellValue('R1', 'Personpay')
        ->setCellValue('S1', 'Dust Allowance')
        ->setCellValue('T1', 'Guaranteed Benefit')
        ->setCellValue('U1', 'Other Allowance'); */
		
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
 if($data->remuneration->salary_structure == 'Contract') {
   $deptname = Department::find()->where(['id' => $data->department_id])->one();
   $divname = Division::find()->where(['id' => $data->division_id])->one();
   $modelRemu = EmpStaffPayScale::find()->where(['salarystructure' => $data->remuneration->salary_structure])->one();  
    $gross = $data->remuneration->gross_salary;   
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
	   $recentdop,
	   $unitdata,
       $divname['division_name'],      
       $deptname['name'],
       $designationdata,
       $data->remuneration->salary_structure,
       $data->remuneration->work_level,
       $data->remuneration->grade,
      // $gross
   );
   $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);  

}
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:N1");
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:N1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

$i = 2;
foreach ($model as $data) {

   $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
   $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation->setAllowBlank(true);
   $objValidation->setShowInputMessage(true);
   $objValidation->setShowErrorMessage(true);
   $objValidation->setShowDropDown(true);
   $objValidation->setFormula1('=$DA2:$DA' . $designationcounter);



   $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
   $objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation1->setAllowBlank(true);
   $objValidation1->setShowInputMessage(true);
   $objValidation1->setShowErrorMessage(true);
   $objValidation1->setShowDropDown(true);
   $objValidation1->setFormula1('=$DC2:$DC' . $deptcounter);


   $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getDataValidation();
   $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation2->setAllowBlank(true);
   $objValidation2->setShowInputMessage(true);
   $objValidation2->setShowErrorMessage(true);
   $objValidation2->setShowDropDown(true);
   $objValidation2->setFormula1('=$DB2:$DB' . $unitcounter);
   
   $objValidation21 = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getDataValidation();
   $objValidation21->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation21->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation21->setAllowBlank(true);
   $objValidation21->setShowInputMessage(true);
   $objValidation21->setShowErrorMessage(true);
   $objValidation21->setShowDropDown(true);
   $objValidation21->setFormula1('=$DD2:$DD' . $divcounter);

   $objValidation3 = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
   $objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation3->setAllowBlank(true);
   $objValidation3->setShowInputMessage(true);
   $objValidation3->setShowErrorMessage(true);
   $objValidation3->setShowDropDown(true);
   $objValidation3->setFormula1('"WL5,WL4C,WL4B,WL4A,WL3B,WL3A"');

   $objValidation4 = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getDataValidation();
   $objValidation4->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation4->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation4->setAllowBlank(true);
   $objValidation4->setShowInputMessage(true);
   $objValidation4->setShowErrorMessage(true);
   $objValidation4->setShowDropDown(true);
   $objValidation4->setFormula1('"A,B,C,D"');   
    
   
   $objValidation16 = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
   $objValidation16->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation16->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation16->setAllowBlank(true);
   $objValidation16->setShowInputMessage(true);
   $objValidation16->setShowErrorMessage(true);
   $objValidation16->setShowDropDown(true);
   $objValidation16->setFormula1('"' . $salaryStructure . '"');  
   
   $objValidation7 = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getDataValidation();
   $objValidation7->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation7->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation7->setAllowBlank(true);
   $objValidation7->setShowInputMessage(true);
   $objValidation7->setShowErrorMessage(true);
   $objValidation7->setShowDropDown(true);
   $objValidation7->setFormula1('"WL5,WL4C,WL4B,WL4A,WL3B,WL3A"');
   
   $objValidation8 = $objPHPExcel->getActiveSheet()->getCell('N' . $i)->getDataValidation();
   $objValidation8->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation8->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation8->setAllowBlank(true);
   $objValidation8->setShowInputMessage(true);
   $objValidation8->setShowErrorMessage(true);
   $objValidation8->setShowDropDown(true);
   $objValidation8->setFormula1('"A,B,C,D"');  

   $i++;
}


$j = 2;
$k = 2;

foreach ($model as $data) {
   $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, 'A' . $j++ . ':N' . $k++);
}
$j--;
$k--;
foreach (range('A', 'N') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
}

foreach (range('P', 'Z') as $columnID) {
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
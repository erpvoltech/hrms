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
use common\models\Qualification;
use common\models\Unit;
use common\models\Division;
use common\models\College;
use common\models\Course;
use app\models\EmpStaffPayScale;
use app\models\EmpSalarystructure;
use common\models\EmpRemunerationDetails;
use common\models\EmpFamilydetails;

//error_reporting(E_ALL);

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
        ->setCellValue('C1', 'Designation')     
        ->setCellValue('D1', 'Unit')
        ->setCellValue('E1', 'Division')       
        ->setCellValue('F1', 'Department')    
		->setCellValue('G1', 'Qualification')
		->setCellValue('H1', 'Course')
		->setCellValue('I1', 'Board')
		->setCellValue('J1', 'Institute')
		->setCellValue('K1', 'YOP');
		
		
		
		 $unitparams = Yii::$app->getRequest()->getQueryParam('unit');
         $designparams=Yii::$app->getRequest()->getQueryParam('design');
		 $deptparams= Yii::$app->getRequest()->getQueryParam('dept');
		 $categparams= Yii::$app->getRequest()->getQueryParam('categ');
		 $divparams= Yii::$app->getRequest()->getQueryParam('division');
		 $exporttype= Yii::$app->getRequest()->getQueryParam('type');
		 
		$fields = array('designation_id', 'unit_id', 'division_id', 'category', 'department_id');
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

// Qualification row O 
$qualiarray = Qualification::find()->all();
$qrow = 2;
foreach ($qualiarray as $qualifi) {
   $qualificationArray = array(
       $qualifi->qualification_name,
   );
   $objPHPExcel->getActiveSheet()->fromArray($qualificationArray, NULL, 'O' . $qrow++);
}
$qrow--;
$qualificationcounter = $qrow;


// Course row P 
$carray = Course::find()->all();
$crow = 2;
foreach ($carray as $course) {
   $coursearray = array(
       $course->coursename,
   );
   $objPHPExcel->getActiveSheet()->fromArray($coursearray, NULL, 'P' . $crow++);
}
$crow--;
$coursecounter = $crow;

// Institute row Q 
$iarray = College::find()->all();
$irow = 2;
foreach ($iarray as $inistitute) {
   $instituteArray = array(
       $inistitute->collegename,
   );
   $objPHPExcel->getActiveSheet()->fromArray($instituteArray, NULL, 'Q' . $irow++);
}
$irow--;
$institutecounter = $qrow;

$row = 2;
foreach ($model as $data) {
   $deptname = Department::find()->where(['id' => $data->department_id])->one();
   $divname = Division::find()->where(['id' => $data->division_id])->one(); 
   
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
	
					
	$modelEdu = EmpEducationdetails::find()->where(['empid' => $data->id])->all();
    foreach ($modelEdu as $edu) {
	
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
		
	$degree = Qualification::find()->where(['id' => $edu->qualification])->one();
	  if($degree){
		$degreename =  $degree->qualification_name;
		} else {
		$degreename = '';
		}
	if($exporttype == 2){
		
		} else if($exporttype == 1){
   $dataArray = array(
       $data->empcode,
       $data->empname, 
       $designationdata,     
       $unitdata,
       $divname['division_name'],      
       $deptname['name'],
	   $degreename,
	   $coursename,
	   $edu->board,
	   $collgename,
	   $edu->yop,	  
   );
   $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);  
}
}
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:K1");
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:K1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

$i = 2;
foreach ($model as $data) {

   $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
   $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation->setAllowBlank(true);
   $objValidation->setShowInputMessage(true);
   $objValidation->setShowErrorMessage(true);
   $objValidation->setShowDropDown(true);
   $objValidation->setFormula1('=$O2:$O' . $qualificationcounter);



   $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
   $objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation1->setAllowBlank(true);
   $objValidation1->setShowInputMessage(true);
   $objValidation1->setShowErrorMessage(true);
   $objValidation1->setShowDropDown(true);
   $objValidation1->setFormula1('=$Q2:$Q' . $institutecounter);


   $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
   $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation2->setAllowBlank(true);
   $objValidation2->setShowInputMessage(true);
   $objValidation2->setShowErrorMessage(true);
   $objValidation2->setShowDropDown(true);
   $objValidation2->setFormula1('=$P2:$P' . $coursecounter);   
  

   $i++;
}



foreach (range('A', 'K') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);   
}

foreach (range('N', 'Z') as $columnID) {
	 $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setVisible(false);  
}


$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Emp_education.xlsx"');
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
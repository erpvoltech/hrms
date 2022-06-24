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
		->setCellValue('G1', 'Relationship')
		->setCellValue('H1', 'Name')
		->setCellValue('I1', 'Mobile')
		->setCellValue('J1', 'Aadhaar#')
		->setCellValue('K1', 'Birthday')
		->setCellValue('L1', 'Nominee');
		
		
		 
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
	
		$family = EmpFamilydetails::find()->Where(['empid'=>$data->id])->all();
					
	foreach ($family as $familydata) {
	
	if(!empty($familydata->birthdate) && $familydata->birthdate !='0000-00-00' && $familydata->birthdate !='1970-01-01'){
		$birthdate = Yii::$app->formatter->asDate($familydata->birthdate, "dd-MM-yyyy");
				} else {
				$birthdate =''; 
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
       $familydata->relationship,
	   $familydata->name,
	   $familydata->mobileno,
	   $familydata->aadhaarno,
	   $birthdate,
	   $familydata->nominee,
   );
   $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);  
}
}
}
$row--;

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:L1");
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setWrapText(TRUE);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:L1');
$objPHPExcel->getActiveSheet()->freezePane('A2');

$objPHPExcel->setActiveSheetIndex(0);

$i = 2;
foreach ($model as $data) {
   $objValidation10 = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getDataValidation();
   $objValidation10->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
   $objValidation10->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
   $objValidation10->setAllowBlank(true);
   $objValidation10->setShowInputMessage(true);
   $objValidation10->setShowErrorMessage(true);
   $objValidation10->setShowDropDown(true);
   $objValidation10->setFormula1('"Yes,No"');
   $i++;
}


foreach (range('A', 'L') as $columnID) {
   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);  
}

$objPHPExcel->setActiveSheetIndex(0);


$callStartTime = microtime(true);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Emp_family.xlsx"');
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
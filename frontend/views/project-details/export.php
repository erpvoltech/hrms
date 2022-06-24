<?php
ob_start();
use common\models\Customer;
use common\models\ProjectDetails;
use common\models\District;
use common\models\State;
use yii\helpers\ArrayHelper;

error_reporting(0);

		/*$list = StatutoryHr::find()->where(['month'=>Yii::$app->formatter->asDate($month, "yyyy-MM-dd")])->orderBy(['list_no' => SORT_DESC]) ->one();
		   if($list){
			   $pflistno = $list->list_no;
			} else {
			   $pflistno = 1;
			 }

			$m = date("m", strtotime($month));
            $y = date("Y", strtotime($month));
            $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);*/
			
			//print_r($custData);
			//exit;
			
			$objPHPExcel = new \PHPExcel();

			$sharedStyle1 = new \PHPExcel_Style();
			$sharedStyle2 = new \PHPExcel_Style();
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
					->setCellValue('A1', 'Project code')
					->setCellValue('B1', 'Project Name')
					->setCellValue('C1', 'Po No')
					->setCellValue('D1', 'Po Date')
					->setCellValue('E1', 'Po Delivery Date')
					->setCellValue('F1', 'Location Code')
					->setCellValue('G1', 'Principal Employer')
					->setCellValue('H1', 'PE HR Name')
					->setCellValue('I1', 'PE HR Contact')
					->setCellValue('J1', 'PE HR Email')
					->setCellValue('K1', 'PE Tech Name')
					->setCellValue('L1', 'PE Tech Contact')
					->setCellValue('M1', 'PE Tech Email')
					->setCellValue('N1', 'Customer')
					->setCellValue('O1', 'Customer HR Name')
					->setCellValue('P1', 'Customer HR Contact')
					->setCellValue('Q1', 'Customer HR Email')
					->setCellValue('R1', 'Customer Tech Name')
					->setCellValue('S1', 'Customer Tech Contact')
					->setCellValue('T1', 'Customer Tech Email')
					->setCellValue('U1', 'Job Details')
					->setCellValue('V1', 'State')
					->setCellValue('W1', 'District')
					->setCellValue('X1', 'Compliance Required')
					->setCellValue('Y1', 'Consultant')
					->setCellValue('Z1', 'Consultant Name')
					->setCellValue('AA1', 'Consultant HR Name')
					->setCellValue('AB1', 'Consultant HR Contact')
					->setCellValue('AC1', 'Consultant HR Email')
					->setCellValue('AD1', 'Consultant Tech Name')
					->setCellValue('AE1', 'Consultant Tech Contact')
					->setCellValue('AF1', 'Consultant Tech Email')
					->setCellValue('AG1', 'Project Status')
					->setCellValue('AH1', 'Remark');
					
				/*$row = 2;	
			foreach ($salary as $data) {
			 $EMP = EmpDetails::find()->where(['id'=>$data->empid])->one();
			 $UAN = EmpStatutorydetails::find()->where(['empid' =>$data->empid])->one();
			 $modelRemu = EmpRemunerationDetails::find()->where(['empid' => $data->empid])->one();
			 	
				$epfwages = round(($data->pf * 100)/12);	
				$epswages = ($epfwages < 15000 ? $epfwages : 15000);				
				$eps_cont = round($epswages *0.0833);
				$eps_contriputed = ($eps_cont < 1250 ? $eps_cont : 1250);				
				$ncp_days = (($day_count- $data->paiddays) > 0 ? $day_count- $data->paiddays : '0');				
				$round_adv = '0';
				$found = 0;
				$Exlist = StatutoryHr::find()->where(['month'=>Yii::$app->formatter->asDate($month, "yyyy-MM-dd")])->all();
				if($Exlist) {
				foreach ($Exlist as $Exlist) {
				$ExEMP = PfList::find()->where(['list_id'=>$Exlist->id,'empid'=>$data->empid])->one();
				if($ExEMP){
					$found = 1;
					}
				}
				}
			if($found == 0) {*/
			//$dataArray = array(
			  // $UAN->epfuanno,
			  // $EMP->empname,
			  // $data->earnedgross,
			  // $epfwages,
			  // $epswages,
			  // $epswages,
			  // $data->pf,
			  // $eps_contriputed,
			  // $data->pf - $eps_contriputed,
			   //$ncp_days,
			   //$round_adv,
			//);			
			//$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
			//}
			//}
			//$row--;		
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:AH1");
			$objPHPExcel->getActiveSheet()->getStyle('A1:AH1')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('A1:AH1')->getFont()->setBold(true);
			//$objPHPExcel->getActiveSheet()->setAutoFilter("A1:O1");
			$objPHPExcel->getActiveSheet()->freezePane('A2');

			$objPHPExcel->setActiveSheetIndex(0);
			$model=ProjectDetails::find()->all();
			
			$principal = Customer::find()->where(['type'=>'Principal Employer'])->all();
			//print_r($principal);
			
			$principal_data = '';

			foreach($principal as $princi){
				$principal_data .=$princi->customer_name . ',';
				//print_r($principal_data);
			}
			//exit;
			
			$cust = Customer::find()->where(['type'=>'Customer'])->all();
			$customer_data = '';

			foreach($cust as $customer){
				$customer_data .=$customer->customer_name . ',';
			}
			
			$consult = Customer::find()->where(['type'=>'Consultant'])->all();
			$consultant_data = '';

			foreach($consult as $consultant){
				$consultant_data .=$consultant->customer_name . ',';
				//print_r($consultant_data);
			}
			//exit;
			
			$state = State::find()->all();
			$state_data = '';

			foreach($state as $sta){
				$state_data .=$sta->state_name . ',';
				//print_r($state_data);
				
			}
			
			/*$district = District::find()->all();
			$district_data = '';

			foreach($district as $dist){
				$district_data .=$dist->district_name . ',';
				//print_r($district_data);
			}*/
			//exit;
			$i=2;
			for($model=1; $model<=100; $model++) {
			
		   $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
		   $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation->setAllowBlank(true);
		   $objValidation->setShowInputMessage(true);
		   $objValidation->setShowErrorMessage(true);
		   $objValidation->setShowDropDown(true);
		   $objValidation->setFormula1('"' . $principal_data . '"');
		   
		   $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('N' . $i)->getDataValidation();
		   $objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation1->setAllowBlank(true);
		   $objValidation1->setShowInputMessage(true);
		   $objValidation1->setShowErrorMessage(true);
		   $objValidation1->setShowDropDown(true);
		   $objValidation1->setFormula1('"' . $customer_data . '"');
		   
		/*  $objValidation2 = $objPHPExcel->getActiveSheet()->getCell('V' . $i)->getDataValidation();
		   $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation2->setAllowBlank(true);
		   $objValidation2->setShowInputMessage(true);
		   $objValidation2->setShowErrorMessage(true);
		   $objValidation2->setShowDropDown(true);
		  
		   $objValidation2->setFormula1('"'.$state_data.'"');*/
		   
		 /*  $objValidation3 = $objPHPExcel->getActiveSheet()->getCell('R' . $i)->getDataValidation();
		   $objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation3->setAllowBlank(true);
		   $objValidation3->setShowInputMessage(true);
		   $objValidation3->setShowErrorMessage(true);
		   $objValidation3->setShowDropDown(true);
		   $objValidation3->setFormula1('"' . $district_data . '"');*/
		   
		   $objValidation4 = $objPHPExcel->getActiveSheet()->getCell('X' . $i)->getDataValidation();
		   $objValidation4->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation4->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation4->setAllowBlank(true);
		   $objValidation4->setShowInputMessage(true);
		   $objValidation4->setShowErrorMessage(true);
		   $objValidation4->setShowDropDown(true);
		   $objValidation4->setFormula1('"EPF,ESI,WC,CLRA(S),CLRA(C),ISMW,Factories Act,GPA"');
		   
		   $objValidation5 = $objPHPExcel->getActiveSheet()->getCell('Y' . $i)->getDataValidation();
		   $objValidation5->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation5->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation5->setAllowBlank(true);
		   $objValidation5->setShowInputMessage(true);
		   $objValidation5->setShowErrorMessage(true);
		   $objValidation5->setShowDropDown(true);
		   $objValidation5->setFormula1('"Yes,No"');
		   
		   $objValidation6 = $objPHPExcel->getActiveSheet()->getCell('Z' . $i)->getDataValidation();
		   $objValidation6->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation6->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation6->setAllowBlank(true);
		   $objValidation6->setShowInputMessage(true);
		   $objValidation6->setShowErrorMessage(true);
		   $objValidation6->setShowDropDown(true);
		   $objValidation6->setFormula1('"' . $consultant_data . '"');
		   
		   $objValidation100 = $objPHPExcel->getActiveSheet()->getCell('AG' . $i)->getDataValidation();
		   $objValidation100->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
		   $objValidation100->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
		   $objValidation100->setAllowBlank(true);
		   $objValidation100->setShowInputMessage(true);
		   $objValidation100->setShowErrorMessage(true);
		   $objValidation100->setShowDropDown(true);
		   $objValidation100->setFormula1('"Active,Hold,closed"');
		   
		   $i++;
			}
			
			foreach (range('A', 'AH') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);			
			}
			
			$objPHPExcel->setActiveSheetIndex(0);
			

				$callStartTime = microtime(true);


				// Redirect output to a client’s web browser (Excel2007)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="ProjectList.xlsx"');
				header('Cache-Control: max-age=0');
				// If you're serving to IE 9, then the following may be needed
				header('Cache-Control: max-age=1');

				// If you're serving to IE over SSL, then the following may be needed
				header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
				header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
				header('Pragma: public'); // HTTP/1.0

				$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save('php://output');
				exit;	
				?>
				
	  
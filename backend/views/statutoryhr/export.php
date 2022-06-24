<?php
ob_start();

use common\models\EmpDetails;
use common\models\StatutoryHr;
use common\models\EmpSalary;
use common\models\EmpRemunerationDetails;
use common\models\EmpStatutorydetails;
use common\models\PfList;
use common\models\Division;
use common\models\Unit;
error_reporting(0);
//error_reporting(E_ALL);

		$list = StatutoryHr::find()->where(['month'=>Yii::$app->formatter->asDate($month, "yyyy-MM-dd")])->orderBy(['list_no' => SORT_DESC])->one();
		   if($list){
			   $pflistno = $list->list_no;
			} else {
			   $pflistno = 1;
			 }

			$m = date("m", strtotime($month));
            $y = date("Y", strtotime($month));
            $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
			
			
			$workdays = 0;
			/*for ($i = 1; $i <= $day_count; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               } */
			
			
			
			$objPHPExcel = new \PHPExcel();

			$sharedStyle1 = new \PHPExcel_Style();
			$sharedStyle2 = new \PHPExcel_Style();

			$sharedStyle1->applyFromArray(
					array('fill' => array(
							'type' => \PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('argb' => 'BBDEFB')
						),					
			));

			$objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'UAN')
					->setCellValue('B1', 'MEMBER NAME')
					->setCellValue('C1', 'ECODE')
					->setCellValue('D1', 'GROSS WAGES')
					->setCellValue('E1', 'EPF WAGES')
					->setCellValue('F1', 'EPS WAGES')
					->setCellValue('G1', 'EDLI WAGES')
					->setCellValue('H1', 'EPF CONTRI REMITTED')
					->setCellValue('I1', 'EPS CONTRI REMITTED')
					->setCellValue('J1', 'EPF EPS DIFF REMITTED')
					->setCellValue('K1', 'NCP DAYS')
					->setCellValue('L1', 'REFUND OF ADVANCES')
					->setCellValue('M1', 'UNIT')
					->setCellValue('N1', 'DIVISION')
					->setCellValue('O1', 'Category');
					
					$row = 2;	
			foreach ($salary as $data) {
			$workdays = 0;
			for ($i = 1; $i <= $day_count; $i++) {
				$date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               }
			$pfgross = 0;
			 $gross = 0;			 
			 $daycount =0;
			 $tot_val = 0;
			$modelRemu = EmpRemunerationDetails::find()->where(['empid' => $data->empid])->one();
			if($modelRemu->	pf_applicablity == 'Yes'){
			 $EMP = EmpDetails::find()->where(['id'=>$data->empid])->one();
			 $UAN = EmpStatutorydetails::find()->where(['empid' =>$data->empid])->one();
			 
			 $division = Division::find()->Where(['id'=>$data->division_id])->One();
			 $modelUnit = Unit::find()->Where(['id'=>$data->unit_id])->One(); 
			// $division_name = $division['division_name'];
			// $unit_name = $modelUnit['name'];
			 	
			//	$epfwages = round(($data->pf * 100)/12);	
							
				if(!empty($data->statutoryrate)){
						if($data->paiddays == $day_count){	
						$tot_val =round(($data->statutoryrate * $workdays) + $data->over_time + $data->arrear + $data->holiday_pay);
						$gross = max($tot_val, round(($data->earnedgross - ($data->spl_allowance + $data->misc))));
						} else {
						 $dojmonth = date("m-Y", strtotime($EMP->doj));
					     $salprocessing = date("m-Y", strtotime($data->month));
						/*$daycount = $data->paiddays;
								$workdays = 0 ;
									for ($i = 1; $i <= $daycount; $i++) {
										  $date = $y . '/' . $m . '/' . $i; //format date
										  $get_name = date('l', strtotime($date)); //get week day
										  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
										  //if not a weekend add day to array
										  if ($day_name != 'Sun') {
											 $workdays += 1;
										  }
									   } */
							if ($dojmonth == $salprocessing) {
								$doj = date("d", strtotime($EMP->doj));
								$your_date = date("t", strtotime($data->month));
								$workingDays = ($your_date - $doj) + 1;
								$work = 0 ;
											for ($i = 1; $i <= $workingDays; $i++) {
												  $date = $y . '/' . $m . '/' . $i; //format date
												  $get_name = date('l', strtotime($date)); //get week day
												  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
												  //if not a weekend add day to array
												  if ($day_name != 'Sun') {
													 $work += 1;
												  }
											   }
									if($data->paiddays == $workingDays){	
										$workdays = $work;
									} else {
										$workdays = $work - ($workingDays - $data->paiddays);
									}
							} else {
							$workdays = $workdays - ($day_count - $data->paiddays);
							}
						
						$tot_val =round(($data->statutoryrate * $workdays) + $data->over_time + $data->arrear + $data->holiday_pay);
						$gross =  max($tot_val, round(($data->earnedgross - ($data->spl_allowance + $data->misc))));						
						
						//$gross = max((($data->statutoryrate * $workdays )+$data->over_time), ($data->earnedgross - ($data->spl_allowance + $data->misc)));
						//$pfgross = $gross - ($data->hra + $data->over_time);
						 // $lopdays = $day_count - $data->paiddays;
						 // $gross = max((($data->statutoryrate * ( $workdays - $lopdays))+$data->over_time), $data->earnedgross);
						}
					} else {
						$gross = round($data->earnedgross -($data->spl_allowance + $data->misc));						
					}	
				
				$epfwages =  round($data->pf_wages);
				$epswages = ($epfwages < 15000 ? $epfwages : 15000);				
				$eps_cont = round($epswages *0.0833);
				$eps_contriputed = ($eps_cont < 1250 ? $eps_cont : 1250);				
				$ncp_days = (($day_count- $data->paiddays) > 0 ? $day_count- $data->paiddays : '0');				
				$round_adv = '0';
				$found = 0;
				$Exlist = StatutoryHr::find()->where(['month'=>Yii::$app->formatter->asDate($month, "yyyy-MM-dd")])->all();
				if($Exlist) {
				foreach ($Exlist as $Exlist) {
				$ExEMP = PfList::find()->where(['list_id'=>$Exlist->id,'uanno'=>$UAN->epfuanno])->one();
				if($ExEMP){
					$found = 1;
					}
				 } 
				}				
			// GROSS WAGES CALCULATION
			//$epfgrosswages = max(($data-> + $model->over_time), ($earned_gross - $model->special_allowance));	
				
			if($found == 0) {
			$dataArray = array(
			   $UAN->epfuanno,
			   $EMP->empname,
			   $EMP->empcode,
			   $gross,
			   $epfwages,
			   $epswages,
			   $epswages,
			   $data->pf,
			   $eps_contriputed,
			   $data->pf - $eps_contriputed,
			   $ncp_days,
			   $round_adv,				  
			   $modelUnit->name,
			   $division->division_name,
			   $EMP->category,
			);			
			$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);
			}
			}
			}
			$row--;		
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:O1");
			$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);			
			$objPHPExcel->getActiveSheet()->freezePane('A2');

			$objPHPExcel->setActiveSheetIndex(0);			
			
			foreach (range('A', 'O') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);			
			}
			
			$objPHPExcel->setActiveSheetIndex(0);

				$callStartTime = microtime(true);

				// Redirect output to a client’s web browser (Excel2007)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="PFList'.$pflistno.'('.$m.'-'.$y.').xlsx"');
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
				
	  
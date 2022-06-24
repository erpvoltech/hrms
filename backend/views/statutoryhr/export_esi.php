<?php
ob_start();

use common\models\EmpDetails;
use common\models\StatutoryHr;
use common\models\EmpSalary;
use common\models\EmpRemunerationDetails;
use common\models\EmpStatutorydetails;
use common\models\Division;
use common\models\Unit;
use common\models\EmpSalaryActual;
set_time_limit(2080);
//error_reporting(0);
		
	/*if (Yii::$app->getRequest()->getQueryParam('unit')) {	  
	   $unitdata = Yii::$app->getRequest()->getQueryParam('unit');
	} else {  	 
	   $unitdata ='';
	} */

		    $m = date("m", strtotime($month));
            $y = date("Y", strtotime($month));
            $day_count = cal_days_in_month(CAL_GREGORIAN, $m, $y); 
			
			
			
			   
			   
			/*$unitda = serialize($unitdata);
		   if($dataunit = unserialize($unitda)){
				$modelUnit = Unit::find()->Where(['IN','id',$dataunit])->orderBy('id')->all();
			} else {		
				$modelUnit = Unit::find()->orderBy('id')->all();  
			}   */
			
			$objPHPExcel = new \PHPExcel();

			$sharedStyle1 = new \PHPExcel_Style();
			$sharedStyle2 = new \PHPExcel_Style();

			$sharedStyle1->applyFromArray(
					array('fill' => array(
							'type' => \PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('argb' => '0095ff')
						),					
			));
			
			 $modelRemu = EmpRemunerationDetails::find()->where(['esi_applicability'=>'Yes'])->all();
			 $objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'Ecode')
					->setCellValue('B1', 'IP Number')
					->setCellValue('C1', 'IP Name')
					->setCellValue('D1', 'PAID DAYS') 
					->setCellValue('E1', 'GROSS WAGES')
					->setCellValue('F1', 'REASON CODE')
					->setCellValue('G1', 'LAST WORKINGDAY')
					->setCellValue('H1', 'STATUTORY RATE')
					->setCellValue('I1', 'PRESENT DAYS')
					->setCellValue('J1', 'ESI AMT')
					->setCellValue('K1', 'UNIT')
					->setCellValue('L1', 'DIVISION');
			$row = 2;		
		
			 foreach ($modelRemu as $data) {
			 $Actual = EmpSalaryActual::find()->where('empid = :empid and gross <= :gross',[':empid'=>$data->empid,':gross'=>21000])->one(); 
			 if($Actual){
			 $flag = 1;
			 $lopdays = 0;
			 $gross = 0;
			 $esiamt =0;
			 $sr=0;
			 $prisentdays =0;
			 $workdays = 0;
			 $daycount =0;
			 for ($i = 1; $i <= $day_count; $i++) {
                  $date = $y . '/' . $m . '/' . $i; //format date
                  $get_name = date('l', strtotime($date)); //get week day
                  $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
                  //if not a weekend add day to array
                  if ($day_name != 'Sun') {
                     $workdays += 1;
                  }
               }
			 
			
				$EMP = EmpDetails::find()->where(['id'=>$data->empid])->one();
				$UAN = EmpStatutorydetails::find()->where(['empid' =>$data->empid])->one(); 
				$sal = EmpSalary::find()->where(['empid'=>$data->empid,'month'=>Yii::$app->formatter->asDate($month, "yyyy-MM-dd")])->andWhere(['or',
					   ['revised'=>0],
					   ['revised'=>NULL]
				   ])->one();
			
				if($EMP->status =='Relieved'){
					$mon = date("m", strtotime($EMP->last_working_date));				
					if($mon >= ($m - 1)){
					$last_working = Yii::$app->formatter->asDate($month, "dd-MM-yyyy");
					$zero_reason = 2;
					$paiddays = 0;
					$earnedgross = 0;
					} else {
					$flag = 0;	
					}	
					} 
				if($sal && $flag ){
				$esiamt =  $sal->esi;
					if ($data->salary_structure == 'Contract'){
						if(!empty($sal->statutoryrate)){
							$gross = max((($sal->statutoryrate * $sal->paiddays)+$sal->over_time), ($sal->earnedgross - ($sal->spl_allowance + $sal->misc + $sal->washing_allowance)));							
							$prisentdays = $sal->paiddays;
							$sr = $sal->statutoryrate;
						} else {
							$gross = $sal->earnedgross - ($sal->spl_allowance + $sal->misc + $sal->washing_allowance);
							$prisentdays = $sal->paiddays;
							$sr ='';
					    }
					} else {					
						if(!empty($sal->statutoryrate)){
							if($sal->paiddays == $day_count){
								$tot_val =($sal->statutoryrate * $workdays) + $sal->over_time + $sal->arrear + $sal->holiday_pay;
						        $gross = max($tot_val, ($sal->earnedgross - ($sal->spl_allowance + $sal->misc + $sal->washing_allowance)));
								$prisentdays = $workdays;
								} else {
								 $dojmonth = date("m-Y", strtotime($EMP->doj));
								 $salprocessing = date("m-Y", strtotime($sal->month));						
								if ($dojmonth == $salprocessing) {
									$doj = date("d", strtotime($EMP->doj));
									$your_date = date("t", strtotime($sal->month));
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
										if($sal->paiddays == $workingDays){	
											$workdays = $work;
										} else {
											$workdays = $work - ($workingDays - $sal->paiddays);
										}
								} else {
								$workdays = $workdays - ($day_count - $sal->paiddays);
								}
							
							$tot_val =($sal->statutoryrate * $workdays) + $sal->over_time + $sal->arrear + $sal->holiday_pay;
							$gross = max($tot_val, ($sal->earnedgross - ($sal->spl_allowance + $sal->misc + $sal->washing_allowance)));	
							}
							
							$sr = $sal->statutoryrate;
						} else {
							$gross = $sal->earnedgross - ($sal->spl_allowance + $sal->misc);
							$prisentdays = $sal->paiddays;
							$sr ='';
						}
					}
					
					$paiddays = $sal->paiddays;					
					$earnedgross = $gross;
					$zero_reason = '';	
					$last_working = '';	
					$division = Division::find()->Where(['id'=>$sal->division_id])->One();
					$modelUnit = Unit::find()->Where(['id'=>$sal->unit_id])->One(); 
					
					$division_name = $division['division_name'];
					$unit_name = $modelUnit['name'];
					} else {
					$esiamt = '0';
					$paiddays = '0';
					$earnedgross = '0';
					$zero_reason = 1;
					$last_working = '';
					$division_name ='';
					$unit_name ='';
					$prisentdays ='';
					$sr ='';
				}
				 
				$dataArray = array(
				   $EMP->empcode,
				   $UAN->esino,
				   $EMP->empname,
				   $paiddays,
				   $earnedgross,
				   $zero_reason,
				   $last_working,
				   $sr,
				   $prisentdays,
				   $esiamt,
				   $unit_name,
				   $division_name,
				);
				$objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A' . $row++);			
			 }					
			}
			$row--;	
			$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:L1");
			$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setWrapText(TRUE);
			$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);			
			$objPHPExcel->getActiveSheet()->freezePane('A2');

			$objPHPExcel->setActiveSheetIndex(0);			
			
			foreach (range('A', 'F') as $columnID) {
			   $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);			
			}
			
			$objPHPExcel->setActiveSheetIndex(0);
				$callStartTime = microtime(true);

				// Redirect output to a client’s web browser (Excel2007)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="ESIList'.'('.$m.'-'.$y.').xlsx"');
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
				
	  
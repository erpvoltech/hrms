<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\TrainingTopics;
use app\models\TrainingFaculty;
use app\models\PorecTraining;
use app\models\Department;
use app\models\RecruitmentBatch;
use app\models\Recruitment;
use common\models\EmpDetails;
?>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>HTML</title>
		<meta name="description" content="">
		<meta name="author" content="INTS-137">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
		<style>
			*, *:after, *::before {   -webkit-box-sizing: border-box;  -moz-box-sizing: border-box;   box-sizing: border-box;padding: 0;    margin: 0;}
			body{font-family: 'Roboto', sans-serif;font-size:12px;color:282828;}
			.clearfix { display: block;}
			.clearfix:after { visibility: hidden;display: block; font-size: 0; content: " "; clear: both; height: 0;}
			.pay_container{max-width: 800px;width:100%;margin: auto;border:1px solid #ddd;}
			.pay_wraper{    padding: 20px;}
			.row_section{width:100%;display: block;}
			.emp_info_col{width:100%;}				
			table { border-spacing: 0; border-collapse: collapse;}
			table {width: 100%;}
			.emp_info table th {font-weight:500; color:#000;text-align: left;}
			.emp_info table th, .emp_info table td { padding:5px;border: 1px solid #000;}
			.emp_info table td { background-color:#fff}
			.table_line td{padding: 5px;    border: 1px solid #ccc;}
			.pay_container h3{margin-bottom: 15px;font-size:20px;}
			.pay_container h4{margin-bottom: 10px;font-size: 18px;}
			.pay_container h5{margin-bottom: 10px;font-size: 16px;}
			.pay_container h3, .pay_container h4, .pay_container h5{text-align:center;font-weight:500;}
			.center{text-align:center;}
			//.emp_deatils {margin: 15px 0;}
			.pay_container strong{font-weight: 500;}
		</style>
	</head>

	<body>
	<?php 
	#echo "<pre>";print_r($model);echo "</pre>"; 
	#exit;
	$wr	=	'';
	/*$topic_id	=	$_POST['TrainingFaculty']['training_topic_id'];
	$batch_id	=	$_POST['TrainingFaculty']['batch_id'];
	$faculty_id	=	$_POST['TrainingFaculty']['faculty_name'];*/
	
	$training_batch_id		=	$model->training_batch_id;
	$training_topic_id		=	$model->training_topic_id;
	$rec_id					=	$model->rec_id;
	$porec_id				=	$model->porec_id;
	$faculty_id				=	$model->faculty_name;
	$print_date				=	$model->print_date;
	#$batch_id				=	$model->porec_id;
	
	$topicModel = TrainingTopics::find()
        ->where(['id' => $training_topic_id])
        ->one();
	
	if($training_topic_id	!= ''){
		$trainingModel = PorecTraining::find()
        ->where(['id' => $porec_id])
        #->where(['training_batch_id' => $training_batch_id,'trainig_topic_id' => $training_topic_id])
        ->all();
	}	
	#echo "training topic id: ".$trainingModel[0]->training_topic_id;
	#exit;
	
		
	$facultyModel = TrainingFaculty::find()
        ->where(['id' => $faculty_id])
        ->one();
		
	/*$batchModel = RecruitmentBatch::find()
        ->where(['id' => $batch_id])
        ->one();*/
	
	
	

	/*if($batch_id != '' && $training_topic_id	== ''){
		$trainingModel = PorecTraining::find()
        ->where(['training_batch_id' => $training_batch_id])
        ->all();
	}	

	if($batch_id == '' && $training_topic_id	!= ''){
		$trainingModel = PorecTraining::find()
        ->where(['trainig_topic_id' => $training_topic_id])
        ->all();
	}*/	
	
	#echo "<pre>";print_r($rec_id);echo "</pre>";
	#exit;
	if($trainingModel[0]->training_type == 'new'){
		for($i=0;$i<count($rec_id); $i++){
			
			$recModel = Recruitment::find()
			->where(['id' => $rec_id[$i]])
			->all();
			
			#echo "<pre>";print_r($recModel);echo "</pre>";
			#exit;
			
		?>
		<div class="pay_wraper" style="font-size: 10px;">
			<div class="pay_container">
					
					<div class="emp_info row_section clearfix">                      
							<table class="table">
							  <thead>                            
								<tr>
										<td>Programme Feed Back – Effectiveness Form <br>
									   (Duration:<?php echo date("dMy",strtotime($trainingModel[0]->training_startdate)) ?> to <?php echo date("dMy",strtotime($trainingModel[0]->training_enddate)) ?>)
										</td>
										<td><img src="images/vt-logo.jpg" style="height: 62px; width:200px;"><br>
																		Format No: VE/ F/ 016, Rev.No.03
										</td>
									</tr>
									
									<tr >
									   <td>Name of the Participant</td>
									   <td><?php echo $recModel[0]->name; ?></td> 
									</tr>
									<tr>
										<td>Title of the Programme</td>
										<td><?php echo $topicModel->topic_name; ?></td>
									</tr>
									<tr>
									  <td>Objective of the Programme</td>
									  <td></td>
									</tr>
									<tr>
									  <td>Faculty</td>
									  <td><?php echo $facultyModel->faculty_name; ?></td>
									</tr>
									<tr>
									  <td>Place</td>
									  <td>Voltech ECO Tower</td>
									</tr>
									<tr>
									  <td>Date</td>
									  <?php #echo date("d/m/y",strtotime($trainingModel[0]->training_enddate)) ?>
									  <td> <?php echo date("d-m-y",strtotime($print_date)) ?></td>
									</tr>
							  </thead>						
							</table>
					  <div>
					   
						<table>
						  <tr><td colspan="4"><p>01. To what extent were the objectives of the programme met?</p></td></tr>
						  <tr>                  
						  <td>  Full Extent &nbsp;&nbsp;<input type="checkbox" name="" value=""> </td>
						  <td> Large Extent	&nbsp;&nbsp;<input type="checkbox" name="" value="" ></td>
						  <td> Some Extent	&nbsp;&nbsp;<input type="checkbox" name="" value="" ></td>
						  <td> Little Extent &nbsp;&nbsp;<input type="checkbox" name="" value="" ></td>
					  </tr>
						<tr ><td colspan="4" "><p>02. Effectiveness of Programme content & Faculty (in %)</p></td></tr>
						</table>
					  </div>			
							
					</div>
					<div class="emp_info emp_deatils row_section clearfix" >
						<table class="table table_line"  >
							<thead >
							<tr >
								<th>Title & Faculty</th>
								<th colspan="4">New knowledge/ Skills acquired</th>
								<th colspan="4">Relevance of knowledge /skills in your job </th>
								<th colspan="4">Level of interest generated by the Faculty </th>							
							</tr>

							</thead>
							<tbody>
								<tr>
									<td> 01. Course Content</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td> 02. Course Material</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td>03. Faculty extent to topic </td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td>04. Improvement</td>
								<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td>05. Relevance</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
							
							   
								
							</tbody>
						</table>
						
						<div style="font-size: 10px;">
					   
						<table class="table table_line">
						  
					<tr>
						  <td colspan="6" >
							<pre style="font-family: 'Roboto', sans-serif;font-size: 12px;">                          E- Excellent, 	       G- Good, 	             A- Average, 	       P-Poor</pre>
							<br>
							<h5 style="text-align:left;">03. Suggestions</h5> 
							<br>
							<br>
						  
                                                        <h5 style="text-align:right;"></h5>

						  </td>
						</tr>
						

						<tfoot >
						<tr >
						  <td colspan="6">
							<h5 style="text-align:left; ">TRAINING EVALUATION</h5>
							<br>
							<br>
							<h5 style="text-align:right; ">Evaluator’s Signature</h5>

						  </td>
						</tr>

					  </tfoot>
						</table>
						</div>
					 
						
					</div>
					
				</div>
			</div>
		</div>
		<?php } 
	}
	
	if($trainingModel[0]->training_type == 'existing'){
		for($i=0;$i<count($rec_id); $i++){
			
			$empModel = EmpDetails::find()
			->where(['id' => $rec_id[$i]])
			->one();
			
			#echo "<pre>";print_r($recModel);echo "</pre>";
			#exit;
			
		?>
		<div class="pay_wraper" style="font-size: 12px;">
			<div class="pay_container">
					
					<div class="emp_info row_section clearfix">                      
							<table class="table">
							  <thead>                            
								<tr>
										<td>Programme Feed Back – Effectiveness Form <br>
									   (Duration:<?php echo date("dMy",strtotime($trainingModel[0]->training_startdate)) ?> to <?php echo date("dMy",strtotime($trainingModel[0]->training_enddate)) ?>)
										</td>
										<td><img src="images/vt-logo.jpg" style="height: 62px; width:200px;"><br>
																		Format No: VE/ F/ 016, Rev.No.03
										</td>
									</tr>
									
									<tr >
									   <td>Name of the Participant</td>
									   <td><?php echo $empModel->empname; ?></td> 
									</tr>
									<tr>
										<td>Title of the Programme</td>
										<td><?php echo $topicModel->topic_name; ?></td>
									</tr>
									<tr>
									  <td>Objective of the Programme</td>
									  <td></td>
									</tr>
									<tr>
									  <td>Faculty</td>
									  <td><?php echo $facultyModel->faculty_name; ?></td>
									</tr>
									<tr>
									  <td>Place</td>
									  <td>Voltech ECO Tower</td>
									</tr>
									<tr>
									  <td>Date</td>
									  <?php #echo date("d/m/y",strtotime($trainingModel[0]->training_enddate)) ?>
									  <td> <?php echo date("d-m-y",strtotime($print_date)) ?></td>
									</tr>
							  </thead>						
							</table>
					  <div>
					   
						<table>
						  <tr><td colspan="4"><p>01. To what extent were the objectives of the programme met?</p></td></tr>
						  <tr>                  
						  <td>  Full Extent &nbsp;&nbsp;<input type="checkbox" name="" value=""> </td>
						  <td> Large Extent	&nbsp;&nbsp;<input type="checkbox" name="" value="" ></td>
						  <td> Some Extent	&nbsp;&nbsp;<input type="checkbox" name="" value="" ></td>
						  <td> Little Extent &nbsp;&nbsp;<input type="checkbox" name="" value="" ></td>
					  </tr>
						<tr ><td colspan="4" "><p>02. Effectiveness of Programme content & Faculty (in %)</p></td></tr>
						</table>
					  </div>			
							
					</div>
					<div class="emp_info emp_deatils row_section clearfix" >
						<table class="table table_line" >
							<thead >
							<tr >
								<th>Title & Faculty</th>
								<th colspan="4">New knowledge/ Skills acquired</th>
								<th colspan="4">Relevance of knowledge /skills in your job </th>
								<th colspan="4">Level of interest generated by the Faculty </th>							
							</tr>

							</thead>
							<tbody>
								<tr>
									<td> 01. Course Content</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td> 02. Course Material</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td>03. Faculty extent to topic </td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td>04. Improvement</td>
								<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
								<tr>
									<td>05. Relevance</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									<td>E</td>
										<td>G</td>
											<td>A</td>
												<td>P</td>
									
								</tr>
							
							   
								
							</tbody>
						</table>
						
						<div style="font-size: 12px;">
					   
						<table class="table table_line">
						  
					<tr>
						  <td colspan="6" >
							<pre style="font-family: 'Roboto', sans-serif;font-size: 12px;">                          E- Excellent, 	       G- Good, 	             A- Average, 	       P-Poor</pre>
							<br>
							<h5 style="text-align:left">03. Suggestions</h5> 
							<br>
							<br>
						  
							<h5 style="text-align:right;">HR DEPARTMENT</h5>

						  </td>
						</tr>
						

						<tfoot >
						<tr >
						  <td colspan="6">
							<h5 style="text-align:left">TRAINING EVALUATION</h5>
							<br>
							<br>
							<h5 style="text-align:right">Evaluator’s Signature</h5>

						  </td>
						</tr>

					  </tfoot>
						</table>
						</div>
					 
						
					</div>
					
				</div>
			</div>
		</div>
		<?php } 
	}
	
	?>
	</body>
</html>

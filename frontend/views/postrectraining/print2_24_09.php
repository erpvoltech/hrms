<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\TrainingTopics;
use app\models\TrainingFaculty;
use app\models\PorecTraining;
use app\models\Department;
use app\models\RecruitmentBatch;
use app\models\Recruitment;
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
			.clearfix {    display: block;}
			.clearfix:after { visibility: hidden;display: block; font-size: 0; content: " "; clear: both; height: 0;}
			.pay_container{max-width: 800px;width:100%;margin: auto;border:1px solid #ddd;}
			.pay_wraper{    padding: 20px;}
			.row_section{width:100%;display: block;}
			.emp_info_col{width:100%;}
						
				
			table {    border-spacing: 0;    border-collapse: collapse;}
			table {width: 100%;}
			.emp_info {padding: 25px;}
			.emp_info table th {font-weight:500;background-color:#ddd; color:#000;text-align: left;}
			.emp_info table th, .emp_info table td { padding:5px;}
			.emp_info table td { background-color:#fff}
			.table_line td{padding: 5px;    border: 1px solid #ccc;}
			.pay_container h3{margin-bottom: 15px;font-size:20px;}
			.pay_container h4{margin-bottom: 10px;font-size: 18px;}
			.pay_container h5{margin-bottom: 10px;font-size: 16px;}
			.pay_container h3, .pay_container h4, .pay_container h5{text-align:center;font-weight:500;}
			.center{text-align:center;}
		//	.emp_deatils {margin: 15px 0;}
			.pay_container strong{font-weight: 500;}			
		</style>
	</head>

	<body>
	<?php 
	#echo "<pre>";print_r($model);echo "</pre>"; 
	#exit;
	$wr	=	'';
	$training_batch_id		=	$model->training_batch_id;
	$training_topic_id		=	$model->training_topic_id;
	$rec_id					=	$model->rec_id;
	$porec_id				=	$model->porec_id;
	$faculty_id				=	$model->faculty_name;
	$topicModel = TrainingTopics::find()
        ->where(['id' => $training_topic_id])
        ->one();
		
	$facultyModel = TrainingFaculty::find()
        ->where(['id' => $faculty_id])
        ->one();
		
	/*$batchModel = RecruitmentBatch::find()
        ->where(['id' => $batch_id])
        ->one();*/	
	
	/*if($batch_id	!= '' && $topic_id	!= ''){
		$trainingModel = PorecTraining::find()
        ->where(['batch_id' => $batch_id,'trainig_topic_id' => $topic_id])
        ->all();
	}	

	if($batch_id != '' && $topic_id	== ''){
		$trainingModel = PorecTraining::find()
        ->where(['batch_id' => $batch_id])
        ->all();
	}*/	

	if($training_batch_id != ''){
		$trainingModel = PorecTraining::find()
        ->where(['training_batch_id' => $training_batch_id])
        ->all();
	}
	
	#echo "<pre>";print_r($trainingModel);echo "</pre>";	
	?>
	<div class="pay_wraper">
			<div class="pay_container">				
				<div class="emp_info row_section clearfix">                      
						<table class="" border="0" align="center" style="font-weight: bold;">
                          <thead>                            
								<tr>
									<td>Training Feedback Form <br>
									   (Duration:<?php echo date("dMy",strtotime($trainingModel[0]->training_startdate)) ?> to <?php echo date("dMy",strtotime($trainingModel[0]->training_enddate)) ?>)
									</td>
									<td align="right"><img src="images/vt-logo.jpg" style="height: 62px; width:200px;"><br>
																		Format No: VE/ F/ 016, Rev.No.01
									</td> 
								</tr>
                                <tr><td colspan="2"><hr></hr></td></tr>
                                <tr>
                                    <td></td>
                                    <td align="right">Date: <?php echo date("d-m-Y"); ?></td>
                                </tr>
								<tr>
									<td>Topic: <?php echo $topicModel['topic_name']; ?></td>
								</tr>
                                <tr>
									<td>Faculty: <?php echo $facultyModel['faculty_name']; ?></td>                                   	
                                    <!--<td>Batch: <?php #echo $batchModel['batch_name']; ?></td>-->
                                </tr>
								<tr><td></td></tr>
                          </thead>						
						</table>
				</div>
				<div class="emp_info emp_deatils row_section clearfix">
					<table class="table table_line" align="center" style="border: 1px solid #000;">
						<thead>
						<tr >
							<th>S.No</th>
							<th>Name of the person</th>
							<th>Department</th>
							<th>Feedback</th>							
						</tr>
						</thead>
						<tbody>
						
						<?php 
						$i=1;
						$count_trainingModel	=	count($rec_id);						
						foreach($rec_id as $res){
							$recModel = Recruitment::find()
							->where(['id' => $res])
							->one();
							/*$departmentModel = Department::find()
							->where(['id' => $res['department_id']])
							->one();*/
						?>						
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $recModel->name; ?></td>
								<td><?php #echo $departmentModel['name']; ?></td>
								<?php if($i == '1'){ ?>
									<td rowspan="<?php echo $count_trainingModel; ?>"></td>				
								<?php } ?>
							</tr>
						<?php 
						$i++;
						} ?>							
                            							
						</tbody>
						<tfoot>
												
						</tfoot>
					</table>
				</div>		
				
				<div class="emp_info row_section clearfix">                      
						<table class="table table_line" align="center" style="font-weight: bold;">                                                 
							<tr>								
								<td colspan="3" style="text-align: center; width: 250px;"><strong>Prepared By</strong></td>
								<td style="text-align: center;"><strong>Approved By</strong></td>									
							</tr>
                            <tr>
								<td colspan="3"></br></br></br></td>
								<td></br></br></br></td>
                            </tr>		                         					
						</table>
				</div>
			</div>
	</div>
	</body>
</html>
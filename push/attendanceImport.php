<?php
$dbuser      =   'root';
$dbpass      =   'Te@mEr9!';
$dbname =	 'hrms'; 
$dbcon = new mysqli('localhost',$dbuser,$dbpass,$dbname);

header('content-type:application/json');
$data = file_get_contents('php://input');
$json1 = json_decode($data,true); extract($json1);
$flag =1;
foreach($result as $res){ 
	$chekcOldId = $dbcon->query("SELECT `id` FROM `engineer_attendance` WHERE 1 AND `old_id`='".$res['id']."'");
	$checkResult = $chekcOldId->fetch_array(); 
	if(!$checkResult['id']){ 	
		//$dbcon->query("INSERT INTO `engineer_attendance` (`emp_id`,`project_id`,`date`, `attendance`,`status`,`uid`,`created_at`,`ichead`,`updated`,`hr`,`hrUpdated`,`image`,`old_id`) VALUES ('".$res['empID']."','".$res['projectID']."','".$res['date']."','".$res['attendance']."','".$res['status']."','".$res['uid']."','".$res['created_at']."','".$res['ichead']."','".$res['updated']."','".$res['hr']."', '".$res['hrUpdated']."','".$res['image']."','".$res['id']."')");
		
		$sql = "INSERT INTO engineer_attendance (`emp_id`, `project_id`, `date`, `attendance`, `status`, `uid`, `created_at`, `ichead`, `updated`, `hr`, `hrUpdated`, `image`, `old_id`) VALUES ('".$res['empID']."','".$res['project_id']."','".$res['date']."','".$res['attendance']."','".$res['status']."','".$res['uid']."','".$res['created_at']."','".$res['ichead']."','".$res['updated']."','".$res['hr']."', '".$res['hrUpdated']."','".$res['image']."','".$res['id']."')";

		if($dbcon->query($sql) === TRUE) {
			$flag =1;
		} else {
			$flag =0;
		  echo $dbcon->error.'<br>';
		}
	}
}
if($flag == 1){
	echo 'Successfully updated';
} 

//print_r($result);
?>
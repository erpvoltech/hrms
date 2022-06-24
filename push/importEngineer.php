<?php
ini_set('max_execution_time', 2400);
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

/* mysql Connection String Change Here Start*/
$mysqli = new mysqli("localhost",'root','Te@mEr9!','hrms');
/* End */
$sql = "SELECT a.id,a.empcode, a.empname, a.division_id, a.unit_id, a.department_id, a.mobileno, a.status, b.mobile_no FROM emp_details AS a JOIN emp_personaldetails AS b ON a.id=b.empid Where a.status='Active'";
$empDetails = $mysqli->query($sql);
while($empDetail = $empDetails->fetch_array()){
   $data[] = $empDetail;
}
// 	mobile_no
$headers = array('Content-Type: application/json');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://voltech.xyz/api/empDetails');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('result'=>$data)));
$results = curl_exec($ch);  print_r($results);
curl_close($ch);

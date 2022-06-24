<?php
/* mysql Connection String Change Here Start*/
$mysqli = new mysqli("localhost",'root','Te@mEr9!','hrms');
/* End */
$sql = "SELECT * FROM `unit`";
$projectDetails = $mysqli->query($sql);
while($projectDetail = $projectDetails->fetch_array()){
   $data[] = $projectDetail;
}

$headers = array('Content-Type: application/json');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://voltech.xyz/api/unit');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('result'=>$data)));
$result = curl_exec($ch); 
print_r($result);
curl_close($ch); 

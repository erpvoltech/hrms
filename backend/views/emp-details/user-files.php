<?php

$ftp = new \yii2mod\ftp\FtpClient();
$host = '192.168.1.99';
$ftp->connect($host);
$ftp->login('hr_mis', 'Vepl@1234');

/*

$conn = ftp_connect("file.voltechgroup.com");
    ftp_login($conn, "hr_mis", "Vepl@1234");
    ftp_pasv($conn, true);
    ftp_chdir($conn, "MIS/");
/*
// connect and login to FTP server
$ftp_server = "192.168.1.99";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, 'hr_mis', 'Vepl@1234');
//$login = ftp_login($ftp_conn, 'erp', 'Vg@1234');
// get file list of current directory
$items = ftp_nlist($ftp_conn, 'MIS/'.$_GET['id']);
 */
//var_dump($ftp->scanDir());
//echo $total = $ftp->count();
//echo $total = $ftp->count('IC D1/SJ');
$items = $ftp->scanDir('MIS/'.$_GET['id']); 
$i =1;

if(!empty($items)) {
foreach($items as $file){
	echo $i.' ) ';
	echo "<a href='ftp://hr_mis:Vepl@1234@file.voltechgroup.com/MIS/".$_GET['id']."/".$file['name']."' target='_blank'>".$file['name']."</a><br>";
	$i++;
}
 header("Content-Disposition: inline; filename=\"".$name."\";");
} else {

echo 'No Attachment';
} 
/*
//$items = $ftp->scanDir('/vepl/');
if(!empty($items)) {
	foreach($items as $file){
	echo $file['name'];
	}
} */
?>

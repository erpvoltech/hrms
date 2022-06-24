<?php
$ftp = new \yii2mod\ftp\FtpClient();
//$host = 'file.voltechgroup.com';
$host = '192.168.1.99';
$ftp->connect($host);
$ftp->login('hr_mis', 'Vepl@1234');

//var_dump($ftp->scanDir());
//echo $total = $ftp->count();
//echo $total = $ftp->count('IC D1/SJ');
$items = $ftp->scanDir('Insurance/'.$_GET['id']);
$i =1;

if(!empty($items)) {
foreach($items as $file){
	echo $i.' ) ';
	echo "<a href='ftp://hr_mis:Vepl@1234@file.voltechgroup.com/Insurance/".$_GET['id']."/".$file['name']."' target='_blank'>".$file['name']."</a><br>";
	$i++;
}
 //header("Content-Disposition: inline; filename=\"".$name."\";");
} else {

echo 'No Attachment';
}
?>

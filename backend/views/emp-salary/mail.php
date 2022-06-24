<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
//require 'vendor/autoload.php';

$mail = new PHPMailer;

//Enable SMTP debugging. 
//$mail->SMTPDebug = 2;                               
//Set PHPMailer to use SMTP.
$mail->isSMTP();            
//Set SMTP host name                          
$mail->Host = "mail.voltechgroup.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;                          
//Provide username and password     
$mail->Username = "erp.voltech@voltechgroup.com";                 
$mail->Password = "vepl1234";                           
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "ssl";                           
//Set TCP port to connect to 
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->Port = 465;                                   

$mail->From = "erp.voltech@voltechgroup.com";
$mail->FromName = "voltechgroup";

$mail->addAddress("v.jeyaprakash@voltechgroup.in", "Balasrini");

$mail->isHTML(true);

$mail->Subject = "Subject Text";
$mail->Body = "<i>Test</i>";
$mail->AltBody = "test mail";

if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Message has been sent successfully";
}
?>

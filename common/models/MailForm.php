<?php

namespace common\models;

use Yii;
use yii\base\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/**
 * ContactForm is the model behind the contact form.
 */
class MailForm extends Model
{
   
    public $email;
    public $subject;
    public $body;
	public $from;
	public $fromName;
	public $attachment;
	public $cc;
	public $bcc;
	public $password;
  


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],  
			[['from', 'fromName','password'],'safe'],
            
        ];
    }
   
    public function sendEmail($email)
    {
		$mail = new PHPMailer;
		$mail->isSMTP();        
		$mail->Host = "mail.voltechgroup.com";
		$mail->SMTPAuth = true;     
		//$mail->Username = "erp.voltech@voltechgroup.com";                 
		//$mail->Password = "VEPL@#$4321"; 
		$mail->Username = $this->from;                 
		$mail->Password = $this->password;
		$mail->SMTPSecure = "ssl";
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Port = 465; 
		//$mail->SMTPDebug = 3;
		$mail->From = $this->from;
		$mail->FromName = $this->fromName;
		$mail->addAddress($email);
		$mail->isHTML(true);
		$mail->Subject = $this->subject;
		$mail->Body = $this->body;
		if($this->attachment){
			$mail->addAttachment($this->attachment);
		}
		
		if($this->cc){
			$mail->addCC($this->cc);
		}
		
		if($this->bcc){
			$mail->addBCC($this->bcc);
		}
		
		if($mail->send()){
			return 1;
		} else {
		echo $mail->ErrorInfo;
		exit;
		}    
    }
	
	 public function MailWithMultCC($email,$cc,$bcc)
    {
		$mail = new PHPMailer;
		$mail->isSMTP();        
		$mail->Host = "mail.voltechgroup.com";
		$mail->SMTPAuth = true;     
		//$mail->Username = "erp.voltech@voltechgroup.com";                 
		//$mail->Password = "VEPL@#$4321"; 
		
		$mail->Username = $this->from;                 
		$mail->Password = $this->password;
		
		$mail->SMTPSecure = "ssl";
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->Port = 465; 
		//$mail->SMTPDebug = 3;
		$mail->From = $this->from;
		$mail->FromName = $this->fromName;
		$mail->addAddress($email);
		$mail->isHTML(true);
		$mail->Subject = $this->subject;
		$mail->Body = $this->body;
		if($this->attachment){
			$mail->addAttachment($this->attachment);
		}
		
		foreach($cc as $ccemail)
		{
		   $mail->AddCC($ccemail);
		}
			
		foreach($bcc as $bccemail)
		{
		   $mail->addBCC($bccemail);
		}
		
		if($mail->send()){
			return 1;
		}    
    }
}

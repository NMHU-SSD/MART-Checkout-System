<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\POP3;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require ( dirname(__dir__, 2).'/vendor/autoload.php');

$this->load->config('emailer');
$this->load->config('late_message');

date_default_timezone_set('Etc/UTC');

class MyMailer extends PHPMailer{

	function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
	}

	public function send_mail($to, $name)
	{
		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = $this->config->item('SMTPDebug');
		//Set the hostname of the mail server
		$mail->Host = $this->config->item('Host');
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = $this->config->item('Port');
		$mail->SMTPSecure = $this->config->item('SMTPSecure');
		//Whether to use SMTP authentication
		$mail->SMTPAuth = $this->config->item('SMTPAuth');
		//Username to use for SMTP authentication
		$mail->Username = $this->config->item('Username');
		//Password to use for SMTP authentication
		$mail->Password = $this->config->item('Password');
		//Set who the message is to be sent from
		$mail->setFrom($this->config->item('setFrom'), $this->config->item('sendName'));
		//Set an alternative reply-to address
		//$mail->addReplyTo($this->config->item('addReplyTo'), $this->config->item('replytName'));
		//Set who the message is to be sent to
		$mail->addAddress($to, $name);
		//Set the subject line
		$mail->Subject = $this->config->item('message_subject');
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($this->config->item('late_equiptment_message'));
		//Replace the plain text body with one created manually
		$mail->AltBody = $this->config->item('normal_message');
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');
		//send the message, check for errors
		if (!$mail->send()) {
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
		    echo 'Message sent!';
		}
	}
}

?>
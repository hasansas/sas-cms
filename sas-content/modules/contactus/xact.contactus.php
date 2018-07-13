<?php if (!defined('basePath')) exit('No direct script access allowed');

//require systemPath.'plugins/recaptcha/recaptchakey.php';

$error = true;
$alert = '';
//$resp  = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);

if(empty($_POST['add_contact_name'])){
	$alert = 'Name required';
}
elseif(empty($_POST['add_contact_email'])){
	$alert = 'Email required';
}
elseif(empty($_POST['add_contact_message'])){
	$alert = 'Message required';
}
/*
elseif(empty($_POST["recaptcha_response_field"])){

	$alert = 'Kode yang anda masukkan salah.';
}
elseif(!$resp->is_valid) {

	$alert = 'Kode yang anda masukkan salah.';
}
*/
else{

	foreach($_POST as $fName=>$fVal){

		if(preg_match('/add_/i',$fName)){

			@$setField .= str_replace('add_','',$fName).'=\''.htmlentities(strip_tags(stripslashes($fVal)), ENT_QUOTES, 'UTF-8').'\',';
		}
	}
	$setField = $setField." contact_date='".date("Y-m-d H:i:s")."'";
	$query	  = 'insert into '.$this->table_prefix.'contact set '.$setField;

	if(!$this->db->execute($query)){

		$alert = 'Pesan anda gagal terkirim.';
	}
	else{

		#send email
		$email = $this->getEmailTemplate('contact');
		extract($email);

		$sendmail['to'] 	 	= @$_POST['add_contact_email'];
		$sendmail['subject'] 	= @$email_subject;
		$sendmail['cc'] 		= @$email_cc;
		$sendmail['bcc'] 		= @$email_bcc;
		$sendmail['from'] 		= @$email_from;
		$sendmail['from_name'] 	= @$email_from_name;
		$sendmail['content'] 	= @$this->replaceEmailContent($email_content,$_POST);

		$this->sendMail($sendmail);

		/* send email to admin */
		$emailAdmin = $this->getEmailTemplate('contact_admin');
		extract($emailAdmin);

		$sendmailAdmin['to']	= $email_admin;
		$sendmailAdmin['subject'] 	= @$email_subject;
		$sendmailAdmin['cc'] 		= @$email_cc;
		$sendmailAdmin['bcc'] 		= @$email_bcc;
		$sendmailAdmin['from'] 		= @$email_from;
		$sendmailAdmin['from_name'] 	= @$email_from_name;
		$sendmailAdmin['content'] 	= @$this->replaceEmailContent(html_entity_decode($email_content),$_POST);
		$this->sendMail($sendmailAdmin);

		$alert = 'Pesan anda telah berhasil dikirimkan.';
		$error = false;
	}
}

$response = array(

	'error' => $error,
	'alert' => $alert
);

echo json_encode($response);
?>

<?php if (!defined('basePath')) exit('No direct script access allowed');

$error = true;
$alert = '';
$response = $_POST["g-recaptcha-response"];
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
	'secret' => '6Lf6BksUAAAAAGZu7f_43sPXKXihI2SaarJ0tI',
	'response' => $_POST["g-recaptcha-response"]
);
$query = http_build_query($data);
$options = array(
	'http' => array (
		'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
					"Content-Length: ".strlen($query)."\r\n".
					"User-Agent:MyAgent/1.0\r\n",
		'method' => 'POST',
		'content' => $query
	)
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
if(empty($_POST['add_contact_name'])){

	$alert = 'Please sign your name.';
}
elseif(empty($_POST['add_contact_email'])){

	$alert = 'Please insert your email address.';
}
elseif(filter_var($_POST['add_contact_email'], FILTER_VALIDATE_EMAIL)=== false){

	$alert = 'Invalid email address.';
}
elseif(empty($_POST['add_contact_message'])){

	$alert = 'Please sign your message.';
}
elseif(empty($_POST['g-recaptcha-response'])){

	$alert = 'Please verify that you\'re not a robot';
}
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
	    $nourut=$this->db->insert_id();
		#send email
		$email = $this->getEmailTemplate('contact');
		extract($email);

		$sendmail['to'] 	 	= @$_POST['add_contact_email'];
		$sendmail['subject'] 	= @$email_subject;
		$sendmail['cc'] 		= @$email_cc;
		$sendmail['bcc'] 		= @$email_bcc;
		$sendmail['from'] 		= @$email_from;
		$sendmail['from_name'] 	= @$email_from_name;
		$sendmail['content'] 	= @$this->replaceEmailContent(html_entity_decode($email_content),$_POST);

		$this->sendMail($sendmail);

		$alert = 'Thank you for contacting us.';
		$error = false;
	}
}

$response = array(

	'error' => $error,
	'alert' => $alert
);

echo json_encode($response);
?>

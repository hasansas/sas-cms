<?php if (!defined('basePath')) exit('No direct script access allowed');

require systemPath.'plugins/recaptcha/recaptchakey.php';
require modulePath.$this->thisModule().'/contact.setting.php';

$errorLang = array(

	'error' 	 => '<p class="error"><b>GAGAL : </b>Pesan anda gagal terkirim.</p>',
	'error_en' 	 => '<p class="error"><b>ERROR : </b>Failed to sennding your message.</p>',
	'success' 	 => '<p class="success"><b>SUKSES : </b>Pesan anda telah berhasil dikirimkan.</p>',
	'success_en' => '<p class="success"><b>SUCCESS : </b>Your message has been successfully sent.</p>'
);

$msg 	     = '';
$settings    = '';
$setField    = '';
$errorInsert = '';
$cParams     = $this->getParams('contact');

if(isset($_POST['save'])){

	$resp  = null;
	$error = null;

	foreach($arrSetting as $xval=>$label){

		if(in_array($xval,$cParams['setting'])){

			if(empty($_POST['add_'.$xval])){

				$error['add_'.$xval] = 'This field is required.';
				$error['code'][]		 = 1;
			}
			else{

				$error['add_'.$xval] = '';
				$error['code'][]	 = 0;
			}
		}
	}

	if(empty($_POST["recaptcha_response_field"])){

		$error['rechaptha'] = 'Please Enter the Code Shown';
		$error['code'][]	= 1;
	}
	else{

		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);

		if(!$resp->is_valid) {

			$error['rechaptha'] = 'Incorrect. Try again..';
			$error['code'][]	= 1;
		}
		else{

			$error['rechaptha'] = '';
			$error['code'][]	= 0;
		}
	}

	if(!in_array(1,$error['code'])){

		foreach($_POST as $fName=>$fVal){

			if(preg_match('/add_/i',$fName)){

				$setField .= str_replace('add_','',$fName).'=\''.htmlentities(strip_tags(stripslashes($fVal)), ENT_QUOTES, 'UTF-8').'\',';
			}
		}
		$setField = $setField." contact_date='".date("Y-m-d H:i:s")."'";
		$query	  = 'insert into '.$this->table_prefix.'contact set '.$setField;

		if(!$this->db->execute($query)){

			$errorInsert = $errorLang['error_'.$this->active_lang()];
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

			$errorInsert = @$errorLang['success_'.$this->active_lang()];
			$_POST 		 = array();
		}
	}
}

foreach($arrSetting as $val=>$label){

	if(in_array($val,$cParams['setting'])){

		$errorMsg  = !empty($error['add_'.$val])?'<em>'.$error['add_'.$val].'</em>':'';
		$addClass  = $val=='contact_email'?'required email':'required';
		$type  	   = $val=='contact_email'?'email':'text';
		$settings .= '

			<div class="col-sm-6">
				<input type="'.$type.'" name="add_'.$val.'" value="'.@$_POST['add_'.$val].'" class="form-control form-control-lg '.$addClass.'" placeholder="'.$label.'"/>
				'.$errorMsg.'
			</div>
		';
	}
}

if(isFileExist($this->themePath(),'contactus.php')){
	include $this->themePath().'contactus.php';
}
else{

	?>
	<div class="container">
		<div class="big-title text-center">
			<h2 class="heading text-center">Contact Map</h2>
			<div class="separator"></div>
		</div>
		<div class="section-contact">
			<p class="contact-info">
				<?php echo nl2br(base64_decode($cParams['content'])) ?>
			</p>
		</div>
	</div>

	<div class="section-map">
		<div id="map-canvass"></div>
	</div>

	<div class="container">
		<div class="contact-form">
			<div class="big-title text-center">
				<h2 class="heading text-center"><?php echo $this->lang('contact_form_title')?></h2>
				<div class="separator"></div>
			</div>
			<form method="post" action="" id="contactForm" class="form-horizontal">
				<div class="msg-alert"><?php echo $errorInsert;?></div>
				<div class="row">
					<?php echo $settings;?>
					<div class="col-sm-12">
						<textarea name="add_contact_message" cols="70" rows="6" class="form-control input-lg required" placeholder="Message"><?=@$_POST['add_contact_message'];?></textarea>
					</div>
				</div>
				<div class="text-right">
					<input type="hidden" value="contact" name="add_contact_type" />
					<span class="contact-progress" style="display:none">
						<img src="<?=baseURL?>-admin/themes/ace/assets/img/progress.gif">
					</span>
					<button type="submit" name="save" class="btn btn-default btn-lg">Submit</button>
				</div>
			</form>
		</div>
	</div>
	<?php
}
?>

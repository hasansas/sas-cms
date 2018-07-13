<?php if (!defined('basePath')) exit('No direct script access allowed');

$cParams = $this->getParams('contact');

foreach($arrSetting as $val=>$label){

	if(in_array($val,$cParams)){

		$arrInput[] = $this->form->input->text($label, 'add_'.$val,80);
	}
}

$arrInput[] = $this->form->input->html('<div class="box-body hide-hr">');
$arrInput[] = $this->form->input->textarea('Reply Message', 'add_contact_reply_msg',62,5);
$arrInput[] = $this->form->input->html('</div>');

$sqltable 	= array(

	'table'      => $this->table_prefix.'contact',
	'contact_id' => intval($this->uri(3))
);


//$this->form->onUpdate('sendMessage($post,$tableName,$tableID,$tableKey)');

if(isset($_POST['add_contact_reply_msg']) && !empty($_POST['add_contact_reply_msg'])){

	$post['name'] 		= $contact['contact_name'];
	$post['email'] 		= $contact['contact_email'];
	$post['message'] 	= $contact['contact_message'];
	$post['reply_msg'] 	= $_POST['add_contact_reply_msg'];

	$email = $this->getEmailTemplate('re-contact');
	extract($email);
	$sendmail['to'] 	 	= @$post['email'];
	$sendmail['subject'] 	= @$email_subject;
	$sendmail['cc'] 		= @$email_cc;
	$sendmail['bcc'] 		= @$email_bcc;
	$sendmail['from'] 		= @$email_from;
	$sendmail['from_name'] 	= @$email_from_name;
	$sendmail['content'] 	= @$this->replaceEmailContent(html_entity_decode($email_content),$post);

	$this->sendMail($sendmail);

	$this->db->execute("update ".$this->table_prefix."contact set contact_reply='1' where contact_id='".intval($this->uri(3))."'");

	$redirect = base64_decode(get_string_after(requestURI,'='));

	$this->redirect($redirect);
}

function sendMessage($post,$tableName,$tableID,$tableKey){

	global $system;

	$system->db->execute("update ".$tableName." set contact_reply='1' where ".$tableID."='".$tableKey."'");

	$redirect = base64_decode(get_string_after(requestURI,'='));

	$system->redirect($redirect);
	exit();
}
?>

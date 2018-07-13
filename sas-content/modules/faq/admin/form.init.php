<?php if (!defined('basePath')) exit('No direct script access allowed');
$linkID   = intval($this->uri(3));
$redirect = base64_decode(substr($this->uri(4),3));

// Table Name
$sqltable 	= array(

	'table'	    => $this->table_prefix.'faq',
	'faq_id' => $linkID
);

// Define form field
$params	= array(

	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->text('Question', 'add_question'),
	$this->form->input->textarea('Answer', 'add_answer',60, 30, $editor=true, $multilang=true),
	$this->form->input->html('<div class=" hidden-hr">'),
	$this->form->input->switchcheck('Publish', 'add_publish', $skin=5,$checked=true),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->beforeInsert('cek()');
$this->form->beforeUpdate('cek()');

function cek(){

	global $system;

	$error = false;
	$alert = '';

	@$sc = '

		elseif(empty($_POST[\'add_question\'])){
			$error = true;
			$alert = "Question required.";
		}
		elseif(empty($_POST[\'add_answer\'])){
			$error = true;
			$alert = "Answer required.";
		}
	';

	$sc = substr(trim($sc),4);

	eval($sc);

	$response = array(

		'error' => $error,
		'alert' => $alert
	);

	return $response;
}
?>

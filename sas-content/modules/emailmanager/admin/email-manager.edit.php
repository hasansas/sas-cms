<?php if (!defined('basePath')) exit('No direct script access allowed');

$sqltable 	= array(

	'table'    => $this->table_prefix.'email_template',
	'email_id' => intval($this->uri(3))
);

$arrInput = array(

	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->plaintext('Template Name', 'add_email_name',318),
	$this->form->input->text('Subject', 'add_email_subject',60),
	$this->form->input->text('CC', 'add_email_cc',60),
	$this->form->input->text('BCC', 'add_email_bcc',60),
	$this->form->input->textarea('Content', 'add_email_content',60,30,$editor=true),
	$this->form->input->text('From', 'add_email_from',40),
	$this->form->input->text('From Name', 'add_email_from_name',40),
	$this->form->input->textarea('Description', 'add_email_description',80,3),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->getForm('edit',$sqltable,$arrInput,$formName='replyContact',$submitValue='Update Template',$finishButton=true);
?>

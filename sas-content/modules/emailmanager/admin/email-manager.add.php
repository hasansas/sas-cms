<?if (!defined('basePath')) exit('No direct script access allowed');

$sqltable 	= array(

	'table'    => $this->table_prefix.'email_template'
);

$arrInput = array(

	$this->form->input->html('<div class="widget-content">'),
	$this->form->input->text('Template Name', 'add_email_name',318),
	$this->form->input->text('Subject', 'add_email_subject',60),
	$this->form->input->text('CC', 'add_email_cc',60),
	$this->form->input->text('BCC', 'add_email_bcc',60),
	$this->form->input->textarea('Content', 'add_email_content',60,30,$editor=true),
	$this->form->input->text('From', 'add_email_from',40),
	$this->form->input->text('From Name', 'add_email_from_name',40),
	$this->form->input->textarea('Description', 'add_email_description',80,3),
	$this->form->input->html('</div>')
);
?>
<div class="widget-box">
	
	<div class="widget-header header-color-blue">
		<h5>Add Email Template</h5>
	</div>

	
		<div class="widget-body">
			<div class="widget-main">
           <? $this->form->getForm('add',$sqltable,$arrInput,$formName='replyContact',$submitValue='Add Template',$finishButton=true);?>
            </div>
       </div>
</div>

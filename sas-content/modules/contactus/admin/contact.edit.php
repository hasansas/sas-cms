<?php if (!defined('basePath')) exit('No direct script access allowed');
$contact = $this->db->getRow("select * from ".$this->table_prefix."contact where contact_id='".intval($this->uri(3))."'");
require 'form.init.php';
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<h4 class="form-inline">Message #<?php echo $contact['contact_id'] ?></h4>
			<span class="widget-toolbar no-border">
	            <em><i class="icon-calendar"></i> <?php echo date_indo($contact['contact_date'],$setDay=false,$setTime=false) ?></em>
	        </span>
		</div>
	</div>
	<div class="box-body">
		<div class="form-info">
			<label><strong>From</strong></label>
			<pre><?php echo $contact['contact_name'] ?></pre>
			<label><strong>Email</strong></label>
			<pre><?php echo $contact['contact_email'] ?></pre>
			<label><strong>Message</strong></label>
			<p><?php echo $contact['contact_message'] ?></p>
		</div>
	</div>
</div>

<div class="box footer-light">
	<div class="box-header with-border">
		<div class="widget-header"><h4>Reply message</h4></div>
	</div>
	<?php
	if($contact['contact_reply'] == 1 ){
		?>
		<div class="box-body">
			<p><?php echo nl2br($contact['contact_reply_msg']) ?></p>
		</div>
		<div class="form-input-bottom form-actions">
			<a href="<?php echo @base64_decode($this->_GET('r'))?>" class="btn btn-flat btn-warning"><i class="fa fa-long-arrow-left"></i>Back</a>
		</div>
		<?php
	}
	else{
		$this->form->getForm('edit',$sqltable,$arrInput,$formName='replyContact',$submitValue='Reply',$finishButton=true);
	}
	?>
</div>

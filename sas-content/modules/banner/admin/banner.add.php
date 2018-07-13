<?php if (!defined('basePath')) exit('No direct script access allowed');

$linkID   = intval($this->uri(3));
$redirect = base64_decode(substr($this->uri(4),3));

// Table Name
$sqltable 	= array(

	'table'	    => $this->table_prefix.'banner',
	'banner_id' => $linkID
);

// Define form field
$params	= array(

	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->image('Banner Image','add_banner_image',uploadPath.'modules/banner/',uploadPath.'modules/banner/thumbs/','image'),
	$this->form->input->text('Name', 'add_banner_title'),
	$this->form->input->text('Url','add_banner_link'),
	$this->form->input->html('<div class=" hidden-hr">'),
	$this->form->input->switchcheck('Publish', 'add_publish', $skin=5,$checked=true),
	$this->form->input->html('</div>'),
	$this->form->input->hidden('add_banner_position',@$this->_GET('position')),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
);

$this->form->beforeInsert('cek()');

function cek(){

	global $system;

	$error = false;
	$alert = '';

	@$sc = '

		elseif(empty($_POST[\'postImages\'][\'name\'][0])){
			$error = true;
			$alert = "Banner image required.";
		}
		elseif(empty($_POST[\'add_banner_title\'])){
			$error = true;
			$alert = "Banner title required";
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

$this->form->getForm('add',$sqltable,$params,$formName='banner',$submitValue='Add banner',true,$resetBotton=false,$extra='',$width=1000,$height=125);
?>

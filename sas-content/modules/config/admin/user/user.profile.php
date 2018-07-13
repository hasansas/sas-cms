<?php if (!defined('basePath')) exit('No direct script access allowed');
// adodb_pr($_SESSION['admin']);
$sqltable = array(

	'table' => $this->table_prefix.'user',
	'id'	=> $this->admin('id')
);

$group = array(
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'user_group',
		'id' 	=> 'group_id',
		'field'	=> 'name',
		'cond' 	=> 'where 1'
	)
);

$active 	= array('addcheck' => array('1' => 'Yes'));

$params = array(

	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->html('<div class="image-holder">'),
	$this->form->input->image('Profil Picture','add_image',uploadPath.'modules/user/',uploadPath.'modules/user/thumbs/','image'),
	$this->form->input->html('</div>'),
	$this->form->input->text('Name', 'add_name'),
	$this->form->input->text('Email', 'add_email'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->beforeUpdate('cek()');

function cek(){

	$error = false;
	$alert = '';

	@$sc = '
		elseif(!validateEmail($_POST[\'add_email\'])){
			$error = true;
			$alert = "Email tidak valid.";
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

$this->form->onUpdate('updatePage($tableKey,$tableName,$tableID,$tableKey)');

function updatePage($tableKey,$tableName,$tableID,$tableKey){
	global $system;
	$_SESSION['admin']['name'] = $_POST['add_name'];
	$_SESSION['admin']['email'] = $_POST['add_email'];
	$_SESSION['admin']['image'] = $system->db->getOne("select image from ".$tableName." where ".$tableID."='".$tableKey."'");
}

$this->form->getForm('edit',$sqltable,$params,$formName='edituser',$submitValue='Save Changes',$finishButton=true);?>

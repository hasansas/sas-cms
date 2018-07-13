<?php if (!defined('basePath')) exit('No direct script access allowed');

$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$sqlCond   = $groupSessId!=1?'where group_id<>1':'where 1';

$sqltable 	= array(
	'table' 	=> $this->table_prefix.'user'
);

$group = array(
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'user_group',
		'id' 	=> 'group_id',
		'field'	=> 'name',
		'cond' 	=> $sqlCond
	)
);

$active 	= array('addcheck' => array('1' => 'Yes'));
$params = array(
	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->html('<div class="row">'),
	$this->form->input->html('<div class="col-md-6">'),
	$this->form->input->text('User Name', 'add_username'),
	$this->form->input->password('Password', 'add_pass'),
	$this->form->input->password('Retype Password', 'pass'),
	$this->form->input->html('<div class=" hidden-hr">'),
	$this->form->input->switchcheck('Active', 'add_active', $skin=3,$checked=true),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('<div class="col-md-6">'),
	$this->form->input->select('User Group', 'add_group_id',$group),
	$this->form->input->text('Name', 'add_name'),
	$this->form->input->text('Email', 'add_email'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);

$this->form->beforeInsert('cek()');

function cek(){

	global $system;

	$error = false;
	$alert = '';

	$currentUser = $system->db->getOne("select username from ".$system->table_prefix."user where username='".$_POST['add_username']."'");

	if(empty($_POST['add_username'])){
		$error = true;
		$alert = "Username cannot be empty.";
	}
	elseif($currentUser){
		$error = true;
		$alert = "Username already in use.";
	}
	elseif(empty($_POST['md5_add_pass'])){
		$error = true;
		$alert = "Pasword cannot be empty.";
	}
	elseif(empty($_POST['md5_pass'])){
		$error = true;
		$alert = "Please retype pasword.";
	}
	elseif($_POST['md5_pass'] !== $_POST['md5_add_pass']){
		$error = true;
		$alert = "Pasword does not match.";
	}
	elseif(empty($_POST['add_name'])){
		$error = true;
		$alert = "Name cannot be empty.";
	}
	elseif(empty($_POST['add_email'])){
		$error = true;
		$alert = "Email cannot be empty.";
	}
	elseif(!validateEmail($_POST['add_email'])){
		$error = true;
		$alert = "Invalid email address.";
	}

	$response = array(

		'error' => $error,
		'alert' => $alert
	);

	return $response;
}
?>

<?php $this->form->getForm('add',$sqltable,$params,$formName='adduser',$submitValue='Add User',$finishButton=true); ?>

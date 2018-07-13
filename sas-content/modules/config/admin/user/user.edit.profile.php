<?php if (!defined('basePath')) exit('No direct script access allowed');

$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$sqlCond   = $groupSessId!=1?'where group_id<>1':'where 1';

$userID 	= intval(@$this->uri(3));

$sqltable = array(

	'table' => $this->table_prefix.'user',
	'id'	=> $userID
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

	$this->form->input->text('User Name', 'add_username'),
	$this->form->input->select('User Group', 'add_group_id',$group),
	$this->form->input->text('Name', 'add_name'),
	$this->form->input->text('Email', 'add_email'),
	$this->form->input->switchcheck('Active', 'add_active', $skin=3,$checked=true),
	$this->form->input->html('<input type="hidden" class="active_tab" name="active_tab" value="profile">')
);

$this->form->beforeUpdate('cek()');

function cek(){

	global $system;

	$error = false;
	$alert = '';

	$currentUser = $system->db->getOne("select username from ".$system->table_prefix."user where id='".intval($system->uri(3))."'");
	$requestUser = $system->db->getOne("select username from ".$system->table_prefix."user where username='".$_POST['add_username']."'");

	if(empty($_POST['add_username'])){
		$error = true;
		$alert = "Username cannot be empty.";
	}
	elseif($requestUser && $_POST['add_username'] !== $currentUser){
		$error = true;
		$alert = "Username already in use.";
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

$this->form->getForm('edit',$sqltable,$params,$formName='edituser',$submitValue='Save Changes',$finishButton=true);
?>

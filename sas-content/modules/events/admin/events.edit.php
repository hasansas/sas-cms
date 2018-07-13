<?php if (!defined('basePath')) exit('No direct script access allowed');

$this->form->beforeUpdate('cekForm()');
$this->form->onUpdate('updatePage($post)');

function cekForm(){

	global $system;

	$error = false;
	$alert = '';

	if(empty($_POST['add_event_title'])){

		$error = true;
		$alert = 'Event name required.';
	}
	elseif(empty($_POST['add_event_description'])){

		$error = true;
		$alert = 'Event description required.';
	}
	elseif(empty($_POST['add_event_content'])){

		$error = true;
		$alert = 'Event detail required.';
	}
	elseif(empty($_POST['tanggal'])){

		$error = true;
		$alert = 'Event date required.';
	}
	elseif(empty($_POST['add_place'])){

		$error = true;
		$alert = 'Event place required.';
	}
	elseif(empty($_POST['add_address'])){

		$error = true;
		$alert = 'Event address required.';
	}
	elseif(empty($_POST['postImages']['name'][0])){
		$error = true;
		$alert = "Event Image required.";
	}

	$response = array(

		'error' => $error,
		'alert' => $alert
	);

	return $response;
}

function updatePage($post){

	global $system;

	$eventID	= intval($system->uri(3));
	$arrDate 	= explode(' - ',$post['tanggal']);
	$tmpDate1	= explode('/',$arrDate[0]);
	$tmpDate2	= explode('/',$arrDate[1]);

	$startDate	= $tmpDate1[2].'-'.$tmpDate1[0].'-'.$tmpDate1[1].' 00:00:00';
	$endDate	=  $tmpDate2[2].'-'.$tmpDate2[0].'-'.$tmpDate2[1].' 23:59:59';
	$qry = "update ".$system->table_prefix."events set start_date='".$startDate."',end_date='".$endDate."' where event_id='".$eventID."'";

	$system->db->execute($qry);
}

$this->form->getForm('edit',$sqltable,$params,$formName='event',$submitValue='Update event',true);
?>

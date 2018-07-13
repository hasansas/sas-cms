<?php if(!defined('basePath')) exit('No direct script access allowed');

if(is_numeric($this->uri(2))){
	$query	= "select * from ".$this->table_prefix."agenda where agenda_id='".$this->uri(2)."'";
	$event = $this->db->getRow($query);
	if(isFileExist($this->themePath(),'event.detail.php')){
		include $this->themePath().'event.detail.php';
	}
	else{
		echo 'event book';
	}
}
else{

	$shoPerPage = 5;
	$query = "
		select
			agenda_id,
			author_id,
			author_name,
			event,
			content,
			date_format(start_date,'%Y-%m-%d') as sratDate,
			date_format(end_date,'%Y-%m-%d') as endDate,
			place,
			address,
			image
		from
			".$this->table_prefix."agenda
		where
			status='1'
	";

	$event		= new stdClass;

	$this->data->init($query,$shoPerPage);
	$event->data 		= $this->data->arrData();
	$event->pagination  = $this->data->getNav();

	if(isFileExist($this->themePath(),'event.php')){
		include $this->themePath().'event.php';
	}
	else{
		adodb_pr($event);
	}
}
?>

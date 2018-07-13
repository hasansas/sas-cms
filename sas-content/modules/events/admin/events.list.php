<?php if (!defined('basePath')) exit('No direct script access allowed');

$tablename  = $this->table_prefix.'events';
$query		= 'select event_id, event_title, start_date, end_date, place, status from '.$tablename.' where 1 order by event_id desc';

$data 		= array(

	'Event' 		=> 'event_title.text..align="left"',
	'Start Date' 	=> 'start_date.custom.startDate.align="left"',
	'End Date' 		=> 'end_date.custom.endDate.align="left"',
	'Place' 		=> 'place.text..align="left"',
	'Publish'		=> 'status.switchcheck..width="60".align="center"',
	'Edit'			=> 'id.edit.'.$editUrl
);

function startDate($data){

	global $system;

	$lang = $system->lang();

	$startDate = get_date($data['start_date'],$lang['month'],$lang['day'],$setDay=false,$setTime=false);
	return $startDate;
}

function endDate($data){

	global $system;

	$lang = $system->lang();

	$endDate = get_date($data['end_date'],$lang['month'],$lang['day'],$setDay=false,$setTime=false);
	return $endDate;
}

$this->data->addSearch('event_title');
$this->data->removeImage('image','modules/event/');
$this->data->init($query,10,5);
$this->data->getPage($tablename,'event_id',$data);
?>

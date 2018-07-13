<?php if (!defined('basePath')) exit('No direct script access allowed');

$eventID = intval($this->uri(3));
$redirect = base64_decode(substr($this->uri(4),3));

// Table Name
$sqltable 	= array(

	'table'	  => $this->table_prefix.'events',
	'event_id' => $eventID
);

$event	  = $this->db->getRow("select date_format(start_date,'%m/%d/%Y') as startDate,date_format(end_date,'%m/%d/%Y') as endDate from ".$sqltable['table']." where event_id='".$eventID."'");
$tanggal  = isset($event['startDate'])&&isset($event['endDate'])?$event['startDate'].' - '.$event['endDate']:'';

// Define form field
$params	= array(

	$this->form->input->html('<div class="row">'),
	$this->form->input->html('<div class="col-md-8 col-lg-9">'),
	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-body">'),
	$this->form->input->text('Event Name', 'add_event_title'),
	$this->form->input->textarea('Event description','add_event_description',30,3,$editor=false),
	$this->form->input->textarea('Event detail','add_event_content',30,3,$editor=true),
	$this->form->input->text('Tags', 'add_event_tag'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),

	$this->form->input->html('<div class="col-md-4 col-lg-3">'),

	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-header with-border">'),
	$this->form->input->html('<div class="widget-header">'),
	$this->form->input->html('<h4 class="widget-title">Location</h4>'),
	$this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#publish" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('<div id="publish" class="box-body collapse in">'),
	$this->form->input->html('<div class="widget-main">'),
	$this->form->input->dateRangePicker('Date', 'tanggal',$tanggal),
	$this->form->input->text('Place', 'add_place'),
	$this->form->input->textarea('Address','add_address',30,3,$editor=false),
	$this->form->input->html('<div class="hide-hr">'),
	$this->form->input->switchcheck('Publish', 'add_status',$type=2,$checked=true,$addClass='pull-right'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('<div class="space"></div>'),

	$this->form->input->html('<div class="box">'),
	$this->form->input->html('<div class="box-header with-border">'),
	$this->form->input->html('<div class="widget-header">'),
	$this->form->input->html('<h4 class="widget-title">Event Image</h4>'),
	$this->form->input->html('<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#image" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('<div id="image" class="box-body collapse in">'),
	$this->form->input->html('<div class="widget-main hide-hr">'),
	$this->form->input->image('','add_image',uploadPath.'modules/event/',uploadPath.'modules/event/thumbs/'),
	$this->form->input->html('<div class="clearfix"></div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),
	$this->form->input->html('</div>'),

	$this->form->input->html('</div>'),
	$this->form->input->html('</div>')
);
?>

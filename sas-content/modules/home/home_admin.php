<?php if (!defined('basePath')) exit('No direct script access allowed');

//adodb_pr($this->session('adminmenu'));

$admin = $this->session('admin');
echo $this->form->alert('ok','Welcome '.ucwords($admin['name']));
$month 	= '';
$year	= '';
?>

<div class="row">
	<div class="col-sm-7">
		<div class="box">
			<div class="box-header with-border">
				<div class="widget-header">
					<h4 class="widget-title">This Month</h4>
					<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#line" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>
				</div>
			</div>
			<div id="line" class="box-body collapse in">
				<div class="widget-main">
					<?php $this->stats->displayVisitorStatistic($month, $year); ?>
				</div>
			</div>
		</div>
		<div class="space"></div>
	</div>
	<div class="col-sm-5">
		<div class="box">
			<div class="box-header with-border">
				<div class="widget-header">
					<h4 class="widget-title">Referrer Websites</h4>
					<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#pie" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>
				</div>
			</div>
			<div id="pie" class="box-body collapse in">
				<div class="widget-main">
					<?php $this->stats->displayVisitorReferrer($month, $year); ?>
				</div>
			</div>
		</div>
		<div class="space"></div>
	</div>
</div>

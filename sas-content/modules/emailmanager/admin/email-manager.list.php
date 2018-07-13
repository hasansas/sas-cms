<?if (!defined('basePath')) exit('No direct script access allowed');

$addUrl		= 'add-email-template';
$addUrl 	= $this->adminUrl().''.$addUrl.$this->permalink().'?r='.base64_encode($this->thisUrl());

$taqblename = $this->table_prefix.'email_template';
$query		= 'select * from '.$taqblename;
$data 		= array(

	'Email Name'		=> 'email_name.text..align="left"',
	'Email Description'	=> 'email_description.text..align="left"',
	'Edit'				=> 'id.edit.edit-email-template'
);

$this->data->init($query,20);
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<div class="widget-toolbar">
				<a href="<?=$addUrl?>" class="btn btn-sm btn-flat btn-info"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
		<?php $this->data->getPage($taqblename,'email_id',$data,true,false);?>
		</div>
	</div>
</div>

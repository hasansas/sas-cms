<?php if (!defined('basePath')) exit('No direct script access allowed');

/* Add URL */
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$addUrl		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='event_add' and parent_id='".$this->thisPageID()."'");
$addUrl 	= $this->adminUrl().''.$addUrl.$this->permalink().'?r='.base64_encode($this->thisUrl());

/* Edit URL */
$editUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='event_edit' and parent_id='".$this->thisPageID()."'");
?>
<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<span class="widget-toolbar">
			<a href="<?php echo $addUrl?>" class="btn btn-sm btn-flat btn-info"><i class="ace-icon fa fa-plus"></i> Add New</a>
			</span>
		</div>
	</div>
	<?php include modulePath.$this->thisModule().'/admin/events.list.php';?>
</div>

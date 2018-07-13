<?php if (!defined('basePath')) exit('No direct script access allowed');

/* Add/Edit URL */
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$addUrl		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='add_category' and parent_id='".$this->thisPageID()."'");
$editUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='edit_category' and parent_id='".$this->thisPageID()."'");

$parentID 		= !$this->uri(4)?0:intval($this->uri(4));
$parentID 		= @$this->uri(3)=='parent'?$parentID:0;
$addUrl 		= $this->adminUrl().$addUrl.$this->permalink().'?r='.base64_encode($this->thisUrl());
$breadcrumbCat	= $this->breadcrumbCategory($parentID);
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
		<h4 class="widget-title"><?php echo $breadcrumbCat?></h4>
			<div class="widget-toolbar">
				<a href="<?=$addUrl?>" class="btn btn-sm btn-flat btn-info"><i class="fa fa-plus"></i> Add Section</a>
			</div>
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
			<? require 'category.list.php'; ?>
		</div>
	</div>
</div>

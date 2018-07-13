<?php if (!defined('basePath')) exit('No direct script access allowed');

/* Add URL */
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$addUrl		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='faq_add' and parent_id='".$this->thisPageID()."'");

/* Edit URL */
$addUrl 	= $this->adminUrl().''.$addUrl.$this->permalink().'?r='.base64_encode($this->thisUrl());
$editUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='faq_edit' and parent_id='".$this->thisPageID()."'");


$tablename  = $this->table_prefix.'faq';
$query		= 'select * from '.$tablename.' where 1 order by faq_order';
$data 		= array(

	'Question' 	=> 'question.text..align="left"',
	'Order'		=> 'faq_order.inputText..width="20".class="input-order"',
	'Publish'	=> 'publish.switchcheck..width="60".align="center"',
	'Edit'		=> 'slider_id.edit.'.$editUrl
);

$this->data->addSearch('question');
$this->data->init($query,10,5);
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<div class="widget-toolbar">
				<a href="<?php echo $addUrl; ?>" class="btn btn-sm btn-flat btn-info"><i class="ace-icon fa fa-plus"></i> Add New</a>
			</div>
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
			<div class="default-form form-actions-inner">
				<?php $this->data->getPage($tablename,'faq_id',$data);?>
			</div>
		</div>
	</div>
</div>

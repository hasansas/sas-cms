<?php if (!defined('basePath')) exit('No direct script access allowed');

//Position
$arrTabs  = array(

	'right'	 => 'Right',
	'top'	 => 'Top',
	'bottom' => 'Bottom',
	//'left'	 => 'Left',
);

$banner_position = @$this->_GET('position');
$getPosition 	 = empty($banner_position)?'right':$banner_position;
$xPosition	  = '<select name="position" onchange="this.form.submit()" class="select2 form-control form-control">';
foreach($arrTabs as $tabID=>$tabVal){

	$activeClass = $tabID == $getPosition?' selected="true"':'';
	$xPosition .= '<option value="'.$tabID.'"'.$activeClass.'>'.$tabVal.'</option>';
}
$xPosition .= '</select>';

/* Add/Edit URL */
$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$addUrl		= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='banner_add' and parent_id='".$this->thisPageID()."'");
$addUrl	 	= $this->adminUrl().$addUrl.$this->permalink().'?position='.$getPosition.'&r='.base64_encode($this->thisUrl());
$editUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='banner_edit' and parent_id='".$this->thisPageID()."'");
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<form name="frm-filter" class="form-inline" method="get">
				<div class="form-group">
					<label>Position</label>
					<?php echo $xPosition ?>
				</div>
			</form>
			<div class="widget-toolbar">
				<a href="<?=$addUrl?>" class="btn btn-sm btn-flat btn-info"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
		<?php include modulePath.$this->thisModule().'/admin/banner.list.php';?>
		</div>
	</div>
</div>

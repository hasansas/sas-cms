<?php if (!defined('basePath')) exit('No direct script access allowed');

//Update Access
$errorMsg = '';

if(isset($_POST['save'])){

	$access 	 = serialize($_POST['page']);
	$updateQuery = "update ".$this->table_prefix."user_group set access='".$access."' where group_id='".intval($this->uri(3))."'";

	if($this->db->execute($updateQuery)){

		$errorMsg = '

			<div class="alert success" id="alert-success">
				<i class="icon-ok-sign"></i>
				<strong>Success!</strong> Data has been successfully updated.
				<span onclick="closeThis(\'alert-success\')" class="close"><i class="icon-remove"></i></span>
			</div>
		';
	}
	else{

		$errorMsg = '

			<div class="alert error" id="alert-error">
				<i class="icon-remove-sign"></i>
				<strong>Error!</strong> Unable to update data, please try again later.
				<span onclick="closeThis(\'alert-error\')" class="close"><i class="icon-remove"></i></span>
			</div>
		';
	}
}


$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$groupId 	= intval($this->uri(3));
$userAccess = $this->user->getPermission($groupSessId);
$getAccess  = $this->user->getPermission($groupId);

$query 		= "select * from ".$this->table_prefix."pages order by page_name";

if($groupId==1 && $groupSessId!=1){
	$this->_404();
}
else{

	$groupID 	 = anti_injection(intval($this->uri(3)));
	$groupName 	 = $this->db->getOne("select name from ".$this->table_prefix."user_group where group_id='".anti_injection($groupID)."'");
	$widgetTitle = !empty($groupName)?'<strong>'.ucwords($groupName).'</strong> Set Permissions':'Set Permission';
	?>
	<div class="box">
		<div class="box-header with-border">
			<div class="widget-header">
				<h4 class="widget-title"><?php echo $widgetTitle?></h4>
			</div>
		</div>

		<div class="box-body">
			<form action="" method="post">
				<div class="widget-permission">
					<?=!empty($errorMsg)?$errorMsg:'';?>
					<div class="tree">
						<label><input type="checkbox" id="chkall_page" class="ace"/><span class="lbl"> Check All</span></label>
						<?=$this->user->pages($query,$userAccess,$getAccess);?>
					</div>
				</div>

			</form>
		</div>
		<div class="box-footer">
			<button type="submit" name="save" class="btn btn-fat btn-primary"><i class="fa fa-save"></i> Update Permission</button>
		</div>
	</div>
	<?
}
?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#chkall_page").click(function()
		{
			var checked_status = this.checked;
			$(".chk").each(function()
			{
				this.checked = checked_status;
			});
		});
	});
</script>

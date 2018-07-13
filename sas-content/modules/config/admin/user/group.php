<?php if (!defined('basePath')) exit('No direct script access allowed'); ?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<span class="widget-toolbar">
				<a class="btn btn-sm btn-flat btn-info" href="#" data-toggle="modal" data-target="#modal-group"><i class="fa fa-plus"></i> Add New Group</a>
			</span>
		</div>
	</div>
	<div class="group-list">
		<?php include modulePath.$this->thisModule().'/admin/user/group.list.php';?>
	</div>
</div>

<div class="modal fade" id="modal-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form id="frmAddGroup" method="post" action="">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Add New Group</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="add_name" name="add_name" class="form-control" placeholder="Group Name">
				</div>
				<div class="modal-footer">
					<button type="submit" name="add_group" class="add_group btn btn-sm btn-flat btn-primary">Add New Group</button>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- Script -->
<script>

	$(function(){

		//add group
		$(".add_group").click(function(){

			var loadFile = ajaxURL+"<?=modulePath?>config/admin/user/group.list.php";
			var xajaxFile = ajaxURL+"<?=modulePath?>config/admin/user/group.add.ajax.php";

			$.ajax({

				type: 'POST',
				url: xajaxFile,
				data: $("#frmAddGroup").serialize(),
				dataType: 'json',
				success: function(data){

					if(!data.error){
						$("#add_name").val("");
						$(".group-list").load(loadFile);
						$(".group-list").html(data.errorMsg);
					}
					else{
						$(".x").html(data.errorMsg);
					}
				}
			});
			return false;
		});
	});
</script>

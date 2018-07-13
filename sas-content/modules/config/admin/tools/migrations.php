<?php if (!defined('basePath')) exit('No direct script access allowed');

// get migration from db
$rs_migration = $this->db->getAll("select migration_file from ".$this->table_prefix."migrations");
$migrations = array();
foreach ($rs_migration as $key => $value) {
	$migrations[] = $value['migration_file'];
}

// get migration file
$pending_migratin = array();
if ($handle = opendir(modulePath.'config/admin/tools/migrations/')){

	while (false !== ($file = readdir($handle))){

		if($file !=='.' and $file !=='..'){

			$xfile = explode('_',str_replace('.txt','',$file));
			if(!in_array($xfile[1],$migrations)){
				$pending_migratin[$xfile[1]] = $xfile[0];
			}
		}
	}
	closedir($handle);
}

$btn_apply = 'style="display:none"';
$migration_list = '

	<div class="migrations-content">
		<div class="alert alert-warning">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			No migration detected
			<br>
		</div>
	</div>
';

if(count($pending_migratin) > 0){
	$btn_apply		= '';
	$migration_list = '';
	foreach ($pending_migratin as $key => $value) {
		$migration_list .= '<pre>Migration '.$value.' '.$key.'</pre>';
	}
}
?>

<div class="text-right">
	<button type="button" class="btn btn-flat btn-warning btn-apply" <?php echo $btn_apply ?>>Apply migration</button>
	<button type="button" class="btn btn-flat btn-primary" data-toggle="modal" data-target="#modal-group">Create migration</button>
</div>
<br>
<div class="migration-item">
	<?php echo $migration_list ?>
</div>

<div class="modal fade" id="modal-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<form id="frmMigration" method="post" action="">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Create Migrations</h4>
				</div>
				<div class="modal-body">
					<div class="message"></div>
					<div class="form-group">
						<input type="text" name="module" class="form-control" value="" placeholder="Module *">
					</div>
					<div class="form-group">
						<textarea name="query" class="form-control input-query" rows="10" cols="80" placeholder="Query *"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-flat btn-warning" data-dismiss="modal">Close</button>
					<button type="submit" name="add_group" class="btn btn-flat btn-primary btn-migration">
						<span class="label right">Submit</span>
						<span class="spinner" style="display:none">
							<i class="bounce1"></i>
							<i class="bounce2"></i>
							<i class="bounce3"></i>
						</span>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="modal-apply" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<form id="frmMigration" method="post" action="">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Applay Migrations</h4>
				</div>
				<div class="modal-body">
					<div class="apply-status"></div>
					<div class="spinner-box" style="display:none">
						<!-- <div class="spinner">
						  	<div class="dot1"></div>
						  	<div class="dot2"></div>
						</div> -->
						<div class="sk-cube-grid">
							<div class="sk-cube sk-cube1"></div>
							<div class="sk-cube sk-cube2"></div>
							<div class="sk-cube sk-cube3"></div>
							<div class="sk-cube sk-cube4"></div>
							<div class="sk-cube sk-cube5"></div>
							<div class="sk-cube sk-cube6"></div>
							<div class="sk-cube sk-cube7"></div>
							<div class="sk-cube sk-cube8"></div>
							<div class="sk-cube sk-cube9"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-flat btn-warning" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Script -->
<script>

	$(function(){

		$('#modal-group').on('hide.bs.modal', function (e) {
		  	$('.message').html('');
		  	$('input').val('');
		  	$('textarea').val('');
		})
		$(".btn-migration").click(function(){

			var xajaxFile = ajaxURL+"<?php echo modulePath ?>config/admin/tools/migrations.create.php";
			$('.spinner').show();
			$(this).attr('disabled', 'disabled');
			$.ajax({

				type: 'POST',
				url: xajaxFile,
				data: $("#frmMigration").serialize(),
				dataType: 'json',
				success: function(data){

					if(!data.error){
						$('.alert-warning').remove();
					  	$('input').val('');
					  	$('textarea').val('');
					  	$('.migrations-content').append('<pre>Migration '+ data.module +' '+ data.file +'</pre>');
						$('.btn-apply').show();
					}
					else{
					}
					$(".message").html(data.message);
					$('.spinner').hide();
					$(".btn-migration").removeAttr('disabled');
				}
			});
			return false;
		});

		$('.btn-apply').click(function(){

			$('#modal-apply').modal();
			 $('.spinner-box').show();
			var xajaxFile = ajaxURL+"<?php echo modulePath ?>config/admin/tools/migrations.apply.php";

			$.ajax({

				type: 'POST',
				url: xajaxFile,
				data: {},
				dataType: 'json',
				success: function(data){

					$('.apply-status').html(data.status)
					$('.migration-item').html(data.migrate_error)
					if(data.migrate_error == ''){
						$('.btn-apply').hide();
						$('.migration-item').html('	<div class="migrations-content">'+
								'<div class="alert alert-warning">'+
									'<button data-dismiss="alert" class="close" type="button">&times;</button>'+
									'No migration detected'+
									'<br>'+
								'</div>'+
							'</div>')
					}
					$('.spinner-box').hide();
				}
			});
		});
	});
</script>

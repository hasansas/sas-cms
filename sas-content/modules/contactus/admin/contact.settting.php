<?if (!defined('basePath')) exit('No direct script access allowed');

//Form
$msg 	  = '';
$settings = '';

if(isset($_POST['save'])){

	$params['content'] = base64_encode(htmlspecialchars($_POST['content']));

	foreach($_POST as $k=>$v){

		if($v!='Save' && $k!='content'){$params['setting'][] = $v;}
	}

	$params['geolocation']	= substr($_POST['geolocation'],1,-1);

	$contactSetting = serialize($params);

	$qry = "update ".$this->table_prefix."params set contact='".$contactSetting."' where 1";
	$msg = !$this->db->execute($qry)?$this->form->alert('error','Faile to update data.'):$this->form->alert('success','Data has been successfully updated.');
}

$cParams 		= $this->getParams('contact');
$contactSetting = is_array(@$cParams['setting'])?$cParams['setting']:array();

foreach($arrSetting as $val=>$label){

	$checked   = in_array($val,$contactSetting)?'checked':'';
	$settings .= '
		<div class="form-group"><label><input type="checkbox" class="chk ace" name="'.$val.'" value="'.$val.'" '.$checked.'/><span class="lbl"></span> Show '.$label.'</label></div>
	';
}
$settings	= '<div class="form-group"><label><input type="checkbox" id="chkall" class="chk ace"><span class="lbl"></span> Select All</label></div>'.$settings;
?>


<form method="post" action="">

	<?=$msg;?>

	<div class="row">

		<div class="col-md-8 col-lg-9">
			<div class="box">
				<div class="box-body">
					<div class="form-group">
						<label class="control-label">Contact Map</label>
						<div class="controls">
							<?=inputMap(@$cParams['geolocation'],'geolocation')?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">Contact Info</label>
						<div class="controls">
							<textarea name="content" class="form-control validateText"><?=base64_decode(@$cParams['content'])?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-4 col-lg-3">
			<div class="box">
				<div class="box-header with-border">
					<div class="widget-header">
						<h4 class="widget-title">Contact Fields</h4>
						<div class="widget-toolbar"><a data-toggle="collapse" data-parent="#accordion" href="#page" aria-expanded="true" aria-controls="collapseOne" class="toggle-select"><i class="ace-icon fa fa-chevron-down"></i></a></div>
					</div>
				</div>
				<div id="page" class="box-body collapse in">
					<div class="widget-main">
						<div class="default-form form-actions-inner">
							<?=$settings;?>
						</div>
					</div>
				</div>
			</div>
			<div class="space"></div>

		</div>
	</div>
	<div class="form-input-bottom form-actions">
		<button type="submit" class="btn btn-flat btn-primary" id="save" name="save">Save all changes</button>
	</div>
</form>

<!-- Script -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#chkall").click(function()
		{
			var checked_status = this.checked;
			$(".chk").each(function()
			{
				this.checked = checked_status;
			});
		});
	});
</script>

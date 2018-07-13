<?php if (!defined('basePath')) exit('No direct script access allowed');

$prevURL = base64_decode($this->_GET('r'));

if(isset($_POST['changepass'])){

	$pass 	= $_POST['password'];

	if(empty($pass)){
		$alert = $this->form->alert('error','Enter password.');
	}
	else{

		$password  = md5(base64_encode($pass));
		$updateQry = "update ".$this->table_prefix."user set pass='".$password."' where id='".intval($this->uri(3))."'";

		if($this->db->execute($updateQry)){
			$alert = $this->form->alert('success','Password updated.');
		}
		else{
			$alert = $this->form->alert('error','Unable to change password.');
		}
	}
}
?>

<form method="post" action="" name="frm_account">
	<?=@$alert?>
	<div class="form-group">
		<label class="control-label">New Password</label>
		<div class="controls">
			<input type="password" class="form-control" value="" name="password" readonly onfocus="this.removeAttribute('readonly')">
		</div>
	</div>
	<hr>
	<div class="form-input-bottom form-actions">
		<input type="hidden" class="active_tab" name="active_tab" value="xpassword">
		<button type="submit" class="btn btn-flat btn-primary" name="changepass" id="save_edituser"><i class="fa fa-save"></i>Change Password</button>
		<a href="<?php echo $prevURL; ?>" class="btn btn-flat btn-warning"><i class="fa fa-long-arrow-left"></i>Back</a>
	</div>
</form>

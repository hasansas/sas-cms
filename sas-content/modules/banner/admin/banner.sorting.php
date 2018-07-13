<?if (!defined('basePath')) exit('No direct script access allowed');

$blockOrder = 1;
$error	   = array();

foreach($_POST as $id=>$v){

	$updateQuery = "update ".$this->table_prefix."banner set banner_order='".$blockOrder."' where banner_id='".$id."'";
	
	if($this->db->execute($updateQuery)){		
		$error[] = '';
	}
	else{
		$error[] = 'error';
	}
	$blockOrder++;
}

$alert = in_array('$error',$error)?	$this->form->alert('error','Unable to reorder widget'):$this->form->alert('success','Widget updated.');

echo $alert;
?>
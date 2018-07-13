<?php if (!defined('basePath')) exit('No direct script access allowed');


$orderQuery = '';
$query   	= "select banner_id,banner_title from ".$this->table_prefix."banner where banner_position ='".$banner_position."' order by banner_order";
$rsMenu 	= $this->db->execute($query);
$sortable	= '';

while($data = $rsMenu->fetchRow()){
	
	$item_id   = $data['banner_id'].'_'.strtolower(str_replace(' ','',$data['banner_title']));
	$sortable .= '<li id="'.$item_id.'"><i class="icon-random"></i><h4>'.$data['banner_title'].'</h4></li>';
}

?>
<div class="sortable">
	<div class="alert-message"></div>
	<ul>
		<?=$sortable;?>
	</ul>
</div>


<!-- Script -->
<script type="text/javascript">
$(function() {
	
	$(".sortable ul").sortable({
	
		opacity:0.7,
		update: function() {
			
			var ajaxFle = '<?=modulePath?>banner/admin/banner.sorting.php';
			var order = $(this).sortable("serialize"); 
			
			$.post(ajaxURL+ajaxFle, order, function(theResponse){
				$(".alert-message").html(theResponse);
			});
		}								  
	});
});
</script>
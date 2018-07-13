<?php if (!defined('basePath')) exit('No direct script access allowed');

$xtableName	= $this->table_prefix.'menu';
$xrefTable	= $this->table_prefix.'pages';
$pageName   = $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
$pageUrl    = $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$query   	= "select ".$xtableName.".menu_id,".$xtableName.".parent_id,".$xtableName.".page_id,".$xtableName.".custom_title,".$xrefTable.".page_name as name,".$xrefTable.".".$pageName." as page_name,".$xrefTable.".".$pageUrl." as page_url,".$xrefTable.".page_url as url from ".$xtableName." left join ".$xrefTable." on(".$xtableName.".page_id=".$xrefTable.".page_id) where admin_menu='".$xadminMenu."' and position='".$activePosition."' order by ".$xtableName.".menu_order";
$publicMenu	= $this->_GET('menu')=='admin'?'admin':'public';
$menuUrl 	= $this->adminURL().'menu/'.$publicMenu.$this->permalink();
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<?php echo $navMenu?>
			<div class="widget-toolbar">
        <form method="get" action="">
				      <?php echo $position?>
        </form>
			</div>
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
				<span id="nestable-menu">
					<button type="button" data-action="expand-all" class="btn btn-xs btn-flat btn-info">Expand All</button>
					<button type="button" data-action="collapse-all" class="btn btn-xs btn-flat btn-info">Collapse All</button>
				</span>
			<div class="dd" id="data-menu">
				<?php echo $this->tree->getDataMenu($query,$menuUrl,$xtableName,'menu_id');?>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){

	var updateOutput = function(e){

		var jasonData = window.JSON.stringify($('#data-menu').nestable('serialize'));
		var xajaxFile = ajaxURL+"<?=modulePath?>config/admin/menu/menu.order.update.php";

		$.ajax({

			type: 'POST',
			url: xajaxFile,
			data: {menu:jasonData},
			//dataType: 'json',
			success: function(data){

				$('#data-menu-output').html(data);
			}
		});
	};
	$('#data-menu').nestable().on('change', updateOutput);
	$('#nestable-menu').on('click', function(e)
	{
		var target = $(e.target),
			action = target.data('action');
		if (action === 'expand-all') {
			$('.dd').nestable('expandAll');
		}
		if (action === 'collapse-all') {
			$('.dd').nestable('collapseAll');
		}
	});
	$(".dd span").on("mousedown", function(event) { // mousedown prevent nestable click
		event.preventDefault();
		return false;
	});
	$(".dd span").on("click", function(event) { // click event
		event.preventDefault();
		return false;
	});
	$(".dd-handle a").on("click", function(event) { // click event
		window.location = $(this).attr("href");
	});
});
function deleteMenu(id){

	$('#dd-info'+id).remove();
	$('#dd-progress'+id).fadeIn();

	var xajaxFile = ajaxURL+"<?=modulePath?>config/admin/menu/menu.delete.php";

	$.ajax({

		type: 'POST',
		url: xajaxFile,
		data: {menuID:id},
		dataType: 'json',
		success: function(data){

			$('#dd-item'+id).remove();
		}
	});

	return false;
}
</script>

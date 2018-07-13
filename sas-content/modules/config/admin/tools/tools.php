<?php if (!defined('basePath')) exit('No direct script access allowed');

// Clear junk menu
/*
$xtableName	= $this->table_prefix.'menu';
$xrefTable	= $this->table_prefix.'pages';
$query   	= "select menu_id, ".$xrefTable.".page_id from ".$xtableName." left join ".$xrefTable." on(".$xtableName.".page_id=".$xrefTable.".page_id) where 1 order by ".$xtableName.".menu_order";

$get_menu = $this->db->getAll($query);

foreach ($get_menu as $key => $value) {
	if(empty($value['page_id'])){
		adodb_pr($value['menu_id']);
		$this->db->execute("delete from ".$xtableName." where menu_id='".$value['menu_id']."'");
	}
}
*/

$fURL   	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$currentUrl	= $this->db->getOne("select ".$fURL." from ".$this->table_prefix."pages where page_switch='tools' and page_id='".$this->thisPageID()."'");

switch($this->uri(3)){

	case 'migrations':
		$includeFile 		= modulePath.$this->thisModule().'/admin/tools/migrations.php';
		$migrationsActive 	= 'nav-menu active';
		$formActive 		= 'nav-menu';
		$generalActive 		= 'nav-menu';
		$iconActive 		= 'nav-menu';
		$syncActive 		= 'nav-menu';
		break;

	case 'form':
		$includeFile 		= modulePath.$this->thisModule().'/admin/tools/form.php';
		$migrationsActive 	= 'nav-menu';
		$formActive 		= 'nav-menu active';
		$generalActive 		= 'nav-menu';
		$iconActive 		= 'nav-menu';
		$syncActive 		= 'nav-menu';
		break;

	case 'icons':
		$includeFile 		= modulePath.$this->thisModule().'/admin/tools/icons.php';
		$migrationsActive 	= 'nav-menu';
		$formActive 		= 'nav-menu';
		$generalActive 		= 'nav-menu';
		$iconActive 		= 'nav-menu active';
		$syncActive 		= 'nav-menu';
		break;

	case 'sync':
		$includeFile 		= modulePath.$this->thisModule().'/admin/tools/update.page.php';
		$migrationsActive 	= 'nav-menu';
		$formActive 		= 'nav-menu';
		$generalActive 		= 'nav-menu';
		$iconActive 		= 'nav-menu';
		$syncActive 		= 'nav-menu active';
		break;

	default:
		$includeFile 		= modulePath.$this->thisModule().'/admin/tools/form.php';
		$migrationsActive 	= 'nav-menu';
		$formActive 		= 'nav-menu active';
		$generalActive 		= 'nav-menu';
		$iconActive 		= 'nav-menu';
		$syncActive 		= 'nav-menu';
		break;
}

$arrTabs  = array(

	'form' 		=> array(
							'title'		=>	'Form Element',
							'icon'		=>	'wpforms',
							'nav_menu'	=>	$formActive,
							'url'		=>	$this->adminURL().$currentUrl.'/form'.$this->permalink()
						),
	'migrations' 		=> array(
							'title'		=>	'Migrations',
							'icon'		=>	'code',
							'nav_menu'	=>	$migrationsActive,
							'url'		=>	$this->adminURL().$currentUrl.'/migrations'.$this->permalink()
						),
	// 'sync' 		=> array(
	// 						'title'		=>	'Synchronize Page',
	// 						'icon'		=>	'bookmark',
	// 						'nav_menu active'	=>	$syncActive,
	// 						'url'		=>	$this->adminURL().'tools/sync'.$this->permalink()
	// 					)
);

$navMenu = '';
foreach($arrTabs as $v){
	$navMenu .= '<li class="'.$v['nav_menu'].'"><a href="'.$v['url'].'"><i class="fa fa-'.$v['icon'].'"></i>&nbsp;&nbsp;&nbsp;'.$v['title'].'</a></li>';
}
$navMenu = '<ul class="nav-group">'.$navMenu.'</ul>';
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
			<?php echo $navMenu?>
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
			<?php include($includeFile); ?>
		</div>
	</div>
</div>

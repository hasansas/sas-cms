<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){

	case 'banner_main':
		include modulePath.$this->thisModule().'/admin/banner.php';
		include modulePath.$this->thisModule().'/help/main_banner.php';
		$this->addHelp($help,'',400);
	break;

	case 'banner_add':
		include modulePath.$this->thisModule().'/admin/banner.add.php';
		include modulePath.$this->thisModule().'/help/add_banner.php';
		$this->addHelp($help,'',400);
	break;

	case 'banner_edit':
		include modulePath.$this->thisModule().'/admin/banner.edit.php';
		include modulePath.$this->thisModule().'/help/edit_banner.php';
		$this->addHelp($help,'',400);
	break;
}
?>

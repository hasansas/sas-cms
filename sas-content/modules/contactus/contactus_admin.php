<?if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){
	
	case 'contact_main':
		include modulePath.$this->thisModule().'/admin/contact.list.php';
		include modulePath.$this->thisModule().'/help/main.php';
		$this->addHelp($help,'',400);
	break;
	
	case 'contact_setting':
		include modulePath.$this->thisModule().'/contact.setting.php';
		include modulePath.$this->thisModule().'/admin/contact.settting.php';
		include modulePath.$this->thisModule().'/help/add.php';
		$this->addHelp($help,'',400);
	break;
	
	case 'contact_edit':
		include modulePath.$this->thisModule().'/contact.setting.php';
		include modulePath.$this->thisModule().'/admin/contact.edit.php';
		include modulePath.$this->thisModule().'/help/edit.php';
		$this->addHelp($help,'',400);
	break;
}
?>
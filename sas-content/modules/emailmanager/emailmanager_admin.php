<?if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){

	case 'email_main':
		require modulePath.$this->thisModule().'/admin/email-manager.list.php';
		include modulePath.$this->thisModule().'/help/main.php';
		$this->addHelp($help,'',400);
		break;

	case 'email_add':
		require modulePath.'emailmanager/admin/email-manager.add.php';
		include modulePath.$this->thisModule().'/help/add.php';
		$this->addHelp($help,'',400);
		break;
	
	case 'email_edit':
		require modulePath.'emailmanager/admin/email-manager.edit.php';
		include modulePath.$this->thisModule().'/help/edit.php';
		$this->addHelp($help,'',400);
		break;
	
	default:
		$this->_404();
		break;
}
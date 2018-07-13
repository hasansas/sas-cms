<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){

	case 'email_main':
		require modulePath.$this->thisModule().'/admin/email-manager.list.php';
		break;

	case 'email_add':
		require modulePath.'email-manager/admin/email-manager.add.php';
		break;

	case 'email_edit':
		require modulePath.'email-manager/admin/email-manager.edit.php';
		break;

	default:
		$this->_404();
		break;
}

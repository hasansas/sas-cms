<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){

	case 'faq_view':
		require 'admin/faq.view.php';
		break;

	case 'faq_add':
		require 'admin/form.init.php';
		require 'admin/faq.add.php';
		break;

	case 'faq_edit':
		require 'admin/form.init.php';
		require 'admin/faq.edit.php';
		break;

	default:

		break;
}
?>

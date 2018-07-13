<?if (!defined('basePath')) exit('No direct script access allowed');

switch($this->getSwitch()){

	case 'event_main':
		include modulePath.$this->thisModule().'/admin/events.php';
	break;

	case 'event_add':
		include modulePath.$this->thisModule().'/admin/form.init.php';
		include modulePath.$this->thisModule().'/admin/events.add.php';
	break;

	case 'event_edit':
		include modulePath.$this->thisModule().'/admin/form.init.php';
		include modulePath.$this->thisModule().'/admin/events.edit.php';
	break;
}
?>

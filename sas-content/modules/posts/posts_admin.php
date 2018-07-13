<?if (!defined('basePath')) exit('No direct script access allowed');

$categoryID = $this->db->getOne("select category_id from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");

if($categoryID!=0){
	require 'admin/posts.list.php';
	include modulePath.$this->thisModule().'/help/main.php';
	$this->addHelp($help,'',400);
}
else{

	switch($this->getSwitch()){

		case 'main':
			require 'admin/posts.list.php';
			include modulePath.$this->thisModule().'/help/main.php';
			$this->addHelp($help,'',400);
			break;

		case 'post_add':
			require 'admin/form.init.php';
			require 'admin/posts.add.php';
			include modulePath.$this->thisModule().'/help/add.php';
			$this->addHelp($help,'',400);
			break;

		case 'post_edit':
			require 'admin/form.init.php';
			require 'admin/posts.edit.php';
			include modulePath.$this->thisModule().'/help/edit.php';
			$this->addHelp($help,'',400);
			break;

		case 'category':
			require 'admin/category.php';
			include modulePath.$this->thisModule().'/help/c.main.php';
			$this->addHelp($help,'',400);
			break;

		case 'category_add':
			require 'admin/category.add.php';
			include modulePath.$this->thisModule().'/help/c.add.php';
			$this->addHelp($help,'',400);
			break;

		case 'category_edit':
			require 'admin/category.edit.php';
			include modulePath.$this->thisModule().'/help/c.edit.php';
			$this->addHelp($help,'',400);
			break;

		case 'comments':
			require 'admin/comment.php';
			include modulePath.$this->thisModule().'/help/main_comment.php';
			$this->addHelp($help,'',400);
			break;

		default:

			break;
	}
}
?>

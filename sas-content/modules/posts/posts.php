<?php if(!defined('basePath')) exit('No direct script access allowed');

$categoryID = $this->db->getOne("select category_id from ".$this->table_prefix."pages where page_id='".$this->thisPageID()."'");

if($categoryID!=0){

	switch($this->uri(1)){

		case 'read':
			include modulePath.$this->thisModule().'/posts.detail.php';
			break;

		default:

			$categoryName 	= $this->db->getOne("select category_name from ".$this->table_prefix."category where category_id='".$categoryID."'");
			$shoPerPage 	= 5;
			$query 			= "select post_id from ".$this->table_prefix."posts where (post_category='".$categoryID."' or post_category_main_parent='".$this->getCatMainParent($categoryID)."') and publish='1' order by post_id desc";
			$posts			= new stdClass;

			$this->data->init($query,$shoPerPage);
			$posts->data 		= $this->data->arrData();
			$posts->pagination  = $this->data->getNav();

			if(isFileExist($this->themePath(),'post.php')){
				include $this->themePath().'post.php';
			}
			else{
				include modulePath.$this->thisModule().'/posts.category.php';
			}
			break;
	}
}
else{

	switch($this->getSwitch()){

		case 'read':
			include modulePath.$this->thisModule().'/posts.detail.php';
			break;

		default:
			$this->_404();
			break;
	}
}
?>

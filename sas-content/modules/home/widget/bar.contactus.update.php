<?php if(!defined('basePath')) exit('No direct script access allowed');

$this->db->execute("update ".$this->table_prefix."contact set isread=1 where contact_id='".intval($_POST['id'])."'");
?>

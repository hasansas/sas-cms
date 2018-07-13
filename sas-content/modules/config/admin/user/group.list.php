<?php if (!defined('basePath')) exit('No direct script access allowed');

$adminSessId = $this->session('admin');
$groupSessId = $adminSessId['group_id'];

$taqblename = $this->table_prefix.'user_group';
$sqlCond	= $groupSessId!=1?" where group_id<>1":"";
$query		= 'select * from '.$taqblename.$sqlCond;
$link		= $this->adminUrl().'permission'.$this->permalink();
$data 		= array(

	'Name' 		 => 'name.inputText..align="left"',
	'Permission' => 'access.custom.permissionLink.width="150"'
);

function permissionLink($data,$params){

	$permissionLink = $params['adminURL'].'permission/'.$data['group_id'].'/'.seo_slug($data['name']).$params['permalink'];
	$permissionLink = '<a href="'.$permissionLink.'">Set Permission</a>';
	return $permissionLink;
}

$this->data->addSearch('name');
$this->data->init($query);

echo $this->data->getPage($taqblename,'group_id',$data,$deleteButton=false,$savebutton=true,$formName='form',$addHtml='',$static=true);
?>

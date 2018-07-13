<?php if (!defined('basePath')) exit('No direct script access allowed');

$tablename  = $this->table_prefix.'banner';
$query		= 'select * from '.$tablename.' where banner_position =\''.$getPosition.'\' order by banner_order';
$data 		= array(


	'Banner'	=> 'banner_image.custom.getImage.align="left".width="100"',
	'Title' 	=> 'banner_title.text..align="left"',
	'Order'		=> 'banner_order.inputText..width="20".class="input-order"',
	'Position'  => 'banner_position.select.addOption(top => Top, bottom => Bottom, right => Right).width="70".width="70"',
	'Publish'	=> 'publish.switchcheck..width="60".align="center"',
	'Edit'		=> 'id.edit.'.$editUrl
);

function getImage($data,$params){

	$image 	  = empty($data['banner_image'])?'noimage.jpg':$data['banner_image'];
	$imgUrl	  = uploadURL.'modules/banner/thumbs/mini/'.$image;
	$getImage = '<div class="image-holder"><img src="'.$imgUrl.'"/><span></span></div>';

	return $getImage;
}

$this->data->addSearch('banner_title');
$this->data->removeImage('banner_image','modules/banner/');
$this->data->init($query,10,5);
$this->data->getPage($tablename,'banner_id',$data);
?>

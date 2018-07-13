<?php if (!defined('basePath')) exit('No direct script access allowed');

$error		= true;
$alertMsg	= '';
$tableName  = $this->table_prefix."banner";
$uploadPath = uploadPath.'modules/banner/';
$position 	= @$this->session('banner_position');
$position 	= empty($position)?'top':$position;
$postCount  = count(@$_POST['post']['image']);

if($postCount>0){

	for($i=0;$i<$postCount;$i++){

		$title 	  = @$_POST['post']['title'][$i];
		$link  	  = @$_POST['post']['url'][$i];
		$image 	  = @$_POST['post']['image'][$i];
		
		$addQuery = "insert into ".$tableName." set banner_title='".$title."', banner_link='".$link."', banner_image='".$image."', banner_position='".$position."', publish='1'";
		
		if($this->db->execute($addQuery)){
			
			$error 	  	= false;
			$extension	= $ext = pathinfo($image, PATHINFO_EXTENSION);
			
			create_thumb(tmpPath.$image,$uploadPath.$image,$setWidth=1000,$extension)?0:1;
			
			//create_thumb(tmpPath.$image,$uploadPath.'thumbs/'.$image,$setWidth=100,$extension)?0:1;
			$moveFile = tmpPath.$image;
			$thumbPath = $uploadPath.'thumbs/';
			$thumbPathMini = $thumbPath.'mini/';
			$thumbPathSmall = $thumbPath.'small/';
			$thumbPathMedium = $thumbPath.'medium/';
			$thumbPathLarge = $thumbPath.'large/';
			
			//if(!empty($uploadPath.$image)){
				if (!file_exists($thumbPath.'mini/')) {		mkdir($thumbPath.'mini', 0777);}
				if (!file_exists($thumbPath.'small/')) {	mkdir($thumbPath.'small', 0777);}
				if (!file_exists($thumbPath.'medium/')) {	mkdir($thumbPath.'medium', 0777);}
				if (!file_exists($thumbPath.'large/')) {	mkdir($thumbPath.'large', 0777);}
				
				//create_thumb(tmpPath.$image,$uploadPath.'thumbs/'.$image,$setWidth=100,$extension)?0:1;
				create_thumb($moveFile,$thumbPathMini.$image,$setWidth=$this->thumbnail('mini'),$extension)?0:1; // mini
				create_thumb($moveFile,$thumbPathSmall.$image,$setWidth=$this->thumbnail('small'),$extension)?0:1; // small
				create_thumb($moveFile,$thumbPathMedium.$image,$setWidth=$this->thumbnail('medium'),$extension)?0:1; // medium
				create_thumb($moveFile,$thumbPathLarge.$image,$setWidth=$this->thumbnail('large'),$extension)?0:1; // large
			//}
			
			/*			
			if(copy(tmpPath.$image,$uploadPath.$image)){
			
			
				$alertMsg = $this->form->alert('success','New banner added');
			}
			else{
				$alertMsg = $this->form->alert('warning','Unable to upload  to FTP server '.$uploadPath);
			}
			*/			
		}
		else{
			$alertMsg = $this->form->alert('error','Unable to add new banner, please try again later.');
		}
	}
	clearTemp(tmpPath);
}
else{
	$alertMsg = $this->form->alert('warning','No file uploaded.');
}

$response = array(
	
	'error' 	=> $error,
	'alertMsg' 	=> $alertMsg
);

echo json_encode($response);
?>
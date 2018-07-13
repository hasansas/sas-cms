<?php if (!defined('basePath')) exit('No direct script access allowed');

$breadcrumbImg 	= uploadURL.'/modules/siteconfig/'.$this->site->defaultImage();
$pageTitle		= $this->PageTitle();
$tagline		= $this->pageTagline();
$mobileClass	= '';
if($this->device->isMobile() && $this->thisModule()=='book' && !is_numeric($this->uri(2))){
	$mobileClass = ' mobile';
}
$classBanner	= 'page-banner'.@$mobileClass ;

// if($this->thisModule()=='posts'){
//
// 	if(is_numeric($this->uri(2))){
// 		$xSection 		= $this->db->getRow("
// 		select
// 			c.category_name, c.category_image from ".$this->table_prefix."category c
// 		left join ".$this->table_prefix."posts p
// 			on(c.category_id=p.post_category)
// 		where
// 			p.post_id='". $this->uri(2) ."'
// 		");
// 		$pageTitle		= $xSection['category_name'];
// 		$breadcrumbImg 	= @getimagesize(uploadPath.'modules/category/thumbs/mini/'.$xSection['category_image'])?uploadURL.'modules/category/'.$xSection['category_image']:$breadcrumbImg;
// 	}
// }
?>

<div class="<?php echo $classBanner; ?>" style="background-image:url(<?php echo $breadcrumbImg; ?>);">
	<div class="page-banner-wrapper">
		<div class="container">
			<div class="page-banner-body">
				<?php
				if($this->thisModule()=='book' && !is_numeric($this->uri(2))){
					$this->getWidget('search');
				}else{
					echo '<h1 class=" text-center">'.$pageTitle.'</h1>';
				}
				?>
			</div>
		</div>
	</div>
</div>

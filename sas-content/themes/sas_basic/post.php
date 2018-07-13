<?php if (!defined('basePath')) exit('No direct script access allowed');

$postList = '';

if(count($posts->data)>0){

	foreach($posts->data as $dataPost){

		$post = $this->post->getRow($dataPost['post_id']);
		$imgThumb = '';
		if(list($width, $height) = @getimagesize(uploadPath.'modules/posts/thumbs/mini/'.$post->image)){
            if($width > $height){
                $imgSize = 'landscape';
            }
            elseif($width < $height){
                $imgSize = 'potrait';
            }
            $imageURL = !$this->device->isMobile()?$post->imageUrlMedium:$post->imageUrlSmall;
            $imgThumb = '
				<div class="product-thumbnail">
					<div class="square ratio16_9">
						<div class="square-content">
							<div class="img-wrap default">
								<figure class="effect-bubba">
									<img src="'.$post->imageURL.'" class="'.@$imgSize.'" alt="">
									<a href="'.$post->url.'">
										<figcaption>
											<span class="icon-view"><i class="lnr lnr-magnifier"></i><span>
										</figcaption>
									</a>
								</figure>
							</div>
						</div>
					</div>
				</div>
			';
        }

		$postList .= '

		<div class="post-item">
			'.$imgThumb.'
			<h2 class="post-title"><a href="'.$post->url.'">'.$post->title.'</a></h2>
			<ul class="post-meta">
				<li>Oleh : '.$post->author .'</li>
				<li>'.get_date($post->published,$this->lang('month'),$this->lang('day'),$setDay=false,$setTime=true).' WIB</li>
			</ul>
			<div class="post-content">
				'.substr(strip_tags($post->content),0,250).' ...
			</div>
		</div>
		';
	}
}
?>

<?php echo $postList; ?>
<div class="page-nav text-left"><?=$this->data->getNav();?></div>

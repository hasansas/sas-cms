<?php if (!defined('basePath')) exit('No direct script access allowed');

$rsTrending = $this->db->getAll("select post_id from ".$this->table_prefix."posts where publish='1' order by post_id desc limit 0,5");
$trendingList = '';

foreach($rsTrending as $v){

  $tPost = $this->post->getRow($v['post_id']);
  $getImage	= '';

  list($width, $height) = @getimagesize(uploadPath.'modules/posts/thumbs/mini/'.$tPost->image);
  if($width > $height){
    $imgSize = 'landscape';
  }
  elseif($width < $height){
    $imgSize = 'potrait';
  }

if(@getimagesize(uploadPath.'modules/posts/thumbs/mini/'.$tPost->image)){
	$getImage = '
      <div class="square">
        <div class="square-content">
          <div class="img-wrap default">
            <figure class="effect-bubba">
              <img src="'.$tPost->imageUrlMini.'" class="'.@$imgSize.'">
            </figure>
          </div>
        </div>
      </div>
    ';
}
else{
	$getImage = '
      <div class="square">
        <div class="square-content">
          <div class="img-wrap default">
            <figure class="effect-bubba"></figure>
          </div>
        </div>
      </div>
    ';
}


  $trendingList .= '
    <div class="post-list-sm">
      <div class="media">
        <div class="media-left">
          <a href="'.$tPost->url.'">
            '.$getImage.'
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading"><a href="'.$tPost->url.'">'.$tPost->title.'</a></h4>
        </div>
      </div>
    </div>
  ';
}
?>

<div class="widget-right">
  <div class="panel">
    <div class="panel-heading">
      Latest Blog
    </div>
    <div class="panel-body">
      <?php echo $trendingList ;?>
    </div>
  </div>
</div>

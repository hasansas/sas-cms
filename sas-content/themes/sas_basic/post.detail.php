<?php if (!defined('basePath')) exit('No direct script access allowed');

$publishDate  = strtotime($post->published);
$publishDay   = date("d", $publishDate);
$publishMonth = date("M", $publishDate);
?>

<div class="post-detail">
	<h2 class="post-title"><a href="<?php echo $post->url?>"><?php echo $post->title?></a></h2>
	<ul class="post-meta">
		<li>Oleh : <?php echo $post->author ?></li>
		<li><?php echo get_date($post->published,$this->lang('month'),$this->lang('day'),$setDay=false,$setTime=true)?> WIB</li>
	</ul>
	<div class="img-main">
		<img alt="" class="propotion-image" src="<?php echo $post->imageURL; ?>">
	</div>
	<div class="post-content">
		<?php echo nl2br($post->content); ?>
	</div>
	<div class="social-share">
		<div class="pull-right">
			<?php echo simpleShare(); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="comment-wrapper">
	<h3 class="comment-heading"><i class="fa fa-comment-o"></i><span>Tinggalkan komentar</span></h3>
	<div class="comment-list"><?=$this->post->comment($post->id);?></div>
</div>

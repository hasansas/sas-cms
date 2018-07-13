<?php if (!defined('basePath')) exit('No direct script access allowed');

$manImage = '';
if(!empty($page->image)){
	$manImage = '<div class="img-main"><img src="' . $page->image . '"></div>';
}
?>
<section>		
	<div class="container">
		<div class="post-detail">
			<?php echo $manImage ;?>
			<?php echo $page->content ;?>
		</div>
	</div>
</section>

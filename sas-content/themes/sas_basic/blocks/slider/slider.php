<?php if (!defined('basePath')) exit('No direct script access allowed');
$sliderLength = 0;
$indicators = '';
foreach($slider->items as $xslider){

	if(isFileExist(uploadPath.'modules/slider/',$xslider['image'])){

		$itemActive  = $sliderLength==0?' active':'';
		$itemTitle 	 = !empty($xslider['title'])?'<h2 class="title">'.$xslider['title'].'</h2>':'';
		$itemTagline = !empty($xslider['description'])?'<p class="info">'.$xslider['description'].'</p>':'';
		$itemButton	 = !empty($xslider['url'])&&!empty($xslider['btn_caption'])?'<p class="button"><a class="btn btn-lg btn-default" href="'.$xslider['url'].'" role="button">'.$xslider['btn_caption'].'</a></p>':'';
		@$getSlider .= '

			<div class="carousel-item '.$itemActive.'" style="background-image: url(\''.$slider->url.$xslider['image'].'\')">
				<div class="carousel-caption d-none d-md-block">
					<div class="container">
						'.$itemTitle .'
						'.$itemTagline .'
					</div>
				</div>
			</div>
		';
		$indicators .= '<li data-target="#slider" data-slide-to="'.$sliderLength.'" class="'.$itemActive.'"></li>';
		$sliderLength++;
	}
}
$sliderIndicators 	= count($slider->items)>1?'<ol class="carousel-indicators">'.$indicators.'</ol>':'';
$sliderControl 		= count($slider->items)>1?'<a class="left carousel-control" href="#slider" data-slide="prev"><i class="fa fa-angle-left"></i></a><a class="right carousel-control" href="#slider" data-slide="next"><i class="fa fa-angle-right"></i></a>':'';
$sliderProgress 	= count($slider->items)>1?'<div class="carousel-progress"><span class="carousel-bar" style="width: 43%;"></span></div>':'';
?>

<!-- Carousel
================================================== -->
<div id="slider" class="carousel slide" data-ride="carousel">
	<?php echo $sliderIndicators ?>
	<div class="carousel-inner" role="listbox">
		<?php echo $getSlider ?>
	</div>
	<!--
	<a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#slider" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
	 -->
</div>

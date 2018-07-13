<?php if (!defined('basePath')) exit('No direct script access allowed');

$tableName	= $this->table_prefix.'posts';
$fTitle   	= $this->site->isMultiLang()?'post_title_'.$this->active_lang():'post_title';
$shoPerPage = 3;
$query		= "select post_id,".$fTitle.",publish from ".$tableName." where publish='1' and post_type='post' order by post_id desc";
$posts		= new stdClass;
$latestBlog	= '';

$this->data->init($query,$shoPerPage);
$posts->data 		= $this->data->arrData();
$posts->pagination  = $this->data->getNav();

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
            $imgThumb = '<img src="'.$imageURL.'" alt="" class="'.$imgSize.'"/>';
        }
        $latestBlog .= '

        <div class="col-md-4">
            <div class="post-item">
                <div class="square ratio4_3">
                    <div class="square-content">
                        <div class="img-wrap default">
                            <figure class="effect-bubba">
                                '.$imgThumb.'
                                <a href="'.$post->url.'">
                                    <figcaption>
                                        <span class="icon-view"><i class="lnr lnr-magnifier"></i><span>
                                    </figcaption>
                                </a>
                            </figure>
                        </div>
                    </div>
                </div>
                <h4 class="post-title"><a href="'.$post->url.'">'.$post->title.'</a></h4>
            </div>
        </div>

        ';
    }
    ?>
    <section class="section-package">
        <div class="container">

            <!-- Start Big Heading -->
            <h2 class="heading text-center">Latest From Blog</h2>
            <!-- End Big Heading -->

            <div class="row">
               <?php echo $latestBlog; ?>
            </div>
        </div>
    </section>
    <?php
    }
?>

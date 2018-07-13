<?php if(!defined('basePath')) exit('No direct script access allowed');

$keyword    = urldecode($this->_GET('k'));
$arrKeyword = explode(' ',$keyword);
$addKeyword	= '';
$fTitle   	= $this->site->isMultiLang()?'post_title_'.$this->active_lang():'post_title';
foreach($arrKeyword as $v){
	$addKeyword .= "or ".$fTitle." like ('%".$v."%') ";
}
$addKeyword = substr($addKeyword,0,-1);
$shoPerPage = 12;
$query 		= "select post_id from ".$this->table_prefix."posts where (".$fTitle." like '%".$keyword."%' ".$addKeyword.") and publish='1' order by post_id desc";
$result		= $this->db->execute($query);
$postList	= '';

$this->data->init($query,$shoPerPage);
foreach($this->data->arrData() as $dataPost){

	$post = $this->post->getRow($dataPost['post_id']);

	$postList .= '
		<li>
			<h2 class="post-title"><a href="'.$post->url.'">'.$post->title.'</a></h2>
			<div class="entry-meta">
				<div class="post-date">'.date_indo($post->published,true,true).'</div>
				<div class="author">Reporter  '.$post->author.'</div>
			</div>
			<div class="post-content">'.$post->smallContent.'</div>
			<hr/>
		</li>
	';
}

$postList = '<ul>'.$postList.'</ul>';

if(isFileExist($this->themePath(),'search.php')){
	include $this->themePath().'search.php';
}
else{
	?>
	<div class="widget widget-default">
		<div class="widget-head">Hasil pencarian - <span><?=$keyword?></span></div>
		<div class="widget-body">
			<div class="widget-content">
				<div class="post">
					<div class="post-content">
						<?php
						if($result->recordCount()>0){
							?>
							<div class="post-content">
								<?=$postList?>
							</div>
							<?php
						}
						else{
							?>
							<div class="not_found">
								<p>Your search  returned <strong>no results</strong>. Seems one or more of queries doesn't match your search. Please change them and try again.
								<br><br>
								<font class="nf_plus">+</font> Your query must be at least 3 letters long.<br>
								<font class="nf_plus">+</font> Make sure you spelled it right. 90% of all errors are wrong spelling.<br>
								<font class="nf_plus">+</font> Probably, we don't have what you're looking for
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="page-nav"><?=$this->data->getNav();?></div>
			</div>
		</div>
	</div>
	<?php
	}
?>

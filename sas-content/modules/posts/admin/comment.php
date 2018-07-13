<? if (!defined('basePath')) exit('No direct script access allowed');

$tableName 	= $this->table_prefix.'comments';
$query 		= "select * from ".$tableName." order by comment_id desc";

$data 		= array(

	'From' 		 	=> 'comment_from.text',
	'Comment on' 	=> 'comment_post.custom.getPost',
	'Comment'	 	=> 'comment_content.text',
	'Comment Date' 	=> 'comment_date.custom.getcDate',
	'Publish'	 	=> 'publish.switchcheck..width="70".align="center"',
	'Delete'	 	=> 'id.delete'
);

$this->data->addSearch('comment_from');
$this->data->init($query,10,2);

function getPost($data){

	global $system;
	if($data['comment_type']=='post'){
		$postitile	= $system->site->isMultiLang()?'post_title_'.$system->active_lang():'post_title';
		$getPost = $system->db->getOne("select ".$postitile." as post_title from ".$system->table_prefix."posts where post_id='".$data['comment_post']."'");
	}
	elseif($data['comment_type']=='book'){
		$getPost = $system->db->getOne("select title from ".$system->table_prefix."book where book_id='".$data['comment_post']."'");
	}
	return htmlspecialchars_decode(html_entity_decode($getPost));
}

function getcDate($data,$params){

	$getcDate = date_indo($data['comment_date']);
	return $getcDate;
}
?>

<div class="box">
	<div class="box-header with-border">
		<div class="widget-header">
		</div>
	</div>
	<div class="box-body">
		<div class="widget-main">
			<?$this->data->getPage($tableName,'comment_id',$data,$deleteButton=true,$savebutton=true);?>
		</div>
	</div>
</div>

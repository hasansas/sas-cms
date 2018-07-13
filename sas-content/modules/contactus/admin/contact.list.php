<?if (!defined('basePath')) exit('No direct script access allowed');

$taqblename = $this->table_prefix.'contact';
$contacType = 'contact';
$query		= 'select * from '.$taqblename.' where contact_type=\''.$contacType.'\' order by contact_id desc';

$data 		= array(

	'Contact&nbsp;Name'	=> 'contact_name.text..align="left"',
	'Contact Email'	  	=> 'contact_email.text..align="left"',
	'Contact Message' 	=> 'contact_message.text..align="left"',
	'Date'						=> 'contact_date.custom.contactDate.width="200" align="left"',
	'Status' 		  	=> 'contact_reply.custom.setStatus.width="80"',
	'View' 					=> 'isread.custom.read..align="center"',
	'Replay'  		  	=> 'id.reply.reply-contact',
	'Delete'		  	=> 'id.delete'
);

function setStatus($data){

	$status = $data['contact_reply']=='1'?'<span class="label label-info arrowed">Replied</span>':'<span class="label label-warning arrowed">Not replied</span>';
	return $status;
}
function contactDate($data){

	$contactDate = date_indo($data['contact_date'],$setDay=false,$setTime=false);
	return $contactDate;
}
function read($data){

	$cClass = 'text-red';
	if($data['isread']=='1'){$cClass = 'text-green';}
	$xIcon  = $data['isread']=='1'?'<span class="'.$cClass.'"><i class="fa fa-eye"></i></span>':'<span class="'.$cClass.'"><i class="fa fa-eye-slash"></i></span>';
	return $xIcon;
}

$this->data->addSearch('contact_name,contact_email');
$this->data->init($query);
?>
<div class="box">
	<div class="box-header with-border">
		<div class="widget-header"></div>
	</div>
	<?$this->data->getPage($taqblename,'contact_id',$data,$saveButton=true,$deleteButton=false);?>
</div>

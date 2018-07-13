<?php if (!defined('basePath')) exit('No direct script access allowed');

$upload_path = tmpURL;
?>

<script type="text/javascript" src="<?=systemURL?>plugins/js/upload.file.js"></script>
<script type="text/javascript">

	function hidemsg(){	
		$("#msg").fadeOut("slow");
	}
	function ajaxFileUpload()
	{	
		var xxx 	 = $("#file").val();
		
		$('.timeline-wrap').show();
		$(".uploading").ajaxStart(function(){
			$('#slider_upload').show();
			$(this).show();
			$(this).html(
				'<div class="progress-container">'+
				'<span class="info">'+xxx+'</span>'+
				'<div class="progress progress-warning progress-small progress-striped active">'+
					'<div class="bar"></div>'+
				'</div>'+
				'</div>'
			);
			})
			.ajaxComplete(function(){
			$(this).hide();			
		});
		
		$.ajaxFileUpload
		(
			{
				type: 'POST',
				url: '<?=baseURL?>system/upload/image',
				secureuri:false,
				fileElementId:'file',
				data: $.param({nama:"nama"}),
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{				
							$('#slider_upload').prepend(
								'<li id="row_'+data.id+'">'+
									'<div class="timeline-new">'+
										'<span class="info">'+data.name+'</span>'+
										'<span class="error">'+data.error+'</span>'+
										'<div style="clear:both;"></div>'+
									'</div>'+								
								'</li>'
							);
						}else
						{						
							/* Update Timeline */
							$('#slider_upload').prepend(
								'<li id="row_'+data.id+'">'+
									'<div class="timeline-new">'+
										'<div class="image-holder"><img id="image-'+data.id+'" align="left" src="<?=$upload_path;?>'+data.fileName+'" width="30" height="30"></div>'+
										'<span class="info">'+data.name+'</span>'+
										'<a id="show-'+data.id+'" class="slide" href="javascript:void(0)" onclick="$(\'#image-'+data.id+'\').fadeOut();$(\'#detail-'+data.id+'\').slideDown(\'slow\',function(){$(\'#show-'+data.id+'\').css({display:\'none\'});$(\'#hide-'+data.id+'\').css({display:\'block\'})});return false;">Detail</a>'+
										'<a id="hide-'+data.id+'" class="slide hidden" href="javascript:void(0)" onclick="$(\'#image-'+data.id+'\').fadeIn();$(\'#detail-'+data.id+'\').slideUp(\'slow\',function(){$(\'#hide-'+data.id+'\').css({display:\'none\'});$(\'#show-'+data.id+'\').css({display:\'block\'})});return false;">Hide</a>'+
										'<div style="clear:both;"></div>'+
									'</div>'+								
									'<div id="detail-'+data.id+'" class="detail">'+
									'<table width="100%">'+
										'<tr valign="top">'+
											'<td id="thumbnail-head-'+data.id+'" class="A1B1" width="170">'+
												'<img alt="" src="<?=$upload_path;?>'+data.fileName+'" width="150" class="thumbnail">'+
											'</td>'+
											'<td>'+											
												'<div class="input-wrapper">'+
													'<div class="input2">'+
														'<label>Title</label>'+
														'<div class="input-prepend">'+
														'<span class="add-on"><i class="icon-pencil"></i></span>'+
														'<input type="text" name="post[title][]">'+
														'</div>'+
														'<div class="clearfix"></div>'+
													'</div>'+													
													'<div class="input2">'+
														'<label>Link Url</label>'+
														'<div class="input-prepend">'+
														'<span class="add-on"><i class="icon-cloud"></i></span>'+
														'<input type="text" name="post[url][]">'+
														'</div>'+
														'<div class="clearfix"></div>'+
													'</div>'+
												'</div>'+
												'<input type="hidden" name="post[image][]" value="'+data.fileName+'">'+
												'<div class="delete-wrap">'+
													'<a onclick="this.style.display=\'none\';$(\'#del_attachment_'+data.id+'\').css({display:\'block\'});" class="del-link" id="del_'+data.id+'" href="javascript:void(0)">Delete</a>'+
													'<div class="del-attachment" id="del_attachment_'+data.id+'" style="display:none;">'+
														'You are about to delete <span class="delname">'+data.name+'</span>.'+		
														'<a class="button delete" id="'+data.id+'" alt="'+data.fileName+'" href="javascript:void(0)">Continue</a>'+										
														'<a onclick="this.parentNode.style.display=\'none\';$(\'#del_'+data.id+'\').css({display:\'block\'});return false;" class="button" href="javascript:void(0)">Cancel</a>'+
													'</div>'+
												'</div>'+												
											'</td>'+
										'</tr>'+
									'</table>'+
									'</div>'+
								'</li>'
							);
						}
					}
					$("input:file").val("");
				},
				error: function (data, status, e)
				{
					alert(e);
					$("input:file").val("");
				}
			}
		)		
		return false;
	}


	/*---------------------------------------------------
	Delete Timeline
	----------------------------------------------------*/

	$('.delete').live("click",function() 
	{
		var item = $(this);
			
		$("#row_"+item.attr("id")).slideUp('slow', function() {$(this).remove();});
		var xtimeline = $('#slider_upload li').length;
		if(xtimeline==1){
			$('.timeline-wrap').hide();
		}		
		
		return false;
	});


	/*---------------------------------------------------
	Save all changes
	----------------------------------------------------*/
	
	var ajaxFile   = ajaxURL+"<?=modulePath?>banner/admin/banner.update.php";
	
	$('#formAddNew').live("submit",function() 
	{	
		$.ajax({
			type: 'POST',
			url: ajaxFile,
			data: $(this).serialize(),
			dataType: 'json',
			success: function(data){
				if(data.error){
					$(".alert-message").html(data.alertMsg);
				}
				else{
					window.location="<?=$this->adminUrl()?>banners<?=$this->permalink()?>";
				}
			}
		})
		return false;
	});
</script>
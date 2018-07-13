<?php if(!defined('basePath')) exit('No direct script access allowed'); ?>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-contact-detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Message Detail</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Date</label>
					<div id="contact-date">&nbsp;</div>
				</div>
				<div class="form-group">
					<label>From</label>
					<div id="contact-name">&nbsp;</div>
				</div>
				<div class="form-group">
					<label>Email</label>
					<div id="contact-email">&nbsp;</div>
				</div>
				<div class="form-group">
					<label>Message</label>
					<div id="contact-message">&nbsp;</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- bootstrap/app scripts -->
<?php echo $this->load_js($this->themeURL().'assets/js/bootstrap.min.js');?>
<?php echo $this->load_js($this->themeURL().'assets/js/app.js');?>

<!-- plugin scripts -->
<script src="<?=$this->themeURL()?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?=$this->themeURL()?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?=$this->themeURL()?>assets/js/date-time/moment.js"></script>
<script src="<?=$this->themeURL()?>assets/js/date-time/daterangepicker.js"></script>
<script src="<?=$this->themeURL()?>assets/js/date-time/bootstrap-datetimepicker.js"></script>
<script src="<?=$this->themeURL()?>assets/js/bootstrap-colorpicker.js"></script>
<script src="<?=$this->themeURL()?>assets/js/jquery.dataTables.js"></script>
<script src="<?=$this->themeURL()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<script src="<?=$this->themeURL()?>assets/js/jquery.nestable.js"></script>
<script src="<?=$this->themeURL()?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?=$this->themeURL()?>assets/js/select2.full.min.js"></script>

<!-- Flot scripts -->
<script src="<?=$this->themeURL()?>assets/js/flot/jquery.flot.js"></script>
<script src="<?=$this->themeURL()?>assets/js/flot/jquery.flot.pie.js"></script>
<script src="<?=$this->themeURL()?>assets/js/flot/jquery.flot.resize.js"></script>

<!-- Cookie scripts -->
<?php echo $this->load_js(systemURL.'plugins/js/jquery.cookie.min.js');?>

<script type="text/javascript">
	jQuery(function($) {

		/* Active menu */
		var thisMenuId 	 = '<?=$this->thisMenuID()?>';
		var parentId 	 = '<?=$this->getParentID($this->thisMenuID())?>';
		var mainParentId = '<?=$this->mainParentID()?>';

		if($("#m"+mainParentId).data('child')=='haschild'){
			$("#m"+mainParentId).addClass("open active");
		}
		if($("#m"+parentId).data('child')=='haschild'){
			$("#m"+parentId).addClass("open active");
		}
		$("#m"+thisMenuId).addClass("active");

		/* tooltip */
		$('[data-toggle="tooltip"]').tooltip();

		/* th check all */
		$('table th input:checkbox').on('click' , function(){
			var that = this;
			$(this).closest('table').find('tr > td:first-child input:checkbox')
			.each(function(){
				this.checked = that.checked;
				$(this).closest('tr').toggleClass('selected');
			});
		});

		/* Styling select */
		$(".select2").select2();

		/* datepicker */
		$(".date-picker").datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true
		})
		.next().on('click', function(){
			$(this).prev().focus();
		});

		/* date time picker */
		$('.date-timepicker').datetimepicker({
			use24hours: true,
			format: 'YYYY-MM-DD HH:mm:ss'
		}).next().on('click', function(){
			$(this).prev().focus();
		});

		/* timepicker */
		$('.time-picker').timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		}).next().on('click', function(){
			$(this).prev().focus();
		});

		//date range picker
		$('.date-range-picker').daterangepicker({
			'applyClass' : 'btn-sm btn-success',
			'cancelClass' : 'btn-sm btn-default',
			locale: {
				applyLabel: 'Apply',
				cancelLabel: 'Cancel',
			}
		}).next().on('click', function(){
			$(this).prev().focus();
		});

		/* color picker */
		$('.color-picker').colorpicker().on('changeColor', function(ev){
			$(this).next().children().css('background',ev.color.toHex())
		})
		.next().on('click', function(){
			$(this).prev().focus();
		});

		/* Input icon */
		$('.fa-icon').click(function(){

			var icon   = $(this).data('icon');
			var iconId = $(this).data('id');

			$('#icon'+iconId).removeAttr('class');
			$('#icon'+iconId).addClass('fa '+icon);
			$('#input-icon'+iconId).val('fa '+icon);
			$('#modal-'+iconId).modal('hide');
		});

		/* change admin skin */
		$('.btn-skin').click(function(){

			var skin = $(this).data('id');

			// Set time
			var expiryDate = new Date();
			var hours = 168;
			expiryDate.setTime(expiryDate.getTime() + (hours * 3600 * 1000));

			var oldSkin = $.cookie('adminSkin');
			$("body").removeClass(oldSkin);

			// Create cookie to expire in 168 hours (1 week)
			$.cookie("adminSkin", skin, { path: '/', expires: expiryDate });
			$("body").addClass(skin);

			return false;
		});

		/*---------------------------------------------------
		Switcher
		----------------------------------------------------*/
		$('#ace-settings-btn').click(function(){

			if($(this).parent().hasClass('open')){
				$(this).parent().removeClass('open');
			}
			else{
				$(this).parent().addClass('open');
			}
			return false;
		});
		$('.btn-color-switcher').click(function(){

			skinStyle = $(this).data('skin');
			$.cookie('skin', skinStyle, { expires: 7 });
			$('.skin-style').attr('href','assets/css/'+$.cookie('skin')+'.css');
		});
		if($.cookie('skin')){
			skinStyle = $.cookie('skin');
		}
		else{
			skinStyle = 'skin1';
		}
		$('.skin-style').attr('href','assets/css/'+skinStyle+'.css');

		/*---------------------------------------------------
		Contact bar
		----------------------------------------------------*/
		getMessage();
		function getMessage(){

			var xajaxFile = ajaxURL+"sas-content/modules/home/widget/bar.contactus.getmessage.php";

			$.ajax({

				type: 'POST',
				url: xajaxFile,
				dataType: 'json',
				success: function(data){

					$('.badge-total-contact').html(data.xMessage);
					$('.new-message').html(data.totalMessage);
					$('.contanct-see-all').attr('href',data.contatUrl);
					$('#messages').html(data.getMessageList);
				}
			});
		};

		$(document).on('click','.btn-contact-detail',function(){

			var messageID = ($(this).data('id'));
			var name = ($(this).data('name'));
			var email = ($(this).data('email'));
			var message = ($(this).data('message'));
			var xDate = ($(this).data('date'));

			var xajaxFile = ajaxURL+"sas-content/modules/home/widget/bar.contactus.update.php";

			$.ajax({

				type: 'POST',
				url: xajaxFile,
				data: {id:messageID},
				dataType: 'json',
				success: function(data){

				}
			});

			getMessage();
			$('#contact-date').html(xDate);
			$('#contact-name').html(name);
			$('#contact-email').html('<a href="mailto:'+email+'">'+email+'</a>');
			$('#contact-message').html(message);
			$('#modal-contact-detail').modal();

			return false;
		});

		$('#modal-contact-detail').on('hidden.bs.modal', function () {
			$('#message-list').addClass('open');
		});
	})
</script>
</body>
</html>

jQuery.noConflict();
jQuery(document).ready(function($){

	/*---------------------------------------------------
	Tooltip
	----------------------------------------------------*/
	$('[rel="tooltip"]').tooltip();

	/*---------------------------------------------------
	Remove li scpace(display: inline)
	----------------------------------------------------*/
	$('ul').contents().filter(function() { return this.nodeType === 3; }).remove();

	/*---------------------------------------------------
	Styling select
	----------------------------------------------------*/
	$(".select2").select2();
	$(window).on('resize', function() {
	    $('.input-group').each(function() {
	        var formGroup = $(this),
	            formgroupWidth = formGroup.outerWidth();

	        formGroup.find('.select2-container').css('width', formgroupWidth);

	    });
	});
	/*---------------------------------------------------
	Tab
	----------------------------------------------------*/
	$('.navtabs a').click(function(){
		$(this).tab('show');
		return false;
	});

	/*---------------------------------------------------
	Fixed menu
	----------------------------------------------------*/
	if($(window).width() > 765){

		var navbarHeight = $('.navbar').height();
		if ($(this).scrollTop() > navbarHeight) {
			$('#navbar-trasparent').addClass('navbar-light');
		}
		else {
			$('#navbar-trasparent').removeClass('navbar-light');
		}
	}
	$(window).scroll(function(){
		if($(window).width() > 765){

			var navbarHeight = $('.navbar').height();

			if ($(this).scrollTop() > navbarHeight) {
				$('#navbar-trasparent').addClass('navbar-light');
			}
			else {
				$('#navbar-trasparent').removeClass('navbar-light');
			}
		}
	});

	/*---------------------------------------------------
	Slider
	----------------------------------------------------*/
	$('#slider .active').find('h2').addClass('active');
	$('#slider .active').find('.info').addClass('active');
	$('#slider').on('slide.bs.carousel', function () {
		$('#slider').find('h2').removeClass('active');
		$('#slider').find('p').removeClass('active');
	});
	$('#slider').on('slid.bs.carousel', function () {
		$('#slider .active').find('h2').addClass('active');
		$('#slider .active').find('.info').addClass('active');
	});

	/*---------------------------------------------------
	Owl
	----------------------------------------------------*/
	$(".owl-letter").owlCarousel({
		items:6,
		loop:true,
		margin:10,
		responsive:{
			600:{
				items:6
			}
		},
		autoplay:false,
		autoplayTimeout:5000,
		lazyLoad:true,
		nav: true,
		dots: false,
		dotsEach: false,
		navText: ['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>']
	});

	/*---------------------------------------------------
	To top
	----------------------------------------------------*/
	if ($(window).scrollTop() > $(window).height()) {
		$('.back-to-top').fadeIn();
	}
	else{
		$('.back-to-top').fadeOut();
	}

	$(window).scroll(function(){

		if ($(this).scrollTop() > $(this).height()) {
			$('.back-to-top').fadeIn();
		}
		else{
			$('.back-to-top').fadeOut();
		}
	})

	$( window ).resize(function(){

		if ($(this).scrollTop() > $(this).height()) {
			$('.back-to-top').fadeIn();
		}
		else{
			$('.back-to-top').fadeOut();
		}
	})

	$('.back-to-top').click(function() {
		$('body,html').animate({scrollTop:0},300);
		return false;
	});

	/*---------------------------------------------------
	Post Comment
	----------------------------------------------------*/
	$("#frmAddComment").submit(function(){

		var xajaxFile = ajaxURL+"sas-content/modules/posts/post.comment.php";

		$('.msg').html('');
		$('.comment-progress').show();

		$.ajax({

			type: 'POST',
			url: xajaxFile,
			data: $("#frmAddComment").serialize(),
			dataType: 'json',
			success: function(data){

				if(!data.error){

					$(":input","#frmAddComment")
					.not(":button, :submit, :reset, :hidden")
					.val("")
					.removeAttr("checked")
					.removeAttr("selected");
					$('#comment-list').append(data.newComment);
				}
				else{
					$(".msg").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="glyphicon glyphicon-exclamation-sign iconleft" aria-hidden="true"></span> '+data.alert+"</div>");
				}
				$('.comment-progress').hide();
			}
		});
		return false;
	});

	/*---------------------------------------------------
	Contact Us
	----------------------------------------------------*/
	$("#contactForm").submit(function(){

		var xajaxFile = ajaxURL+"sas-content/modules/contactus/act.contactus.php";

		$('.msg-alert').html('');
		$('.spinner').show();

		$.ajax({

			type: 'POST',
			url: xajaxFile,
			data: $("#contactForm").serialize(),
			dataType: 'json',
			success: function(data){

				if(!data.error){

					$(":input","#contactForm")
					.not(":button, :submit, :reset, :hidden")
					.val("")
					.removeAttr("checked")
					.removeAttr("selected");
					Recaptcha.reload();
					$(".msg-alert").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="glyphicon glyphicon-ok-circle iconleft" aria-hidden="true"></span> '+data.alert+"</div>");
				}
				else{
					$(".msg-alert").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="glyphicon glyphicon-exclamation-sign iconleft" aria-hidden="true"></span> '+data.alert+"</div>");
				}
				$('.spinner').hide();
			}
		});
		return false;
	});

	/*---------------------------------------------------
	Stats
	----------------------------------------------------*/
	$(window).load(function(){
		$(this).load(ajaxURL+"sas-content/modules/statistik/callstats.php");
	});

	/*---------------------------------------------------
	newsletter
	----------------------------------------------------*/
	$('#frm-newsletter').submit(function(){
		var xajaxFile = ajaxURL+"sas-content/modules/newsletter/act.subscribe.php";

		$('.newsletter-msg').html('');
		$('.newsletter-progress').show();
		$('.btn-newsletter').attr('disabled','disabled');

		$.ajax({

			type: 'POST',
			url: xajaxFile,
			data: $("#frm-newsletter").serialize(),
			dataType: 'json',
			success: function(data){

				if(!data.error){

					$(":input","#frm-newsletter")
					.not(":button, :submit, :reset, :hidden")
					.val("")
					.removeAttr("checked")
					.removeAttr("selected");
					$(".newsletter-msg").html(data.alert);
				}
				else{
					$(".newsletter-msg").html(data.alert);
				}
				$('.newsletter-progress').hide();
				$('.btn-newsletter').removeAttr('disabled');
				$('#newsletter-modal').modal();
			}

		});
		return false;
	})
});

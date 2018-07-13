<?php if (!defined('basePath')) exit('No direct script access allowed'); ?>

<section class="contact">
	<div class="container">
		<h2 class="heading text-center">Contact <span class="deep-orange">Form</span></h2>
		<form method="post" action="" id="contactForm" class="form-horizontal">
			<div class="msg-alert"><?php echo $errorInsert;?></div>
			<div class="row">
				<?php echo $settings;?>
				<div class="col-sm-12">
					<textarea name="add_contact_message" cols="70" rows="6" class="form-control form-control-lg required" placeholder="Message"><?=@$_POST['add_contact_message'];?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="g-recaptcha" data-sitekey="6Lf6BksUAAAAAFdVbnv77BI01OB0HQA597baONcm"></div>
				</div>
				<div class="col-sm-6">
					<div class="text-right">
						<input type="hidden" value="contact" name="add_contact_type" />
						<button type="submit" name="save" class="btn btn-default btn-lg">
							<span class="label right">Submit</span>
							<span class="spinner" style="display:none">
							    <i class="bounce1"></i>
							    <i class="bounce2"></i>
							    <i class="bounce3"></i>
							</span>
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>

<section class="section-contact">
	<div class="container">
		<h2 class="heading text-center">Contact <span class="deep-orange">Map</span></h2>
		<p class="text-center"><?php echo nl2br(base64_decode($cParams['content'])) ?></p>
	</div>
	<div id="map-canvass"></div>
</section>

<script src='https://www.google.com/recaptcha/api.js'></script>

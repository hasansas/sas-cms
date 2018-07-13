<?php if(!defined('basePath')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
	<?php echo $this->head();?>

	<!-- bootstrap & fontawesome -->
	<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/font-awesome.min.css');?>

	<!-- plugin style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/select2.min.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/datepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap-timepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/daterangepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/bootstrap-datetimepicker.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/colorpicker.css');?>

	<!-- admin style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/AdminLTE.min.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/skins/skin-blue.css');?>

	<!-- flag style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/flag.css');?>

	<!-- custom style -->
	<?php echo $this->load_css($this->themeURL().'assets/css/form.css');?>
	<?php echo $this->load_css($this->themeURL().'assets/css/style.css');?>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="<?php echo $this->themeURL(); ?>assets/js/html5shiv.js"></script>
	<script src="<?php echo $this->themeURL(); ?>assets/js/respond.min.js"></script>
	<![endif]-->
	<?php echo $this->load_js($this->themeURL().'assets/js/jquery-2.2.3.min.js');?>
	<?php echo $this->load_js($this->themeURL().'assets/js/jquery-ui.min.js');?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<?php
			$textLogo = explode(' ',$this->site->title(),2);
			?>
			<a href="<?php echo baseURL?>" target="_blank" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini text-center"><small><i class="fa fa-tasks"></i></small></span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg">
					<b><?php echo @$textLogo[0] ?></b><?php echo @$textLogo[1] ?>
				</span>
			</a>

			<?php
			$has_picture = false;
			if(@getimagesize(uploadPath.'modules/user/thumbs/mini/'.$this->admin('image'))){

				$imgSize = 'squared';
				list($width, $height) = @getimagesize(uploadPath.'modules/user/thumbs/mini/'.$this->admin('image'));
				if($width > $height){
					$imgSize = 'landscape';
				}
				elseif($width < $height){
					$imgSize = 'potrait';
				}
				$has_picture = true;
			}
			?>

			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->
						<?php require (modulePath.'home/widget/bar.contactus.php'); ?>

						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<div class="thumb circle mini-xs">
									<div class="square">
										<div class="square-content">
											<div class="img-wrap default">
												<figure class="effect-bubba">
													<img src="<?php echo uploadURL; ?>modules/user/thumbs/mini/<?php echo $this->admin('image'); ?>" class="<?php echo @$imgSize; ?>">
												</figure>
											</div>
										</div>
									</div>
								</div>
								<span class="hidden-xs"><?php echo $this->admin('name');?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<div class="thumb circle">
										<div class="square">
											<div class="square-content">
												<div class="img-wrap default">
													<figure class="effect-bubba">
														<img src="<?php echo uploadURL; ?>modules/user/thumbs/mini/<?php echo $this->admin('image'); ?>" class="<?php echo @$imgSize; ?>">
													</figure>
												</div>
											</div>
										</div>
									</div>
									<p>
										<?php echo $this->admin('name');?>
										<small><?php echo $this->admin('group_name');?></small>
									</p>
								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="pull-left">
										<a href="<?php echo $this->adminURL()?>my-account<?php echo $this->permalink()?>" class="btn btn-default btn-flat">My account</a>
									</div>
									<div class="pull-right">
										<?php if($this->admin('group_id')==1){ ?>
											<a href="<?php echo $this->reloginURL()?>" class="btn btn-default btn-flat">Relogin</a>
										<?php } ?>
										<a href="<?php echo $this->logoutURL()?>" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

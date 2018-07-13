<!DOCTYPE html>
<html lang="en">
	<head>
		<?=$this->head();?>

		<!-- bootstrap & fontawesome -->
		<?=$this->load_css($this->themeURL().'assets/css/bootstrap.css');?>
		<?php echo $this->load_css($this->themeURL().'assets/css/font-awesome.min.css');?>

		<!-- AdminLTE styles -->
		<?php echo $this->load_css($this->themeURL().'assets/css/AdminLTE.min.css');?>

		<!-- sas styles -->
		<?=$this->load_css($this->themeURL().'assets/css/style.css');?>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?=$this->themeURL()?>assets/js/html5shiv.js"></script>
		<script src="<?=$this->themeURL()?>assets/js/respond.js"></script>
		<![endif]-->
	</head>

	<body class="login-page">
		<div class="login-box">
		  <div class="login-logo">
				<?php
				$textLogo = explode(' ',$this->site->title(),2);
				?>
		    <b><?php echo @$textLogo[0] ?></b><span><?php echo @$textLogo[1] ?></span>
		  </div>
			<div class="login-box-body">
		    <p class="login-box-msg">Sign in to start your session</p>
				<?php
				if(!empty($this->ErrorLogin)){
					echo '<div class="alert alert-danger">'.$this->ErrorLogin.'</div><div class="space-6"></div>';
				}
				?>
				<form action="" method="post">
					<div class="form-group has-feedback">
		        <input type="text" class="form-control input-lg" name="username" placeholder="Username" autocomplete="off"/>
		        <span class="glyphicon glyphicon-user form-control-feedback"></span>
		      </div>
					<div class="form-group has-feedback">
		        <input type="password" class="form-control input-lg" name="pass" placeholder="Password" autocomplete="off" />
		        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		      </div>
					<button type="submit" class="btn btn-lg btn-block btn-flat btn-primary" name="login"><span>Login</span><i class="icon-right fa fa-sign-in"></i></button>
					<input type="hidden" value="<?=$this->data->token('scode')?>" name="scode">
				</form>
			</div>
		</div>
	</body>
</html>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SAS BASIC - Installation</title>

		<link rel="icon" href="<?php echo systemURL?>install/images/site/favicon.png" type="image/x-icon">

		<!-- CSS -->
		<link rel="stylesheet" href="<?=systemURL?>install/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=systemURL?>install/assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=systemURL?>install/assets/css/font-awesome-animation.css">
		<link rel="stylesheet" href="<?=systemURL?>install/assets/css/select2.min.css">
		<link rel="stylesheet" href="<?=systemURL?>install/assets/css/style.css">

		<script type="text/javascript">
			var ajaxURL="<?php echo ajaxURL ?>?";
		</script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

		<div class="container">
			<div class="brand">
				<img src="<?php echo systemURL?>install/images/site/logo.png">
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<ul class="steps">
						<li id="steps-1" data-step="1" class="active">
							<span class="step">1</span>
							<span class="title">Setup Database</span>
						</li>

						<li id="steps-2" data-step="2" class="">
							<span class="step">2</span>
							<span class="title">Site Configuration</span>
						</li>

						<li id="steps-3" data-step="3" class="">
							<span class="step">3</span>
							<span class="title">Create an Account</span>
						</li>

						<li id="steps-4" data-step="4" class="">
							<span class="step">4</span>
							<span class="title">Site Information</span>
						</li>
					</ul>
				</div>
				<div id="step-container" class="panel-body">

					<form id="frm-config" name="frm-config" method="post" action="" class="form-horizontal">

						<div class="alert alert-danger alert-dismissible" role="alert" style="display:none">
							<button type="button" class="btn-alert-close close"><span aria-hidden="true">&times;</span></button>
							<strong>Warning!</strong> <span class="alert-container"></span>
						</div>

						<!-- Step 1 -->
						<div class="step-1">
							<?php
							$drivers = array();
							if ($handle = opendir(systemPath.'databases/adodb/drivers/')){
								while (false !== ($file = readdir($handle))){
									if($file !=='.' and $file !=='..'){
										$drivers[] = str_replace('adodb-','',str_replace('.inc.php','',$file));
									}
								}
								closedir($handle);
							}
							$list_driver = '<select name="driver" class="select2 form-control">';
							foreach ($drivers as $key => $value) {
								$selected = $value == 'mysqli'?' selected':'';
								$list_driver .= '<option value="'.$value.'"'.$selected.'>'.ucwords($value).'</option>';
							}
							$list_driver .= '</select>';
							?>
							<div class="form-group">
								<label class="col-sm-3 control-label">Database Driver</label>
								<div class="col-sm-9">
									<?php echo $list_driver; ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Database Host</label>
								<div class="col-sm-9">
									<input type="text" name="db_host" class="form-control" placeholder="" value="localhost">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Database Name</label>
								<div class="col-sm-9">
									<input type="text" name="db_name" class="form-control" placeholder="" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Database User</label>
								<div class="col-sm-9">
									<input type="text" name="db_user" class="form-control" placeholder="" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Password</label>
								<div class="col-sm-9">
									<input type="text" name="db_password" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Table Prefix</label>
								<div class="col-sm-9">
									<input type="text" name="table_prefix" class="form-control" placeholder="sas_" value="sas_">
								</div>
							</div>
						</div>

						<!-- Step 2 -->
						<div class="step-2" style="display:none">
							<div class="form-group">
								<label class="col-sm-3 control-label">Admin Name</label>
								<div class="col-sm-9">
									<input type="text" name="admin_name" class="form-control" placeholder="" value="sas-admin">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Session Name</label>
								<div class="col-sm-9">
									<input type="text" name="sassession" class="form-control" placeholder="" value="sassession">
									<input type="hidden" name="permalink" value=".html">
								</div>
							</div>
						</div>

						<!-- Step 3 -->
						<div class="step-3" style="display:none">
							<div class="form-group">
								<label class="col-sm-3 control-label">Your Name</label>
								<div class="col-sm-9">
									<input type="text" name="name" class="form-control" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Username</label>
								<div class="col-sm-9">
									<input type="text" name="username" class="form-control" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Password</label>
								<div class="col-sm-9">
									<input type="password" name="password" class="form-control" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Retype Password</label>
								<div class="col-sm-9">
									<input type="password" name="repassword" class="form-control" value="">
								</div>
							</div>
						</div>

						<!-- Step 4 -->
						<div class="step-4" style="display:none">
							<div class="form-group">
								<label class="col-sm-3 control-label">Site Title</label>
								<div class="col-sm-9">
									<input type="text" name="site_title" class="form-control" placeholder="SAS BASIC" value="SAS BASIC">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Site Tagline</label>
								<div class="col-sm-9">
									<input type="text" name="site_tagline" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Site Description</label>
								<div class="col-sm-9">
									<textarea name="site_description" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<!-- Step Success -->
						<div class="step-complete text-center" style="display:none">
							<div class="alert-begin text-center" style="display:none">You are ready to install</div>
							<div class="progress-install" style="display:none">
								<p>Installing...</p>
								<div class="progress progress-striped active">
									<div style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="100" role="progressbar" class="progress-bar"></div>
								</div>
							</div>
							<div class="alert-response" style="display:none"></div>
						</div>

						<!-- Step Value [hidden] -->
						<input type="hidden" name="steps" value="1" class="act-step">
					</form>
				</div>
				<div class="panel-footer text-right">
					<button type="submit" class="btn btn-primary btn-step-1">
						<i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>
						Next &#8594;
					</button>
				</div>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="<?=systemURL?>install/assets/js/jquery-1.10.1.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?=systemURL?>install/assets/js/bootstrap.min.js"></script>
		<script src="<?=systemURL?>install/assets/js/select2.full.min.js"></script>

		<script type="text/javascript">

			jQuery(function($) {

				$(".select2").select2();

				var xajaxFile = ajaxURL+"<?=systemPath?>install/act.install.php";

				/* Step 1 */
				$(document).on('click', '.btn-step-1', function(){

					$('.btn-step-1').attr('disabled','disabled');
					$('.loading').show();

					$.ajax({

						type: 'POST',
						url: xajaxFile,
						data: $("#frm-config").serialize(),
						dataType: 'json',
						success: function(data){

							if(data.error){
								$('.alert-container').html(data.errorAlert);
								$('.alert-danger').fadeIn();
							}
							else{
								$('.alert-danger').hide();
								$('.step-1').hide();
								$('.step-2').fadeIn();
								$('#steps-1').attr('class','complete');
								$('#steps-2').attr('class','active');
								$('.panel-footer').html('<button type="submit" class="btn btn-success btn-prev-1">Prev</button> <button type="submit" class="btn btn-primary btn-step-2"><i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>Next &#8594;</button>');
								$('.act-step').val(2);
							}
							$('.btn-step-1').removeAttr('disabled');
							$('.loading').hide();
						}
					});
				});

				$(document).on('click', '.btn-prev-1', function(){

					$('.alert-danger').hide();
					$('.step-1').fadeIn();
					$('.step-2').hide();
					$('#steps-1').attr('class','active');
					$('#steps-2').removeClass('active');
					$('.panel-footer').html('<button type="submit" class="btn btn-primary btn-step-1"><i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>Next &#8594;</button>');
					$('.act-step').val(1);
				});


				/* Step 2 */
				$(document).on('click', '.btn-step-2', function(){

					$('.btn-step-2').attr('disabled','disabled');
					$('.loading').show();

					$.ajax({

						type: 'POST',
						url: xajaxFile,
						data: $("#frm-config").serialize(),
						dataType: 'json',
						success: function(data){

							if(data.error){
								$('.alert-container').html(data.errorAlert);
								$('.alert-danger').fadeIn();
							}
							else{
								$('.alert-danger').hide();
								$('.step-2').hide();
								$('.step-3').fadeIn();
								$('#steps-2').attr('class','complete');
								$('#steps-3').attr('class','active');
								$('.panel-footer').html('<button type="submit" class="btn btn-success btn-prev-2">Prev</button> <button type="submit" class="btn btn-primary btn-step-3"><i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>Next &#8594;</button>');
								$('.act-step').val(3);
							}
							$('.btn-step-2').removeAttr('disabled');
							$('.loading').hide();
						}
					});
				});

				$(document).on('click', '.btn-prev-2', function(){

					$('.alert-danger').hide();
					$('.step-2').fadeIn();
					$('.step-3').hide();
					$('#steps-2').attr('class','active');
					$('#steps-3').removeClass('active');
					$('.panel-footer').html('<button type="submit" class="btn btn-success btn-prev-1">Prev</button> <button type="submit" class="btn btn-primary btn-step-2"><i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>Next &#8594;</button>');
					$('.act-step').val(2);
				});


				/* Step 3 */
				$(document).on('click', '.btn-step-3', function(){

					$('.btn-step-3').attr('disabled','disabled');
					$('.loading').show();

					$.ajax({

						type: 'POST',
						url: xajaxFile,
						data: $("#frm-config").serialize(),
						dataType: 'json',
						success: function(data){

							if(data.error){
								$('.alert-container').html(data.errorAlert);
								$('.alert-danger').fadeIn();
							}
							else{
								$('.alert-danger').hide();
								$('.step-3').hide();
								$('.step-4').fadeIn();
								$('#steps-3').attr('class','complete');
								$('#steps-4').attr('class','active');
								$('.panel-footer').html('<button type="submit" class="btn btn-success btn-prev-3">Prev</button> <button type="submit" class="btn btn-primary btn-step-4"><i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>Next &#8594;</button>');
								$('.act-step').val(4);
							}
							$('.btn-step-3').removeAttr('disabled');
							$('.loading').hide();
						}
					});
				});

				$(document).on('click', '.btn-prev-3', function(){

					$('.alert-danger').hide();
					$('.step-3').fadeIn();
					$('.step-4').hide();
					$('#steps-3').attr('class','active');
					$('#steps-4').removeClass('active');
					$('.panel-footer').html('<button type="submit" class="btn btn-success btn-prev-2">Prev</button> <button type="submit" class="btn btn-primary btn-step-3"><i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>Next &#8594;</button>');
					$('.act-step').val(3);
				});

				/* Step 4 */

				$(document).on('click', '.btn-step-4', function(){

					$('.btn-step-4').attr('disabled','disabled');
					$('.loading').show();

					$.ajax({

						type: 'POST',
						url: xajaxFile,
						data: $("#frm-config").serialize(),
						dataType: 'json',
						success: function(data){

							if(data.error){
								$('.alert-container').html(data.errorAlert);
								$('.alert-danger').fadeIn();
							}
							else{
								$('.alert-danger').hide();
								$('.step-4').hide();
								$('.alert-begin').show();
								$('.step-complete').fadeIn();
								$('#steps-4').attr('class','complete');
								$('.panel-footer').html('<button type="submit" class="btn btn-success btn-prev-4">Prev</button> <button type="submit" class="btn btn-primary btn-install">Install &#8594;</button>');
								$('.act-step').val('install');
							}
							$('.btn-step-4').removeAttr('disabled');
							$('.loading').hide();
						}
					});
				});

				$(document).on('click', '.btn-prev-4', function(){
					$('.progress-install').hide();
					$('.alert-danger').hide();
					$('.step-4').fadeIn();
					$('.step-complete').hide();
					$('#steps-4').removeClass('complete');
					$('#steps-4').attr('class','active');
					$('.panel-footer').html('<button type="submit" class="btn btn-success btn-prev-3">Prev</button> <button type="submit" class="btn btn-primary btn-step-4"><i class="fa fa-circle-o-notch fa-spin animated loading" style="display:none"></i>Next &#8594;</button>');
					$('.act-step').val(4);
				});

				/* Install */

				$(document).on('click', '.btn-install', function(){

					$('.alert-response').hide();
					$('.alert-begin').hide();
					$('.progress-install').fadeIn();
					$('.btn-prev-4').attr('disabled','disabled');
					$('.btn-install').attr('disabled','disabled');

					$.ajax({

						type: 'POST',
						url: xajaxFile,
						data: $("#frm-config").serialize(),
						dataType: 'json',
						success: function(data){

							if(data.error){
								$('.progress-install').hide();
								$('.alert-response').html(data.errorAlert).fadeIn();
								$('.btn-prev-4').removeAttr('disabled');
								$('.btn-install').removeAttr('disabled');
							}
							else{
								$('.progress-install').hide();
								$('.alert-response').html(data.errorAlert).fadeIn();
								$('.panel-footer').html('<a href="<?=baseURL?>" class="btn btn-primary btn-step-4">View site</a> <a href="<?=baseURL?>'+data.adminName+'" class="btn btn-primary btn-step-4">Admin panel</a>');
							}
						}
					});
				});

				/* Close alert */
				$(document).on('click', '.btn-alert-close', function(){
					$('.alert-danger').fadeOut();
				});
			});
		</script>

	</body>
</html>

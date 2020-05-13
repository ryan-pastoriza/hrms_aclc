<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="<?= base_url('scripts/jquery.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('scripts/jquery.form.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/bootstrap/js/bootstrap.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>">

		<script>
	     $(document).ready(function(){
	        $('#loginForm').ajaxForm(function(r) {
	          $('#errorMsg').html(r);
	        });
	      });
	  	</script>
	  	<style type="text/css">
	  	.top{
			margin-top:15%;
		}
		.panel-heading {
		    padding: 5px 15px;
		}
		.profile-img {
			width: 150px;
			height: 96px;
			margin: 0 auto 10px;
			display: block;
			/*-moz-border-radius: 50%;*/
			/*-webkit-border-radius: 50%;*/
			/*border-radius: 30%;*/
		}
		.panel-default{
			background-color: #ECECFB;
			float: right;
		}
	  	</style>
</head>
<body>
<div class="container">
	<!-- login form -->
	<div class="row top">
		<div class="col-sm-6 col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<center><h3>HRMS</h3></center>
				</div>
				<div class="panel-body">
					<?php echo form_open('login/try_login',array('id'=>'loginForm' , 'class' => 'form-horizontal center' ,'role' => 'form')); ?>
						<fieldset>
							<div class="row">
								<div class="center-block">
									<img class="profile-img"
										src="<?= base_url()?>images/engtech.fw.png">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-10  col-md-offset-1 ">
									<div class="form-group">
										<div class="input-group">
											<input class="form-control" placeholder="Username" name="username" type="text" autofocus>
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-user"></i>
											</span>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<input class="form-control" placeholder="Password" name="password" type="password">
											<span class="input-group-addon">
												<i class="glyphicon glyphicon-lock"></i>
											</span>
										</div>
									</div>
									<div class="form-group">
										<input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign in" name="submit">
										<br>
										<center><span id="errorMsg" style="color:red";></span></center>
									</div>
								</div>
							</div>
						</fieldset>
					<?php echo form_close();?>
				    <a href="<?= base_url('index.php/register') ?>"><i class="fa fa-pencil-square-o"></i> Register account</a>
				</div>
	        </div>
		</div>
	</div>
<!-- end login form -->
</div>
</body>
</html>
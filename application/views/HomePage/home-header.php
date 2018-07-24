<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title> Home - Crypdexx </title>
<!-- Favicon -->
<link rel="shortcut icon" href="favicon.png" sizes="32x32" type="image/x-icon">
<link rel="stylesheet" href="<?php echo base_url(); ?>assests/css/bootstrap.min.css">
<link href="<?php echo base_url(); ?>assests/css/font-awesome.min.css" type="text/css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assests/css/animate.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assests/css/toastr.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assests/css/style.css" rel="stylesheet">

</head>
<body class="home">
<!-- Preloader -->
<div class="preloader">
  <div class="ballLoader">
    <div class="ball"></div>
    <div class="ball"></div>
    <div class="ball"></div>
  </div>
</div>
	<!-- Header area -->
<header class="header homeheader">
	<div class="logo"><a href="index.html"><img src="<?php echo base_url(); ?>assests/images/logo.png" alt="logo"></a></div>
	<div class="right-header">
	<form method="POST" id="signIN">
		<div class="form-group">
			<div class="row">
			   <div class="col-md-5">
				<label>Email or Phone</label>
		     	<input type="text" name="sign_in">
				</div>
			   <div class="col-md-5">
				<label>Password</label>
				<input name="password" type="password">
				 <a href="javascript:void(0)" data-toggle="modal" data-target="#forgot" ><span>Forgotten account?</span></a>				
				</div>
			   <div class="col-md-2">
				   <label></label>
				<input class="btn-hover" type="submit" value="Log In">
				</div>		
			</div>	
		</div>
		</form>
	</div>
</header>

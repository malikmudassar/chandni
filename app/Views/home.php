<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login - <?=$company_name?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="/assets/fonts/material-design-iconic-font/css/material-design-iconic-font.css">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="/assets/css/style.css">
        <script>
            function onFormSubmit() {
                document.form.submit();
            }
        </script>
  
	</head>
	<body>
    
    
		<div class="wrapper">
            <form action="" id="wizard" method="POST">           
        		<!-- SECTION LOGIN FOR EXISING USER -->
                <h2></h2>
                <section>
                    <div class="inner">
						<div class="image-holder">
							<img src="/assets/images/form-wizard-2.jpg" alt="">
						</div>
						<div class="form-content" >
							<div class="form-header">
								<h3>CUSTOMER LOGIN</h3>
							</div>
							<p>Enter Login Details</p><br><br>

							<?php if(session()->getFlashdata('msg')):?>
							<div class="alert alert-warning">
							<?= session()->getFlashdata('msg') ?>
							</div>
                            <?php endif;?>

							<?php
								if (isset($isNewRegistered) && $isNewRegistered=="new") {
							?>
								<div class="form-row">
									<div class="alert alert-success">You have Successfully Registered with <?=$company_name?></div>
								</div>
							<?php		
								}
							?>
							<?php if(isset($validation)):?>
								<div class="form-row">
									<div class="alert alert-danger"><?= $validation ?></div>
								</div>
							<?php endif;?>
							<?php if(isset($validationError)):?>
					
								<div class="form-row">
									<div class="alert alert-danger"><?= $validationError->listErrors() ?></div>
								</div>
							<?php endif;?>
							<div class="form-row">
								<div class="form-holder w-100">
									<input type="text" name="email" placeholder="Email" class="form-control">
								</div>
							</div>
                            
							<div class="form-row">
								<div class="form-holder w-100">
									<input type="password" name="password" placeholder="Password" class="form-control">
								</div>
								
							</div>
							
							<div class="my-2 d-flex justify-content-between align-items-center">
							<div class="checkbox-circle" style="margin-bottom: 15px;">
												<label>
													<input type="checkbox" checked> Remember me.
													<span class="checkmark"></span>
												</label>
											</div>
								<a href="/Administration/forgetPassEmail" class="auth-link text-black">Forgot password?</a>
							</div>

                            <div class="form-row">
								<div class="form-holder w-100">
                                <br />
                                    <center>                                        
                                        <p><button type="submit" onclick="onFormSubmit()">LOGIN</button>
                                        &nbsp;&nbsp;
                                        Don't have an account, 
                                        <a href="register" class="form-control">Sign UP!</a></p>
                                    </center>
								</div>
								
							</div>
						</div>
					</div>
                    
                </section>
            </form>
		</div>

		<!-- JQUERY -->
		<script src="/assets/js/jquery-3.3.1.min.js"></script>

		<!-- JQUERY STEP -->
		<!-- <script src="/assets/js/jquery.steps.js"></script> -->
		<script src="/assets/js/main.js"></script>
		<!-- Developed by Dinx Studio Inc. -->
</body>
</html>
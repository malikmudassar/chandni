<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sign Up</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="../assets/fonts/material-design-iconic-font/css/material-design-iconic-font.css">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="../assets/css/style.css">
  
	</head>
	<body>
    
    
		<div class="wrapper">            
            
            
            
             <!-- SECTION 1 -->
                <h2></h2>
                <section>
                    <div class="inner">
						<div class="image-holder">
							<img src="../assets/images/form-wizard-1.jpg" alt="">
						</div>
						<div class="form-content" >
							<div class="form-header">
								<h3>SIGN-UP</h3>
							</div>
							<p>Please fill with your details</p><br>

							<?php if(isset($validation)):?>
								<div class="form-row">
									<div class="alert alert-danger"><?= $validation->listErrors() ?></div>
								</div>
							<?php endif;?>

							<?php if(isset($emailCheck)):?>
								<div class="form-row">
									<div class="alert alert-danger"><?= $emailCheck; ?></div>
								</div>
							<?php endif;?>

							<form action="/register/save" method="post">

							<div class="form-row">
								<div class="form-holder">
									<input type="text" name="first_name" placeholder="First Name" class="form-control">
								</div>
								<div class="form-holder">
									<input type="text" name="last_name"placeholder="Last Name" class="form-control">
								</div>
							</div>
                            
							<div class="form-row">
								<div class="form-holder">
									<input type="text" name="email" placeholder="Your Email" class="form-control">
								</div>
								<div class="form-holder">
									<input type="text" name="phone" placeholder="Phone Number" class="form-control">
								</div>
							</div>
							<div class="form-row">
								<div class="form-holder">
									<input type="text" name="age" placeholder="Enter Age" class="form-control">
								</div>
								<div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
									<div class="checkbox-tick">
										<label class="male">
											<input type="radio" name="gender" value="male" checked> Male<br>
											<span class="checkmark"></span>
										</label>
										<label class="female">
											<input type="radio" name="gender" value="female"> Female<br>
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
							<div class="checkbox-circle">
								<!--<label>-->
								<!--	<input type="checkbox" checked> By clicking "REGISTER", you agree to the <a href="http://chandnivictoria.ca/wp-content/uploads/2022/06/terms.pdf" target="_blank" style="text-decoration: underline;">Terms and Privacy Policy</a> </label>-->
        <!--                      <label><br>-->
                                    <div>
										<label>
											<input type="checkbox" name="terms" value="1"> BY CLICKING THIS OPTION YOU AGREE TO THE CONTRACT <a href="http://chandnivictoria.ca/wp-content/uploads/2022/06/terms.pdf" target="_blank" style="text-decoration: underline;">TERMS & CONDITIONS</a>*
											<span class="checkmark"></span>
										</label>
									</div>
									<input type="checkbox" checked> Already have an account? <a href="https://chandani.dinxstudio.com/home" style="color: #469015; font-weight: bold;">Sign in</a></label>
							</div>
								<br />
							<div class="form-row">
								<div class="form-holder">
									<input type="submit" value="Register" class="form-control submit-button-chandni">
								</div>
								
							</div>
							</form>

							
						</div>
					</div>
                   
                </section>
                
                
                
		</div>

		<!-- JQUERY -->
		<script src="../assets/js/jquery-3.3.1.min.js"></script>

		<!-- JQUERY STEP -->
		<!-- <script src="js/jquery.steps.js"></script> -->
		<script src="../assets/js/main.js"></script>
		<!-- Template created and distributed by Dinx Studio Inc. -->
</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Activate User</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="author" content="colorlib.com">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="/assets/fonts/material-design-iconic-font/css/material-design-iconic-font.css">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="/assets/css/style.css">
  
	</head>
	<body>
    
    
		<div class="wrapper">            
            
            
            
             <!-- SECTION 1 -->
                <h2></h2>
                <section>
                    <div class="inner">
						<div class="image-holder">
							<img src="/assets/images/form-wizard-1.jpg" alt="">
						</div>
						<div class="form-content" >
							<div class="form-header">
								<h3>SIGN-UP</h3>
							</div>
							<p>							<?php if(isset($validation)):?>
								<div class="form-row">
									<div class="alert alert-danger"><?= $validation ?></div>
								</div>
							<?php endif;?></p><br>

                             <?php if (isset($url)){ ?>
								<label>
									<a href="/Administration">Sign in</a>
								</label>
							<?php }else{ ?>
							    <label>
									<a href="/home">Sign in</a>
								</label>
							<?php } ?>	
							</div>
								
							
						</div>
					</div>
                   
                </section>
                
                
                
		</div>

		<!-- JQUERY -->
		<script src="/assets/js/jquery-3.3.1.min.js"></script>

		<!-- JQUERY STEP -->
		<!-- <script src="js/jquery.steps.js"></script> -->
		<script src="/assets/js/main.js"></script>
		<!-- Template created and distributed by Dinx Studio Inc. -->
</body>
</html>

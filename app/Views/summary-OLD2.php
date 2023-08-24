<?php
    if (isset($_SESSION["EVENTS"]["STEP-1"])) {
?>
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
        <div class="template-demo">
        <h3 class="card-title text-success">Summary</h3>
        <p class="card-description">
        Review your order before submission....
        </p>
        </div>
        
        <div class="card-body">
        <blockquote class="blockquote blockquote-primary" style="font-size: 0.95rem; color: #000; font-weight: bold;">
        <table cellpadding="5" cellspacing="5">
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Event Details</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Event Date & Time: </strong>
                </td>
                <td style="padding-left: 10px">
                    <?=date("F j, Y, g:i a", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>No of Guests:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["no_of_guests"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Coat Check?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["coat_check"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Valid Licensed Bar?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["valid_licensed_bar"]?>
                </td>
            </tr>                      
            
            <?php
            if ($_SESSION["EVENTS"]["STEP-1"]["valid_licensed_bar"]=="Own Liquor License") {
            ?>
            <tr>
                <td>
                    <strong>Licene file:</strong>
                </td>
                <td style="padding-left: 10px">
                    <a target="_blank" href='<?=$_SESSION["EVENTS"]["STEP-1"]["own_license_file"]?>'>Download File</a>
                </td>
            </tr>                      
            <?php
            }
            ?>

            <tr>
                <td>
                    <strong>Coat Check?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["coat_check"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>No. of Bartenders?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["no_of_bartenders"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>Need a Hall Rental?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>Need Security Gaurds?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["need_security_gaurds"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>How many Security Gaurds?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["how_many_security_gaurds"]?>
                </td>
            </tr>
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-2"]["label"])) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Choose Hall & Menu Option</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Hall and Location:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_venue"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Event Type:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Selected Menu Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_menuOption"]?>
                </td>
            </tr>
            <?php
                }
            ?>

            <?php
                if (isset($_SESSION["EVENTS"]["STEP-3"]["label"])) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong><?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_menuOption"]?></strong></4>
                </td>
            </tr>
            <?php
                foreach($_SESSION["EVENTS"]["STEP-3"]["label"] as $key => $value) {
                    
            ?>
                    <tr>
                        <td colspan=2 style="vertical-align:top">
                        <table>
                            <tr>
                            <td style="vertical-align:top">
                                <strong><?=$key?>:</strong>
                            </td>
                            <td style="padding-left: 20px">
                            <?php
                                foreach($value as $key1 => $value1) {
                                    if ($key1!="Empty") { 
                            ?>
                                    <table>
                                        <tr>
                                        <td style="vertical-align:top"><?=$key1?>: </td>
                                        <td style="padding-left: 10px"><?=implode(",<br />", $value1)?></td>
                                        </tr>
                                    </table>
                            <?php
                                    } else {
                                        echo implode(",<br />", $value1);
                                    }
                                }
                            ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
            <?php
                }
            ?>
            
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-4"]["label"])) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Floor Plan</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Floor Plan:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-4"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-5"]["label"])) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Napkin</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Napkin:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-5"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
                
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-6"]["label"])) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Table Cloth Color</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Table Cloth:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-6"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
                        <?php
                if (isset($_SESSION["EVENTS"]["STEP-7"]["label"])) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Flower Color</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Flower:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-7"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-8"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Sound Option</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Sound:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?php 
                        if ($_SESSION["EVENTS"]["STEP-8"]["sound_select"]==0) {
                            echo "WILL ARRANGE OWN SOUND SYSRTEM";
                        } else {
                            echo $_SESSION["EVENTS"]["STEP-8"]["label"];   
                        }
                    ?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-9"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>PROFESSIONAL DJ</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>DJ Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-9"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-10"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>STAGE DECORE</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Stage Decore Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-10"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["EVENTS"]["STEP-11"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>LIGHTING SETUP</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Lighting Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-11"]["label"]?>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="padding-left: 10px">&nbsp;</td>
            </tr>
            <tr>
              <td height="30" bgcolor="#E6E6E6" style="font-family: Arial, Helvetica, sans-serif">Service Charge:</td>
              <td bgcolor="#E6E6E6" style="font-family: Arial, Helvetica, sans-serif">2500</td>
            </tr>
            <tr>
              <td height="30" bgcolor="#F4F4F4" style="font-family: Arial, Helvetica, sans-serif">HST/GST:</td>
              <td bgcolor="#F4F4F4" style="font-family: Arial, Helvetica, sans-serif">5600</td>
            </tr>
            <tr>
              <td height="30" bgcolor="#E6E6E6" style="font-family: Arial, Helvetica, sans-serif">Others:</td>
              <td bgcolor="#E6E6E6" style="font-family: Arial, Helvetica, sans-serif">2000</td>
            </tr>
            <tr>
              <td height="51" bgcolor="#EAFFEA" style="font-family: Arial, Helvetica, sans-serif; color: #000000;">Grand Total:</td>
              <td bgcolor="#EAFFEA" style="font-family: Arial, Helvetica, sans-serif">50000</td>
            </tr>
            <?php
                }
            ?>
            <tr>
            <td colspan=2 style="padding-top:20px">
            <button type="button" onclick="document.location='/events/reset'" class="btn btn-dark">RESET SELECTION</button>
            </td>
            </tr>
        
        </table>

        
        </blockquote>
    </div>

    </div>
    </div>
</div>



<div class="page-content" style="background-image: url('images/wizard-v4.jpg')">
		<div class="wizard-v4-content">
			<div class="wizard-form">
				<div class="wizard-header">
					<h3 class="heading">Sign Up To Financial</h3>
					<p>Fill all form field to go next step</p>
				</div>
		        <form class="form-register" action="#" method="post">
		        	<div id="form-total">
		        		<!-- SECTION 1 -->
			            <h2>
			            	<span class="step-icon"><i class="zmdi zmdi-account"></i></span>
			            	<span class="step-text">About</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<h3>Personal Information:</h3>
								<div class="form-row">
									<div class="form-holder">
										<label class="form-row-inner">
											<input type="text" class="form-control" id="first-name" name="first-name" required>
											<span class="label">First Name</span>
					  						<span class="border"></span>
										</label>
									</div>
									<div class="form-holder">
										<label class="form-row-inner">
											<input type="text" class="form-control" id="last-name" name="last-name" required>
											<span class="label">Last Name</span>
					  						<span class="border"></span>
										</label>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-1">
										<label class="form-row-inner">
											<input type="text" class="form-control" id="address" name="address" required>
											<span class="label">Address Location</span>
					  						<span class="border"></span>
										</label>
									</div>
									<div class="form-holder">
										<label class="form-row-inner">
											<input type="text" class="form-control" id="code" name="code" required>
											<span class="label">Zip Code</span>
					  						<span class="border"></span>
										</label>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<label class="form-row-inner">
											<input type="text" class="form-control" id="phone" name="phone" required>
											<span class="label">Phone Number</span>
					  						<span class="border"></span>
										</label>
									</div>
								</div>
							</div>
			            </section>
						<!-- SECTION 2 -->
			            <h2>
			            	<span class="step-icon"><i class="zmdi zmdi-lock"></i></span>
			            	<span class="step-text">Account</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<h3>Do you have an account?</h3>
								<div class="form-row">
									<div id="radio">
										<input type="radio" name="gender" value="male" checked class="radio-1"> I already have an account.
  										<input type="radio" name="gender" value="female"> I'm newbie
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<label class="form-row-inner">
											<input type="text" name="your_email_1" id="your_email_1" class="form-control" required>
											<span class="label">E-Mail</span>
					  						<span class="border"></span>
										</label>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder">
										<label class="form-row-inner">
											<input type="password" name="password_1" id="password_1" class="form-control" required>
											<span class="label">Password</span>
											<span class="border"></span>
										</label>
									</div>
									<div class="form-holder">
										<label class="form-row-inner">
											<input type="password" name="comfirm_password_1" id="comfirm_password_1" class="form-control" required>
											<span class="label">Comfirm Password</span>
											<span class="border"></span>
										</label>
									</div>
								</div>
							</div>
			            </section>
			            <!-- SECTION 3 -->
			            <h2>
			            	<span class="step-icon"><i class="zmdi zmdi-receipt"></i></span>
			            	<span class="step-text">Ownership</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<h3>More About Yourself</h3>
								<div class="form-row">
									<div class="form-holder">
										<label class="form-row-inner">
											<input type="text" class="form-control" id="first-name-1" name="first-name-1" required>
											<span class="label">First Name</span>
											<span class="border"></span>
										</label>
									</div>
									<div class="form-holder">
										<label class="form-row-inner">
											<input type="text" class="form-control" id="last-name-1" name="last-name-1" required>
											<span class="label">Last Name</span>
											<span class="border"></span>
										</label>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<select name="position" id="position">
											<option value="Position" disabled selected>Position</option>
											<option value="Manager">Manager</option>
											<option value="Employee">Employee</option>
											<option value="Director">Director</option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<select name="area" id="area">
											<option value="Business Area" disabled selected>Business Area</option>
											<option value="Marketing">Marketing</option>
											<option value="Finance">Finance</option>
											<option value="IT Support">IT Support</option>
										</select>
									</div>
								</div>
								<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
										<label for="date" class="special-label">Date of Birth:</label>
										<select name="date" id="date">
											<option value="Day" disabled selected>Day</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
										</select>
										<select name="month" id="month">
											<option value="Month" disabled selected>Month</option>
											<option value="Feb">Feb</option>
											<option value="Mar">Mar</option>
											<option value="Apr">Apr</option>
											<option value="May">May</option>
										</select>
										<select name="year" id="year">
											<option value="Year" disabled selected>Year</option>
											<option value="2017">2017</option>
											<option value="2016">2016</option>
											<option value="2015">2015</option>
											<option value="2014">2014</option>
											<option value="2013">2013</option>
										</select>
									</div>
								</div>
							</div>
			            </section>
			            <!-- SECTION 4 -->
			            <h2>
			            	<span class="step-icon"><i class="zmdi zmdi-money"></i></span>
			            	<span class="step-text">Financing</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<h3>Financing Information</h3>
			                	<div class="form-row">
									<div class="form-holder form-holder-2">
										<select name="inventory" id="inventory">
											<option value="Buy Inventory" disabled selected>Buy Inventory</option>
											<option value="Yes">Yes</option>
											<option value="No">No</option>
										</select>
									</div>
								</div>
								<div class="form-row">
									<div id="checkbox">
										<span>Do you have existing business financing?: </span>
										<input type="checkbox" name="vehicle1" value="Yes"> Yes
  										<input type="checkbox" name="vehicle2" value="No"> No
									</div>
								</div>
								<h4>Existing Balance </h4>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<label class="form-row-inner">
											<input type="text" name="business" id="business" class="form-control" required>
											<span class="label">Business</span>
											<span class="border"></span>
										</label>
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<label class="form-row-inner">
											<input type="text" name="balance" id="balance" class="form-control" required>
											<span class="label">Current Balance</span>
											<span class="border"></span>
										</label>
									</div>
								</div>
							</div>
			            </section>
		        	</div>
		        </form>
			</div>
		</div>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.steps.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/main.js"></script>
    
    
    
    <!-- Font-->
	<link rel="stylesheet" type="text/css" href="css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="css/roboto-font.css">
	<link rel="stylesheet" type="text/css" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- datepicker -->
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="css/style.css"/>
<?php
    }
?>
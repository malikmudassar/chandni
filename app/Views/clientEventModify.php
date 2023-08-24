	<!-- partial -->
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Groom/Bride Details</h4>
                  <p class="card-description">
                    Groom/Bride Details
                    <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  <form action="/ModifyEvent/new" method="post" enctype="multipart/form-data">
                    
                    <!--Groom & Bride information-->
                    <div class="form-row">
                      <div class="form-holder"> 
                        <label for="groom_title">Groom Title:</label>
                        <select name="groom_title" class="form-control" aria-hidden="true" style="height:44px; color:#000;">
                            <option value="Mr">Mr</option>
                            <option value="Dr">Dr</option>
                        </select>
                      </div>
                      <div class="form-holder" style="margin-left: 2%; width: 71%;"> 
                        <label for="groom_fname">Groom First Name</label>
                        <input value="<?php if (isset($groom_fname)) echo $groom_fname?>" type="text" placeholder="Groom First Name" name="groom_fname" class="form-control" />
                      </div>
                    </div> 

                    <br>
                    <div class="form-row">
                      <div class="form-holder"> 
                        <label for="bride_title">Bride Title:</label>
                        <select name="bride_title" class="form-control" aria-hidden="true" style="height:44px; color:#000;">
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                            <option value="Miss">Miss</option>
                            <option value="Dr">Dr</option>
                        </select>
                      </div>
                      <div class="form-holder" style="margin-left:2%; width: 74%;"> 
                        <label for="bride_fname">Bride First Name</label>
                        <input value="<?php if (isset($bride_fname)) echo $bride_fname?>" type="text" placeholder="Bride First Name" name="bride_fname" class="form-control" />
                      </div>
                    </div>  
                    <br>
                    <div class="form-row">
                      <div class="form-holder" style="width:100%;"> 
                        <label for="groom_lname">Groom Last Name</label>
                        <input value="<?php if (isset($groom_lname)) echo $groom_lname?>" type="text" placeholder="Groom Last Name" name="groom_lname" class="form-control" />
                      </div>
                      <div class="form-holder" style="width: 100%;"> 
                        <label for="bride_lname">Bride Last Name</label>
                        <input value="<?php if (isset($bride_lname)) echo $bride_lname?>" type="text" placeholder="Bride Last Name" name="bride_lname" class="form-control" />
                      </div>
                    </div>  
                    <br>
                    <div class="form-row">
                      <div class="form-holder" style="width:100%;"> 
                        <label for="groom_phone">Groom Phone No</label>
                        <input value="<?php if (isset($groom_phone)) echo $groom_phone?>" type="text" placeholder="Groom Phone No" name="groom_phone" class="form-control" />
                      </div>
                      <div class="form-holder" style="width: 100%;"> 
                        <label for="bride_phone">Bride Phone No</label>
                        <input value="<?php if (isset($bride_phone)) echo $bride_phone?>" type="text" placeholder="Bride Phone No" name="bride_phone" class="form-control" />
                      </div>
                    </div>  
                    <br>
                    <div class="form-row">
                      <div class="form-holder" style="width: 100%;"> 
                        <label for="groom_address">Groom Home Address</label>
                        <input value="<?php if (isset($groom_address)) echo $groom_address?>" type="text" placeholder="Groom Address" name="groom_address" class="form-control" />
                      </div>
                    </div>  
                    <br>
                    <div class="form-row">
                      <div class="form-holder" style="width: 100%;"> 
                        <label for="bride_address">Bride Home Address</label>
                        <input value="<?php if (isset($bride_address)) echo $bride_address?>" type="text" placeholder="Bride Address" name="bride_address" class="form-control" />
                      </div>
                    </div>  
                    <br>
                    <div class="form-row">
                      <div class="form-holder" style="width: 100%;"> 
                        <label for="groom_driver_license">Groom Driver’s License</label>
                        <input type="file" name="groom_driver_license" id="custom-file-input" placeholder="Upload .Pdf format" class="form-control" />
                      </div>
                    </div>  
                    <br>
                    <div class="form-row">
                      <div class="form-holder" style="width:100%;"> 
                        <label for="bride_driver_license">Bride Driver’s License</label>
                        <input type="file" name="bride_driver_license" id="custom-file-input" placeholder="Upload .Pdf format" class="form-control" />
                      </div>
                    </div>  
                    <br>
                    <h4 class="card-title">Event Details</h4>
                  <p class="card-description">Event Details</p>
                    <!--Date and time information-->
                    <div class="form-row">
                      <div class="form-holder" style="width:100%;"> 
                        <label for="event_date">Event Date</label>
                        <input value="<?php if (isset($event_date)) echo $event_date?>" type="date" placeholder="Event Date" name="event_date" class="form-control" />
                      </div>
                      
                        <div class="form-holder" style="width:100%; padding-bottom:10px !important;">
                        <label for="event_time">Time of event</label>
                        <select name="event_time" class="form-control" aria-hidden="true" style="height:44px; color:#000;">
                          <option <?php if (isset($event_time) && $event_time=="Morning Event") echo "selected"; ?> value="Morning Event">Morning Event - 8:00 am - 3:00 pm</option>
                          <option <?php if (isset($event_time) && $event_time=="Evening Event") echo "selected"; ?> value="Evening Event">Evening Event - 6:00 pm - 1:00 am</option>
                          <option <?php if (isset($event_time) && $event_time=="Full Day Event") echo "selected"; ?> value="Full Day Event">Full Day Event – 8:00 am – 1:00 am</option>
                        </select>
                        	
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder" style="width:100%;">
                            <label for="payment_mode">Payment Mode</label>
                            <select name="payment_mode" class="form-control" aria-hidden="true" style="height:44px; color:#000;">
                              <option <?php if (isset($payment_mode) && $payment_mode=="Email Transfer") echo "selected"; ?> value="Email Transfer">Email Transfer</option>
                              <option <?php if (isset($payment_mode) && $payment_mode=="Bank Draft") echo "selected"; ?> value="Bank Draft">Bank Draft</option>
                              <option <?php if (isset($payment_mode) && $payment_mode=="Certified Cheque Only") echo "selected"; ?> value="Certified Cheque Only">Certified Cheque Only (No Regular Cheques accepted)</option>
                            </select>
                        </div>
                        <br>
                        <small>Note: All payment must be received 3 weeks prior to your event.</small>
                        <br>
                    </div>
                    
                    <div class="form-row">
                      <div class="form-holder" style="width:50%;"> 
                        <label for="no_of_guests">No. of Guests</label>
                        <input value="<?php if (isset($no_of_guests)) echo $no_of_guests?>" type="number" name="no_of_guests" placeholder="#" class="form-control">
                      </div>
                      <div class="form-holder" style="padding-left:2%; padding-bottom:10px !important;width:50%;">
                        <label for="coat_check">Coat Check?</label>
                        <select name="coat_check" class="form-control" aria-hidden="true" style="height:44px; color:#000;">
                          <option <?php if (isset($coat_check) && $coat_check=="Yes") echo "selected"; ?> value="Yes">Yes</option>
                          <option <?php if (isset($coat_check) && $coat_check=="No") echo "selected"; ?> value="No">No</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-holder" style="width:100%;"> 
                        <label for="valid_licensed_bar">Valid Licensed Bar?</label>
                        <select name="valid_licensed_bar" class="form-control" aria-hidden="true" id="valid_licensed_bar" style="color:#000;" onchange="val2()">
                          <option <?php if (isset($valid_licensed_bar) && $valid_licensed_bar=="Not applicable") echo "selected"; ?> value="Not applicable">Not applicable</option>
                          <option <?php if (isset($valid_licensed_bar) && $valid_licensed_bar=="Own Liquor License") echo "selected"; ?> value="Own Liquor License">Own Liquor License</option>
                          <option <?php if (isset($valid_licensed_bar) && $valid_licensed_bar=="Use Our Hall License") echo "selected"; ?> value="Use Our Hall License">Use Our Hall License</option>
                        </select>
                      </div>
                      <div class="form-holder" style="width:100%; <?php if ($valid_licensed_bar==null || $valid_licensed_bar=="Use Our Hall License" || $valid_licensed_bar=="Not applicable") { ?>display:none;<?php } ?>" id="valid_licensed_bar_image">
                        
                        <div class="form-holder"> 
                        <label for="own_license">Upload own licence if applicable?</label>
                          
                          <?php
                            //if (isset($valid_licensed_bar) && $valid_licensed_bar=="Own Liquor License") {
                          ?>
                          
                            <!-- <br /><p style="padding-top: 14px"><a target="_blank" href='<?php //echo $_SESSION["MODIFYEVENTS"]["STEP-1"]["own_license_file"]?>'>View File</a></p> -->
                                               
                          <?php
                           // } else {
                          ?>
                            <input type="file" name="own_license" id="custom-file-input" placeholder="Upload .Pdf format" class="form-control" />
                          <?php
                            //}
                          ?>
                        </div>
                      </div>
                      
                    </div>
                    <small>Note: Liquor License expires 1am and Hall Closes 2am</small>
                    <br>
                    <br>
                    <div class="form-row">
                      <div class="form-holder" style="width:50%;"> 
                        <label for="no_of_bartenders">No. of Bartenders?</label>
                        <input value="<?php if (isset($valid_licensed_bar)) echo $no_of_bartenders?>" type="number" name="no_of_bartenders" placeholder="#" class="form-control">
                      </div>
                      <div class="form-holder" style="padding-left:2%; !important;width:50%;">
                        <label for="need_a_hall_rental">Need a Hall Rental?</label>
                        <select name="need_a_hall_rental" class="form-control" aria-hidden="true" style="height:44px; color:#000;">
                          <option <?php if (isset($need_a_hall_rental) && $need_a_hall_rental=="Yes") echo "selected"; ?> value="Yes">No</option>
                          <option <?php if (isset($need_a_hall_rental) && $need_a_hall_rental=="No") echo "selected"; ?> value="No">Yes</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-holder" style="width:100%;"> 
                        <label for="need_security_gaurds">Need Security Gaurds?</label>
                        <select name="need_security_gaurds" class="form-control" aria-hidden="true" id="need_security_gaurds"  onchange="val()" style="height:44px; color:#000;">
                          
                          <option <?php if (isset($need_security_gaurds) && $need_security_gaurds=="No") echo "selected"; ?> value="No">No</option>
                          <option <?php if (isset($need_security_gaurds) && $need_security_gaurds=="Yes") echo "selected"; ?> value="Yes">Yes</option>
                        </select>
                      </div>
                      <div class="form-holder" style="width:100%;<?php if((!isset($need_security_gaurds))){ ?>display:none;<?php } ?>" id="how_many_security_gaurds" >
                        <label for="how_many_security_gaurds">How many Security Gaurds?</label>
                        <select name="how_many_security_gaurds" class="form-control" aria-hidden="true" style="height:44px; color:#000;">
                          <option value="0">0</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="4") echo "selected"; ?> value="4">2-4</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="6") echo "selected"; ?> value="6">4-6</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="8") echo "selected"; ?> value="8">6-8</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="10") echo "selected"; ?> value="10">8-10</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="12") echo "selected"; ?> value="12">10-12</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="14") echo "selected"; ?> value="14">12-14</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="16") echo "selected"; ?> value="16">14-16</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="18") echo "selected"; ?> value="18">16-18</option>
                          <option <?php if (isset($how_many_security_gaurds) && $how_many_security_gaurds=="20") echo "selected"; ?> value="20">18-20</option>
                        </select>
                        
                        
                        <!--<input value="<?php if (isset($how_many_security_gaurds)) echo $how_many_security_gaurds?>" type="number" name="how_many_security_gaurds" value='0' placeholder="#" class="form-control">-->
                        
                        
                      </div>
                    </div>
                    <br />
                    
                    <input type="button" class="btn btn-light" onclick="document.location='/home'" value="Cancel" />
                    <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                  </form>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        
        <script>
            function val() {
                d = document.getElementById("need_security_gaurds").value;
                var x = document.getElementById("how_many_security_gaurds");
                  if (d === "Yes") {
                    x.style.display = "block";
                  } else {
                    x.style.display = "none";
                  }
            }
            
            function val2() {
                d = document.getElementById("valid_licensed_bar").value;
                var x = document.getElementById("valid_licensed_bar_image");
                  if (d === "Not applicable" || d === "Use Our Hall License" ) {
                    x.style.display = "none";
                  } else {
                    x.style.display = "block";
                  }
            }
            
        
        </script>


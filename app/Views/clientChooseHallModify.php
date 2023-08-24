	<!-- partial -->
  <script>
    function onVenueChange(box) {
      var venue_id = box.options[box.options.selectedIndex].value;
      var div_menu_option = document.getElementById("div_menu_option");
      div_menu_option.innerHTML = "";
      $.ajax({
        url: '/events/getVenueBuffet',
        type: 'POST',
        data: {
          venue_id: venue_id
        },
        success: function(data) {
            div_menu_option.innerHTML = data;
        }
      });
    }
  </script>
  <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Choose Hall & Menu Option</h4>
                  <p class="card-description">
                    Enter Venue & Menu details
                    <?php if(session()->getFlashdata('message')):?>
                      <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                        <?= session()->getFlashdata('message') ?>
                      </div>
                    <?php endif;?>
                  </p>
                  <form action="/ModifyEvent/chooseHall" class="forms-sample" method="post" enctype="multipart/form-data">
                    
                    
                    <div class="form-row">
                      <div class="form-holder" style="padding-bottom:10px !important; width: 100%;"> 
                        <label for="venue_hall">Pick Your Hall and Location</label>
                        <select name="venue_hall" class="form-control" aria-hidden="true" onchange="onVenueChange(this)" style="color:#000;">
                          <option value=-1>Select Your Location
                        <?php
                          $i = 0;
                          foreach($venues as $value) {
                        ?>
                          <option <?php if (isset($tblcompany_venue_id) && $value->id==$tblcompany_venue_id) {echo "selected";} else {if ($i==0) echo "selected";} ?> value="<?=$value->id?>"><?=$value->name?></option>
                        <?php
                            $i++;
                          }
                        ?>
                        </select>
                      </div>

                      <div class="form-holder" style="width: 100%; padding-bottom:10px !important;"> 
                        <label for="event_type">Select Event Type</label>
                        <select name="event_type" class="form-control" aria-hidden="true" style="color:#000;">
                          <option value=-1>Event Type</option>
                        <?php
                          foreach($event_types as $event_type) {
                        ?>
                          <option <?php if (isset($tblcompany_event_type_id) && $event_type->id==$tblcompany_event_type_id) echo "selected"; ?> value="<?=$event_type->id?>"><?=$event_type->event_type?></option>
                        <?php
                          }
                        ?>
                        </select>
                      </div>
                    </div>

                
                    <?php if(isset($_SESSION["MODIFYEVENTS"]["STEP-1"]["need_a_hall_rental"]) && $_SESSION["MODIFYEVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes'){ ?> 
                    <div class="form-row">
                      
                    <div class="form-holder"> 
                      <br />
                        <div class="display-4">MENU OPTIONS:</div>
                        <label for="menu_option">Choose you desired menu from below options:</label>
                        <br /><p class="card-description">NOTE: Tea/Coffee and Soft Drink Included</p><br/>
                        <div id="div_menu_option">
                        <?php
                          foreach($menu_options as $menu_option) {
                              if(!str_contains($menu_option->name, 'Bar')){
                        ?>
                          <input name="menu_option" id="menu_option<?=$menu_option->id?>" type="radio" <?php if (isset($tblcompany_menuOption_id) && $menu_option->id==$tblcompany_menuOption_id) echo "checked"; ?> value="<?=$menu_option->id?>" />&nbsp;&nbsp;<label for="menu_option<?=$menu_option->id?>"><?=$menu_option->name?></label><br />
                        <?php
                          }
                          }
                        ?>
                        </div>
                      </div>

                    </div>
                    <div class="form-row">
                      
                    <div class="form-holder"> 
                      <br />
                        <div class="display-4">BAR OPTIONS:</div>
                        <label for="menu_option">Choose you desired options:</label>
                        <div id="div_menu_option">
                        <?php
                          foreach($menu_options as $menu_option) {
                              if(str_contains($menu_option->name, 'Bar')){
                                if(isset($tblcompany_barOption_id) && $tblcompany_barOption_id==0){$tblcompany_barOption_id=55;}else{$tblcompany_barOption_id=$menu_option->id;}  
                        ?>
                          <input name="bar_option" class="<?php echo $tblcompany_barOption_id; ?>" id="bar_option<?=$menu_option->id?>" type="radio" <?php if (isset($_SESSION["MODIFYEVENTS"]["STEP-2"]["tblcompany_barOption_id"]) && $menu_option->id==$_SESSION["MODIFYEVENTS"]["STEP-2"]["tblcompany_barOption_id"]) echo "checked"; ?> value="<?=$menu_option->id?>" />&nbsp;&nbsp;<label for="bar_option<?=$menu_option->id?>"><?=$menu_option->name?></label><br />
                        <?php
                          }
                          }
                        ?>
                        </div>
                      </div>

                    </div>
                    <?php } ?>
                    <br />
                    <input type="button" class="btn btn-light" onclick="document.location='/ModifyEvent/new'" value="Previous" />
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
        


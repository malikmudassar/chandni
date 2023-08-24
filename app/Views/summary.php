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
        <table cellspacing="5">
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Groom/Bride Details</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?php
                        if (isset($_SESSION["EVENTS"]["STEP-1"]['groom_title']) && $_SESSION["EVENTS"]["STEP-1"]['groom_title'] !='') {
                    ?>
                    <?=$_SESSION["EVENTS"]["STEP-1"]["groom_title"].'. '.$_SESSION["EVENTS"]["STEP-1"]["groom_fname"].' '.$_SESSION["EVENTS"]["STEP-1"]["groom_lname"]?>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Bride:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["bride_title"].'. '.$_SESSION["EVENTS"]["STEP-1"]["bride_fname"].' '.$_SESSION["EVENTS"]["STEP-1"]["bride_lname"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom Phone No:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["groom_phone"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Bride Phone No:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["bride_phone"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom Address:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["groom_address"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Bride Address:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-1"]["bride_address"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom Driver’s License:</strong>
                </td>
                <?php if($_SESSION["EVENTS"]["STEP-1"]["groom_driver_license_file"]!=''){ ?>
                <td style="padding-left: 10px">
                    <a target="_blank" href='<?=$_SESSION["EVENTS"]["STEP-1"]["groom_driver_license_file"]?>'>View File</a>
                </td>
                <?php }else{ echo '<td>Not uploaded</td>'; } ?>
            </tr>
            <tr>
                <td>
                    <strong>Bride Driver’s License:</strong>
                </td>
                <?php if($_SESSION["EVENTS"]["STEP-1"]["bride_driver_license_file"]!=''){ ?>
                <td style="padding-left: 10px">
                    <a target="_blank" href='<?=$_SESSION["EVENTS"]["STEP-1"]["bride_driver_license_file"]?>'>View File</a>
                </td>
                <?php }else{ echo '<td>Not uploaded</td>'; } ?>
            </tr>
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
                <?php 
                if($_SESSION["EVENTS"]["STEP-1"]["event_time"]=='Morning Event'){ $time='Morning Event - 8:00 am - 3:00 pm';}
                if($_SESSION["EVENTS"]["STEP-1"]["event_time"]=='Evening Event'){ $time='Evening Event - 6:00 pm - 1:00 am';}
                if($_SESSION["EVENTS"]["STEP-1"]["event_time"]=='Full Day Event'){ $time='Full Day Event – 8:00 am – 1:00 am';}
                echo date('Y-m-d', strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"])) ." (". $time.")";
                ?>
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
                    <a target="_blank" href='<?=$_SESSION["EVENTS"]["STEP-1"]["own_license_file"]?>'>View File</a>
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
                    <?=$_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes' ? 'No' : 'Yes'?>
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
            <?php } ?>
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
            <?php if(isset($_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]) && $_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes'){ ?>
            <tr>
                <td>
                    <strong>Your Selected Menu Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_menuOption"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Selected Bar Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_barOption"]?>
                </td>
            </tr>
            <?php } 
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
                if(isset($_SESSION["EVENTS"]["STEP-3"]["label"])){
                foreach($_SESSION["EVENTS"]["STEP-3"]["label"] as $key => $value) {
                    
            ?>
                    <tr>
                        <td colspan=2 style="vertical-align:top">
                        <table>
                            <tr>
                            
                            <td style="vertical-align:top">
                             <strong><?=$key?><?php if($key=='APPETIZER' || $key=='MAIN COURSE'){ ?>(Start Time: <?=$key=='APPETIZER' ? date('h:i A', strtotime($_SESSION["APPETIZER"]["start_time"]))  : date('h:i A', strtotime($_SESSION["MAINCOURSE"]["start_time"])) ?>, End Time: <?=$key=='APPETIZER' ? date('h:i A', strtotime($_SESSION["APPETIZER"]["end_time"]))  : date('h:i A', strtotime($_SESSION["MAINCOURSE"]["end_time"])) ?>)<?php } ?></strong>
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
                }else{
            ?>       <tr>
                        <td colspan=2 style="vertical-align:top">
            <?php                
                    echo "No Menu Selected";
                }
            ?>
            </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong><?=$_SESSION["EVENTS"]["STEP-2"]["label"]["selected_barOption"]?></strong></4>
                </td>
            </tr>
            <?php
            if(isset($_SESSION["EVENTS"]["STEP-3"]["barLabel"])){
            foreach($_SESSION["EVENTS"]["STEP-3"]["barLabel"] as $key => $value) {
                    
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
                    <a href="https://smartsoundav.ca/" target="_blank">www.smartsoundav.ca</a>
                </td>
            </tr>
            
            <!-- <?php
                //if (isset($_SESSION["EVENTS"]["STEP-9"]["label"])) {
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
                    <?php //echo $_SESSION["EVENTS"]["STEP-9"]["label"]?>
                </td>
            </tr>
            <?php
                //}
            ?> -->
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
<?php
    }
?>

<?php
    if (isset($_SESSION["MODIFYEVENTS"]["STEP-1"])) {
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
        <table cellspacing="5">
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Groom/Bride Details</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["groom_title"].'. '.$_SESSION["MODIFYEVENTS"]["STEP-1"]["groom_fname"].' '.$_SESSION["MODIFYEVENTS"]["STEP-1"]["groom_lname"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Bride:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["bride_title"].'. '.$_SESSION["MODIFYEVENTS"]["STEP-1"]["bride_fname"].' '.$_SESSION["MODIFYEVENTS"]["STEP-1"]["bride_lname"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom Phone No:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["groom_phone"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Bride Phone No:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["bride_phone"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom Address:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["groom_address"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Bride Address:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["bride_address"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Groom Driver’s License:</strong>
                </td>
                <?php if($_SESSION["MODIFYEVENTS"]["STEP-1"]["groom_driver_license_file"]!=''){ ?>
                <td style="padding-left: 10px">
                    <a target="_blank" href='<?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["groom_driver_license_file"]?>'>View File</a>
                </td>
                <?php }else{ echo '<td>Not uploaded</td>'; } ?>
            </tr>
            <tr>
                <td>
                    <strong>Bride Driver’s License:</strong>
                </td>
                <?php if($_SESSION["MODIFYEVENTS"]["STEP-1"]["bride_driver_license_file"]!=''){ ?>
                <td style="padding-left: 10px">
                    <a target="_blank" href='<?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["bride_driver_license_file"]?>'>View File</a>
                </td>
                <?php }else{ echo '<td>Not uploaded</td>'; } ?>
            </tr>
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
                <?php 
                if($_SESSION["MODIFYEVENTS"]["STEP-1"]["event_time"]=='Morning Event'){ $time='Morning Event - 8:00 am - 3:00 pm';}
                if($_SESSION["MODIFYEVENTS"]["STEP-1"]["event_time"]=='Evening Event'){ $time='Evening Event - 6:00 pm - 1:00 am';}
                if($_SESSION["MODIFYEVENTS"]["STEP-1"]["event_time"]=='Full Day Event'){ $time='Full Day Event – 8:00 am – 1:00 am';}
                echo date('Y-m-d', strtotime($_SESSION["MODIFYEVENTS"]["STEP-1"]["event_datetime"])) ." (". $time.")";
                ?>
                </td>
            </tr>
            
            
            
            <tr>
                <td>
                    <strong>No of Guests:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["no_of_guests"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Coat Check?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["coat_check"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Valid Licensed Bar?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["valid_licensed_bar"]?>
                </td>
            </tr>                      
            
            <?php
            if ($_SESSION["MODIFYEVENTS"]["STEP-1"]["valid_licensed_bar"]=="Own Liquor License") {
            ?>
            <tr>
                <td>
                    <strong>Licene file:</strong>
                </td>
                <td style="padding-left: 10px">
                    <a target="_blank" href='<?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["own_license_file"]?>'>View File</a>
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
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["coat_check"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>No. of Bartenders?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["no_of_bartenders"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>Need a Hall Rental?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes' ? 'No' : 'Yes'?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>Need Security Gaurds?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["need_security_gaurds"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>How many Security Gaurds?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["how_many_security_gaurds"]?>
                </td>
            </tr>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-2"]["label"])) {
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
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_venue"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Event Type:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_eventType"]?>
                </td>
            </tr>
            <?php if(isset($_SESSION["MODIFYEVENTS"]["STEP-1"]["need_a_hall_rental"]) && $_SESSION["MODIFYEVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes'){ ?>
            <tr>
                <td>
                    <strong>Your Selected Menu Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_menuOption"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Selected Bar Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_barOption"]?>
                </td>
            </tr>
            <?php } 
                }
            ?>

            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-3"]["label"])) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong><?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_menuOption"]?></strong></4>
                </td>
            </tr>
            <?php
                foreach($_SESSION["MODIFYEVENTS"]["STEP-3"]["label"] as $key => $value) {
                    
            ?>
                    <tr>
                        <td colspan=2 style="vertical-align:top">
                        <table>
                            <tr>
                            <td style="vertical-align:top">
                             <strong><?=$key?><?php if($key=='APPETIZER' || $key=='MAIN COURSE'){ ?>(Start Time: <?=$key=='APPETIZER' ? date('h:i A', strtotime($_SESSION["APPETIZER"]["start_time"]))  : date('h:i A', strtotime($_SESSION["MAINCOURSE"]["start_time"])) ?>, End Time: <?=$key=='APPETIZER' ? date('h:i A', strtotime($_SESSION["APPETIZER"]["end_time"]))  : date('h:i A', strtotime($_SESSION["MAINCOURSE"]["end_time"])) ?>)<?php } ?></strong>
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
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-4"]["label"])) {
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
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-4"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-5"]["label"])) {
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
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-5"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
                
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-6"]["label"])) {
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
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-6"]["label"]?>
                </td>
            </tr>
            <?php
                }
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
                    <a href="https://smartsoundav.ca/" target="_blank">www.smartsoundav.ca</a>
                </td>
            </tr>
            
            <!-- <?php
                //if (isset($_SESSION["MODIFYEVENTS"]["STEP-9"]["label"])) {
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
                    <?php //echo $_SESSION["MODIFYEVENTS"]["STEP-9"]["label"]?>
                </td>
            </tr>
            <?php
                //}
            ?> -->

           <?php
            if (isset($_SESSION["MODIFYEVENTS"]["STEP-13"]["discount"]) && $_SESSION["MODIFYEVENTS"]["STEP-13"]["discount"] !="" && $_SESSION["MODIFYEVENTS"]["STEP-13"]["discount"]!=null) {
            ?>
            <tr>
                <td colspan=2>&nbsp;
                    
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Discount</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Discount:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-13"]["discount"]?>%
                </td>
            </tr>
            <?php
                }
            ?>


            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-10"]["label"])) {
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
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-10"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-11"]["label"])) {
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
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-11"]["label"]?>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="padding-left: 10px">&nbsp;</td>
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
<?php
    }
?>
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
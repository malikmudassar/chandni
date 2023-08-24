<div>
    <h2 class="mb-0 font-weight-normal"><?php 
        //echo $temperature["condition"]; exit;
        if (strpos(strtolower($temperature["condition"]), 'snow')!==false) {
            echo '<i class="mdi mdi-weather-snowy">';
        } else if (strpos(strtolower($temperature["condition"]), 'rain')!==false) {
            echo '<i class="mdi mdi-weather-rainy">';
        } else if (strpos(strtolower($temperature["condition"]), 'cloud')!==false) {
            echo '<i class="mdi mdi-cloud-outline">';
        } else if (strpos(strtolower($temperature["condition"]), 'wind')!==false) {
            echo '<i class="mdi mdi-weather-windy">';
        } else if (strpos(strtolower($temperature["condition"]), 'sun')!==false) {
            echo '<i class="icon-sun mr-2">';
        }
    ?></i><?=round((str_replace("°", "", $temperature["current_temperature"])-32)/1.8)."°"?><sup>C</sup></h2>
</div>
<div class="ml-2">
    <h4 class="location font-weight-normal">Brampton</h4>
    <h6 class="font-weight-normal">ON. Canada.</h6>
    <h6 class="font-weight-normal" style="text-align:right; font-size:12px"> last updated on: <br /><?=$temperature["as_of_time"]?></h6>
    <h6 class="font-weight-normal" style="text-align:right; font-size:12px"> Day: <?=round((str_replace("°", "", $temperature["day_temperature"])-32)/1.8)."°"?><br />
    >Night: <?=round((str_replace("°", "", $temperature["night_temperature"])-32)/1.8)."°"?></h6>
</div>
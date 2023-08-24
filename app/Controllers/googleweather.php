<?php

namespace App\Controllers;

class Gw extends BaseController {
    public function index() {
        $location = "London";
        $hl = 'en';
        $url = $this->_api_url.'?weather='.urlencode($location).'&oe=utf-8'; // oe parameter fix for Spanish chars
        $xml = simplexml_load_file($url);
        
        $information = $xml->xpath("/xml_api_reply/weather/forecast_information");
		$current = $xml->xpath("/xml_api_reply/weather/current_conditions");
		$forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");
        
        /* Example how you can use this: 
        
		$current[0]->temp_f['data']; 
        $current[0]->temp_c['data'];
		$current[0]->condition['data'];
        $current[0]->icon['data'];
        $information[0]->city['data'];
        foreach ($forecast_list as $forecast) :
            $forecast->icon['data'];
            $forecast->day_of_week['data'];
            $forecast->low['data']; 
            $forecast->high['data'];
	        $forecast->condition['data'];
        endforeach;
        
        */

        $result = array(
                    'information' => $information,
                    'current' => $current,
                    'forecast_list' => $forecast_list
                );
                $this->show($information, 0);
                $this->show($current, 0);
                $this->show($forecast_list, 0);
                $this->show($result, 1);        
        return $result;
    }
}

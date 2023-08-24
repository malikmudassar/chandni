<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use DateTime;
class Chef extends BaseController
{
    protected $request;

    public function index() {
        $session = session();
        $session->set('forgetPassRedirection', 'Chef');
        $session->set('forgetPassTable', 'tblcompany_users');
        helper('html');
        if (isset($_SESSION["user_id"])) {
            echo view('chefHeader');
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('chefLeftSidebar');
            //$data["temperature"] = $this->getTemperature();
            $data["temperature"] = '';
            $eventsModel = model('App\Models\EventsModel');
            $clientModel = model('App\Models\CompanyClientModel');
            
            $today_events = $eventsModel->where("tblcompany_id", SITE_ID)
                                    ->where("need_a_hall_rental", "No")->where("event_datetime >=", date("Y-m-d")." 00:00:00") 
                                    ->where("event_datetime <=", date("Y-m-d")." 23:59:59")
                                    ->orderBy("event_datetime", "ASC")
                                    ->get()->getResult();
            
            
            $data["todays_total_orders"] = count($today_events);
            
            $data["total_dishes"] = 0;
            $data["total_guests"] = 0;
            foreach ($today_events as $today_event) {
                $data["total_dishes"] += count(explode(",", $today_event->menu_item_selection));
                $data["total_guests"] += $today_event->no_of_guests;
            }

            if (isset($today_events[0])) {
                $first_event_datetime = $today_events[0]->event_datetime;
                $today = date("Y-m-d H:i:s");
                
                $diff = abs(strtotime($first_event_datetime) - strtotime($today));

                $years   = floor($diff / (365*60*60*24)); 
                $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
                $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

                $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

                $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

                $str_first_event_in = "Coming Event in: ";
                if ($years>0) {
                    $str_first_event_in .= $years." years, ";
                } 
                if ($months>0) {
                    $str_first_event_in .= $months." months, ";
                } 
                if ($days>0) {
                    $str_first_event_in .= $days." days, ";
                } 
                if ($hours>0) {
                    $str_first_event_in .= $hours." hours, ";
                } 
                if ($minuts>0) {
                    $str_first_event_in .= $minuts." minutes, ";
                } 
                if ($seconds>0) {
                    $str_first_event_in .= $seconds." seconds.";
                } 
                $data["str_first_event_in"] = $str_first_event_in;
            }
            
            $all_events = $eventsModel->where("tblcompany_id", SITE_ID)->orderBy("event_datetime", "DESC")->get()->getResult();
            // echo '<pre>';
            // print_r($all_events);
            // exit;
            $data["total_events"] = count($all_events);

            $data["events_completed"] = 0;
            $data["venues"] = $this->getAllCompanyVenues();
            
            $companyVenueModel = model('App\Models\CompanyVenueModel');
            $menuOptionModel = model('App\Models\MenuOptionModel');
            $companyVenueServiceChargesModel = model('App\Models\CompanyVenueServiceChargesModel');
            $companyVenueTaxes = model('App\Models\CompanyVenueTaxes');
            $companyBuffetPricingModel = model('App\Models\CompanyBuffetPricingModel');
            $companyVenueTableClothModel = model('App\Models\CompanyVenueTableClothModel');
            $companyVenueFlowersModel = model('App\Models\CompanyVenueFlowersModel');
            $companyVenueNapkinsModel = model('App\Models\CompanyVenueNapkinsModel');
            $soundOptionsModel = model('App\Models\SoundOptionsModel');
            $companyMiscPricingModel = model('App\Models\CompanyMiscPricing');

            $miscPricings = $companyMiscPricingModel->where("tblcompany_id", SITE_ID)->get()->getResult();

            $bartender_per_person = 0;
            $security_Guard_per_person = 0;
            $per_person = array();
            $per_hall = array();
            foreach ($miscPricings as $miscPricing) {
                if ($miscPricing->option_key=="Bartender_per_person") {
                    $bartender_per_person = $miscPricing->option_price;
                    $per_person[] = $miscPricing;
                } else if ($miscPricing->option_key=="Security_Guard_per_person") {
                    $security_Guard_per_person = $miscPricing->option_price;
                    $per_person[] = $miscPricing;
                } else {
                    $ex = explode("_", $miscPricing->option_key);
                    if ($ex[count($ex)-2]=="per" && $ex[count($ex)-1]=="person") {
                        $per_person[] = $miscPricing;
                    } else if ($ex[count($ex)-2]=="per" && $ex[count($ex)-1]=="hall") {
                        $per_hall[] = $miscPricing;
                    }
                }
            }
            
            $hallRental='';
            
            foreach($all_events as $event) {
                if($event->need_a_hall_rental=='Yes'){
                    $hallRental=='Yes';
                }else{
                    $hallRental=='No';
                }
                if ($event->status=="completed") {
                    $data["events_completed"]++;
                }
                
                foreach($data["venues"] as $venue) {
                    if ($venue->id==$event->tblcompany_venue_id) {
                        $venues[$venue->name][] = $event->id;
                    }
                }

                $venue_name = $companyVenueModel->where("id", $event->tblcompany_venue_id)->get()->getResult();
                $client_record = $clientModel->where("id", $event->tblcompany_client_id)->get()->getResult();

                $client_name = "";
                $avator = "";
                foreach ($client_record as $client_rec) {
                    $client_name = $client_rec->first_name." ".$client_rec->last_name;

                    if ($client_rec->gender=="male") {
                        $avator = "https://chandani.dinxstudio.com/assets/images/male.png";
                    } else {
                        $avator = "https://chandani.dinxstudio.com/assets/images/female.png";
                    }
                }
                
                $data["new_clients"][$client_name] = array(
                    "name" => $client_name,
                    "avator" => $avator,
                    "venue" => $venue_name[0]->name,
                    "no_of_guests" => $event->no_of_guests, 
                    "event_datetime" =>  date("F j, Y, g:i a", strtotime($event->event_datetime))
                );
                                        
                $pricing = $companyBuffetPricingModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                    ->where("tblcompany_menuOption_id", $event->tblcompany_menuOption_id)
                                                    ->get()->getResult();
                $serviceCharges = $companyVenueServiceChargesModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)->get()->getResult();
                $companyVenueTax = $companyVenueTaxes->where("tblcompany_venue_id", $event->tblcompany_venue_id)->get()->getResult();
                $tableCloth = $companyVenueTableClothModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                            ->where("id", $event->tableCloth_id)        
                                                            ->get()
                                                            ->getResult();
                if(empty($tableCloth)){
                    $tableCloth=0;
                }
                
                $flowers = $companyVenueFlowersModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                            ->where("id", $event->flower_id)        
                                                            ->get()
                                                            ->getResult();
                
                $flowers=0;
                
                $napkin = $companyVenueNapkinsModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                            ->where("id", $event->napkin_id)        
                                                            ->get()
                                                            ->getResult();
                                                            
                if(empty($napkin)){
                    $napkin=0;
                }                                            
                
                $sound_option = 0;
                $soundOption = array();
                if ($event->sound_option_id!=0) {
                    $soundOption = $soundOptionsModel->where("tblcompany_id", SITE_ID)->where("id", $event->sound_option_id)->get()->getResult();
                    $sound_option = 1;
                }
                
                
                
                $price = 0;
                $sound_price = 0;
                if (date("w", strtotime($event->event_datetime))==0) {
                    if($hallRental=='Yes'){
                        $price = $pricing[0]->Sunday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Sunday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Sunday*$price)/100);
                    $price += (($companyVenueTax[0]->Sunday*$price)/100);
                    $tax = (($companyVenueTax[0]->Sunday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Sunday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Sunday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Sunday*$price)/100);
                    $napkin_price = (($napkin[0]->Sunday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Sunday*$price)/100);
                        $sound_price = (($soundOption[0]->Sunday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==1) {
                    if($hallRental=='Yes'){
                    $price = $pricing[0]->Monday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Monday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Monday*$price)/100);
                    $price += (($companyVenueTax[0]->Monday*$price)/100);
                    $tax = (($companyVenueTax[0]->Monday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Monday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Monday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Monday*$price)/100);
                    $napkin_price = (($napkin[0]->Monday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }
                    if ($sound_option) {
                        $price += (($soundOption[0]->Monday*$price)/100);
                        $sound_price = (($soundOption[0]->Monday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==2) {
                    if($hallRental=='Yes'){
                    $price = $pricing[0]->Tuesday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Tuesday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Tuesday*$price)/100);
                    $price += (($companyVenueTax[0]->Tuesday*$price)/100);
                    $tax = (($companyVenueTax[0]->Tuesday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Tuesday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Tuesday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Tuesday*$price)/100);
                    $napkin_price = (($napkin[0]->Tuesday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }
                    if ($sound_option) {
                        $price += (($soundOption[0]->Tuesday*$price)/100);
                        $sound_price = (($soundOption[0]->Tuesday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==3) {
                    if($hallRental=='Yes'){
                    $price = $pricing[0]->Wednesday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Wednesday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Wednesday*$price)/100);
                    $price += (($companyVenueTax[0]->Wednesday*$price)/100);
                    $tax = (($companyVenueTax[0]->Wednesday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Wednesday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Wednesday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Wednesday*$price)/100);
                    $napkin_price = (($napkin[0]->Wednesday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }
                    
                    if ($sound_option) {
                        $price += (($soundOption[0]->Wednesday*$price)/100);
                        $sound_price = (($soundOption[0]->Wednesday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==4) {
                    if($hallRental=='Yes'){
                        $price = $pricing[0]->Thursday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Thursday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Thursday*$price)/100);
                    $price += (($companyVenueTax[0]->Thursday*$price)/100);
                    $tax = (($companyVenueTax[0]->Thursday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Thursday*$price)/100);
                    
                    $tableCloth_price = (($tableCloth[0]->Thursday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Thursday*$price)/100);
                    $napkin_price = (($napkin[0]->Thursday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }
                    if ($sound_option) {
                        $price += (($soundOption[0]->Thursday*$price)/100);
                        $sound_price = (($soundOption[0]->Thursday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==5) {
                    if($hallRental=='Yes'){
                        $price = $pricing[0]->Friday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Friday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Friday*$price)/100);
                    $price += (($companyVenueTax[0]->Friday*$price)/100);
                    $tax = (($companyVenueTax[0]->Friday*$price)/100);
                    if($tableCloth!=0){
                    $tableCloth_price = (($tableCloth[0]->Friday*$price)/100);
                    $price += (($tableCloth[0]->Friday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $napkin_price = (($napkin[0]->Friday*$price)/100);
                    $price += (($napkin[0]->Friday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }
                    if ($sound_option) {
                        $price += (($soundOption[0]->Friday*$price)/100);
                        $sound_price = (($soundOption[0]->Friday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==6) {
                    if($hallRental=='Yes'){
                    $price = $pricing[0]->Saturday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Saturday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Saturday*$price)/100);
                    $price += (($companyVenueTax[0]->Saturday*$price)/100);
                    $tax = (($companyVenueTax[0]->Saturday*$price)/100);
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Saturday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Saturday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    
                    if($napkin!=0){
                    $price += (($napkin[0]->Saturday*$price)/100);
                    $napkin_price = (($napkin[0]->Saturday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }
                    
    
                    if ($sound_option) {
                        $price += (($soundOption[0]->Saturday*$price)/100);
                        $sound_price = (($soundOption[0]->Saturday*$price)/100);
                    }
                }

                $price *= $event->no_of_guests;

                $data["buffetPrice"] = $buffetPrice*$event->no_of_guests;
                $data["serviceCharge"] = $serviceCharge*$event->no_of_guests;
                $data["tax_title"] = $companyVenueTax[0]->name;
                $data["tax"] = $tax*$event->no_of_guests;
                $data["tableCloth_price"] = $tableCloth_price*$event->no_of_guests;
                $data["flowers_price"] = $flowers_price*$event->no_of_guests;
                $data["napkin_price"] = $napkin_price*$event->no_of_guests;
                $data["sound_option"] = $sound_option;
                $data["sound_price"] = $sound_price;

                $total_person = 0;
                $data["total_price"] = 0;
                $misc_price = array();
                
                if (count($per_person)>0) {
                    foreach($per_person as $option) {
                        eval("\$total_person = \$event->$option->event_table_field_name;"); 
                        $price += $total_person*$option->option_price;
                        $misc_price[$option->title] = $total_person*$option->option_price;
                        $data["total_price"] += $misc_price[$option->title];
                    }
                }

                $isOptionSelected = 0;
                if (count($per_hall)>0) {
                    foreach($per_hall as $option) {
                        eval("\$isOptionSelected = \$event->$option->event_table_field_name;"); 
                        if ($isOptionSelected==1) {
                            $price += $option->option_price;
                            $misc_price[$option->title] = $option->option_price;
                            $data["total_price"] += $misc_price[$option->title];
                        }
                    }
                }

                $data["misc_price"] = $misc_price;
                $data["total_price"] += floatval($data["buffetPrice"]) + floatval($data["serviceCharge"]) + floatval($data["tax"]) + 
                                        floatval($data["tableCloth_price"]) + floatval($data["flowers_price"]) + floatval($data["napkin_price"]) + $data["sound_price"];
                    if($event->tblcompany_menuOption_id!=0){
                        $data["all_events"][] = array(
                            "client_name" => $client_name,
                            "venue" => $venue_name[0]->name,
                            "menu" => $menuOptionModel->where("id", $event->tblcompany_menuOption_id)->get()->getResult()[0]->name,
                            "no_of_guests" => $event->no_of_guests, 
                            "Payment" => "$".number_format($data["total_price"], 2, ",", "."),
                            "event_datetime" =>  date("F j, Y, g:i a", strtotime($event->event_datetime)),
                            "status" => $event->status
                        );
                    }else{
                        $data["all_events"][] = array(
                            "client_name" => $client_name,
                            "venue" => $venue_name[0]->name,
                            "menu" => 'No menu',
                            "no_of_guests" => $event->no_of_guests, 
                            "Payment" => "$".number_format($data["total_price"], 2, ",", "."),
                            "event_datetime" =>  date("F j, Y, g:i a", strtotime($event->event_datetime)),
                            "status" => $event->status
                        );
                    }    
                    
                }
            
            $data["all_venues"] = $venues;
            echo view('chefHome', $data);
            echo view('adminFooter');
        } else {
            $companyModel = model('App\Models\CompanyModel');
    
            $company = $companyModel->find(SITE_ID);
    
            $data['company_name'] = $company["name"];
            $data['logo'] = $company["logo"];

            if ($this->request->getMethod() == "post") {
                $post = $this->request->getRawInput(); 
                
                $session = session();
    
                $cUserModel = model('App\Models\CompanyUserModel');
    
                $email = $this->request->getVar('email');
                $password = $this->request->getVar('password');
                
                $data = $cUserModel->where('email', $email)->first();
    
                if($data) {
                    $pass = $data['password'];
                    $authenticatePassword = md5($password, $pass);
    
                    if(password_verify($password, $pass)){
                        $ses_data = [
                            'user_id' => $data['id'],
                            'name' => $data['fname']." ".$data['lname'],
                            'email' => $data['email'],
                            "logo" => $company["logo"],
                            "avatar" => $data["avatar"],
                            'isLoggedIn' => TRUE
                        ];
                        $session->set($ses_data);
                        return redirect()->to(site_url().'Chef');
                    
                    } else {
                        $session->setFlashdata('msg', 'Password is incorrect.');
                        return redirect()->to(site_url().'Chef');
                    }
    
                }else{
                    $session->setFlashdata('msg', 'Email does not exist.');
                    return redirect()->to(site_url().'Chef');
                }
            }
            //$data["temperature"] = $this->getTemperature();
            $data["temperature"] = array();
            return view('chef', $data);
        }
    }

    public function companyProfile() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompanies');
            $crud->columns(array('logo', 'name','address','phone','website'));
            $crud->fields(array('logo', 'name','address','phone','website'));
            $crud->fieldType("phone", "string");
            
            $crud->unsetAdd();
            $crud->unsetBackToDatagrid();
            $crud->unsetDelete();

            $crud->callbackColumn('logo', function($value, $primaryKey) {
                return '<img src="'. $value .'" width=100>';
            });

            $companyModel = model('App\Models\CompanyModel');
            $crud->callbackAfterUpdate(function ($stateParameters) use ($companyModel) {
                $data = [
                    'updated_by'   => $_SESSION["user_id"],
                    'updated_at'  => date("Y-m-d H:i:s")
                ];

                $companyModel->update($data, ['id' => $stateParameters->primaryKeyValue]);

                return $stateParameters;
            });

            $output = $crud->render();

            echo view('chefHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Company Profile",
                "title_description" => "Company profile can be managed here"
            );
            //echo "<pre>"; print_r($crud_data);
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Chef');
        }
    }

    function log_user_after_update($post_array, $primary_key) {
        echo "<pre>"; 
        print_r($post_array);
        print_r($primary_key);
        exit;

        return true;
    }
    
    public function dishes() {
        $data["next"] = 1;
        $data["pre"] = -1;
        $date = date("Y-m-d");
        
        // if (isset($this->request->uri->getSegments()[2])) {
            
        //     if($this->request->uri->getSegments()[2]=='next'){
        //       $plueNo = (int)$this->request->uri->getSegments()[3];
        //       $day = 86400 * $plueNo;
        //       $date = date("Y-m-d", time() + $day);
        //       $data["next"] = $plueNo + 1 ;
        //       $data["pre"] = $plueNo - 1;
        //     }else{
        //         $minusNo = (int)$this->request->uri->getSegments()[3];
        //         $day = 86400 * $minusNo;
        //         $date = date("Y-m-d", time() + $day);
        //         $data["next"] = $minusNo + 1 ;
        //         $data["pre"] = $minusNo - 1;
        //     }
        // }
        
        
        $MenuModel = model('App\Models\MenuModel');
        $eventsModel = model('App\Models\EventsModel');
        $HallModel = model('App\Models\CompanyVenueModel');
        
        
        $events = $eventsModel->where("tblcompany_id", SITE_ID)
                                    ->where("need_a_hall_rental", "Yes")
                                    ->orderBy("event_datetime", "DESC")
                                    ->get()->getResult();
        
        
        $data["dateArr"] = array();
        
        foreach ($events as $event){
            $date=date_create($event->event_datetime);
            $event_datetime=date_format($date,"Y-m-d");
          if(!in_array($event_datetime, $data["dateArr"])){
           array_push($data["dateArr"],$event_datetime);   
          }
               
        }
        
        $date = $this->find_closest($data["dateArr"], date("Y-m-d"));
        
        if (isset($this->request->uri->getSegments()[2])) {
            
            $date=$this->request->uri->getSegments()[2];
        }
        
        $data["date"]= $date;
        //exit;
        $today_events = $eventsModel->where("tblcompany_id", SITE_ID)
                                ->where("need_a_hall_rental", "Yes")->where("event_datetime >=", $date." 00:00:00") 
                                ->where("event_datetime <=", $date." 23:59:59")
                                ->orderBy("event_datetime", "ASC")
                                ->get()->getResult();
                                
        $data["todays_total_orders"] = count($today_events);
        
        $data["total_dishes"] = 0;
        $data["dishes"] = array();
        $data["total_guests"] = 0;
        $data["id"] = array();
        $arryEventId = array();
        $arryHall = array();
        $arryEventDate = array();
        $arryGuest = array();
        foreach ($today_events as $today_event) {
            
            $data["total_dishes"] += count(explode(",", $today_event->menu_item_selection));
            $data["id"] = explode(",", $today_event->menu_item_selection);
            
            $arryEventId[$today_event->id] = explode(",", $today_event->menu_item_selection);
            
            $arryGuest[$today_event->no_of_guests] = explode(",", $today_event->menu_item_selection);
            
            $arryHall[$today_event->tblcompany_venue_id] = explode(",", $today_event->menu_item_selection);
            
            $arryEventDate[$today_event->event_time] = explode(",", $today_event->menu_item_selection);
            
            //array_push($data["dishes"],$arryTem[$today_event->id]);
            $data["total_guests"] += $today_event->no_of_guests;
            
            
        }
        
        
        $data["dishes"]=$arryEventId;
        
        $data["dish_name"] = array();
        $data["item_id"] = array();
        $data["uniq_item_id"] = array();
        foreach ($data["dishes"] as $itemId) {
            foreach($itemId as $id){
            array_push($data["item_id"],$id);
            }
        }
        
        $arryHallTem=array();
        
        foreach ($arryHall as $key => $value){
            $hallId=$key;
            foreach($value as $val){
                
                $hall_name = $HallModel->select('name')->where("id", $hallId)->get()->getResult();
                
                if (!array_key_exists($val,$arryHallTem)){
                    $arryHallTem[$val] = $hall_name[0]->name;
                }else{
                    $arryHallTem[$val] = array($arryHallTem[$val],$hall_name[0]->name);
                }
            }
        }
        
        $arryEventDateTem=array();
        
        foreach ($arryEventDate as $key => $value){
            $eventTime=$key;
            foreach($value as $val){
                
                if (!array_key_exists($val,$arryEventDateTem)){
                    $arryEventDateTem[$val] = $eventTime;
                }else{
                    $arryEventDateTem[$val] = array($arryEventDateTem[$val],$eventTime);
                }
            }
        }
        
        $arrTem=array();
        
        foreach ($arryGuest as $key => $value){
            $guest=$key;
            foreach($value as $val){
                //echo $val.'='.$guest.'<br>';
                if (!array_key_exists($val,$arrTem)){
                    $arrTem[$val] = $guest;
                }else{
                    $arrTem[$val] = $arrTem[$val] + $guest;
                }
            }
        }

        $arrayTemp=array();
        foreach($arrTem as $itemId => $guest){
            // echo "itemId :".$itemId;die();
            $dishes_name = $MenuModel->select('item_name')->where("id", $itemId)->get()->getResult();
            // echo "<pre>";print_r($dishes_name);die();
            
            if (!array_key_exists($itemId,$arrayTemp) && !empty($dishes_name)){
                    $arrayTemp[$itemId] = array($dishes_name[0]->item_name,$guest);
                }
        }
        
        $arrHallTem = array();
       foreach ($arryHallTem as $itemId => $hallname) {
            if (is_array($hallname)) {
                if (array_key_exists($itemId, $arrayTemp)) {
                    foreach ($hallname as $name) {
                        if (is_array($name)) {
                            $name = implode(", ", $name);
                        }
                        array_push($arrayTemp[$itemId], $name);
                    }
                }
            } else {
                if (array_key_exists($itemId, $arrayTemp)) {
                    array_push($arrayTemp[$itemId], $hallname);
                }
            }
        }
        
        $arrEventTimeTem=array();
        
        foreach($arryEventDateTem as $itemId => $eventTime){
            
            if(is_array($eventTime)){
               if (array_key_exists($itemId,$arrayTemp)){
                  array_push($arrayTemp[$itemId],implode(", ",$eventTime));
              }    
            }else{
                if (array_key_exists($itemId,$arrayTemp)){
                    array_push($arrayTemp[$itemId],$eventTime);
                }
            }
        }
        
        
        // echo '<pre>';
        // print_r($arryEventDate);
        // exit;
        
        
        //$data["uniq_item_id"]=array_unique($data["item_id"]);
        // $arrayTemp=array();
        // foreach ($data["uniq_item_id"] as $itemId) {

        //     $dishes_name = $MenuModel->select('item_name')->where("id", $itemId)->get()->getResult();
        //     $arrayTemp["dish"] = array($dishes_name[0]->item_name,$itemId);
        //     array_push($data["dish_name"],$arrayTemp["dish"]);
        //     //array_push($data["dish_name"],$dishes_name[0]->item_name);
            
        // }
        
        
        $data["dish_name"]=$arrayTemp;
        $data["total_dishes"] = count($data["dish_name"]);
        echo view('chefHeader');
        echo view('chefLeftSidebar');
        $venues = $this->getAllCompanyVenues();
        $data["all_venues"] = $venues;
        echo view('chefDishes', $data);
        echo view('adminFooter');
    }
    public function dishesToCook($filter=null) {
    $db = \Config\Database::connect();
    if(isset($filter))
    {
        
        $date = DateTime::createFromFormat('Y-m-d', $filter);
        if($date && $date->format('Y-m-d') === $filter)
        {
            $event_datetime = $filter;
            
        }
        else
        {
            
            $filterArr = explode('_', $filter);
            $event_datetime = date('Y-m-d'); 
        }
        
    }
    else
    {
        $event_datetime = date('Y-m-d');
    }

    if(isset($filterArr))
    {
        if($filterArr[0]=='hallVenue')
        {
            $menue =  $db->table('tblcompany_events')
            ->select('menu_item_selection,name, no_of_guests, tblcompany_barOption_id,event_time')
            ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
            ->where('menu_item_selection IS NOT NULL', null, false)
            ->where('event_datetime', $event_datetime)
            ->where('tblcompany_venue_id', $filterArr[1])
            ->get();
        }
        else
        {
            $menue =  $db->table('tblcompany_events')
            ->select('menu_item_selection,name, no_of_guests, tblcompany_barOption_id,event_time')
            ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
            ->where('menu_item_selection IS NOT NULL', null, false)
            ->where('event_datetime', $event_datetime)
            ->where('tblcompany_event_type_id', $filterArr[1])
            ->get();
        }
    }
    else
    {
        $menue =  $db->table('tblcompany_events')
        ->select('menu_item_selection,name, no_of_guests, tblcompany_barOption_id,event_time')
        ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
        ->where('menu_item_selection IS NOT NULL', null, false)
        ->where('event_datetime', $event_datetime)
        ->get();
    }

    $menueArray = $menue->getResult();
    // echo "<pre>";print_r($menueArray);die();
    if(!empty($menueArray))
    {
    $menueToCook = array();
    foreach ($menueArray as $obj) {
        $values = explode(',', $obj->menu_item_selection);
        $barOptionsIds[] = $obj->tblcompany_barOption_id;
        foreach ($values as $value) {
            if (!in_array($value, $menueToCook)) {
                $menueToCook[] = $value;
            }
        }
    }
//dishes quantity and hall
// echo "<pre>";print_r($menueArray);die();
$countedSelections = [];
foreach ($menueArray as $item) {
    $selections = explode(',', $item->menu_item_selection);
    foreach ($selections as $selection) {
        if (!isset($countedSelections[$selection])) {
            $countedSelections[$selection] = [
                'locations' => [],
                'total_guests' => 0
            ];
        }
        $abc = $item->name;
        $words = explode(' ', $abc);
        if (count($words) >= 2) {
            $abc = $words[0] . ' ' . $words[1];
        }
        $countedSelections[$selection]['locations'][] = "<br>".$abc."(".$item->no_of_guests." ppl - ".$item->event_time.")";
        $countedSelections[$selection]['total_guests'] += $item->no_of_guests;
    }
}
//echo "<pre>";print_r($countedSelections[$selection]['locations']);die();
$output = [];
foreach ($menueToCook as $selection) {
    $output[$selection] = implode('', $countedSelections[$selection]['locations']) . '<br>Total (' . $countedSelections[$selection]['total_guests'] . ' ppl)';
}
// echo "<pre>";print_r($menueToCook);die();
        $query = $db->table('tblcompany_menu')
                    ->distinct()
                    ->select('category') 
                    ->where('sub_category IS NOT NULL', null, false)
                    ->whereIn('id', $menueToCook)
                    ->whereNotIn('tblcompany_menuOption_id', $barOptionsIds)
                    ->orderBy('id', 'desc')
                    ->get();
        $category = $query->getResult();
        foreach($category as $val){
            $data[] = array(
                "category"=>$val->category, 
                "sub_category"=>$this->subCategory($val->category,$menueToCook),
            );  
    }

}
// echo "<pre>";print_r($data);die();
        echo view('chefHeader');
        echo view('chefLeftSidebar');
        $venues = $this->getAllCompanyVenues();
        $data["all_venues"] = $venues;
        $data["dataArray"] = $data;
        $data["dishesHalls"] = isset($output) ? $output : null;
        $data["eventDateTime"] = $event_datetime;
        echo view('chefDishesToCook',$data);
        echo view('adminFooter');
    }

    public function subCategory($category,$menueToCook)
    {
		$db = \Config\Database::connect();
        $query = $db->table('tblcompany_menu')
                    ->distinct()
                    ->select('sub_category,category')
                    ->where('category',$category)
                    ->where('sub_category IS NOT NULL', null, false)
                    ->whereIn('id', $menueToCook)
                    ->orderBy('id', 'desc')
                    ->get();
        $subCategory = $query->getResult();
		$i=0;
		if($subCategory != '' && $subCategory != null){
			foreach ($subCategory as $val){
                $result [$i]['category'] = $val->category;
				$result [$i]['sub_category'] = $val->sub_category;
                $result [$i]['item_name'] = $this->itemName($val->category,$val->sub_category,$menueToCook);
				$i++;
			}
		}
		return isset($result) ? $result : null;
	}

    public function itemName($category,$sub_category,$menueToCook)
    {
		$db = \Config\Database::connect();
        $query = $db->table('tblcompany_menu')
                    ->distinct()
                    ->select('item_name,id')
                    ->where('category',$category)
                    ->where('sub_category',$sub_category) 
                    ->where('sub_category IS NOT NULL', null, false)
                    ->whereIn('id', $menueToCook)
                    ->orderBy('id', 'desc')
                    ->get();
        $itemName = $query->getResult();
		$i=0;
		if($itemName != '' && $itemName != null){
			foreach ($itemName as $val){
                $result [$i]['id'] = $val->id;
				$result [$i]['item_name'] = $val->item_name;
				$i++;
			}
		}
		return isset($result) ? $result : null;
	}

    public function calendar() {
        echo view('chefHeader');
        echo view('chefLeftSidebar');
        $venues = $this->getAllCompanyVenues();
        $data["all_venues"] = $venues;
        echo view('chefCalender', $data);
        echo view('adminFooter');
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url().'Chef');
    }
    
    public function test(){
        $eventsModel = model('App\Models\EventsModel');
            
        $events = $eventsModel->where("tblcompany_id", SITE_ID)
                                    ->orderBy("event_datetime", "DESC")
                                    ->get()->getResult();
        
        
        $data["date"] = array();
        
        foreach ($events as $event){
            $date=date_create($event->event_datetime);
            $event_datetime=date_format($date,"Y-m-d");
          if(!in_array($event_datetime, $data["date"])){
           array_push($data["date"],$event_datetime);   
          }
               
        }
        //echo '<pre>';
        //print_r($data["date"]);
        
        return $this->find_closest($data["date"], date("Y-m-d h:i:s"));
    }
    
    function find_closest($array, $date)
    {
        //$count = 0;
        foreach($array as $day)
        {
            //$interval[$count] = abs(strtotime($date) - strtotime($day));
            $interval[] = abs(strtotime($date) - strtotime($day));
            //$count++;
        }
    
        asort($interval);
        $closest = key($interval);
    
        return $array[$closest];
    }

    public function SetDropdown(){
        $filterBy = $this->request->getVar('filterBy');
        if($filterBy=='hallVenue')
        {   
        $VenueModel = model('App\Models\CompanyVenueModel');
        $data = $VenueModel->select('name,id')->orderBy("id", 'asc')->get()->getResult();
        }
        else
        {
            $EventTypesModel = model('App\Models\EventTypesModel');
            $data = $EventTypesModel->select('event_type,id')->orderBy("id", 'asc')->get()->getResult();
        }
        if($data > 0)
        {
            $msg = array('Success'=>'200','data' => $data , 'filter' => $filterBy);
       }
       else
       {
            $msg = array('Success'=>'400','data' => 'Something went wrong', 'filter' => 'error');
       }
           echo json_encode($msg);
    }

}

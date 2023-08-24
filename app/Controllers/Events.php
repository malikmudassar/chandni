<?php

namespace App\Controllers;

use App\Libraries\GCalendar1;
use App\Models\EventsModel;

class Events extends BaseController
{
    public function newEvent() {
        $_SESSION["EVENTS"]=array();
        $_SESSION["event_total_amount"]='';
        $_SESSION["APPETIZER"]["start_time"]='';
        $_SESSION["MAINCOURSE"]["start_time"]='';
        $_SESSION["APPETIZER"]["end_time"]='';
        $_SESSION["MAINCOURSE"]["end_time"]='';
        $_SESSION["calendar_event_id"]='';
        $_SESSION["last_inserted_id"]='';
        return redirect()->to(site_url().'events/new');
    }
    
    public function new() {
        helper(['form']);
        helper('html');
        $_SESSION["MODIFYEVENTS"] = array();
        $companyModel = model('App\Models\CompanyModel');
        $data['valid_licensed_bar']=null;
        $company = $companyModel->find(SITE_ID);

        $data['company_name'] = $company["name"];
        $data['logo'] = $company["logo"];   
        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (isset($this->request->uri->getSegments()[2])) {
                $new_or_edit = $this->request->uri->getSegments()[2];
                $event_id = $this->request->uri->getSegments()[3];
            }

            // logged in
            $calendarEventId='';
            if (isset($_SESSION["EVENTS"]["STEP-1"]) && count($_SESSION["EVENTS"]["STEP-1"]) > 1 ) {
                 //var_dump(count($_SESSION["EVENTS"]["STEP-1"]));exit;
                $data["tblcompany_id"] = $_SESSION["EVENTS"]["STEP-1"]["tblcompany_id"];
                $data["tblcompany_client_id"] = $_SESSION["EVENTS"]["STEP-1"]["tblcompany_client_id"];
                $data["event_date"] = explode(" ", $_SESSION["EVENTS"]["STEP-1"]["event_datetime"])[0];    
                $data["event_time"] = $_SESSION["EVENTS"]["STEP-1"]["event_time"];
                $data["payment_mode"] = $_SESSION["EVENTS"]["STEP-1"]["payment_mode"];
                $data["no_of_guests"] = $_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];    
                $data["coat_check"] = $_SESSION["EVENTS"]["STEP-1"]["coat_check"];    
                $data["valid_licensed_bar"] = $_SESSION["EVENTS"]["STEP-1"]["valid_licensed_bar"];    
                $data["own_license_file"] = $_SESSION["EVENTS"]["STEP-1"]["own_license_file"];    
                $data["no_of_bartenders"] = $_SESSION["EVENTS"]["STEP-1"]["no_of_bartenders"];    
                $data["need_a_hall_rental"] = $_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"];    
                $data["need_security_gaurds"] = $_SESSION["EVENTS"]["STEP-1"]["need_security_gaurds"];    
                $data["how_many_security_gaurds"] = $_SESSION["EVENTS"]["STEP-1"]["how_many_security_gaurds"];
                
                // Groom & Bride information
                
                $data["groom_title"] = $_SESSION["EVENTS"]["STEP-1"]["groom_title"];
                $data["groom_fname"] = $_SESSION["EVENTS"]["STEP-1"]["groom_fname"];
                $data["bride_title"] = $_SESSION["EVENTS"]["STEP-1"]["bride_title"];
                $data["bride_fname"] = $_SESSION["EVENTS"]["STEP-1"]["bride_fname"];
                
                $data["groom_lname"] = $_SESSION["EVENTS"]["STEP-1"]["groom_lname"];
                $data["bride_lname"] = $_SESSION["EVENTS"]["STEP-1"]["bride_lname"];
                $data["groom_phone"] = $_SESSION["EVENTS"]["STEP-1"]["groom_phone"];
                $data["bride_phone"] = $_SESSION["EVENTS"]["STEP-1"]["bride_phone"];
                
                $data["groom_address"] = $_SESSION["EVENTS"]["STEP-1"]["groom_address"];
                $data["bride_address"] = $_SESSION["EVENTS"]["STEP-1"]["bride_address"];
                
                $data["groom_driver_license_file"] = $_SESSION["EVENTS"]["STEP-1"]["groom_driver_license_file"];
                $data["bride_driver_license_file"] = $_SESSION["EVENTS"]["STEP-1"]["bride_driver_license_file"];
                
                $data["calendar_event_id"] = $_SESSION["EVENTS"]["STEP-1"]["calendar_event_id"];
                $calendarEventId=$_SESSION["EVENTS"]["STEP-1"]["calendar_event_id"];
                $data["created_at"] = $_SESSION["EVENTS"]["STEP-1"]["created_at"];    
            }

            if ($this->request->getMethod() == "post") {
        
                $filepath = "";
                $groom_driver_license_filepath='';
                $bride_driver_license_filepath='';
                
                $file_uploaded = -1;
                $groom_driver_license_file_uploaded = -1;
                $bride_driver_license_file_uploaded = -1;
                
                $validarion_failed = false;
                $groom_driver_license_validation_failed = false;
                $bride_driver_license_validation_failed = false;
                
                if($file = $this->request->getFile('own_license') && 
                    $this->request->getFile('own_license')!="") {

                    $name = $_FILES["own_license"]["name"];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    
                    $newName = getcwd()."/assets/uploads/client_own_license/".uniqid(rand(), true) . ".".$ext; 
                    //$file->move('assets/uploads/client_own_license/', $newName);
                    if (move_uploaded_file($_FILES['own_license']['tmp_name'], $newName)) {
                        $filepath = base_url().str_replace(getcwd(), "", $newName);
                        //https://chandani.dinxstudio.com//assets/uploads/client_own_license/1644192071_4525dd4d86913fe8a589.png

                        // session()->setFlashdata('message', 'Your License, Uploaded Successfully!');
                        // session()->setFlashdata('alert-class', 'alert-success');
                        session()->setFlashdata('filepath', $filepath);
                        session()->setFlashdata('extension', $ext);
                        $file_uploaded = 1;
                    } else {
                        // Set Session
                        session()->setFlashdata('message', 'File not uploaded.');
                        session()->setFlashdata('alert-class', 'alert-danger');
                        $file_uploaded = 0;
                    }
                } else if ($this->request->getVar('valid_licensed_bar')=="Own Liquor License") {
                    if (!(isset($_SESSION["EVENTS"]["STEP-1"]["own_license_file"]))) {
                        session()->setFlashdata('message', 'You have selected Option "Own Liquor License", please Upload your license!');
                        session()->setFlashdata('alert-class', 'alert-danger');
                        $validarion_failed = true;
                        $file_uploaded = -1;  
                    } else {
                        $filepath = $_SESSION["EVENTS"]["STEP-1"]["own_license_file"];
                        $file_uploaded = 1;
                    }
                }
                // groom_driver_license uploade
                if($file = $this->request->getFile('groom_driver_license') && 
                    $this->request->getFile('groom_driver_license')!="") {

                    $name = $_FILES["groom_driver_license"]["name"];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    
                    $newName = getcwd()."/assets/uploads/client_own_license/".uniqid(rand(), true) . ".".$ext; 
                    //$file->move('assets/uploads/client_own_license/', $newName);
                    if (move_uploaded_file($_FILES['groom_driver_license']['tmp_name'], $newName)) {
                        $groom_driver_license_filepath = base_url().str_replace(getcwd(), "", $newName);
                        //https://chandani.dinxstudio.com//assets/uploads/client_own_license/1644192071_4525dd4d86913fe8a589.png

                        // session()->setFlashdata('message', 'Groom Driver License, Uploaded Successfully!');
                        // session()->setFlashdata('alert-class', 'alert-success');
                        session()->setFlashdata('filepath', $groom_driver_license_filepath);
                        session()->setFlashdata('extension', $ext);
                        $_SESSION["EVENTS"]["STEP-1"]["groom_driver_license_file"]=$groom_driver_license_filepath;
                        $groom_driver_license_file_uploaded = 1;
                    } else {
                        // Set Session
                        session()->setFlashdata('message', 'Your Driver License not uploaded.');
                        session()->setFlashdata('alert-class', 'alert-danger');
                        $groom_driver_license_file_uploaded = 0;
                    }
                } else if ($this->request->getFile('groom_driver_license')=="") {
                    if (!(isset($_SESSION["EVENTS"]["STEP-1"]["groom_driver_license_file"]))) {
                        session()->setFlashdata('message', 'Please Upload Groom Driver License!');
                        session()->setFlashdata('alert-class', 'alert-danger');
                        $validarion_failed = true;
                        $groom_driver_license_file_uploaded = -1;  
                    } else {
                        $groom_driver_license_filepath = $_SESSION["EVENTS"]["STEP-1"]["groom_driver_license_file"];
                        $groom_driver_license_file_uploaded = 1;
                    }
                }
                
                // bride_driver_license uploade
                if($file = $this->request->getFile('bride_driver_license') && 
                    $this->request->getFile('bride_driver_license')!="") {

                    $name = $_FILES["bride_driver_license"]["name"];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    
                    $newName = getcwd()."/assets/uploads/client_own_license/".uniqid(rand(), true) . ".".$ext; 
                    //$file->move('assets/uploads/client_own_license/', $newName);
                    if (move_uploaded_file($_FILES['bride_driver_license']['tmp_name'], $newName)) {
                        $bride_driver_license_filepath = base_url().str_replace(getcwd(), "", $newName);
                        //https://chandani.dinxstudio.com//assets/uploads/client_own_license/1644192071_4525dd4d86913fe8a589.png

                        // session()->setFlashdata('message', 'Bride Driver License, Uploaded Successfully!');
                        // session()->setFlashdata('alert-class', 'alert-success');
                        session()->setFlashdata('filepath', $bride_driver_license_filepath);
                        session()->setFlashdata('extension', $ext);
                        //$_SESSION["EVENTS"]["STEP-1"]["bride_driver_license_file"]=$bride_driver_license_filepath;
                        $bride_driver_license_file_uploaded = 1;
                    } else {
                        // Set Session
                        session()->setFlashdata('message', 'Your Driver License not uploaded.');
                        session()->setFlashdata('alert-class', 'alert-danger');
                        $bride_driver_license_file_uploaded = 0;
                    }
                } else if ($this->request->getFile('bride_driver_license')=="") {
                    if (!(isset($_SESSION["EVENTS"]["STEP-1"]["bride_driver_license_file"]))) {
                        session()->setFlashdata('message', 'Please Upload Driver License!');
                        session()->setFlashdata('alert-class', 'alert-danger');
                        $validarion_failed = true;
                        $bride_driver_license_file_uploaded = -1;  
                    } else {
                        $bride_driver_license_filepath = $_SESSION["EVENTS"]["STEP-1"]["bride_driver_license_file"];
                        $bride_driver_license_file_uploaded = 1;
                    }
                }

                $data = [
                    "event_date" => $this->request->getVar('event_date'),
                    "event_time" => $this->request->getVar('event_time'),
                    "payment_mode" => $this->request->getVar('payment_mode'),
                    "no_of_guests" => $this->request->getVar('no_of_guests'),
                    "coat_check" => $this->request->getVar('coat_check'),
                    "valid_licensed_bar" => $this->request->getVar('valid_licensed_bar'),
                    "own_license_file" => $filepath,
                    "no_of_bartenders" => $this->request->getVar('no_of_bartenders'),
                    "need_a_hall_rental" => $this->request->getVar('need_a_hall_rental'),
                    "need_security_gaurds" => $this->request->getVar('need_security_gaurds'),
                    "how_many_security_gaurds" => $this->request->getVar('how_many_security_gaurds'),
                    
                    // groom & bride info
                    
                    "groom_title" => $this->request->getVar('groom_title'),
                    "groom_fname" => $this->request->getVar('groom_fname'),
                    "bride_title" => $this->request->getVar('bride_title'),
                    "bride_fname" => $this->request->getVar('bride_fname'),
                    
                    "groom_lname" => $this->request->getVar('groom_lname'),
                    "bride_lname" => $this->request->getVar('bride_lname'),
                    "groom_phone" => $this->request->getVar('groom_phone'),
                    "bride_phone" => $this->request->getVar('bride_phone'),
                    
                    "groom_address" => $this->request->getVar('groom_address'),
                    "bride_address" => $this->request->getVar('bride_address'),
                    "groom_driver_license_file" => $groom_driver_license_filepath,
                    "bride_driver_license_file" => $bride_driver_license_filepath,
                ];
                 
                if (($file_uploaded==1 && $this->request->getVar('valid_licensed_bar')=="Own Liquor License") ||
                    $this->request->getVar('valid_licensed_bar')!="Own Liquor License") {
                    $rules = [
                        'event_date'          => 'required|valid_date',
                        'event_time'          => 'required',
                        'payment_mode'  => 'required',
                        'no_of_guests'  => 'required|numeric|min_length[1]|max_length[5]',
                        'coat_check'  => 'required',
                        'valid_licensed_bar'  => 'required',
                        'no_of_bartenders'  => 'required|numeric|min_length[1]|max_length[4]',
                        'need_a_hall_rental'  => 'required',
                        'need_security_gaurds'  => 'required',
                        //groom and bride info
                        'groom_title'  => 'required',
                        'groom_fname'  => 'required',
                        'bride_title'  => 'required',
                        'bride_fname'  => 'required',
                        
                        'groom_lname'  => 'required',
                        'bride_lname'  => 'required',
                        'groom_phone'  => 'required',
                        'bride_phone'  => 'required',
                        
                        'groom_address'  => 'required',
                        'bride_address'  => 'required'
                        
                    ];

                    if($this->validate($rules)) {
                        if ($this->request->getVar('need_security_gaurds')=="Yes") {
                            if ($this->request->getVar('how_many_security_gaurds')==0 || 
                                $this->request->getVar('how_many_security_gaurds')=="") {
                                    session()->setFlashdata('message', "You have selected Option 'Yes', for security guards, please select number of guards you need!");
                                    session()->setFlashdata('alert-class', 'alert-danger');
                                    $validarion_failed = true;
                            }
                        }

                        if ($validarion_failed==false) {
                            $data_insert = [
                                "tblcompany_id" => SITE_ID,
                                "tblcompany_client_id" => $_SESSION["client_id"],
                                "event_datetime" => $this->request->getVar('event_date'),
                                "event_time" => $this->request->getVar('event_time'),
                                "payment_mode" => $this->request->getVar('payment_mode'),
                                "no_of_guests" => $this->request->getVar('no_of_guests'),
                                "coat_check" => $this->request->getVar('coat_check'),
                                "valid_licensed_bar" => $this->request->getVar('valid_licensed_bar'),
                                "own_license_file" => $filepath,
                                "no_of_bartenders" => $this->request->getVar('no_of_bartenders'),
                                "need_a_hall_rental" => $this->request->getVar('need_a_hall_rental'),
                                "need_security_gaurds" => $this->request->getVar('need_security_gaurds'),
                                "how_many_security_gaurds" => $this->request->getVar('how_many_security_gaurds'),
                                // groom & bride info
                    
                                "groom_title" => $this->request->getVar('groom_title'),
                                "groom_fname" => $this->request->getVar('groom_fname'),
                                "bride_title" => $this->request->getVar('bride_title'),
                                "bride_fname" => $this->request->getVar('bride_fname'),
                                
                                "groom_lname" => $this->request->getVar('groom_lname'),
                                "bride_lname" => $this->request->getVar('bride_lname'),
                                "groom_phone" => $this->request->getVar('groom_phone'),
                                "bride_phone" => $this->request->getVar('bride_phone'),
                                
                                "groom_address" => $this->request->getVar('groom_address'),
                                "bride_address" => $this->request->getVar('bride_address'),
                                "groom_driver_license_file" => $groom_driver_license_filepath,
                                "bride_driver_license_file" => $bride_driver_license_filepath,
                                "calendar_event_id"=>$calendarEventId,
                                "created_at" => date("Y-m-d H:i:s")
                            ];
                            // $eventsModel = model('App\Models\EventsModel');
                            // $eventsModel->insert($data_insert);
                            // $this->show($data_insert, 1);
                            $_SESSION["EVENTS"]["STEP-1"] = $data_insert;
                            //$this->show($_SESSION, 1);
                            return redirect()->to(site_url().'events/chooseHall');
                        }
                    } else {
                        session()->setFlashdata('message', $this->validator->listErrors());
                        session()->setFlashdata('alert-class', 'alert-danger');
                    }
                }
            }
            echo view('clientHeader');
            echo view('clientLeftSidebar', $data);
            echo view('clientEvent', $data);
            echo view('clientFooter');
        }

    }

    public function chooseHall() {
        //$this->show($_SESSION, 0);
        $data = array();
        $data_insert = array();

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-1"]))) {
                return redirect()->to(site_url().'events/new');
            }
            $data["venues"] = $this->getAllCompanyVenues();
            $eventTypesModel = model('App\Models\EventTypesModel');
            $data["event_types"] = $eventTypesModel->where("tblcompany_id", SITE_ID)->get()->getResult();

            $menuOptionsModel = model('App\Models\MenuOptionModel');
            $data["menu_options"] = $menuOptionsModel
            ->select('tblcompany_menuOptions.*')
            ->distinct()
            ->join("tblcompany_buffetPricing", "tblcompany_menuOptions.id = tblcompany_buffetPricing.tblcompany_menuOption_id")
            ->where("tblcompany_menuOptions.tblcompany_id", SITE_ID)
            ->where("tblcompany_menuOptions.id !=", 36)
            ->where("tblcompany_buffetPricing.tblcompany_venue_id", $data["venues"][0]->id)
            ->get()->getResult();


            // $this->show($data["menu_options"], 1);
            if (isset($_SESSION["EVENTS"]["STEP-2"])) {
                $data["tblcompany_venue_id"] = $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"];
                $data["tblcompany_event_type_id"] = $_SESSION["EVENTS"]["STEP-2"]["tblcompany_event_type_id"];
                $data["tblcompany_menuOption_id"] = $_SESSION["EVENTS"]["STEP-2"]["tblcompany_menuOption_id"];
                $data["tblcompany_barOption_id"] = $_SESSION["EVENTS"]["STEP-2"]["tblcompany_barOption_id"];
            }
            // echo "<pre>";print_r($data);die();
            if ($this->request->getMethod() == "post") {
                if(isset($_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]) && $_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes'){
                    $rules = [
                            'venue_hall'          => 'required|is_natural',
                            'event_type'          => 'required|is_natural',
                            'menu_option'  => 'required',
                            'bar_option'  => 'required'
                        ];
                $custom_errors = [
                            'venue_hall' => [
                                'is_natural' => 'Please Pick up Location for your Venue!'
                            ],
                            'event_type' => [
                                'is_natural' => 'Please Select Event Type for your Event!'
                            ],
                            'menu_option' => [
                                'required' => 'Please Select Menu Option from the list below!'
                            ],
                            'bar_option' => [
                                'required' => 'Please Select Bar Option'
                            ],
                        ];
                        
                        $data_insert = [
                            "tblcompany_venue_id" => $this->request->getVar('venue_hall'),
                            "tblcompany_event_type_id" => $this->request->getVar('event_type'),
                            "tblcompany_menuOption_id" => $this->request->getVar('menu_option'),
                            "tblcompany_barOption_id" => $this->request->getVar('bar_option')
                        ];
                }else{
                     $rules = [
                            'venue_hall'          => 'required|is_natural',
                            'event_type'          => 'required|is_natural'
                        ];
                $custom_errors = [
                            'venue_hall' => [
                                'is_natural' => 'Please Pick up Location for your Venue!'
                            ],
                            'event_type' => [
                                'is_natural' => 'Please Select Event Type for your Event!'
                            ]
                        ];
                        $menu_option=0;
                        $data_insert = [
                            "tblcompany_venue_id" => $this->request->getVar('venue_hall'),
                            "tblcompany_event_type_id" => $this->request->getVar('event_type'),
                            "tblcompany_menuOption_id" => $menu_option,
                            "tblcompany_barOption_id" => 0
                        ];
                }
                

                

                if($this->validate($rules, $custom_errors)) { 
                    $_SESSION["EVENTS"]["STEP-2"] = $data_insert;
                    foreach ($data["venues"] as $value) {
                        if ($value->id==$data_insert["tblcompany_venue_id"]) {
                            $selected_venue = $value->name;
                        }
                    }
                    foreach ($data["event_types"] as $value) {
                        if ($value->id==$data_insert["tblcompany_event_type_id"]) {
                            $selected_eventType = $value->event_type;
                        }
                    }
                    $selected_menuOption = 'No menu selected';
                    foreach ($data["menu_options"] as $value) {
                        if ($value->id==$data_insert["tblcompany_menuOption_id"]) {
                            $selected_menuOption = $value->name;
                        }
                    }
                    $selected_barOption = 'No bar selected';
                    foreach ($data["menu_options"] as $value) {
                        if ($value->id==$data_insert["tblcompany_barOption_id"]) {
                            $selected_barOption = $value->name;
                        }
                    }
                    

                    $data_insert_labels = [
                        "selected_venue" => $selected_venue,
                        "selected_eventType" => $selected_eventType,
                        "selected_menuOption" => $selected_menuOption,
                        "selected_barOption" => $selected_barOption
                    ];
                    $_SESSION["EVENTS"]["STEP-2"]["label"] = $data_insert_labels;
                    return redirect()->to(site_url().'events/menuItems');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
                
            }
        }

        //echo "<pre>";print_r($data);die();
        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('clientChooseHall', $data, $data_insert);
        echo view('clientFooter');
    }

    function getVenueBuffet() {

        if ($this->request->getMethod() == "post") {
            $venue_id = $this->request->getVar('venue_id');
            //echo $venue_id." from ajax";
            $str = "";

            $menuOptionsModel = model('App\Models\MenuOptionModel');
            $menu_options = $menuOptionsModel
                                        ->select('tblcompany_menuOptions.*')
                                        ->distinct()
                                        ->join("tblcompany_buffetPricing", "tblcompany_menuOptions.id = tblcompany_buffetPricing.tblcompany_menuOption_id")
                                        ->where("tblcompany_menuOptions.tblcompany_id", SITE_ID)
                                        ->where("tblcompany_menuOptions.id !=", 36)
                                        ->where("tblcompany_buffetPricing.tblcompany_venue_id", $venue_id)
                                        ->get()->getResult();

            foreach($menu_options as $menu_option) {
                if(!str_contains($menu_option->name, 'Bar')){
                $str .= '<input name="menu_option" id="menu_option'.$menu_option->id.'" type="radio" ';
                if (isset($tblcompany_menuOption_id) && $menu_option->id==$tblcompany_menuOption_id) {
                    $str .= "checked"; 
                }
                $str .= 'value="'.$menu_option->id.'" />&nbsp;&nbsp;<label for="menu_option'.$menu_option->id.'">';
                $str .= $menu_option->name.'</label><br />';
                }
            }
            echo $str;
        }
    }

    public function menuItems() {
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-2"]))) {
                return redirect()->to(site_url().'events/chooseHall');
            }

            if (isset($_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"])) {
                $menu_item_ids = $_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"];
                $data["menu_item_ids"] = $menu_item_ids;
            }
            if(isset($_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]) && $_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes'){
            $menuOptionsModel = model('App\Models\MenuOptionModel');
            $option = $menuOptionsModel->where("tblcompany_id", SITE_ID)->where("id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_menuOption_id"])->get()->getResult();
            $data["extras_optional"] = $option[0]->extras_optional;
            }else{
                $_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"]=0;
                return redirect()->to(site_url().'events/floorplan');
            }

            $menuModel = model('App\Models\MenuModel');
            $data["menu_options"] = $menuModel->where("tblcompany_id", SITE_ID)
                                    ->where("tblcompany_menuOption_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_menuOption_id"])
                                    ->orderBy("CASE WHEN category = 'APPETIZER' THEN 0 ELSE 1 END, category")
                                    ->orderBy('show_order_category', 'ASC')
                                    ->orderBy('show_order_sub_category', 'ASC')
                                    ->orderBy('show_order_dishes', 'ASC')                            
                                    ->orderBy('item_name', 'ASC')                            
                                    ->get()->getResult();
            $data["bar_options"] = $menuModel->where("tblcompany_id", SITE_ID)
                                    ->where("tblcompany_menuOption_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_barOption_id"])
                                    ->orderBy('show_order_category', 'ASC')
                                    ->orderBy('show_order_sub_category', 'ASC')
                                    ->orderBy('show_order_dishes', 'ASC')                            
                                    ->orderBy('item_name', 'ASC')                            
                                    ->get()->getResult();                        
            
            $categories = array();
            foreach ($data["menu_options"] as $value) {
                if (!(in_array($value->category, $categories))) {
                    $categories[] = $value->category;
                }
            }
            
            $barCategories = array();
            foreach ($data["bar_options"] as $value) {
                if (!(in_array($value->category, $barCategories))) {
                    $barCategories[] = $value->category;
                }
            }
            // $this->show($data, 1);
            $menu = array();
            foreach ($categories as $category) {
                foreach ($data["menu_options"] as $value) {
                    if ($category==$value->category) {
                        if ($value->sub_category=="" || $value->sub_category==NULL) {
                            $menu[$category]["Empty"][] = $value;
                        } else {
                            $menu[$category][$value->sub_category][] = $value;
                        }
                    }
                }
            }
            $data["categories"] = $categories;
            $data["menu"] = $menu;
            
            $barMenu = array();
            foreach ($barCategories as $category) {
                foreach ($data["bar_options"] as $value) {
                    if ($category==$value->category) {
                        if ($value->sub_category=="" || $value->sub_category==NULL) {
                            $barMenu[$category]["Empty"][] = $value;
                        } else {
                            $barMenu[$category][$value->sub_category][] = $value;
                        }
                    }
                }
            }
            $data["barCategories"] = $barCategories;
            $data["barMenu"] = $barMenu;

            if ($this->request->getMethod() == "post") {
                $start_time = $this->request->getVar('start_time');
                $end_time = $this->request->getVar('end_time');
                if(in_array('APPETIZER', $categories))
                {
                    $_SESSION["APPETIZER"]["start_time"]=$start_time[0];
                    $_SESSION["APPETIZER"]["end_time"]=$end_time[0];
                }
                else
                {
                    $_SESSION["APPETIZER"]["start_time"]='';
                    $_SESSION["APPETIZER"]["end_time"]='';
                }
                if(in_array('MAIN COURSE', $categories))
                {
                    $_SESSION["MAINCOURSE"]["start_time"]=$start_time[1];
                    $_SESSION["MAINCOURSE"]["end_time"]=$end_time[1];
                }
                else
                {
                    $_SESSION["MAINCOURSE"]["start_time"]='';
                    $_SESSION["MAINCOURSE"]["end_time"]='';
                }

                $menu_item_ids = $this->request->getVar('menu_item_id');
                if(!empty($menu_item_ids)){
                
                $menu_items = implode(",", $menu_item_ids);
                $data["menu_item_ids"] = $menu_item_ids;
                foreach ($menu as $category => $values) {
                    foreach ($values as $key => $sub_category) {
                        foreach ($sub_category as $value) {
                            if (in_array($value->id, $menu_item_ids)) {
                                $selection[$category][$key]["ids"][] = $value->id;
                            }
                            $selection[$category][$key]["choice_of_any_n_items"] = $value->choice_of_any_n_items;
                        }
                    }
                }
                
                // bar menu
                
                foreach ($barMenu as $category => $values) {
                    foreach ($values as $key => $sub_category) {
                        foreach ($sub_category as $value) {
                            if (in_array($value->id, $menu_item_ids)) {
                                $barSelection[$category][$key]["ids"][] = $value->id;
                            }
                            $barSelection[$category][$key]["choice_of_any_n_items"] = $value->choice_of_any_n_items;
                        }
                    }
                }
                
                $message = "";
                foreach ($selection as $category => $values) {
                    foreach ($values as $sub_category => $sub_category_values) {
                        if (!(array_key_exists("ids",$sub_category_values))) {
                            $message .= "<br />for ".$category;
    
                            if ($sub_category!="Empty") {
                                $message .= " and ".$sub_category;
                            }

                            $message .=", Please Choose at least ".$sub_category_values["choice_of_any_n_items"]." item(s)";
                            $validarion_failed = true;          
                        } else if (count($sub_category_values["ids"])!=$sub_category_values["choice_of_any_n_items"]) {
                            $message .= "<br />for ".$category;

                            if ($sub_category!="Empty") {
                                $message .= " and ".$sub_category;
                            }

                            $message .=", Please Choose at least ".$sub_category_values["choice_of_any_n_items"]." item(s)";
                            $validarion_failed = true;
                        }    
                    }
                }

                if ($validarion_failed) {
                    session()->setFlashdata('message', $message);
                    session()->setFlashdata('alert-class', 'alert-danger');
                } else {
                    $_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"] = $menu_item_ids;

                    $labels = array();
                    foreach ($menu_item_ids as $item) {
                        foreach ($menu as $category => $menu_item) {
                            foreach ($menu_item as $sub_category => $value) {
                                foreach ($value as $v) {
                                    if ($item==$v->id) {
                                        $labels[$category][$sub_category][] = $v->item_name;
                                    }                
                                }
                            }
                        }
                    }
                    
                    $barLabels = array();
                    foreach ($menu_item_ids as $item) {
                        foreach ($barMenu as $category => $menu_item) {
                            foreach ($menu_item as $sub_category => $value) {
                                foreach ($value as $v) {
                                    if ($item==$v->id) {
                                        $barLabels[$category][$sub_category][] = $v->item_name;
                                    }                
                                }
                            }
                        }
                    }
                    $_SESSION["EVENTS"]["STEP-3"]["label"] = $labels;
                    $_SESSION["EVENTS"]["STEP-3"]["barLabel"] = $barLabels;
                    
                    return redirect()->to(site_url().'events/floorplan');
                }
             }else{
                 $_SESSION["EVENTS"]["STEP-3"]["test"]='test';
                 return redirect()->to(site_url().'events/floorplan');
                 
             } 
            }
        }
        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('menuItems', $data, $data_insert);
        echo view('clientFooter');
    }

    function floorplan() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-3"]))) {
                return redirect()->to(site_url().'events/menuItems');
            }
            
            if (isset($_SESSION["EVENTS"]["STEP-4"]["floor_plan_selected"])) {
                $floor_plan_selected = $_SESSION["EVENTS"]["STEP-4"]["floor_plan_selected"];
                $data["floor_plan_selected"] = $floor_plan_selected;
            }

            $companyVenueHallsModel = model('App\Models\CompanyVenueHallsModel');
            $floor_plans = $companyVenueHallsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                                    ->get()
                                                    ->getResult();

            $data["floor_plans"] = $floor_plans;
            if($this->request->getVar('floor_plan') !=''){
              $rules = [
                'floor_plan'          => 'required',
              ];
              $floorId='';
            }else{
                $rules = [
                'floor_plan_0'          => 'required',
              ];
                $floorId='49';
            }
            

            if ($this->request->getMethod() == "post") {
                 
                if($this->validate($rules)) {
                    if($floorId == ''){
                    $data["floor_plan_selected"] = $this->request->getVar('floor_plan');
                    }else{
                        $data["floor_plan_selected"]=$floorId;
                    }
                    $floor_plan = $companyVenueHallsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $data["floor_plan_selected"])        
                                            ->get()
                                            ->getResult();
                    
                    $_SESSION["EVENTS"]["STEP-4"]["floor_plan_selected"] = $data["floor_plan_selected"];
                    
                    if(!empty($floor_plan)){
                      $_SESSION["EVENTS"]["STEP-4"]["label"] = $floor_plan[0]->name;    
                    }else{
                        $_SESSION["EVENTS"]["STEP-4"]["label"] = 'Floor plan not selected';
                    }
                    
                    return redirect()->to(site_url().'events/napkin');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('floorplan', $data, $data_insert);
        echo view('clientFooter');
    }

    function napkin() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;
        $napkinId = '';

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-4"]))) {
                return redirect()->to(site_url().'events/floorplan');
            }
            
            if (isset($_SESSION["EVENTS"]["STEP-5"]["napkin_selected"])) {
                $napkin_selected = $_SESSION["EVENTS"]["STEP-5"]["napkin_selected"];
                $data["napkin_selected"] = $napkin_selected;
                $napkinId = $napkin_selected;
            }
            

            $companyVenueNapkinsModel = model('App\Models\CompanyVenueNapkinsModel');
            $napkins = $companyVenueNapkinsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                                    ->get()
                                                    ->getResult();

            $data["napkins"] = $napkins;
            
            
            if (isset($_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]) && $_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"] !='') {
                $eventType=strtolower($_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]);
                if ($eventType=='maiya' || $eventType=='sangeet or dholki' || $eventType=='mehndi') {
    
                  if($this->request->getVar('napkin[]') !='' && count($this->request->getVar('napkin[]'))<2){

                  $rules = [
                            'napkin[]' => ['rules'=>'required', 'errors'=>['required'=>'Must select 2 napkin colors']],
                        ];
                        $napkinId='';
                  }else{
                      $rules = [
                            'napkin_0'          => 'required',
                        ];
                     $napkinId='92';
                  }
                  
                }else{
                  if($this->request->getVar('napkin') !=''){
                  $rules = [
                            'napkin' => 'required',
                        ];
                    $napkinId='';
                  }else{
                      $rules = [
                            'napkin_0'  => 'required',
                        ];
                    $napkinId='92';
                  }
                }
            }
            //echo $napkinId;
            //echo '<pre>';
            //print_r($this->request->getVar('napkin[]'));
            //var_dump($this->validate($rules));
            //exit;
            if ($eventType=='maiya' || $eventType=='sangeet or dholki' || $eventType=='mehndi') {
                if($this->request->getVar('napkin[]')!='' && count($this->request->getVar('napkin[]'))>=2){
                    $rules = [
                                'napkin_0'          => 'required',
                    ];
                    $napkinId='';
                }
            }
            if ($this->request->getMethod() == "post") {
                
                if($this->validate($rules)) {
                    if (isset($_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]) && $_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"] !='') {
                    //echo $napkinId ;
                    //exit;
                         
                    if($napkinId==''){
                            
                      $eventType=strtolower($_SESSION["EVENTS"]["STEP-2"]["label"]["selected_eventType"]);

                      if ($eventType=='maiya' || $eventType=='sangeet or dholki' || $eventType=='mehndi') {
                          
                        $data["napkin_selected"] = implode(", ", $this->request->getVar('napkin[]'));
                        $db = \Config\Database::connect();
                        $builder = $db->table('tblcompany_napkins');
                        $napkin=$builder->select('id,name')->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])->get()->getResult();
                        $array=explode(", ",$data["napkin_selected"]);
                         
                        $napkins = array();
                        foreach ($napkin as $key => $value) {
                            if (!(array_key_exists($value->id, $napkins))) {
                                $napkins[] = $value->id;
                            }
                        }
                        
                        $result=array_intersect($napkins,$array);
                        
                        $nap = array();
                        foreach ($napkin as $key => $value) {
                            if (in_array($value->id,$result)) {
                                $nap[] = $value->name;
                            }
                        }
                        $_SESSION["EVENTS"]["STEP-5"]["label"] = implode(", ", $nap);
                        
                     }else{
                         
                         $data["napkin_selected"] = $this->request->getVar('napkin');
                         $napkin = $companyVenueNapkinsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $data["napkin_selected"])        
                                            ->get()
                                            ->getResult();
                        $_SESSION["EVENTS"]["STEP-5"]["label"] = $napkin[0]->name;                    
                      }
                     }else{
                         $data["napkin_selected"]=$this->request->getVar('napkin_0');
                         $_SESSION["EVENTS"]["STEP-5"]["label"] = 'Napkin not selected';
                     }
                    }
                    

                    $_SESSION["EVENTS"]["STEP-5"]["napkin_selected"] = $data["napkin_selected"];
                    
                    return redirect()->to(site_url().'events/tableCloth');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('napkin', $data, $data_insert);
        echo view('clientFooter');
    }

    function tableCloth() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-5"]))) {
                return redirect()->to(site_url().'events/napkin');
            }
            
            if (isset($_SESSION["EVENTS"]["STEP-6"]["tableCloth_selected"])) {
                $tableCloth_selected = $_SESSION["EVENTS"]["STEP-6"]["tableCloth_selected"];
                $data["tableCloth_selected"] = $tableCloth_selected;
            }

            $companyVenueTableClothModel = model('App\Models\CompanyVenueTableClothModel');
            $tableCloths = $companyVenueTableClothModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                                    ->get()
                                                    ->getResult();

            $data["tableCloths"] = $tableCloths;
            
            if($this->request->getVar('tableCloth') !=''){
              $rules = [
                'tableCloth'          => 'required',
              ];
              $tableClothId='';
            }else{
                $rules = [
                'tableCloth_0'          => 'required',
              ];
                $tableClothId='46';
            }
            

            if ($this->request->getMethod() == "post") {
                if($this->validate($rules)) {
                    
                    if($tableClothId == ''){
                    $data["tableCloth_selected"] = $this->request->getVar('tableCloth');
                    }else{
                        $data["tableCloth_selected"]=$tableClothId;
                    }

                    $tableCloth = $companyVenueTableClothModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $data["tableCloth_selected"])        
                                            ->get()
                                            ->getResult();

                    $_SESSION["EVENTS"]["STEP-6"]["tableCloth_selected"] = $data["tableCloth_selected"];
                    if(!empty($tableCloth)){
                      $_SESSION["EVENTS"]["STEP-6"]["label"] = $tableCloth[0]->name;    
                    }else{
                        $_SESSION["EVENTS"]["STEP-6"]["label"] = 'Table cloth not selected';
                    }
                    
                    return redirect()->to(site_url().'events/sound');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('tableCloth', $data, $data_insert);
        echo view('clientFooter');
    }

    function flower() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-6"]))) {
                return redirect()->to(site_url().'events/tableCloth');
            }
            
            if (isset($_SESSION["EVENTS"]["STEP-7"]["flower_selected"])) {
                $flower_selected = $_SESSION["EVENTS"]["STEP-7"]["flower_selected"];
                $data["flower_selected"] = $flower_selected;
            }

            $companyVenueFlowersModel = model('App\Models\CompanyVenueFlowersModel');
            $flowers = $companyVenueFlowersModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                                    ->get()
                                                    ->getResult();

            $data["flowers"] = $flowers;

            $rules = [
                'flower'          => 'required',
            ];

            if ($this->request->getMethod() == "post") {
                if($this->validate($rules)) {
                    $data["flower_selected"] = $this->request->getVar('flower');

                    $flower = $companyVenueFlowersModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $data["flower_selected"])        
                                            ->get()
                                            ->getResult();

                    $_SESSION["EVENTS"]["STEP-7"]["flower_selected"] = $data["flower_selected"];
                    $_SESSION["EVENTS"]["STEP-7"]["label"] = $flower[0]->name;
                    return redirect()->to(site_url().'events/sound');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('flower', $data, $data_insert);
        echo view('clientFooter');
    }

    function sound() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-6"]))) {
                return redirect()->to(site_url().'events/tableCloth');
            }

            $soundOptionsModel = model('App\Models\SoundOptionsModel');
            $sound_options = $soundOptionsModel->get()->getResult();
            $sound_options1 = $sound_options;

            $AudioLightningModel = model('App\Models\AudioLightningModel');
            $data['description']= $AudioLightningModel->get()->getResult();

            if (isset($_SESSION["EVENTS"]["STEP-8"]["sound_selected"])) {
                $data["sound_select"] = $_SESSION["EVENTS"]["STEP-8"]["sound_select"];
                $data["sound_selected"] = $_SESSION["EVENTS"]["STEP-8"]["sound_selected"];

                if ($data["sound_selected"]!=0) {
                    $sound_options1 = $soundOptionsModel->where("id", $data["sound_selected"])->get()->getResult();
                } else {
                    $sound_options1 = "";
                }
            }

            $data["sound_options"] = $sound_options;
            $rules = [
                'sound_select'   => 'required'
            ];

            if ($this->request->getMethod() == "post") {
                if($this->validate($rules)) {
                    $data["sound_selected"] = $this->request->getVar('sound');
                    $data["sound_select"]= $this->request->getVar('sound_select');
 
                    if ($data["sound_select"]==1) {
                        if ($data["sound_selected"]=="") {
                            $message = "Please Select one of the Sound Option.";
                            $validarion_failed = true;
                        }
                    }

                    if ($validarion_failed) {
                        session()->setFlashdata('message', $message);
                        session()->setFlashdata('alert-class', 'alert-danger');
                    } else {
                        $_SESSION["EVENTS"]["STEP-8"]["sound_select"] = $data["sound_select"];
                        $_SESSION["EVENTS"]["STEP-8"]["sound_selected"] = $data["sound_selected"];
                        //$_SESSION["EVENTS"]["STEP-8"]["label"] = $sound_options1[0]->name;
                        return redirect()->to(site_url().'events/dj');
                    }
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('sound', $data, $data_insert);
        echo view('clientFooter');
    }

    function dj() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-8"]))) {
                return redirect()->to(site_url().'events/sound');
            }
            
            $rules = [
                'dj_select'   => 'required'
            ];

            if ($this->request->getMethod() == "post") {
                // if($this->validate($rules)) {
                //     $data["dj_select"] = $this->request->getVar('dj_select');

                //     $_SESSION["EVENTS"]["STEP-9"]["dj_selected"] = $data["dj_select"];

                //     if ($data["dj_select"]==0) {
                //         $msg = "NEED A DJ"; 
                //     } else {
                //         $msg = "WILL BRING OWN DJ"; 
                //     }
                    $_SESSION["EVENTS"]["STEP-9"]["label"] = NULL;
                    return redirect()->to(site_url().'events/terms');
                // } else {
                //     session()->setFlashdata('message', $this->validator->listErrors());
                //     session()->setFlashdata('alert-class', 'alert-danger');
                // }
            }
        }

        if (isset($_SESSION["EVENTS"]["STEP-9"]["dj_selected"])) {
            $data["dj_select"] = $_SESSION["EVENTS"]["STEP-9"]["dj_selected"];
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('dj', $data, $data_insert);
        echo view('clientFooter');
    }
    
    function terms() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-9"]))) {
                return redirect()->to(site_url().'events/dj');
            }
            
            $rules = [
                'terms'  => ['rules'  => 'required','errors' => [
                'required' => 'You must agree to our terms & conditions.',
                ],
            ]
            ];

            if ($this->request->getMethod() == "post") {
                if($this->validate($rules)) {
                    $data["terms"] = $this->request->getVar('terms');

                    $_SESSION["EVENTS"]["STEP-12"]["terms"] = $data["terms"];

                    $_SESSION["EVENTS"]["STEP-12"]["label"] = 'Agreed to terms and condistions';
                    return redirect()->to(site_url().'events/orderConfirmation');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        if (isset($_SESSION["EVENTS"]["STEP-12"]["dj_selected"])) {
            $data["terms"] = $_SESSION["EVENTS"]["STEP-12"]["terms"];
        }
        $contractModel = model('App\Models\ContractModel');
        $data['contract']= $contractModel->get()->getResult();
        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('clientTerms', $data, $data_insert);
        echo view('clientFooter');
    }

    function stage() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-9"]))) {
                return redirect()->to(site_url().'events/dj');
            }
            
            $rules = [
                'stageDecore_select'   => 'required'
            ];

            if ($this->request->getMethod() == "post") {
                if($this->validate($rules)) {
                    $data["stageDecore_select"] = $this->request->getVar('stageDecore_select');

                    $_SESSION["EVENTS"]["STEP-10"]["stageDecore_selected"] = $data["stageDecore_select"];

                    if ($data["stageDecore_select"]==0) {
                        $msg = "Yes, I need a professional stage decore from Chandni"; 
                    } else {
                        $msg = "Will arrange own stage decore"; 
                    }
                    $_SESSION["EVENTS"]["STEP-10"]["label"] = $msg;
                    return redirect()->to(site_url().'events/lighting');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        if (isset($_SESSION["EVENTS"]["STEP-10"]["stageDecore_selected"])) {
            $data["stageDecore_select"] = $_SESSION["EVENTS"]["STEP-10"]["stageDecore_selected"];
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('stage', $data, $data_insert);
        echo view('clientFooter');
    }

    function lighting() {    
        $data = array();
        $data_insert = array();
        $validarion_failed = false;

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            if (!(isset($_SESSION["EVENTS"]["STEP-10"]))) {
                return redirect()->to(site_url().'events/stage');
            }
            
            $rules = [
                'lighting_select'   => 'required'
            ];

            if ($this->request->getMethod() == "post") {
                if($this->validate($rules)) {
                    $data["lighting_select"] = $this->request->getVar('lighting_select');

                    $_SESSION["EVENTS"]["STEP-11"]["lighting_selected"] = $data["lighting_select"];

                    if ($data["lighting_select"]==0) {
                        $msg = " NEED CUSTOM LIGHTING SETUP"; 
                    } else {
                        $msg = " DON'T NEED LIGHTING SETUP"; 
                    }
                    $_SESSION["EVENTS"]["STEP-11"]["label"] = $msg;
                    return redirect()->to(site_url().'events/orderConfirmation');
                } else {
                    session()->setFlashdata('message', $this->validator->listErrors());
                    session()->setFlashdata('alert-class', 'alert-danger');
                }
            }
        }

        if (isset($_SESSION["EVENTS"]["STEP-11"]["lighting_selected"])) {
            $data["lighting_select"] = $_SESSION["EVENTS"]["STEP-11"]["lighting_selected"];
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('lighting', $data, $data_insert);
        echo view('clientFooter');
    }

    function orderConfirmation() {
        $data = array();
        $data_insert = array();
        
        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            // if (!(isset($_SESSION["EVENTS"]["STEP-10"]))) {
            //     return redirect()->to(site_url().'events/stage');
            // } else 
            if (!(isset($_SESSION["EVENTS"]["STEP-9"]))) {
                return redirect()->to(site_url().'events/dj');
            } else if (!(isset($_SESSION["EVENTS"]["STEP-8"]))) {
                return redirect()->to(site_url().'events/sound');
            }
            // else if (!(isset($_SESSION["EVENTS"]["STEP-7"]))) {
            //     return redirect()->to(site_url().'events/flower');
            // } 
            else if (!(isset($_SESSION["EVENTS"]["STEP-6"]))) {
                return redirect()->to(site_url().'events/tableCloth');
            } else if (!(isset($_SESSION["EVENTS"]["STEP-5"]))) {
                return redirect()->to(site_url().'events/napkin');
            } else if (!(isset($_SESSION["EVENTS"]["STEP-4"]))) {
                return redirect()->to(site_url().'events/floorplan');
            } else if (!(isset($_SESSION["EVENTS"]["STEP-3"]))) {
                return redirect()->to(site_url().'events/menuItems');
            } else if (!(isset($_SESSION["EVENTS"]["STEP-2"]))) {
                return redirect()->to(site_url().'events/chooseHall');
            } else if (!(isset($_SESSION["EVENTS"]["STEP-1"]))) {
                return redirect()->to(site_url().'events/new');
            }
            
            if ($this->request->getMethod() == "post") {
                if(isset($_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"]) && !empty($_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"]) ){
                    $menu_item_ids = implode(",", $_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"]);
                }else{
                    $menu_item_ids = '0';
                }
                
                $flower_id='0';
                
                //// adding event to calendar ////
                
                $url='';
                $calendarData=array();
                    $url="https://dinxstudio.com/googleapi/create_event.php";
                    $calendarData = array(
                      'datetime' => $_SESSION["EVENTS"]["STEP-1"]["event_datetime"],
                      'clientName' => $_SESSION["name"],
                      'hallid' => $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"],
                      'eventTime' => $_SESSION["EVENTS"]["STEP-1"]["event_time"]
                    );
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($calendarData));
                $_SESSION["CALENDARBUTTON"]='';
                $resp = curl_exec($curl);
                $_SESSION["event_id"] = $resp;
                
                $menue_timer = '[{"category":"APPETIZER","start_time":"'.$_SESSION["APPETIZER"]["start_time"].'","end_time":"'.$_SESSION["APPETIZER"]["end_time"].'"},{"category":"MAINCOURSE","start_time":"'.$_SESSION["MAINCOURSE"]["start_time"].'","end_time":"'.$_SESSION["MAINCOURSE"]["end_time"].'"}]';
                $data_insert = [
                    "tblcompany_id" => $_SESSION["EVENTS"]["STEP-1"]["tblcompany_id"],
                    "tblcompany_client_id" => $_SESSION["EVENTS"]["STEP-1"]["tblcompany_client_id"],
                    "event_datetime" => $_SESSION["EVENTS"]["STEP-1"]["event_datetime"],
                    "event_time" => $_SESSION["EVENTS"]["STEP-1"]["event_time"],
                    "payment_mode" => $_SESSION["EVENTS"]["STEP-1"]["payment_mode"],
                    "no_of_guests" => $_SESSION["EVENTS"]["STEP-1"]["no_of_guests"],
                    "coat_check" => $_SESSION["EVENTS"]["STEP-1"]["coat_check"],
                    "valid_licensed_bar" => $_SESSION["EVENTS"]["STEP-1"]["valid_licensed_bar"],
                    "own_license_file" => $_SESSION["EVENTS"]["STEP-1"]["own_license_file"],
                    "no_of_bartenders" => $_SESSION["EVENTS"]["STEP-1"]["no_of_bartenders"],
                    "need_a_hall_rental" => $_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"],
                    "need_security_gaurds" => $_SESSION["EVENTS"]["STEP-1"]["need_security_gaurds"],
                    "how_many_security_gaurds" => $_SESSION["EVENTS"]["STEP-1"]["how_many_security_gaurds"],
                    
                    // groom & bride info
                    
                    "groom_title" => $_SESSION["EVENTS"]["STEP-1"]["groom_title"],
                    "groom_fname" => $_SESSION["EVENTS"]["STEP-1"]["groom_fname"],
                    "bride_title" => $_SESSION["EVENTS"]["STEP-1"]["bride_title"],
                    "bride_fname" => $_SESSION["EVENTS"]["STEP-1"]["bride_fname"],
                    
                    "groom_lname" => $_SESSION["EVENTS"]["STEP-1"]["groom_lname"],
                    "bride_lname" => $_SESSION["EVENTS"]["STEP-1"]["bride_lname"],
                    "groom_phone" => $_SESSION["EVENTS"]["STEP-1"]["groom_phone"],
                    "bride_phone" => $_SESSION["EVENTS"]["STEP-1"]["bride_phone"],
                    
                    "groom_address" => $_SESSION["EVENTS"]["STEP-1"]["groom_address"],
                    "bride_address" => $_SESSION["EVENTS"]["STEP-1"]["bride_address"],
                    
                    "groom_driver_license_file" => $_SESSION["EVENTS"]["STEP-1"]["groom_driver_license_file"],
                    "bride_driver_license_file" =>$_SESSION["EVENTS"]["STEP-1"]["bride_driver_license_file"],
                    
                    "tblcompany_venue_id" => $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"],
                    "tblcompany_event_type_id" => $_SESSION["EVENTS"]["STEP-2"]["tblcompany_event_type_id"],
                    "tblcompany_menuOption_id" => $_SESSION["EVENTS"]["STEP-2"]["tblcompany_menuOption_id"],
                    "tblcompany_barOption_id" => $_SESSION["EVENTS"]["STEP-2"]["tblcompany_barOption_id"],
                    "menu_item_selection" => $menu_item_ids,
                    "floor_plan_id" => $_SESSION["EVENTS"]["STEP-4"]["floor_plan_selected"],
                    "napkin_id" => $_SESSION["EVENTS"]["STEP-5"]["napkin_selected"],
                    "tableCloth_id" => $_SESSION["EVENTS"]["STEP-6"]["tableCloth_selected"],
                    "flower_id" => $flower_id,
                    "sound_option_id" => ($_SESSION["EVENTS"]["STEP-8"]["sound_select"]==0)?0:$_SESSION["EVENTS"]["STEP-8"]["sound_selected"],
                    // "dj_option" => $_SESSION["EVENTS"]["STEP-9"]["dj_selected"],
                    "dj_option" => NULL,
                    // "stage_decore_option" => $_SESSION["EVENTS"]["STEP-10"]["stageDecore_selected"],
                    // "lighting_option" => $_SESSION["EVENTS"]["STEP-11"]["lighting_selected"],
                    "stage_decore_option" => 0,
                    "lighting_option" => 0,
                    "calendar_event_id" => $_SESSION["event_id"],
                    "created_at" => date("Y-m-d H:i:s"),
                    "event_total_amount" =>$_SESSION["event_total_amount"],
                    "menue_timer" =>$menue_timer,
                ];
                
                $eventsModel = model('App\Models\EventsModel');
                if (!(isset($_SESSION["EVENTS"]["MODIFY"]))) {
                    $eventsModel->insert($data_insert);
                    $last_inserted_id = $eventsModel->db->insertID();
                    $_SESSION["last_inserted_id"] = $last_inserted_id;
                } else {
                    $eventsModel->update(['id' => $_SESSION["EVENTS"]["MODIFY"]], $data_insert); 
                   
                }
                
                $groomname = $_SESSION["EVENTS"]["STEP-1"]["groom_fname"].' '.$_SESSION["EVENTS"]["STEP-1"]["groom_lname"];
                $bridename = $_SESSION["EVENTS"]["STEP-1"]["bride_fname"].' '.$_SESSION["EVENTS"]["STEP-1"]["bride_lname"];
                
                $hallname='';
                $hallid= $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"];
                if($hallid==1){ $hallname='Chandni Chrysler';}
                if($hallid==2){ $hallname='Chandni Gateway';}
                if($hallid==3){ $hallname='Chandni Convention';}
                if($hallid==4){ $hallname='Chandni Country Club';}
                if($hallid==5){ $hallname='Chandni Victoria';}
                if($_SESSION["EVENTS"]["STEP-1"]["event_time"]=='Morning Event'){ $time='Morning Event - 8:00 am - 3:00 pm';}
                if($_SESSION["EVENTS"]["STEP-1"]["event_time"]=='Evening Event'){ $time='Evening Event - 6:00 pm - 1:00 am';}
                if($_SESSION["EVENTS"]["STEP-1"]["event_time"]=='Full Day Event'){ $time='Full Day Event – 8:00 am – 1:00 am';}

                // if (!(isset($_SESSION["EVENTS"]["MODIFY"]))) {
                // $message = file_get_contents(getcwd()."/email_template/event_confirmation.html");
                // $message = str_replace("%COMPANY_NAME%", 'Chandni Halls', $message);
                // $message = str_replace("%GROOM_NAME%", $groomname, $message);
                // $message = str_replace("%BRIDE_NAME%", $bridename, $message);
                // $message = str_replace("%EVENT_DATE%", $_SESSION["EVENTS"]["STEP-1"]["event_datetime"], $message);
                // $message = str_replace("%EVENT_TIME%", $time, $message);
                // $message = str_replace("%HALL_NAME%", $hallname, $message);
                // $message = str_replace("%TOTAL_GUESTS%", $_SESSION["EVENTS"]["STEP-1"]["no_of_guests"], $message);
                // $email = \Config\Services::email();
                // $email->setTo($_SESSION["email"]);            
                // $email->setFrom('fa.nomi.halls@chandani.dinxstudio.com', 'Event Confirmation');
                // $email->setSubject($company["name"].' - Signup Verification Email');
                // $email->setSubject('Event Confirmation');
                // $email->setMessage($message);
                // $email->send();
                // }else{
                //     $message = file_get_contents(getcwd()."/email_template/event_confirmation_modify.html");
                //     $message = str_replace("%COMPANY_NAME%", 'Chandni Halls', $message);
                //     $message = str_replace("%GROOM_NAME%", $groomname, $message);
                //     $message = str_replace("%BRIDE_NAME%", $bridename, $message);
                //     $message = str_replace("%EVENT_DATE%", $_SESSION["EVENTS"]["STEP-1"]["event_datetime"], $message);
                //     $message = str_replace("%EVENT_TIME%", $time, $message);
                //     $message = str_replace("%HALL_NAME%", $hallname, $message);
                //     $message = str_replace("%TOTAL_GUESTS%", $_SESSION["EVENTS"]["STEP-1"]["no_of_guests"], $message);
                //     $email = \Config\Services::email();
                //     $email->setTo($_SESSION["email"]);            
                //     $email->setFrom('fa.nomi.halls@chandani.dinxstudio.com', 'Event Confirmation');
                //     //$email->setSubject($company["name"].' - Signup Verification Email');
                //     $email->setSubject('Event Updated');
                //     $email->setMessage($message);
                //     $email->send();
                // }


                //add to calander email
                     $events = array(
                        'datetime' => $_SESSION["EVENTS"]["STEP-1"]["event_datetime"],
                        'clientName' => $_SESSION["name"],
                        'hallid' => $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"],
                        'eventTime' => $_SESSION["EVENTS"]["STEP-1"]["event_time"]
                        );
            
                        if($events['eventTime']=='Morning Event'){ 
                            $eventStartTime='10:00:00';
                            $eventEndTime='14:00:00';
                        }
                        
                        if($events['eventTime']=='Evening Event'){ 
                            $eventStartTime='16:00:00';
                            $eventEndTime='20:00:00';
                            
                        }
                        
                        if($events['eventTime']=='Full Day Event'){ 
                            $eventStartTime='10:00:00';
                            $eventEndTime='23:00:00';
                        }
                        
                        $hallname='';
                        if($events['hallid']==1){ $hallname='Chandni Chrysler';}
                        if($events['hallid']==2){ $hallname='Chandni Gateway';}
                        if($events['hallid']==3){ $hallname='Chandni Convention';}
                        if($events['hallid']==4){ $hallname='Chandni Country Club';}
                        if($events['hallid']==5){ $hallname='Chandni Victoria';}
                        $clientName=$events['clientName'];
                        $eventTitle = $clientName.' - '.$hallname;
                        $eventLocation = '2935 Drew Rd, Mississauga, ON L4T 0A1';
                        $eventStartTime = $events['datetime']." ".$eventStartTime;
                        $eventEndTime = $events['datetime']." ".$eventEndTime;
                        $eventDescription =  $hallname.' is booked for '.$clientName;
                        // Generate the .ics content
// $icsData = "BEGIN:VCALENDAR
// VERSION:2.0
// PRODID:-//My Event Management//EN
// BEGIN:VEVENT
// UID:" . md5(uniqid(rand(), true)) . "@yourdomain.com
// DTSTAMP:" . gmdate('Ymd\THis\Z') . "
// DTSTART:" . date('Ymd\THis\Z', strtotime($eventStartTime)) . "
// DTEND:" . date('Ymd\THis\Z', strtotime($eventEndTime)) . "
// SUMMARY:" . $eventTitle . "
// LOCATION:" . $eventLocation . "
// DESCRIPTION:" . $eventDescription . "
// END:VEVENT
// END:VCALENDAR";
//                         // Encode the .ics data to base64
//                         $icsDataEncoded = base64_encode($icsData);

//                         // Save the .ics file to a temporary location
//                         $tempFile = tempnam(sys_get_temp_dir(), 'event');
//                         file_put_contents($tempFile, base64_decode($icsDataEncoded));
//                         // Compose the email content
//                         $html = "
//                                 Your event is confirmed at " . $hallname . " " . $_SESSION["EVENTS"]["STEP-1"]["event_datetime"] . " (" . $time . ") <br><br><br>
//                                 Event Description: " . $eventDescription . "<br><br>
//                                 <a href='https://chandani.dinxstudio.com/ModifyEvent/viewSummary/".$_SESSION["last_inserted_id"]."' target='_blank'>View Summary</a><br><br>
//                             ";

//                         // Email headers
//                         $headers = array(
//                             "Authorization: Bearer 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",
//                             "Content-Type: application/json"
//                         );

//                         $emailData = array(
//                             'personalizations' => array(
//                                 array(
//                                     'to' => array(
//                                         array(
//                                             'email' => $_SESSION["email"]
//                                         )
//                                     )
//                                 )
//                             ),
//                             'from' => array(
//                                 'email' => "fa.nomi.halls@chandani.dinxstudio.com",
//                                 'name' => "Chandni Halls"
//                             ),
//                             'subject' => "Event Confirmation",
//                             'content' => array(
//                                 array(
//                                     'type' => "text/html",
//                                     'value' => $html
//                                 )
//                             ),
//                             'attachments' => array(
//                                 array(
//                                     'content' => base64_encode(file_get_contents($tempFile)),
//                                     'type' => "text/calendar",
//                                     'filename' => "event.ics"
//                                 )
//                             )
//                         );

//                         // Send the email using cURL
//                         $url = 'https://api.sendgrid.com/v3/mail/send';
//                         $ch = curl_init();
//                         curl_setopt($ch, CURLOPT_URL, $url);
//                         curl_setopt($ch, CURLOPT_POST, 1);
//                         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailData));
//                         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//                         $response = curl_exec($ch);
//                         curl_close($ch);

//                         // Remove the temporary .ics file
//                         unlink($tempFile);

//                         // Decode the response and check for success
//                         $responseData = json_decode($response, true);
//                         if ($responseData && isset($responseData['status']) && $responseData['status'] === '202 Accepted') {
//                             // Email sent successfully
//                         } else {
//                             // Email sending failed
//                         }


                        //client email
                        // Set your API key
                        $api_key = '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';
                        $html = "
                                Your event is confirmed at ".$hallname." ".$_SESSION["EVENTS"]["STEP-1"]["event_datetime"]." (".$time.") <br><br>
                                <a href='https://chandani.dinxstudio.com/ModifyEvent/viewSummary/".$_SESSION["last_inserted_id"]."' target='_blank'>View Summary</a><br>
                                ";
                        // Endpoint URL
                        $endpoint = 'https://api.brevo.com/v3/smtp/email';
                        // Data to send in the request
                        $data = array(
                            "sender" => array(
                                "name" => "Chandni Halls",
                                "email" => "fa.nomi.halls@chandani.dinxstudio.com"
                            ),
                            "to" => array(
                                array(
                                    "email" => $_SESSION["email"],
                                    "name" => "Chandni Halls"
                                )
                            ),
                            "subject" => "Event Confirmation",
                            "htmlContent" => $html
                        );

                        // Convert data to JSON format
                        $data_json = json_encode($data);
                        // Initialize cURL session
                        $ch = curl_init($endpoint);
                        // Set cURL options
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'accept: application/json',
                            'api-key: ' . $api_key,
                            'content-type: application/json',
                        ));
                        // Execute cURL request and get the response
                        $response = curl_exec($ch);
                        // Check for cURL errors
                        if (curl_errno($ch)) {
                            // Handle cURL error here
                            echo 'cURL error: ' . curl_error($ch);
                        }
                        // Close cURL session
                        curl_close($ch);
                        // Decode the JSON response
                        $result = json_decode($response, true);
                        //email end

                //$_SESSION["EVENTS"] = array(); 
                return redirect()->to(site_url().'events/thankyou');
                //return redirect()->to(site_url().'events/googleevent');
            }
           if(isset($_SESSION["EVENTS"]["STEP-1"]["how_many_security_gaurds"]) && !empty($_SESSION["EVENTS"]["STEP-1"]["how_many_security_gaurds"])){
               
               $how_many_security_gaurds=$_SESSION["EVENTS"]["STEP-1"]["how_many_security_gaurds"];
               
           }else{
               $how_many_security_gaurds=0;
           }
            $misc = array(
                "no_of_bartenders" => $_SESSION["EVENTS"]["STEP-1"]["no_of_bartenders"],
                "how_many_security_gaurds" => $how_many_security_gaurds,
                // "dj_option" => $_SESSION["EVENTS"]["STEP-9"]["dj_selected"],
                "dj_option" => NULL,
                //"stage_decore_option" => $_SESSION["EVENTS"]["STEP-10"]["stageDecore_selected"],
                "stage_decore_option" => 0,
                //"lighting_option" => $_SESSION["EVENTS"]["STEP-11"]["lighting_selected"],
                "lighting_option" => 0,
            );

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
            
            if(isset($_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]) && $_SESSION["EVENTS"]["STEP-1"]["need_a_hall_rental"]=='Yes'){
                $hallRental ='Yes';
            }else{
                $hallRental ='No';
            }

            $pricing = $companyBuffetPricingModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                                    ->where("tblcompany_menuOption_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_menuOption_id"])
                                                    ->get()->getResult();
            $serviceCharges = $companyVenueServiceChargesModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])->get()->getResult();
            $companyVenueTax = $companyVenueTaxes->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])->get()->getResult();
            $tableCloth = $companyVenueTableClothModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                                        ->where("id", $_SESSION["EVENTS"]["STEP-6"]["tableCloth_selected"])        
                                                        ->get()
                                                        ->getResult();
            if(empty($tableCloth)){
                $tableCloth=0;
            }
            //$flowers = $companyVenueFlowersModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])->where("id", $_SESSION["EVENTS"]["STEP-7"]["flower_selected"])->get()->getResult();
            $flowers = 0;
            $napkin = $companyVenueNapkinsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                                        ->where("id", $_SESSION["EVENTS"]["STEP-5"]["napkin_selected"])        
                                                        ->get()
                                                        ->getResult();
            if(empty($napkin)){
                $napkin=0;
            }                                            
                                                        
            $sound_option = 0;
            $soundOption = array();
            if (($_SESSION["EVENTS"]["STEP-8"]["sound_select"]==0)?0:$_SESSION["EVENTS"]["STEP-8"]["sound_selected"]!=0) {
                $soundOption = $soundOptionsModel->where("tblcompany_id", SITE_ID)->where("id", ($_SESSION["EVENTS"]["STEP-8"]["sound_select"]==0)?0:$_SESSION["EVENTS"]["STEP-8"]["sound_selected"])->get()->getResult();
                $sound_option = 1;
            }
            

            $price = 0;
            $sound_price = 0;
            if (date("w", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))==0) {
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
            } else if (date("w", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))==1) {
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
            } else if (date("w", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))==2) {
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
            } else if (date("w", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))==3) {
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
            } else if (date("w", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))==4) {
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
            } else if (date("w", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))==5) {
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
            } else if (date("w", strtotime($_SESSION["EVENTS"]["STEP-1"]["event_datetime"]))==6) {
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

            $data["buffetPrice"] = $buffetPrice;
            $price *= $_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];
            $data["buffetPrice"] = $buffetPrice*$_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];
            $data["serviceCharge"] = $serviceCharge*$_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];
            $data["tax_title"] = $companyVenueTax[0]->name;
            $data["tax"] = $tax*$_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];
            $data["tableCloth_price"] = $tableCloth_price*$_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];
            $data["flowers_price"] = $flowers_price*$_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];
            $data["napkin_price"] = $napkin_price*$_SESSION["EVENTS"]["STEP-1"]["no_of_guests"];
            $data["sound_option"] = $sound_option;
            $data["sound_price"] = $sound_price;

            $total_person = 0;
            $data["total_price"] = 0;
           
             
            if (count($per_person)>0) {
                foreach($per_person as $option) {
                    eval("\$total_person = \$misc[\"$option->event_table_field_name\"];"); 
                    $price += $total_person*$option->option_price;
                    $misc_price[$option->title] = $total_person*$option->option_price;
                    $data["total_price"] += $total_person*$option->option_price;
                }
            }
            // echo '<pre>';
            // print_r($misc);
            // exit;
            
            $isOptionSelected = 0;
            if (count($per_hall)>0) {
                foreach($per_hall as $option) {
                    eval("\$isOptionSelected = \$misc[\"$option->event_table_field_name\"];"); 
                    if ($isOptionSelected==1) {
                        $price += $option->option_price;
                        $misc_price[$option->title] = $option->option_price;
                        $data["total_price"] += $misc_price[$option->title];
                    }
                }
            }
            // $this->show($misc_price, 1);
            $data["misc_price"] = $misc_price;
            
            //$data["total_price"] = $price;
            $data["total_price"] += floatval($data["buffetPrice"]) + floatval($data["serviceCharge"]) + floatval($data["tax"]) + 
                                    floatval($data["tableCloth_price"]) + floatval($data["flowers_price"]) + floatval($data["napkin_price"]) + $data["sound_price"];
        }

        $_SESSION["event_total_amount"]=$data["total_price"];
        // echo "total_price :".$data["total_price"];die();

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('orderConfirmation', $data, $data_insert);
        echo view('clientFooter');
    }

    function googleevent() {
        $data = array();
        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
        
        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('googleevent');
        echo view('clientFooter');
    }
}

    function thankyou() {
        // $eventsModel = model('App\Models\EventsModel');
        // $eventsModel->update(['id' => $_SESSION["last_inserted_id"]], ['calendar_event_id' => $_SESSION["calendar_event_id"]]);
        $_SESSION["EVENTS"] = array();
        $_SESSION["event_total_amount"]='';
        $_SESSION["APPETIZER"]["start_time"]='';
        $_SESSION["MAINCOURSE"]["start_time"]='';
        $_SESSION["APPETIZER"]["end_time"]='';
        $_SESSION["MAINCOURSE"]["end_time"]='';
        $_SESSION["calendar_event_id"]='';
        $_SESSION["last_inserted_id"]='';
        $data = array();
        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
        }
        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('thankyou');
        echo view('clientFooter');
    }

    function modify() {
        $data = array();
        $event_id = $this->request->uri->getSegments()[2];

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            $eventsModel = model('App\Models\EventsModel');
            $event = $eventsModel->where("id", $event_id)->get()->getResult();
            // $this->show($event, 1);
             
            if (isset($event[0]->id)) {
                $step1 = [
                    "tblcompany_id" => $event[0]->tblcompany_id,
                    "tblcompany_client_id" => $event[0]->tblcompany_client_id,
                    "event_datetime" => $event[0]->event_datetime,
                    "event_time" => $event[0]->event_time,
                    "payment_mode" => $event[0]->payment_mode,
                    "no_of_guests" => $event[0]->no_of_guests,
                    "coat_check" => $event[0]->coat_check,
                    "valid_licensed_bar" => $event[0]->valid_licensed_bar,
                    "own_license_file" => $event[0]->own_license_file,
                    "no_of_bartenders" => $event[0]->no_of_bartenders,
                    "need_a_hall_rental" => $event[0]->need_a_hall_rental,
                    "need_security_gaurds" => $event[0]->need_security_gaurds,
                    "how_many_security_gaurds" => $event[0]->how_many_security_gaurds,
                    // Groom & Bride information
                
                    "groom_title" => $event[0]->groom_title,
                    "groom_fname" => $event[0]->groom_fname,
                    "bride_title" => $event[0]->bride_title,
                    "bride_fname" => $event[0]->bride_fname,
                    
                    "groom_lname" => $event[0]->groom_lname,
                    "bride_lname" => $event[0]->bride_lname,
                    "groom_phone" => $event[0]->groom_phone,
                    "bride_phone" => $event[0]->bride_phone,
                    
                    "groom_address" => $event[0]->groom_address,
                    "bride_address" => $event[0]->bride_address,
                    
                    "groom_driver_license_file" => $event[0]->groom_driver_license_file,
                    "bride_driver_license_file" => $event[0]->bride_driver_license_file,
                    "calendar_event_id" => $event[0]->calendar_event_id,
                    "created_at" => $event[0]->created_at
                ];
                
                $_SESSION["EVENTS"]["STEP-1"] = $step1;
                //print_r($_SESSION["EVENTS"]["STEP-1"]["calendar_event_id"]);
             //exit; 
                $step2 = [
                    "tblcompany_venue_id" => $event[0]->tblcompany_venue_id,
                    "tblcompany_event_type_id" => $event[0]->tblcompany_event_type_id,
                    "tblcompany_menuOption_id" => $event[0]->tblcompany_menuOption_id,
                    "tblcompany_barOption_id" => $event[0]->tblcompany_barOption_id
                ];
                $_SESSION["EVENTS"]["STEP-2"] = $step2;

                $data["venues"] = $this->getAllCompanyVenues();
                $eventTypesModel = model('App\Models\EventTypesModel');
                $data["event_types"] = $eventTypesModel->where("tblcompany_id", SITE_ID)->get()->getResult();

                $menuOptionsModel = model('App\Models\MenuOptionModel');
                $data["menu_options"] = $menuOptionsModel->where("tblcompany_id", SITE_ID)->get()->getResult();
                foreach ($data["venues"] as $value) {
                    if ($value->id==$step2["tblcompany_venue_id"]) {
                        $selected_venue = $value->name;
                    }
                }
                foreach ($data["event_types"] as $value) {
                    if ($value->id==$step2["tblcompany_event_type_id"]) {
                        $selected_eventType = $value->event_type;
                    }
                }
                
                foreach ($data["menu_options"] as $value) {
                    if ($value->id==$step2["tblcompany_menuOption_id"]) {
                        $selected_menuOption = $value->name;
                    }
                }
                if(empty($selected_menuOption)){
                    $selected_menuOption='Not Required';
                }
                
                foreach ($data["menu_options"] as $value) {
                    if ($value->id==$step2["tblcompany_barOption_id"]) {
                        $selected_barOption = $value->name;
                    }
                }
                if(empty($selected_barOption)){
                    $selected_barOption='Not Required';
                }
                
                $step2_labels = [
                    "selected_venue" => $selected_venue,
                    "selected_eventType" => $selected_eventType,
                    "selected_menuOption" => $selected_menuOption,
                    "selected_barOption" => $selected_barOption
                ];
                $_SESSION["EVENTS"]["STEP-2"]["label"] = $step2_labels;

                $menu_item_ids = explode(",", $event[0]->menu_item_selection);
                $_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"] = $menu_item_ids;

                $menuModel = model('App\Models\MenuModel');
                $data["menu_options"] = $menuModel->where("tblcompany_id", SITE_ID)
                                        ->where("tblcompany_menuOption_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_menuOption_id"])
                                        ->orderBy('show_order_category', 'ASC')
                                        ->orderBy('show_order_sub_category', 'ASC')
                                        ->orderBy('show_order_dishes', 'ASC')                            
                                        ->orderBy('item_name', 'ASC')                            
                                        ->get()->getResult();
                
                $categories = array();
                foreach ($data["menu_options"] as $value) {
                    if (!(in_array($value->category, $categories))) {
                        $categories[] = $value->category;
                    }
                }
                $menu=array();
                foreach ($categories as $category) {
                    foreach ($data["menu_options"] as $value) {
                        if ($category==$value->category) {
                            if ($value->sub_category=="" || $value->sub_category==NULL) {
                                $menu[$category]["Empty"][] = $value;
                            } else {
                                $menu[$category][$value->sub_category][] = $value;
                            }
                        }
                    }
                }
                $labels = array();
                if(!empty($menu)){
                foreach ($menu_item_ids as $item) {
                    foreach ($menu as $category => $menu_item) {
                        foreach ($menu_item as $sub_category => $value) {
                            foreach ($value as $v) {
                                if ($item==$v->id) {
                                    $labels[$category][$sub_category][] = $v->item_name;
                                }                
                            }
                        }
                    }
                }
                }
                $_SESSION["EVENTS"]["STEP-3"]["label"] = $labels;
                
                $companyVenueHallsModel = model('App\Models\CompanyVenueHallsModel');
                $floor_plan = $companyVenueHallsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $event[0]->floor_plan_id)        
                                            ->get()
                                            ->getResult();

                $_SESSION["EVENTS"]["STEP-4"]["floor_plan_selected"] = $event[0]->floor_plan_id;
                if(!empty($floor_plan)){
                 $_SESSION["EVENTS"]["STEP-4"]["label"] = $floor_plan[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-4"]["label"] = 'Not Selected';
                }
                $companyVenueNapkinsModel = model('App\Models\CompanyVenueNapkinsModel');
                $napkin = $companyVenueNapkinsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                        ->where("id", $event[0]->napkin_id)        
                                        ->get()
                                        ->getResult();

                $_SESSION["EVENTS"]["STEP-5"]["napkin_selected"] = $event[0]->napkin_id;
                if(!empty($napkin)){
                $_SESSION["EVENTS"]["STEP-5"]["label"] = $napkin[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-5"]["label"] = 'Not Selected';
                }
                $companyVenueTableClothModel = model('App\Models\CompanyVenueTableClothModel');
                $tableCloth = $companyVenueTableClothModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $event[0]->tableCloth_id)        
                                            ->get()
                                            ->getResult();

                $_SESSION["EVENTS"]["STEP-6"]["tableCloth_selected"] = $event[0]->tableCloth_id;
                if(!empty($tableCloth)){
                $_SESSION["EVENTS"]["STEP-6"]["label"] = $tableCloth[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-6"]["label"] = 'Not Selected';
                }
                $companyVenueFlowersModel = model('App\Models\CompanyVenueFlowersModel');
            
                $flower = $companyVenueFlowersModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                        ->where("id", $event[0]->flower_id)        
                                        ->get()
                                        ->getResult();
                // echo '<pre>';
                // print_r($flower);
                // exit;
                
                $_SESSION["EVENTS"]["STEP-7"]["flower_selected"] = $event[0]->flower_id;
                if(!empty($flower)){
                $_SESSION["EVENTS"]["STEP-7"]["label"] = $flower[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-7"]["label"] = '';
                }

                if ($event[0]->sound_option_id!=0) {
                    $_SESSION["EVENTS"]["STEP-8"]["sound_select"] = 1;
                    $_SESSION["EVENTS"]["STEP-8"]["sound_selected"] = $event[0]->sound_option_id;

                    $soundOptionsModel = model('App\Models\SoundOptionsModel');
                    $sound_options = $soundOptionsModel->where('id', $event[0]->sound_option_id)->get()->getResult();
                    $_SESSION["EVENTS"]["STEP-8"]["label"] = $sound_options[0]->name; 
                } else {
                    $_SESSION["EVENTS"]["STEP-8"]["sound_select"] = 0;
                    $_SESSION["EVENTS"]["STEP-8"]["sound_selected"] = 0;

                    $_SESSION["EVENTS"]["STEP-8"]["label"] = ''; 
                }
                
                $_SESSION["EVENTS"]["STEP-9"]["dj_selected"] = $event[0]->dj_option;

                if ($event[0]->dj_option==0) {
                    $msg = "NEED A DJ"; 
                } else {
                    $msg = "WILL BRING OWN DJ"; 
                }
                $_SESSION["EVENTS"]["STEP-9"]["label"] = $msg;

                $_SESSION["EVENTS"]["STEP-10"]["stageDecore_selected"] = $event[0]->stage_decore_option;

                if ($event[0]->stage_decore_option==0) {
                    $msg = "Yes, I need a professional stage decore from Chandni"; 
                } else {
                    $msg = "Will arrange own stage decore"; 
                }
                $_SESSION["EVENTS"]["STEP-10"]["label"] = $msg;

                $_SESSION["EVENTS"]["STEP-11"]["lighting_selected"] = $event[0]->lighting_option;

                if ($event[0]->lighting_option==0) {
                    $msg = " NEED CUSTOM LIGHTING SETUP"; 
                } else {
                    $msg = " DON'T NEED LIGHTING SETUP"; 
                }
                $_SESSION["EVENTS"]["STEP-11"]["label"] = $msg;
                $_SESSION["EVENTS"]["MODIFY"] = $event_id;
                return redirect()->to(site_url().'events/new/edit/'.$event_id);
            }
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('thankyou');
        echo view('clientFooter');
    }
    
    function viewSummary() {    
        $data = array();
        $event_id = $this->request->uri->getSegments()[2];

        if (!(isset($_SESSION["client_id"]))) {
            return redirect()->to(site_url().'home');
        } else {
            $eventsModel = model('App\Models\EventsModel');
            $event = $eventsModel->where("id", $event_id)->get()->getResult();
            // $this->show($event, 1);

            if (isset($event[0]->id)) {
                $step1 = [
                    "tblcompany_id" => $event[0]->tblcompany_id,
                    "tblcompany_client_id" => $event[0]->tblcompany_client_id,
                    "event_datetime" => $event[0]->event_datetime,
                    "event_time" => $event[0]->event_time,
                    "payment_mode" => $event[0]->payment_mode,
                    "no_of_guests" => $event[0]->no_of_guests,
                    "coat_check" => $event[0]->coat_check,
                    "valid_licensed_bar" => $event[0]->valid_licensed_bar,
                    "own_license_file" => $event[0]->own_license_file,
                    "no_of_bartenders" => $event[0]->no_of_bartenders,
                    "need_a_hall_rental" => $event[0]->need_a_hall_rental,
                    "need_security_gaurds" => $event[0]->need_security_gaurds,
                    "how_many_security_gaurds" => $event[0]->how_many_security_gaurds,
                    // Groom & Bride information
                
                    "groom_title" => $event[0]->groom_title,
                    "groom_fname" => $event[0]->groom_fname,
                    "bride_title" => $event[0]->bride_title,
                    "bride_fname" => $event[0]->bride_fname,
                    
                    "groom_lname" => $event[0]->groom_lname,
                    "bride_lname" => $event[0]->bride_lname,
                    "groom_phone" => $event[0]->groom_phone,
                    "bride_phone" => $event[0]->bride_phone,
                    
                    "groom_address" => $event[0]->groom_address,
                    "bride_address" => $event[0]->bride_address,
                    
                    "groom_driver_license_file" => $event[0]->groom_driver_license_file,
                    "bride_driver_license_file" => $event[0]->bride_driver_license_file,
                    "created_at" => $event[0]->created_at
                ];
        
                $_SESSION["EVENTS"]["STEP-1"] = $step1;

                $step2 = [
                    "tblcompany_venue_id" => $event[0]->tblcompany_venue_id,
                    "tblcompany_event_type_id" => $event[0]->tblcompany_event_type_id,
                    "tblcompany_menuOption_id" => $event[0]->tblcompany_menuOption_id,
                    "tblcompany_barOption_id" => $event[0]->tblcompany_barOption_id
                ];
                $_SESSION["EVENTS"]["STEP-2"] = $step2;

                $data["venues"] = $this->getAllCompanyVenues();
                $eventTypesModel = model('App\Models\EventTypesModel');
                $data["event_types"] = $eventTypesModel->where("tblcompany_id", SITE_ID)->get()->getResult();

                $menuOptionsModel = model('App\Models\MenuOptionModel');
                $data["menu_options"] = $menuOptionsModel->where("tblcompany_id", SITE_ID)->get()->getResult();
                foreach ($data["venues"] as $value) {
                    if ($value->id==$step2["tblcompany_venue_id"]) {
                        $selected_venue = $value->name;
                    }
                }
                foreach ($data["event_types"] as $value) {
                    if ($value->id==$step2["tblcompany_event_type_id"]) {
                        $selected_eventType = $value->event_type;
                    }
                }
                
                foreach ($data["menu_options"] as $value) {
                    if ($value->id==$step2["tblcompany_menuOption_id"]) {
                        $selected_menuOption = $value->name;
                    }
                }
                if(empty($selected_menuOption)){
                    $selected_menuOption='Not Required';
                }
                
                foreach ($data["menu_options"] as $value) {
                    if ($value->id==$step2["tblcompany_barOption_id"]) {
                        $selected_barOption = $value->name;
                    }
                }
                if(empty($selected_barOption)){
                    $selected_barOption='Not Required';
                }
                
                $step2_labels = [
                    "selected_venue" => $selected_venue,
                    "selected_eventType" => $selected_eventType,
                    "selected_menuOption" => $selected_menuOption,
                    "selected_barOption" => $selected_barOption
                ];
                $_SESSION["EVENTS"]["STEP-2"]["label"] = $step2_labels;

                $menu_item_ids = explode(",", $event[0]->menu_item_selection);
                $_SESSION["EVENTS"]["STEP-3"]["menu_item_ids"] = $menu_item_ids;

                $menuModel = model('App\Models\MenuModel');
                $data["menu_options"] = $menuModel->where("tblcompany_id", SITE_ID)
                                        ->where("tblcompany_menuOption_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_menuOption_id"])
                                        ->orderBy('show_order_category', 'ASC')
                                        ->orderBy('show_order_sub_category', 'ASC')
                                        ->orderBy('show_order_dishes', 'ASC')                            
                                        ->orderBy('item_name', 'ASC')                            
                                        ->get()->getResult();
                
                $categories = array();
                foreach ($data["menu_options"] as $value) {
                    if (!(in_array($value->category, $categories))) {
                        $categories[] = $value->category;
                    }
                }
                $menu=array();
                foreach ($categories as $category) {
                    foreach ($data["menu_options"] as $value) {
                        if ($category==$value->category) {
                            if ($value->sub_category=="" || $value->sub_category==NULL) {
                                $menu[$category]["Empty"][] = $value;
                            } else {
                                $menu[$category][$value->sub_category][] = $value;
                            }
                        }
                    }
                }
                $labels = array();
                if(!empty($menu)){
                foreach ($menu_item_ids as $item) {
                    foreach ($menu as $category => $menu_item) {
                        foreach ($menu_item as $sub_category => $value) {
                            foreach ($value as $v) {
                                if ($item==$v->id) {
                                    $labels[$category][$sub_category][] = $v->item_name;
                                }                
                            }
                        }
                    }
                }
                }
                $_SESSION["EVENTS"]["STEP-3"]["label"] = $labels;
                
                $companyVenueHallsModel = model('App\Models\CompanyVenueHallsModel');
                $floor_plan = $companyVenueHallsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $event[0]->floor_plan_id)        
                                            ->get()
                                            ->getResult();

                $_SESSION["EVENTS"]["STEP-4"]["floor_plan_selected"] = $event[0]->floor_plan_id;
                if(!empty($floor_plan)){
                 $_SESSION["EVENTS"]["STEP-4"]["label"] = $floor_plan[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-4"]["label"] = 'Not Selected';
                }
                $companyVenueNapkinsModel = model('App\Models\CompanyVenueNapkinsModel');
                $napkin = $companyVenueNapkinsModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                        ->where("id", $event[0]->napkin_id)        
                                        ->get()
                                        ->getResult();

                $_SESSION["EVENTS"]["STEP-5"]["napkin_selected"] = $event[0]->napkin_id;
                if(!empty($napkin)){
                $_SESSION["EVENTS"]["STEP-5"]["label"] = $napkin[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-5"]["label"] = 'Not Selected';
                }
                $companyVenueTableClothModel = model('App\Models\CompanyVenueTableClothModel');
                $tableCloth = $companyVenueTableClothModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                            ->where("id", $event[0]->tableCloth_id)        
                                            ->get()
                                            ->getResult();

                $_SESSION["EVENTS"]["STEP-6"]["tableCloth_selected"] = $event[0]->tableCloth_id;
                if(!empty($napkin)){
                $_SESSION["EVENTS"]["STEP-6"]["label"] = $tableCloth[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-6"]["label"] = 'Not Selected';
                }
                $companyVenueFlowersModel = model('App\Models\CompanyVenueFlowersModel');
            
                $flower = $companyVenueFlowersModel->where("tblcompany_venue_id", $_SESSION["EVENTS"]["STEP-2"]["tblcompany_venue_id"])
                                        ->where("id", $event[0]->flower_id)        
                                        ->get()
                                        ->getResult();
                // echo '<pre>';
                // print_r($flower);
                // exit;
                
                $_SESSION["EVENTS"]["STEP-7"]["flower_selected"] = $event[0]->flower_id;
                if(!empty($flower)){
                $_SESSION["EVENTS"]["STEP-7"]["label"] = $flower[0]->name;
                }else{
                    $_SESSION["EVENTS"]["STEP-7"]["label"] = '';
                }

                if ($event[0]->sound_option_id!=0) {
                    $_SESSION["EVENTS"]["STEP-8"]["sound_select"] = 1;
                    $_SESSION["EVENTS"]["STEP-8"]["sound_selected"] = $event[0]->sound_option_id;

                    $soundOptionsModel = model('App\Models\SoundOptionsModel');
                    $sound_options = $soundOptionsModel->where('id', $event[0]->sound_option_id)->get()->getResult();
                    $_SESSION["EVENTS"]["STEP-8"]["label"] = $sound_options[0]->name; 
                } else {
                    $_SESSION["EVENTS"]["STEP-8"]["sound_select"] = 0;
                    $_SESSION["EVENTS"]["STEP-8"]["sound_selected"] = 0;

                    $_SESSION["EVENTS"]["STEP-8"]["label"] = ''; 
                }
                
                $_SESSION["EVENTS"]["STEP-9"]["dj_selected"] = $event[0]->dj_option;

                if ($event[0]->dj_option==0) {
                    $msg = "NEED A DJ"; 
                } else {
                    $msg = "WILL BRING OWN DJ"; 
                }
                $_SESSION["EVENTS"]["STEP-9"]["label"] = $msg;

                $_SESSION["EVENTS"]["STEP-10"]["stageDecore_selected"] = $event[0]->stage_decore_option;

                if ($event[0]->stage_decore_option==0) {
                    $msg = "Yes, I need a professional stage decore from Chandni"; 
                } else {
                    $msg = "Will arrange own stage decore"; 
                }
                $_SESSION["EVENTS"]["STEP-10"]["label"] = $msg;

                $_SESSION["EVENTS"]["STEP-11"]["lighting_selected"] = $event[0]->lighting_option;

                if ($event[0]->lighting_option==0) {
                    $msg = " NEED CUSTOM LIGHTING SETUP"; 
                } else {
                    $msg = " DON'T NEED LIGHTING SETUP"; 
                }
                $_SESSION["EVENTS"]["STEP-11"]["label"] = $msg;
                $_SESSION["EVENTS"]["MODIFY"] = $event_id;
                return redirect()->to(site_url().'events/orderConfirmation');
            }
        }

        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('thankyou');
        echo view('clientFooter');
    }

    public function reset() {
        $_SESSION["EVENTS"] = array();

        return redirect()->to(site_url().'events/new');
    }
    
    public function all() {
        helper(['form']);
        helper('html');
        $logged_in = false;
        
        $companyModel = model('App\Models\CompanyModel');

        $company = $companyModel->find(SITE_ID);

        $data['company_name'] = $company["name"];
        $data['logo'] = $company["logo"];
        
        if ((isset($_SESSION["client_id"]))) {
    
            $eventsModel = model('App\Models\EventsModel');
            $data["my_events"] = $eventsModel
                                        ->select('tblcompany_events.*, '.
                                                 'tblcompany_venues.name AS Venue_Name, '.
                                                 'tblcompany_event_types.event_type AS event_type, '.
                                                 'tblcompany_event_types.description AS event_type_description, '.
                                        'tblcompany_menuOptions.name AS menuOption_name')
                                        ->where("tblcompany_events.tblcompany_id`", SITE_ID)
                                        ->where("tblcompany_menuOptions.id !=", 36)
                                        ->where("tblcompany_client_id", $_SESSION['client_id'])
                                        ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
                                        ->join('tblcompany_event_types', 'tblcompany_events.tblcompany_event_type_id = tblcompany_event_types.id')
                                        ->join('tblcompany_menuOptions', 'tblcompany_menuOptions.id = tblcompany_events.tblcompany_menuOption_id')->orderBy("created_at", "DESC")
                                        ->get()->getResult();
            $data["my_events_2"] = $eventsModel
                                        ->select('tblcompany_events.*, '.
                                                 'tblcompany_venues.name AS Venue_Name, '.
                                                 'tblcompany_event_types.event_type AS event_type, '.
                                                 'tblcompany_event_types.description AS event_type_description, ')
                                        ->where("tblcompany_events.tblcompany_id`", SITE_ID)
                                        ->where("tblcompany_client_id", $_SESSION['client_id']) 
                                        ->where("tblcompany_menuOption_id",0)
                                        ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
                                        ->join('tblcompany_event_types', 'tblcompany_events.tblcompany_event_type_id = tblcompany_event_types.id')->orderBy("created_at", "DESC")
                                        ->get()->getResult();                            

            $menuModel = model('App\Models\MenuModel');
            $data_menu = array();
            foreach ($data["my_events"] as $my_event) {
                $menu_items = explode(",", $my_event->menu_item_selection);
                $menu_item_name = array();
                if(!empty($menu_items)){
                foreach ($menu_items as $menu_item) {
                    if(!empty($menu_item)){
                    $menu_item_name[] = $menuModel->where("id", $menu_item)->get()->getResult()[0]->item_name;
                    }
                }
                }

                $data_menu[] = array(
                                    'menu_item_selection' => $my_event->menu_item_selection,
                                    'menu_item_name' => implode(', ', $menu_item_name));
            }
            // $this->show($data_menu, 1);
            // $this->show($data["my_events"], 1);
            $data["menu_item_name"] = $data_menu;
              echo view('clientHeader');
              echo view('clientLeftSidebar', $data);
              echo view('clientList', $data);
              echo view('clientFooter');
        }else{
            return redirect()->to(site_url().'home');
        }
    }
    
    public function deletecalendar($event_id=null) {
        $this->db = \Config\Database::connect();
        $builder = $this->db->table('tblcompany_events');
        $builder->select('calendar_event_id');
        $builder->where('id',$event_id);
        $query = $builder->get();
        $result = $query->getResult();
        if($query->getNumRows() > 0)
        {
        $_SESSION["EVENTS"]["calendar_event_id"]=$result[0]->calendar_event_id;
        $_SESSION["EVENTS"]["delete_event_id"]=$event_id;
        }
        $data = array();
        echo view('clientHeader');
        echo view('clientLeftSidebar', $data);
        echo view('deletegoogleevent');
        echo view('clientFooter');
    }

    public function delete() {
        $_SESSION["EVENTS"] = array();
        $event_id = $this->request->uri->getSegments()[2];
        $this->db= \Config\Database::connect();
        $builder = $this->db->table('tblcompany_events');

        $builder->select('calendar_event_id');
        $builder->where('id',$event_id);
        $query = $builder->get();
        $result = $query->getResult();

        $url="https://dinxstudio.com/googleapi/deleteEvent.php";
                    $calendarData = array(
                      'eventId' => $result[0]->calendar_event_id,
                    );
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($calendarData));
                $resp = curl_exec($curl);
                
                $event=$builder->delete(["id"=>$event_id]);
                return redirect()->to(site_url().'home');
    }
    
    public function emailTest(){
        $groomname = 'Groom';
        $bridename = 'Bride';
        
        $hallname='Hall';
        $_SESSION["email"]='harryjames2293@gmail.com';
        
        $message = file_get_contents(getcwd()."/email_template/event_confirmation.html");
        $message = str_replace("%COMPANY_NAME%", 'company name', $message);
        $message = str_replace("%GROOM_NAME%", $groomname, $message);
        $message = str_replace("%BRIDE_NAME%", $bridename, $message);
        $message = str_replace("%EVENT_DATE%", '2022-10-19', $message);
        $message = str_replace("%EVENT_TIME%", 'Morning Event', $message);
        $message = str_replace("%HALL_NAME%", $hallname, $message);
        
        $email = \Config\Services::email();
        $email->setTo($_SESSION["email"]);            
        $email->setFrom('fa.nomi.halls@chandani.dinxstudio.com', 'Event Confirmation');
        //$email->setSubject($company["name"].' - Signup Verification Email');
        $email->setSubject('Event Confirmation');
        $email->setMessage($message);
        $email->send();
    }    
}

<?php

namespace App\Controllers;
use App\Libraries\GroceryCrud;
class Client extends BaseController
{
    public function clientProfile($seg1 = false, $seg2 = false){
        if (isset($_SESSION["client_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompany_clients');
            $crud->columns(array('first_name', 'last_name','email','phone','age'));
            $crud->fields(array('first_name', 'last_name','email','phone','age'));
            $crud->fieldType("phone", "string");
            
            $crud->unsetAdd();
            $crud->unsetBackToDatagrid();
            $crud->unsetDelete();

            // $crud->callbackColumn('logo', function($value, $primaryKey) {
            //     return '<img src="'. $value .'" width=100>';
            // });

            $companyModel = model('App\Models\CompanyClientModel');
            // $crud->callbackAfterUpdate(function ($stateParameters) use ($companyModel) {
            //     $data = [
            //         'updated_at'  => date("Y-m-d H:i:s")
            //     ];

            //     $companyModel->update($data, ['id' => $stateParameters->primaryKeyValue]);

            //     return $stateParameters;
            // });
            
            $output = $crud->render();
            //echo "<pre>"; print_r($output); exit;
            echo view('clientHeader', (array)$output);
            
            //$data["temperature"] = $this->getTemperature();
            $data["temperature"] = '';

            $eventsModel = model('App\Models\EventsModel');
            $data["my_events"] = $eventsModel
                                        ->select('tblcompany_events.*, '.
                                                 'tblcompany_venues.name AS Venue_Name, '.
                                                 'tblcompany_event_types.event_type AS event_type, '.
                                                 'tblcompany_event_types.description AS event_type_description, '.
                                                 'tblcompany_menuOptions.name AS menuOption_name')
                                        ->where("tblcompany_events.tblcompany_id`", SITE_ID)
                                        ->where("tblcompany_client_id", $_SESSION['client_id'])
                                        ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
                                        ->join('tblcompany_event_types', 'tblcompany_events.tblcompany_event_type_id = tblcompany_event_types.id')
                                        ->join('tblcompany_menuOptions', 'tblcompany_menuOptions.id = tblcompany_events.tblcompany_menuOption_id')
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
            
            
            $data["menu_item_name"] = $data_menu;
            
            
            echo view('clientLeftSidebar', $data);
            $crud_data = array(
                "title" => "Company Profile",
                "title_description" => "Company profile can be managed here"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('clientFooter');
        } else {
            //return redirect()->to(site_url().'Administration');
        }
    }
    
    public function contract(){
        if (isset($_SESSION["client_id"])) {
            $contractModel = model('App\Models\ContractModel');
            $data['contract']= $contractModel->get()->getResult();
            
            $data_insert = array();
            echo view('clientHeader');
            echo view('clientLeftSidebar', $data);
            echo view('clientContract', $data, $data_insert);
            echo view('clientFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function FAQs(){
        if (isset($_SESSION["client_id"])) {
            $FAQModel = model('App\Models\FAQModel');
            $data['all_faqs']= $FAQModel->orderBy("id", "DESC")->get()->getResult();           
            echo view('clientHeader');
            echo view('clientLeftSidebar', $data);
            echo view('clientFAQ', $data);
            echo view('clientFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

}
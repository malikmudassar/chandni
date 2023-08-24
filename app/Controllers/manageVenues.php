<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class ManageVenues extends BaseController
{
    protected $request;

    public function venues() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompany_venues');
            $crud->columns(array('name','address','phone','website'));
            $crud->fields(array('name','address','phone','website'));
            $crud->fieldType("phone", "string");

            // $crud->setRelation("tblcompany_id", "tblcompanies", "name", "id=".SITE_ID);
            // $crud->displayAs("tblcompany_id", "Company/Organization");
            $output = $crud->render();
            echo view('adminHeader', (array)$output);
            echo view('adminLeftSidebar');
            $crud_data = array(
                "title" => "Manage Venues",
                "title_description" => "Create/Modify Venues here"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function venueHalls() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompany_venue_halls');

            $crud->setRelation("tblcompany_venue_id", "tblcompany_venues", "name", "tblcompany_id=".SITE_ID);
            $crud->displayAs("persons_capacity_min", "Min People");
            $crud->displayAs("persons_capacity_max", "Max People");
            $crud->displayAs("tblcompany_venue_id", "Venue");

            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            echo view('adminLeftSidebar');
            $crud_data = array(
                "title" => "Manage Venue Halls",
                "title_description" => "Create/Modify Halls in Venues here"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    function log_user_after_update($post_array, $primary_key) {
        echo "<pre>"; 
        print_r($post_array);
        print_r($primary_key);
        exit;

        return true;
    }
}

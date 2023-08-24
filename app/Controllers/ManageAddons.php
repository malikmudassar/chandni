<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class ManageAddons extends BaseController
{
    protected $request;

    public function menuOptions() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompany_menuOptions');
            $crud->displayAs("name", "Menu Option Name");
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            echo view('adminLeftSidebar');
            $crud_data = array(
                "title" => "Manage Menu Options",
                "title_description" => "Create/Modify Menu Options here"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function menuItems() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompany_menu');

            $crud->setRelation("tblcompany_menuOption_id", "tblcompany_menuOptions", "name");
            $crud->displayAs("tblcompany_menuOption_id", "Menu Option");

            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            echo view('adminLeftSidebar');
            $crud_data = array(
                "title" => "Manage Menu Items",
                "title_description" => "Create/Modify Menu Items here"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
}

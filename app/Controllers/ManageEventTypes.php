<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class ManageEventTypes extends BaseController
{
    protected $request;

    public function eventTypes() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompany_event_types');
            $crud->setSubject("Event Type", "Event Types");
            // $crud->fieldType('tblcompany_id', 'invisible');
            $crud->columns(array('event_type', 'description'));
            $crud->fields(array('event_type', 'description'));
            // echo "<pre>";print_r($crud);die();
            // $crud->displayAs("tblcompany_id", " ");
            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_id'] = SITE_ID;
                return $stateParameters;
            });

            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Event Types",
                "title_description" => "Create/Modify Event Types here"
            );

            // echo "<pre>";print_r($output);die();
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
}

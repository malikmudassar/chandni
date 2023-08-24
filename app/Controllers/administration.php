<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Administration extends BaseController
{
    protected $request;

    public function index()
    {
        if (!(isset($_SESSION["user_id"]))) {
            helper('html');

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
    
                    if($authenticatePassword){
                        $ses_data = [
                            'user_id' => $data['id'],
                            'name' => $data['fname']." ".$data['lname'],
                            'email' => $data['email'],
                            "logo" => $company["logo"],
                            "avatar" => $data["avatar"],
                            'isLoggedIn' => TRUE
                        ];
                        $session->set($ses_data);
                        return redirect()->to(site_url().'Administration/home');
                    
                    }else{
                        $session->setFlashdata('msg', 'Password is incorrect.');
                        return redirect()->to(site_url().'Administration');
                    }
    
                }else{
                    $session->setFlashdata('msg', 'Email does not exist.');
                    return redirect()->to(site_url().'Administration');
                }
            }
    
            return view('admin', $data);
        } else {
            // logged in
            return redirect()->to(site_url().'Administration/home');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url().'Administration');
    }

    public function home() {
        if (isset($_SESSION["user_id"])) {
            echo view('adminHeader');
            echo view('adminLeftSidebar');
            echo view('adminHome');
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
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

            echo view('adminHeader', (array)$output);
            echo view('adminLeftSidebar');
            $crud_data = array(
                "title" => "Company Profile",
                "title_description" => "Company profile can be managed here"
            );
            //echo "<pre>"; print_r($crud_data);
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

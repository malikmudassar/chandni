<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class ManageClient extends BaseController
{
    protected $request;

    public function register() {
        if (isset($_SESSION["user_id"])) {
            helper(['form']);
            $data = [];
    
            // return view('welcome_message');
            echo view('adminHeader');
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            $CompanyVenueModel = model('App\Models\CompanyVenueModel');
            $data["CompanyVenueData"] = $CompanyVenueModel->select()->get()->getResult();
            echo view('adminLeftSidebar', $data);
            echo view('adminRegister', $data);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
    
    public function save()
    {
        //include helper form
        helper(['form']);
        //set rules validation form
        $rules = [
            'first_name'          => 'required|min_length[3]|max_length[20]',
            'last_name'          => 'required|min_length[3]|max_length[20]',
            //'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[tblcompany_clients.email]',
            'email'         => 'required|min_length[6]|max_length[50]|valid_email',
            'phone'      => 'required|min_length[9]|max_length[16]',
            'age'  => 'required|numeric|min_length[1]|max_length[3]',
            'gender'  => 'required',
            'location'  => 'required',
            'terms'  => ['rules'  => 'required','errors' => [
                'required' => 'You must agree to our terms & conditions.',
                ],
            ]
        ];
      
        if($this->validate($rules)){
            $companyModel = model('App\Models\CompanyModel');
            $company = $companyModel->find(SITE_ID);

            $model = model('App\Models\CompanyClientModel');

            //generate simple random code
			$s = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$activation_code = substr(str_shuffle($s), 0, 12);

            $password = bin2hex(openssl_random_pseudo_bytes(4));

            $data = [
                'tblcompany_id'     => SITE_ID,
                'first_name'     => $this->request->getVar('first_name'),
                'last_name'    => $this->request->getVar('last_name'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'phone'    => $this->request->getVar('phone'),
                'age'    => $this->request->getVar('age'),
                'gender'    => $this->request->getVar('gender'),
                'tblcompany_venues_id'    => $this->request->getVar('location'),
                'terms'    => $this->request->getVar('terms'),
                'activation_code' => $activation_code,
                'active' => '0'
            ];
            $model->save($data);
            $id = $model->insertID();

            $message = file_get_contents(getcwd()."/email_template/register.html"); 

            $message = str_replace("%COMPANY_NAME%", $company["name"], $message);
            $message = str_replace("%COMPANY_WEBSITE%", $company["website"], $message);
            $message = str_replace("%COMPANY_VENUE_URL%", base_url(), $message);
            $message = str_replace("%FIRST_NAME%", $this->request->getVar('first_name'), $message);
            $message = str_replace("%LAST_NAME%", $this->request->getVar('last_name'), $message);
            $message = str_replace("%EMAIL%", $this->request->getVar('email'), $message);
            $message = str_replace("%PASSWORD%", $password, $message);
            $message = str_replace("%CLIENT_ID%", $id, $message);
            $message = str_replace("%ACTIVATION_CODE%", $activation_code, $message);
            
            
            $email = \Config\Services::email();
            $email->setTo($this->request->getVar('email'));            
            $email->setFrom('fa.nomi.halls@chandani.dinxstudio.com', 'Confirm Registration');
            //$email->setSubject($company["name"].' - Signup Verification Email');
            $email->setSubject('Welcome to '.$company["name"]);
            $email->setMessage($message);
            if ($email->send()) {
                $data['validation'] = 'Activation code sent to email';
            } else {
                $data['validation'] = $email->printDebugger(['headers']);
            }

            return redirect()->to(site_url().'ManageClient/clienList');
        } else {
            $CompanyVenueModel = model('App\Models\CompanyVenueModel');
            $data["CompanyVenueData"] = $CompanyVenueModel->select()->get()->getResult();
            $data['validation'] = $this->validator;
            echo view('adminHeader');
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            echo view('adminRegister', $data);
            echo view('adminFooter');

        }
          
    }
    
    public function clienList() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();
            $crud->setTable('tblcompany_clients')
            ->setSubject("Manage Client", "Manage Client")
            ->columns(array('first_name', 'last_name','email','phone','age'))
            ->fields(array('first_name', 'last_name','email','phone','age'));
 /*           
$crud = new GroceryCrud();
$crud->setTable('tblcompany_clients')
    ->setSubject("Manage Client", "Manage Client")
    ->columns(array(
        'first_name', 
        'last_name',
        'email',
        'phone',
        'age',
        'tblcompany_venues.name' // Display the name of the venue instead of the venue ID
    ))
    ->fields(array(
        'first_name',
        'last_name',
        'email',
        'phone',
        'age',
        'tblcompany_venues_id'
    ))
    ->setRelation('tblcompany_venues_id', 'tblcompany_venues', 'name')
    ->displayAs('tblcompany_venues_id', 'Venue')
    ->displayAs('tblcompany_venues.name', 'Join Column');
*/
             $crud->unsetAdd();
             $crud->unsetPrint();
            $output = $crud->render();
            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Clients",
                "title_description" => "Delete/Modify Clients here"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
    
    public function registerAdmin() {
        if (isset($_SESSION["user_id"])) {
            helper(['form']);
            $data = [];
    
            // return view('welcome_message');
            echo view('adminHeader');
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            $db = \Config\Database::connect();
            $query = $db->table('tblcompany_permissions');
            $data['permissions'] = $query->select('*')->get()->getResult();
            echo view('adminLeftSidebar', $data);
            echo view('adminRegisteradmin', $data);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
    
    public function saveadmin()
    {
        //include helper form
        helper(['form']);
        //set rules validation form
        $rules = [
            'first_name'          => 'required|min_length[3]|max_length[20]',
            'last_name'          => 'required|min_length[3]|max_length[20]',
            'email'         => 'required|min_length[6]|max_length[50]|valid_email|is_unique[tblcompany_users.email]',
            // 'email'         => 'required|min_length[6]|max_length[50]|valid_email',
            'phone'      => 'required|min_length[9]|max_length[16]',
            'age'  => 'required|numeric|min_length[1]|max_length[3]',
            'admin_type'  => 'required',
        ];
      
        if($this->validate($rules)){
            $companyModel = model('App\Models\CompanyModel');
            $company = $companyModel->find(SITE_ID);

            $model = model('App\Models\CompanyUserModel');

            //generate simple random code
			$s = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$activation_code = substr(str_shuffle($s), 0, 12);
            $password = bin2hex(openssl_random_pseudo_bytes(4));
            $permission = $this->request->getVar('permission');
            $data = [
                'tblcompany_id'     => SITE_ID,
                'avatar' => '
https://chandani.dinxstudio.com/assets/images/User-Administrator-Blue-icon.png',
                'type'    => 'Manager',
                'fname'     => $this->request->getVar('first_name'),
                'lname'    => $this->request->getVar('last_name'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'phone'    => $this->request->getVar('phone'),
                'age'    => $this->request->getVar('age'),
                'admin_type'    => $this->request->getVar('admin_type'),
                'permission'    => json_encode($permission),
                'terms'    => $this->request->getVar('terms'),
                'activation_code' => $activation_code,
                'active' => '0'
            ];
            // echo "<pre>";
            // print_r($data);
            // exit;
            $model->save($data);
            $id = $model->insertID();

            $message = file_get_contents(getcwd()."/email_template/register-admin.html"); 

            $message = str_replace("%COMPANY_NAME%", $company["name"], $message);
            $message = str_replace("%COMPANY_WEBSITE%", $company["website"], $message);
            $message = str_replace("%COMPANY_VENUE_URL%", base_url(), $message);
            $message = str_replace("%FIRST_NAME%", $this->request->getVar('first_name'), $message);
            $message = str_replace("%LAST_NAME%", $this->request->getVar('last_name'), $message);
            $message = str_replace("%EMAIL%", $this->request->getVar('email'), $message);
            $message = str_replace("%PASSWORD%", $this->request->getVar('password'), $message);
            $message = str_replace("%CLIENT_ID%", $id, $message);
            $message = str_replace("%ACTIVATION_CODE%", $activation_code, $message);
            
            
            $email = \Config\Services::email();
            $email->setTo($this->request->getVar('email'));            
            $email->setFrom('Info@chandnihalls.com', 'Confirm Registration');
            //$email->setSubject($company["name"].' - Signup Verification Email');
            $email->setSubject('Welcome to '.$company["name"]);
            $email->setMessage($message);
            if ($email->send()) {
                $data['validation'] = 'Activation code sent to email';
            } else {
                $data['validation'] = $email->printDebugger(['headers']);
            }
            
            
            $messageAdmin = file_get_contents(getcwd()."/email_template/register-admin-admin.html"); 

            $messageAdmin = str_replace("%COMPANY_NAME%", $company["name"], $messageAdmin);
            $messageAdmin = str_replace("%COMPANY_WEBSITE%", $company["website"], $messageAdmin);
            $messageAdmin = str_replace("%COMPANY_VENUE_URL%", base_url(), $messageAdmin);
            $messageAdmin = str_replace("%FIRST_NAME%", $this->request->getVar('first_name'), $messageAdmin);
            $messageAdmin = str_replace("%LAST_NAME%", $this->request->getVar('last_name'), $messageAdmin);
            $messageAdmin = str_replace("%EMAIL%", $this->request->getVar('email'), $messageAdmin);
            $messageAdmin = str_replace("%PASSWORD%", $this->request->getVar('password'), $messageAdmin);
            $messageAdmin = str_replace("%CLIENT_ID%", $id, $messageAdmin);
            $messageAdmin = str_replace("%ACTIVATION_CODE%", $activation_code, $messageAdmin);
            
            
            $email = \Config\Services::email();
            $email->setTo('fa.nomi.halls@chandani.dinxstudio.com');
            //$email->setTo('shahzeb5@outlook.com');
            $email->setFrom('Info@chandnihalls.com', 'Confirm Registration');
            //$email->setSubject($company["name"].' - Signup Verification Email');
            $email->setSubject('Welcome to '.$company["name"]);
            $email->setMessage($messageAdmin);
            if ($email->send()) {
                $data['validation'] = 'Activation code sent to email';
            } else {
                $data['validation'] = $email->printDebugger(['headers']);
            }

            return redirect()->to(site_url().'ManageClient/adminlist');
        } else {
            $data['validation'] = $this->validator;
            echo view('adminHeader');
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            $db = \Config\Database::connect();
            $query = $db->table('tblcompany_permissions');
            $data['permissions'] = $query->select('*')->get()->getResult();
            echo view('adminLeftSidebar', $data);
            echo view('adminRegisteradmin', $data);
            echo view('adminFooter');
        }
          
    }
    
    public function adminList() {
        helper(['form']);
        helper('html');
        $logged_in = false;
        
        $companyModel = model('App\Models\CompanyModel');

        $company = $companyModel->find(SITE_ID);

        $data['company_name'] = $company["name"];
        $data['logo'] = $company["logo"];
        
        if (isset($_SESSION["user_id"])) {
            $userModel = model('App\Models\CompanyUserModel');
            
            $data["admin_user"] = $userModel->select()->get()->getResult();
            
            echo view('adminHeader');
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            echo view('adminList', $data);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
    
    public function modify(){
        $data = array();
        $admin_id = $this->request->uri->getSegments()[2];
        
        if (!(isset($_SESSION["user_id"]))) {
            return redirect()->to(site_url().'Adminstration');
        }else{
            $userModel = model('App\Models\CompanyUserModel');
            $data["admin_user"] = $userModel->where("id", $admin_id)->get()->getResult();
            // $authenticatePassword = md5('password', $data["admin_user"][0]->password);
            $permission = $this->request->getVar('permission');
            $email = $this->request->getVar('email');
            $duplicateEmail = $userModel->where("id !=", $admin_id)->where("email", $email)->get()->getResult();
            if(!empty($duplicateEmail))
            {
                    $session = session();
                    $session->setFlashdata('success', 'Email already exists');
                    echo view('adminHeader');
                if (isset($_SESSION["venues"])) {
                    $data['venues'] = $_SESSION["venues"];
                }

                $db = \Config\Database::connect();
                $query = $db->table('tblcompany_permissions');
                $data['permissions'] = $query->select('*')->get()->getResult();

                echo view('adminLeftSidebar', $data);
                echo view('adminRegisteradminEdit', $data);
                echo view('adminFooter');
            }
            else
            {
            if ($this->request->getMethod() == "post") {
                if($this->request->getVar('password')!=''){
                    $data = [
                        'tblcompany_id'     => SITE_ID,
                        'type'    => 'Manager',
                        'fname'     => $this->request->getVar('first_name'),
                        'lname'    => $this->request->getVar('last_name'),
                        'email'    => $email,
                        'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                        'phone'    => $this->request->getVar('phone'),
                        'admin_type'    => $this->request->getVar('admin_type'),
                        'permission'    => json_encode($permission),
                        'age'    => $this->request->getVar('age')
                    ];
                }else{
                    $data = [
                        'tblcompany_id'     => SITE_ID,
                        'type'    => 'Manager',
                        'fname'     => $this->request->getVar('first_name'),
                        'lname'    => $this->request->getVar('last_name'),
                        'email'    => $email,
                        'phone'    => $this->request->getVar('phone'),
                        'admin_type'    => $this->request->getVar('admin_type'),
                        'permission'    => json_encode($permission),
                        'age'    => $this->request->getVar('age')
                    ];
                }
                
                // var_dump($data);
            //exit;
                $userModel->update($admin_id, $data);
                return redirect()->to(site_url().'/ManageClient/modify/'.$admin_id);
            }
            else{          
                echo view('adminHeader');
                if (isset($_SESSION["venues"])) {
                    $data['venues'] = $_SESSION["venues"];
                }

                $db = \Config\Database::connect();
                $query = $db->table('tblcompany_permissions');
                $data['permissions'] = $query->select('*')->get()->getResult();

                echo view('adminLeftSidebar', $data);
                echo view('adminRegisteradminEdit', $data);
                echo view('adminFooter');
            }
        }
        }
    }
    
    public function delete() {
        $_SESSION["EVENTS"] = array();
        $admin_id = $this->request->uri->getSegments()[2];
        
        $this->db= \Config\Database::connect();
        $builder = $this->db->table('tblcompany_users');
        $event=$builder->delete(["id"=>$admin_id]);

        return redirect()->to(site_url().'ManageClient/adminList');
    }
}

<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function index()
    {
        helper(['form']);
        $data = [];
        // return view('welcome_message');
        return view('register');
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
            'age' => ['rules' => 'required|numeric|greater_than_equal_to[18]', 'errors'=>[
                   'greater_than_equal_to'=>'Age must be greater then or equal to 18'
                ]],    
            //'age'  => 'required|numeric|greater_than_equal_to[18]',
            'gender'  => 'required',
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
                'terms'    => $this->request->getVar('terms'),
                'activation_code' => $activation_code,
                'active' => '0'
            ];

            $db = \Config\Database::connect();
            $query = $db->table('tblcompany_clients')
                    ->select('*')
                    ->where('email',$this->request->getVar('email'))
                    ->get();
            $result = $query->getResult();
        if(!empty($result))
        {
            $data['emailCheck'] = 'Email already registered';
            return view('register', $data);
        }
        else
        {
            $model->save($data);
            $id = $model->insertID();

            //email
            // Set your API key
            $api_key = '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';
            $html = "Hi! " . $this->request->getVar('first_name') . " " . $this->request->getVar('last_name') . " you are successfully registered at Chandni Halls. This is your password " . $password . " ";
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
                        "email" => $this->request->getVar('email'),
                        "name" => $this->request->getVar('first_name') . " " . $this->request->getVar('last_name')
                    )
                ),
                "subject" => "Chandni Halls Registration",
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


/*
            $message = file_get_contents(getcwd()."/email_template/register-client.html"); 
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
            $email->setSubject($company["name"].' - Signup Verification Email');
            $email->setSubject('Welcome to '.$company["name"]);
            $email->setMessage($message);

            */

            if ($response) {
                $data['validation'] = 'Activation code sent to email';
            } else {
                $data['validation'] = $email->printDebugger(['headers']);
            }
            return redirect()->to(site_url().'home/index/new');

        }
        } else {
            $data['validation'] = $this->validator;
            return view('register', $data);
        }
          
    }

    public function activate() {
		$id =  $this->request->uri->getSegments()[2];
		$code = $this->request->uri->getSegments()[3];

		//fetch Client details
        $model = model('App\Models\CompanyClientModel');
        $user = $model->find($id);

		//if code matches
		if($user['activation_code'] == $code) {
			//update user active status
			$data['active'] = 1;

            $d = [
                'active'   => 1,
                'updated_at'  => date('Y-m-d H:i:s')
            ];
            
			if($model->update(['id' => $id], $d)) {
                $data['validation'] = 'Client activated successfully';
			} else {
                $data['validation'] = 'Something went wrong in activating account';
			}
		} else {
            $data['validation'] = 'Cannot activate account. Code didnt match';
		}

        return view('activate', $data);
        return redirect()->to(site_url().'home/'.$data['validation']);
	}
	
	public function activateAdmin() {
		$id =  $this->request->uri->getSegments()[2];
		$code = $this->request->uri->getSegments()[3];

		//fetch Client details
        $model = model('App\Models\CompanyUserModel');
        $user = $model->find($id);

		//if code matches
		if($user['activation_code'] == $code) {
			//update user active status
			$data['active'] = 1;

            $d = [
                'active'   => 1,
                'updated_at'  => date('Y-m-d H:i:s')
            ];
            
			if($model->update(['id' => $id], $d)) {
                $data['validation'] = 'Activated successfully';
			} else {
                $data['validation'] = 'Something went wrong in activating account';
			}
		} else {
            $data['validation'] = 'Cannot activate account. Code didnt match';
		}
		
		$data['url']='admin';

        return view('activate', $data);
        return redirect()->to(site_url().'Administration/'.$data['validation']);
	}
}

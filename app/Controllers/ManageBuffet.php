<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class ManageBuffet extends BaseController
{
    protected $request;

    public function buffetItems() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $crud->setTable('tblcompany_menuOptions');
            $crud->displayAs("name", "Menu Option Name");
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);            
            $crud_data = array(
                "title" => "Manage Menu Options",
                "title_description" => "Create/Modify Menu Options for Buffet here"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function showPrice($value) {
        if ($value<=0) {
            $show = "-";
        } else {
            $show = "$".$value;
        }
        return $show;
    }

    public function showPercentage($value) {
        if ($value<=0) {
            $show = "-";
        } else {
            $show = $value."%";
        }
        return $show;
    }

    public function buffetPricing() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $venue_id = $this->request->uri->getSegments()[2];
            $crud->setTable('tblcompany_buffetPricing');
            $crud->where('tblcompany_venue_id', $venue_id);

            $crud->setClone();
            $crud->columns(array("tblcompany_menuOption_id", 'name','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'));
            $crud->fieldType('tblcompany_venue_id', 'invisible');

            $crud->setRelation("tblcompany_menuOption_id", "tblcompany_menuOptions", "name");
            $crud->displayAs("tblcompany_menuOption_id", "Buffet");
            $crud->unsetAdd();
            // $crud->unsetEdit();

            // $crud->setActionButton('Edit', 'fa fa-user', function ($row) {
            //     return '/manageBuffet/editBuffetPricing/'.$row ;
            // }, false);

            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_venue_id'] = $this->request->uri->getSegments()[2];
                return $stateParameters;
            });
            $crud->callbackColumn('Saturday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Sunday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Monday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Tuesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Wednesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Thursday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Friday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $companyVenueModel = model('App\Models\CompanyVenueModel');
            $data = $companyVenueModel->select('name')->getWhere(['id' => $venue_id])->getResult();

            $crud_data = array(
                "title" => "Manage Buffet Pricing for <strong>".$data[0]->name."</strong>",
                "title_description" => "Setup Buffet Weekly Pricing"
            );

            echo view('crudGridTitle', $crud_data);
            $add["add_button_name"] = "Add Buffet Pricing";
            $add["add_button_link"] = "/manageBuffet/add_pricing/".$venue_id;
            echo view('showCrudGrid', $add, (array)$output);
            $companyBuffetPricingModel = model('App\Models\CompanyBuffetPricingModel');
            $data1 = $companyBuffetPricingModel->select('tblcompany_menuOption_id')->getWhere(['tblcompany_venue_id' => $venue_id])->getResult();

            $menuOption_ids = [];
            foreach($data1 as $value) {
                $menuOption_ids[] = $value->tblcompany_menuOption_id;
            }
            $data['menuOption_ids'] = $menuOption_ids;
            echo view('adminFooter', $data);
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function add_pricing() {
        if (!(isset($_SESSION["user_id"]))) {
            return redirect()->to(site_url().'Administration');
        }
        $venue_id = $this->request->uri->getSegments()[2];
        $companyVenueModel = model('App\Models\CompanyVenueModel');
        $data = $companyVenueModel->select('name')->getWhere(['id' => $venue_id])->getResult();

        $crud_data = array(
            "title" => "Add Buffet Pricing for <strong>".$data[0]->name."</strong>",
            "title_description" => "Setup Buffet Weekly Pricing"
        );

        echo view('adminHeader');
        if (isset($_SESSION["venues"])) {
            $data['venues'] = $_SESSION["venues"];
        }
        echo view('adminLeftSidebar', $data);
        echo view('crudGridTitle', $crud_data);

        $companyBuffetPricingModel = model('App\Models\CompanyBuffetPricingModel');

        $rules = [
            'menu_option'          => 'required',
            'Saturday'          => 'required|numeric|min_length[1]|max_length[5]',
            'Sunday'          => 'required|numeric|min_length[1]|max_length[5]',
            'Monday'          => 'required|numeric|min_length[1]|max_length[5]',
            'Tuesday'          => 'required|numeric|min_length[1]|max_length[5]',
            'Wednesday'          => 'required|numeric|min_length[1]|max_length[5]',
            'Thursday'          => 'required|numeric|min_length[1]|max_length[5]',
            'Friday'          => 'required|numeric|min_length[1]|max_length[5]',
        ];

        if ($this->request->getMethod() == "post") {
            if($this->validate($rules)) {
                $data["menu_option"] = $this->request->getVar('menu_option');
                $data["Saturday"] = $this->request->getVar('Saturday');
                $data["Sunday"] = $this->request->getVar('Sunday');
                $data["Monday"] = $this->request->getVar('Monday');
                $data["Tuesday"] = $this->request->getVar('Tuesday');
                $data["Wednesday"] = $this->request->getVar('Wednesday');
                $data["Thursday"] = $this->request->getVar('Thursday');
                $data["Friday"] = $this->request->getVar('Friday');

                if ($data["menu_option"]=="-1") {
                    session()->setFlashdata('message', "Select Buffet");
                    session()->setFlashdata('alert-class', 'alert-danger');
                } else {
                    $data_insert = array(
                        "tblcompany_venue_id" => $venue_id,
                        "tblcompany_menuOption_id" => $data["menu_option"],
                        "Saturday" => $data["Saturday"],
                        "Sunday" => $data["Sunday"],
                        "Monday" => $data["Monday"],
                        "Tuesday" => $data["Tuesday"],
                        "Wednesday" => $data["Wednesday"],
                        "Thursday" => $data["Thursday"],
                        "Friday" => $data["Friday"]
                    );
                    // $this->show($data_insert, 1);
                    $companyBuffetPricingModel->insert($data_insert);

                    session()->setFlashdata('message', "Pricing Successfully added!");
                    session()->setFlashdata('alert-class', 'alert-success');
                }
                
            } else {
                session()->setFlashdata('message', $this->validator->listErrors());
                session()->setFlashdata('alert-class', 'alert-danger');
            }
        }

        $data1 = $companyBuffetPricingModel->select('tblcompany_menuOption_id')->getWhere(['tblcompany_venue_id' => $venue_id])->getResult();

        $menuOption_ids = [];
        foreach($data1 as $value) {
            $menuOption_ids[] = $value->tblcompany_menuOption_id;
        }
        // $this->show($menuOption_ids, 1);
        $data['menuOption_ids'] = $menuOption_ids;

        $menuOptionModel = model('App\Models\MenuOptionModel');
        $menuOptions = $menuOptionModel->where("tblcompany_id", SITE_ID)
                                        ->get()
                                        ->getResult();

        foreach($menuOptions as $menuOption) {
            if (!(in_array($menuOption->id, $menuOption_ids))) {
                $new_menuOptions[] = $menuOption;
            }
        }
        $data["venue_id"] = $venue_id;
        $data["menu_options"] = $new_menuOptions;

        echo view('add_pricing', $data);
        echo view('adminFooter');
    }

    public function serviceCharges() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $venue_id = $this->request->uri->getSegments()[2];
            $crud->setTable('tblcompany_serviceCharges');
            $crud->where('tblcompany_venue_id', $venue_id);

            $crud->setClone();
            $crud->setSubject("Service Charges", "Service Charges");
            $crud->columns(array('name','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'));
            $crud->fieldType('tblcompany_venue_id', 'invisible');

            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_venue_id'] = $this->request->uri->getSegments()[2];
                return $stateParameters;
            });
            $crud->callbackColumn('Saturday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Sunday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Monday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Tuesday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Wednesday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Thursday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Friday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Service Charges",
                "title_description" => "Create/Modify Service Charges %ages"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function taxes() {
        if (isset($_SESSION["user_id"])) {
            $crud = new GroceryCrud();

            $venue_id = $this->request->uri->getSegments()[2];
            $crud->setTable('tblcompany_taxes');
            $crud->where('tblcompany_venue_id', $venue_id);

            $crud->setClone();
            $crud->setSubject("Tax", "Taxes");
            $crud->columns(array('name','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'));
            $crud->fieldType('tblcompany_venue_id', 'invisible');

            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_venue_id'] = $this->request->uri->getSegments()[2];
                return $stateParameters;
            });
            $crud->callbackColumn('Saturday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Sunday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Monday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Tuesday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Wednesday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Thursday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $crud->callbackColumn('Friday', function ($value, $row) {
                return $this->showPercentage($value);
            });
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Taxes",
                "title_description" => "Create/Modify Taxes %ages"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function napkins() {
        if (isset($_SESSION["user_id"])) {

            $filepath = "";
            if($file = $this->request->getFile('file')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                   $name = $file->getName();
                   $ext = $file->getClientExtension();

                   $newName = $file->getRandomName(); 
                   $file->move('assets/uploads/napkins/', $newName);
    
                   $filepath = base_url()."/assets/uploads/napkins/".$newName;

                    // Set Session
                    session()->setFlashdata('message', 'Uploaded Successfully!');
                    session()->setFlashdata('alert-class', 'alert-success');
                    session()->setFlashdata('filepath', $filepath);
                    session()->setFlashdata('extension', $ext);
                }else{
                   // Set Session
                   session()->setFlashdata('message', 'File not uploaded.');
                   session()->setFlashdata('alert-class', 'alert-danger');
                }
            }

            $crud = new GroceryCrud();

            $venue_id = $this->request->uri->getSegments()[2];
            $crud->setTable('tblcompany_napkins');
            $crud->where('tblcompany_venue_id', $venue_id);

            $crud->setClone();
            $crud->setSubject("Napkin", "Napkins");
            $crud->columns(array('name','image', 'Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'));
            $crud->fieldType('tblcompany_venue_id', 'invisible');
            $crud->displayAs("image", "Napkins");

            $crud->callbackColumn('image', function ($value, $row) {
                if ($value!="") {
                    $img = $value;
                    $alt = "alt='".$row->name."'";
                } else {
                    $img = base_url()."/assets/images/"."no.image.jpeg";
                    $alt = "alt='NO IMAGE'";
                }

                return "<picture>
                            <img src='".$img."' ".$alt." class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=100 />
                        </picture>";
            });

            $crud->callbackAddField('image', function ($fieldType, $fieldName) {
                $img = "<picture>
                            <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                        </picture>";   
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });            
            
            $crud->callbackEditField('image', function ($fieldValue, $primaryKeyValue, $rowData) {
                if ($fieldValue!="") {
                    $img = "<picture>
                                <img id='output' src='".$fieldValue."' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";
                }  else {
                    $img = "<picture>
                                <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";                
                }
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });

            $companyVenueNapkinsModel = model('App\Models\CompanyVenueNapkinsModel');
            $crud->callbackAfterInsert(function ($stateParameters) use ($filepath, $companyVenueNapkinsModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueNapkinsModel->update(['id' => $stateParameters->insertId], $data); 
                return $stateParameters;
            });

            $crud->callbackAfterUpdate(function ($stateParameters) use ($filepath, $companyVenueNapkinsModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueNapkinsModel->update(['id' => $stateParameters->primaryKeyValue], $data); 
                return $stateParameters;
            });

            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_venue_id'] = $this->request->uri->getSegments()[2];
                return $stateParameters;
            });
            $crud->callbackColumn('Saturday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Sunday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Monday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Tuesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Wednesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Thursday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Friday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Napkins",
                "title_description" => "Create/Modify Napkin Prices"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
    
    public function napkinStyle() {
        if (isset($_SESSION["user_id"])) {

            $filepath = "";
            if($file = $this->request->getFile('file')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                   $name = $file->getName();
                   $ext = $file->getClientExtension();

                   $newName = $file->getRandomName(); 
                   $file->move('assets/uploads/napkins/', $newName);
    
                   $filepath = base_url()."/assets/uploads/napkins/".$newName;

                    // Set Session
                    session()->setFlashdata('message', 'Uploaded Successfully!');
                    session()->setFlashdata('alert-class', 'alert-success');
                    session()->setFlashdata('filepath', $filepath);
                    session()->setFlashdata('extension', $ext);
                }else{
                   // Set Session
                   session()->setFlashdata('message', 'File not uploaded.');
                   session()->setFlashdata('alert-class', 'alert-danger');
                }
            }

            $crud = new GroceryCrud();

            $venue_id = $this->request->uri->getSegments()[2];
            $crud->setTable('tblcompany_napkin_style');
            $crud->where('tblcompany_venue_id', $venue_id);

            $crud->setClone();
            $crud->setSubject("Napkin Style", "Napkin Style");
            $crud->columns(array('name','image', 'Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'));
            $crud->fieldType('tblcompany_venue_id', 'invisible');
            $crud->displayAs("image", "Napkin Style");

            $crud->callbackColumn('image', function ($value, $row) {
                if ($value!="") {
                    $img = $value;
                    $alt = "alt='".$row->name."'";
                } else {
                    $img = base_url()."/assets/images/"."no.image.jpeg";
                    $alt = "alt='NO IMAGE'";
                }

                return "<picture>
                            <img src='".$img."' ".$alt." class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=100 />
                        </picture>";
            });

            $crud->callbackAddField('image', function ($fieldType, $fieldName) {
                $img = "<picture>
                            <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                        </picture>";   
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });            
            
            $crud->callbackEditField('image', function ($fieldValue, $primaryKeyValue, $rowData) {
                if ($fieldValue!="") {
                    $img = "<picture>
                                <img id='output' src='".$fieldValue."' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";
                }  else {
                    $img = "<picture>
                                <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";                
                }
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });

            $companyVenueNapkinsModel = model('App\Models\CompanyVenueNapkinStyleModel');
            $crud->callbackAfterInsert(function ($stateParameters) use ($filepath, $companyVenueNapkinsModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueNapkinsModel->update(['id' => $stateParameters->insertId], $data); 
                return $stateParameters;
            });

            $crud->callbackAfterUpdate(function ($stateParameters) use ($filepath, $companyVenueNapkinsModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueNapkinsModel->update(['id' => $stateParameters->primaryKeyValue], $data); 
                return $stateParameters;
            });

            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_venue_id'] = $this->request->uri->getSegments()[2];
                return $stateParameters;
            });
            $crud->callbackColumn('Saturday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Sunday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Monday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Tuesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Wednesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Thursday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Friday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Napkin Style",
                "title_description" => "Create/Modify Napkin Style"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function flowers() {
        if (isset($_SESSION["user_id"])) {
            $filepath = "";
            if($file = $this->request->getFile('file')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                   $name = $file->getName();
                   $ext = $file->getClientExtension();

                   $newName = $file->getRandomName(); 
                   $file->move('assets/uploads/flowers/', $newName);
    
                   $filepath = base_url()."/assets/uploads/flowers/".$newName;

                    // Set Session
                    session()->setFlashdata('message', 'Uploaded Successfully!');
                    session()->setFlashdata('alert-class', 'alert-success');
                    session()->setFlashdata('filepath', $filepath);
                    session()->setFlashdata('extension', $ext);
                }else{
                   // Set Session
                   session()->setFlashdata('message', 'File not uploaded.');
                   session()->setFlashdata('alert-class', 'alert-danger');
                }
            }

            $crud = new GroceryCrud();

            $venue_id = $this->request->uri->getSegments()[2];
            $crud->setTable('tblcompany_flowers');
            $crud->where('tblcompany_venue_id', $venue_id);

            $crud->setClone();
            $crud->setSubject("flower", "flowers");
            $crud->columns(array('name','image', 'Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'));
            $crud->fieldType('tblcompany_venue_id', 'invisible');
            $crud->displayAs("image", "flowers");

            $crud->callbackColumn('image', function ($value, $row) {
                if ($value!="") {
                    $img = $value;
                    $alt = "alt='".$row->name."'";
                } else {
                    $img = base_url()."/assets/images/"."no.image.jpeg";
                    $alt = "alt='NO IMAGE'";
                }

                return "<picture>
                            <img src='".$img."' ".$alt." class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=100 />
                        </picture>";
            });

            $crud->callbackAddField('image', function ($fieldType, $fieldName) {
                $img = "<picture>
                            <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                        </picture>";   
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });            
            
            $crud->callbackEditField('image', function ($fieldValue, $primaryKeyValue, $rowData) {
                if ($fieldValue!="") {
                    $img = "<picture>
                                <img id='output' src='".$fieldValue."' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";
                }  else {
                    $img = "<picture>
                                <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";                
                }
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });

            $companyVenueFlowersModel = model('App\Models\CompanyVenueFlowersModel');
            $crud->callbackAfterInsert(function ($stateParameters) use ($filepath, $companyVenueFlowersModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueFlowersModel->update(['id' => $stateParameters->insertId], $data); 
                return $stateParameters;
            });

            $crud->callbackAfterUpdate(function ($stateParameters) use ($filepath, $companyVenueFlowersModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueFlowersModel->update(['id' => $stateParameters->primaryKeyValue], $data); 
                return $stateParameters;
            });

            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_venue_id'] = $this->request->uri->getSegments()[2];
                return $stateParameters;
            });
            $crud->callbackColumn('Saturday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Sunday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Monday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Tuesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Wednesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Thursday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Friday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Flowers",
                "title_description" => "Create/Modify Flower Prices"
            );
            echo view('crudGridTitle', $crud_data);
            echo view('showCrudGrid', (array)$output);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }

    public function table_cloth() {
        if (isset($_SESSION["user_id"])) {
            $filepath = "";
            if($file = $this->request->getFile('file')) {
                if ($file->isValid() && ! $file->hasMoved()) {
                   $name = $file->getName();
                   $ext = $file->getClientExtension();

                   $newName = $file->getRandomName(); 
                   $file->move('assets/uploads/table_cloth/', $newName);
    
                   $filepath = base_url()."/assets/uploads/table_cloth/".$newName;

                    // Set Session
                    session()->setFlashdata('message', 'Uploaded Successfully!');
                    session()->setFlashdata('alert-class', 'alert-success');
                    session()->setFlashdata('filepath', $filepath);
                    session()->setFlashdata('extension', $ext);
                }else{
                   // Set Session
                   session()->setFlashdata('message', 'File not uploaded.');
                   session()->setFlashdata('alert-class', 'alert-danger');
                }
            }

            $crud = new GroceryCrud();

            $venue_id = $this->request->uri->getSegments()[2];
            $crud->setTable('tblcompany_table_cloth');
            $crud->where('tblcompany_venue_id', $venue_id);

            $crud->setClone();
            $crud->setSubject("Table Cloth", "Table CLoths");
            $crud->columns(array('name','image', 'Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'));
            $crud->fieldType('tblcompany_venue_id', 'invisible');
            $crud->displayAs("image", "Table CLoth");

            $crud->callbackColumn('image', function ($value, $row) {
                if ($value!="") {
                    $img = $value;
                    $alt = "alt='".$row->name."'";
                } else {
                    $img = base_url()."/assets/images/"."no.image.jpeg";
                    $alt = "alt='NO IMAGE'";
                }

                return "<picture>
                            <img src='".$img."' ".$alt." class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=100 />
                        </picture>";
            });

            $crud->callbackAddField('image', function ($fieldType, $fieldName) {
                $img = "<picture>
                            <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                        </picture>";   
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });            
            
            $crud->callbackEditField('image', function ($fieldValue, $primaryKeyValue, $rowData) {
                if ($fieldValue!="") {
                    $img = "<picture>
                                <img id='output' src='".$fieldValue."' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";
                }  else {
                    $img = "<picture>
                                <img id='output' class='img-fluid img-thumbnail rounded float-left mx-auto d-block' width=150 />
                            </picture>";                
                }
                return '<div>'.$img.'</div><div><input class="form-control" name="file" type="file" accept="image/*" onchange="loadFile(event)" /></div>';
            });

            $companyVenueTableClothModel = model('App\Models\CompanyVenueTableClothModel');
            $crud->callbackAfterInsert(function ($stateParameters) use ($filepath, $companyVenueTableClothModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueTableClothModel->update(['id' => $stateParameters->insertId], $data); 
                return $stateParameters;
            });

            $crud->callbackAfterUpdate(function ($stateParameters) use ($filepath, $companyVenueTableClothModel) {
                $data = [
                    'image' => $filepath
                ];
                $companyVenueTableClothModel->update(['id' => $stateParameters->primaryKeyValue], $data); 
                return $stateParameters;
            });

            $crud->callbackBeforeInsert(function ($stateParameters) {
                $stateParameters->data['tblcompany_venue_id'] = $this->request->uri->getSegments()[2];
                return $stateParameters;
            });
            $crud->callbackColumn('Saturday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Sunday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Monday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Tuesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Wednesday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Thursday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $crud->callbackColumn('Friday', function ($value, $row) {
                return $this->showPrice($value);
            });
            $output = $crud->render();

            echo view('adminHeader', (array)$output);
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            $crud_data = array(
                "title" => "Manage Table Cloths",
                "title_description" => "Create/Modify Table CLoth Prices"
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
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
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

<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyUserModel extends Model
{
    protected $table      = 'tblcompany_users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tblcompany_id', 'fname',  'lname', 'type', 'phone',  'email', 'password', 'status' ,'admin_type' , 'permission' ,'activation_code','age','active'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function __construct()
    {
        parent::__construct();
    }
}
?>
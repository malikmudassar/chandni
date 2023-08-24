<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyClientModel extends Model
{
    protected $table      = 'tblcompany_clients';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['company_id', 'first_name', 'last_name', 'email', 'phone', 'age', 'gender', 'tblcompany_venues_id' ,'terms', 'password', 'activation_code', 'active', 'notes', 'updated_at', 'last_login'];

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
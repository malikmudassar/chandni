<?php

namespace App\Models;

use CodeIgniter\Model;

class UserActivityModel extends Model
{
    protected $table      = 'tbluser_activity';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tblcompany_id', 'tblcompany_user_id', 'ip_address', 'page', 'controller', 'method', 'created_at'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function __construct()
    {
        parent::__construct();
    }

    function insertActivity($data) {
        $this->db->insert('tbluser_activity',$data);
        return true;
	}
}
?>
<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyVenueModel extends Model
{
    protected $table      = 'tblcompany_venues';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tblcompany_id', 'name',  'address', 'phone', 'website',  'no_of_halls', 'status'];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function __construct()
    {
        parent::__construct();
    }
}
?>
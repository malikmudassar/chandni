<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyVenueFlowersModel extends Model
{
    protected $table      = 'tblcompany_flowers';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tblcompany_venue_id', 'name',  'image', 'Saturday', 'Sunday',  'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

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
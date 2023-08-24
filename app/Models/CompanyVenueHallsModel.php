<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyVenueHallsModel extends Model
{
    protected $table      = 'tblcompany_venue_halls';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tblcompany_venue_id', 'name',  'persons_capacity_min', 'persons_capacity_max', 'no_of_tables',  'floor_plan'];

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
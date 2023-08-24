<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyBuffetPricingModel extends Model
{
    protected $table      = 'tblcompany_buffetPricing';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tblcompany_venue_id', 
        'tblcompany_menuOption_id',
        "Saturday",
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday"
    ];

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
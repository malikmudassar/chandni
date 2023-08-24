<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function getCompanyInfo()
    {
        echo SITE_ID; exit;
        
    }
}
?>
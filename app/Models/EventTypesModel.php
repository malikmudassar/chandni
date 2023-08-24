<?php

namespace App\Models;

use CodeIgniter\Model;

class EventTypesModel extends Model
{
    protected $table      = 'tblcompany_event_types';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tblcompany_id',
        'event_type',
        'description'
    ];
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

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
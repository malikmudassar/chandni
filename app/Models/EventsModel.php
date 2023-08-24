<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table      = 'tblcompany_events';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tblcompany_id',
        'tblcompany_client_id',
        
        'event_datetime',
        'event_time',
        'payment_mode',
        'no_of_guests',
        'coat_check',
        'valid_licensed_bar',
        'own_license_file',
        'no_of_bartenders',
        'need_a_hall_rental',
        'need_security_gaurds',
        'how_many_security_gaurds',
        'created_at',
        'tblcompany_venue_id',
        'tblcompany_event_type_id',
        'tblcompany_menuOption_id',
        'menu_item_selection',
        'floor_plan_id',
        'napkin_id',
        'tableCloth_id',
        'flower_id',
        'sound_option_id',
        'dj_option',
        'stage_decore_option',
        'lighting_option',
        'groom_title',
        'groom_fname',
        'bride_title',
        'bride_fname',
        'groom_lname',
        'bride_lname',
        'groom_phone',
        'bride_phone',
        'groom_address',
        'bride_address',
        'groom_driver_license_file',
        'bride_driver_license_file',
        'tblcompany_barOption_id',
        'calendar_event_id',
        'status',
        'user_type',
        'user_id',
        'discount',
        'event_total_amount',
        'menue_timer'
    ];
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    function __construct()
    {
        parent::__construct();
    }
    
    public function delete_new($id){
        $this->db= \Config\Database::connect();
        $builder = $this->db->table('tblcompany_events');
        $event=$builder->delete(["id"=>$id]);
    
        
    }
}
?>
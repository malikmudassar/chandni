<?php
class AdminModel extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function getCompanyInfo()
    {
        echo SITE_ID; exit;
        $this->db->select('*');
        $this->db->select("DATE_FORMAT( date, '%d.%m.%Y' ) as date_human",  FALSE );
        $this->db->select("DATE_FORMAT( date, '%H:%i') as time_human",      FALSE );
    
    
        $this->db->from('news');
    
        $this->db->where('id', $news_id );
    
    
        $query = $this->db->get();
    
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }
}
?>
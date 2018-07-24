<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Postupload_model extends CS_Model
{
	public function __construct()
	{
        $this->table = 'cryp_postupload_data';
        $this->primary_key = 'id';
        $this->soft_deletes = false;       
		parent::__construct();
	}    

    public function InsertMedia( $UserID , $PostID , $FilePath , $Type )
    {
        $insert_data = array(
            array(
                'user_id'      => $UserID,                
                'post_id'      => $PostID,                
                'file_path'    => $FilePath,                
                'type'         => $Type,                
                'created_on'   =>  $this->_the_timestamp(),
                'modified_on'  =>  $this->_the_timestamp()
            )
        );
        //$this->_pre( $insert_data );  
        $this->db->insert_batch($this->table, $insert_data);
        return $this->db->insert_id();
    } 
    
	public function getUserUploads()
	{
		
	}
}


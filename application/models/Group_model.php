<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Group_model extends CS_Model
{
	public function __construct()
	{
        $this->table = 'cryp_group_data';
        $this->primary_key = 'group_id';       
		parent::__construct();       
	}    

    public function GroupInsert( $Data )
    {
        $insert_data = array(
            array(
                'name_group'        => $Data['group_name'],                
                'desc_group'        => $Data['group_desc'],                
                'privacy_group'     => $Data['group_privacy'],
                'pic_group'         => $Data['group_pic'],
                //'banner_group'      => $Data['group_banner'],
                'created_by'        => $this->session->User_ID,                
                'created_on'        => $this->_the_timestamp(), 
                'modified_on'       => $this->_the_timestamp() 
            )
        );
        $this->db->insert_batch($this->table, $insert_data);
        return  $this->db->insert_id() ;
    }

    public function UpdatePostUser( $Data )
    {
        $UpdateData = array(
                'post_content'    => $Data['profile_img'],                
                'modified_on'     => $this->_the_timestamp() 
            );

        return $this->update( $UpdateData , array( 'post_id' => base64_decode($Data['reference_ID'])));
    }
	
}


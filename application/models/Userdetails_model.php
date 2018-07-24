<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Userdetails_model extends CS_Model
{
	public function __construct()
	{
		$this->table = 'cryp_user_details';
        $this->primary_key = 'user_ID';
        $this->soft_deletes = false;
        parent::__construct();
        //$this->has_one['details'] = 'User_details_model';
        // $this->has_one['details'] = array('User_details_model','user_id','id');
       // $this->has_one['details'] = array('local_key'=>'id', 'foreign_key'=>'user_id', 'foreign_model'=>'User_details_model');
        //$this->has_many['posts'] = 'Post_model';
	}    

    public function InsertUserDetailsCrypUser( $Data )
    {       
        $insert_data = array( array(
                'user_ID'        => $this->encryption->decrypt($Data['reference_ID']),                
                'Profile_pic'    => $Data['profile_img'],                
                'photo_url'      => $Data['photo_url'],                
                'city'           => $Data['City'],                
                'country'        => $Data['Country'],                
                'about_me'       => $Data['about_us'],
                'created_on'     => $this->_the_timestamp() 
            ));
        $this->db->insert_batch($this->table, $insert_data);
        return  $this->encryption->encrypt($this->db->insert_id()) ;
    }

    public function is_login()
    {
        return $this->session->is_login;
    }

    public function get_userId()
    {
        return $this->session->User_ID;
    }

     public function get_userType()
    {
        return $this->session->User_type;
    }


	
}


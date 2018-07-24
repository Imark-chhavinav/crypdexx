<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CS_Model
{
	public function __construct()
	{
		$this->table = 'cryp_user';
        $this->primary_key = 'user_ID';
        $this->soft_deletes = false;
        parent::__construct();
        $this->has_one['details'] = 'Userdetails_model';
        // $this->has_one['details'] = array('User_details_model','user_id','id');
       // $this->has_one['details'] = array('local_key'=>'id', 'foreign_key'=>'user_id', 'foreign_model'=>'User_details_model');
        //$this->has_many['posts'] = 'Post_model';
	}
    
    public function InsertCrypUser( $Data )
    {
        $insert_data = array(
            array(
                'firstname'     => $Data['firstname'],                
                'surname'       => $Data['surname'],                
                'phone_number'  => $Data['phone_number'],                
                'email'         => $Data['email'],                
                'business_name' => $Data['business_name'],                
                'password'      => md5($Data['password']),
                'user_role'     => $Data['user_type'], // 1:Customer , 2:Business , 3:Crypto user               
                'reg_type'      => $Data['reg_type'],                
                'verified'      => $Data['verified'],                
                'verify_code'   => $Data['verify_code'],                
                'country_code'   => (isset($Data['country_code']))? $Data['country_code']: NULL,                
                'created_on'    => $this->_the_timestamp() 
            )
        );
        $this->db->insert_batch($this->table, $insert_data);
        return  $this->encryption->encrypt($this->db->insert_id()) ;
    }

    public function UpdateCrypUser( $Data )
    {
        //$this->_pre( $Data );
        $UpdateData = array(
                'Profile_pic'    => $Data['profile_img'],                
                'photo_url'      => $Data['photo_url'],                
                'city'           => $Data['City'],                
                'country'        => $Data['Country'],                
                'about_me'       => $Data['about_us'],
                'created_on'     => $this->_the_timestamp() 
            );

        return $this->update( $UpdateData , array( 'user_ID' =>$this->encryption->decrypt( $Data['reference_ID'])));
    }

    public function CheckSignIn( $Data )
    {        
        return $this->where( $Data )->with_details()->as_array()->get();
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


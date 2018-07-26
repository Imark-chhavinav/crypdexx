<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CS_Model
{
	public function __construct()
    {
        $this->table = 'cryp_user';
        $this->primary_key = 'user_ID';
    }

    public function login( $Data )
    {
        $this->_pre( $Data );  
    }   
	
}


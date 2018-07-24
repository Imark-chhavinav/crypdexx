<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Postmeta_model extends CS_Model
{
	public function __construct()
	{
        $this->table = 'cryp_post_meta';
        $this->primary_key = 'postmeta_Id';
	}    

    public function InsertPostMetaData( $Data )
    {
        $insert_data = array(
            array(
                'user_id'            => $Data['user_id'],                
                'post_Id'            => $Data['post_Id'],                
                'icon_id'            => $Data['icon_id'],
                'created_on'         => $this->_the_timestamp(), 
                'modified_on'        => $this->_the_timestamp() 
            )
        );
        $this->db->insert_batch($this->table, $insert_data);
        return  $this->db->insert_id() ;
    }

    public function UpdatePostMetaData( $Data )
    {
        $UpdateData = array(
                'meta_like'      => $Data['meta_like'],                
                'modified_on'    => $this->_the_timestamp() 
            );

        return $this->update( $UpdateData , array( 'meta_id' => base64_decode($Data['reference_ID'])));
    }
	
}


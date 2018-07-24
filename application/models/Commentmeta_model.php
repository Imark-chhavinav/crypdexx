<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Commentmeta_model extends CS_Model
{
	public function __construct()
	{
        $this->table = 'cryp_comment_meta';
        $this->primary_key = 'meta_id';
	}    

    public function InsertPostCommentMeta( $Data )
    {
        $insert_data = array(
            array(
                'comment_id'         => $Data['comment_id'],                
                'user_id'            => $Data['user_id'],                
                'meta_like'          => $Data['meta_like'],
                'created_on'         => $this->_the_timestamp(), 
                'modified_on'        => $this->_the_timestamp() 
            )
        );
        $this->db->insert_batch($this->table, $insert_data);
        return  $this->db->insert_id() ;
    }

    public function UpdatePostCommentMeta( $Data )
    {
        $UpdateData = array(
                'meta_like'      => $Data['meta_like'],                
                'modified_on'    => $this->_the_timestamp() 
            );

        return $this->update( $UpdateData , array( 'meta_id' => base64_decode($Data['reference_ID'])));
    }

	
}


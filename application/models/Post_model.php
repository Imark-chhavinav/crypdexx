<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Post_model extends CS_Model
{
	public function __construct()
	{
        $this->table = 'cryp_post_details';
        $this->primary_key = 'post_id';
        $this->has_many['comment'] = array('foreign_model'=>'Comment_model','foreign_table'=>'cryp_comment_details','foreign_key'=>'post_id','local_key'=>'post_id' );       
        $this->has_many['media'] = array('foreign_model'=>'Postupload_model','foreign_table'=>'cryp_postupload_data','foreign_key'=>'post_id','local_key'=>'post_id');
		parent::__construct();
	}    

    public function InsertPostUser( $Data )
    {
        $insert_data = array(
            array(
                'user_id'       => $Data['user_id'],                
                'post_content'  => $Data['post_content'],                
                'post_type'     => $Data['post_type'],
                'is_created'    => $this->_the_timestamp(), 
                'modified_on'   => $this->_the_timestamp() 
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


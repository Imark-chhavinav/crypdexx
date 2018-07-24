<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Comment_model extends CS_Model
{
	public function __construct()
	{
        $this->table = 'cryp_comment_details';
        $this->primary_key = 'comment_id';
        $this->has_many['comment_meta'] = array('foreign_model'=>'Commentmeta_model','foreign_table'=>'cryp_comment_meta','foreign_key'=>'comment_id','local_key'=>'comment_id');        
        parent::__construct();
        $this->load->model('Commentmeta_model');
        $this->load->model('User_model');
	}    

    public function InsertPostComment( $Data )
    {
        $insert_data = array(
            array(
                'post_id'            => $Data['user_id'],                
                'comment_userId'     => $Data['post_content'],                
                'comment_content'    => $Data['post_type'],
                'comment_parent'     => $Data['post_type'], 
                'comment_createdOn'  => $this->_the_timestamp(), 
                'comment_modifiedOn' => $this->_the_timestamp() 
            )
        );
        $this->db->insert_batch($this->table, $insert_data);
        return  $this->db->insert_id() ;
    }

    public function UpdatePostComment( $Data )
    {
        $UpdateData = array(
                'comment_content'       => $Data['comment_content'],                
                'comment_modifiedOn'    => $this->_the_timestamp() 
            );

        return $this->update( $UpdateData , array( 'comment_id' => base64_decode($Data['reference_ID'])));
    }

    public function GetPostComments( $PostID )
    {
        $Results = $this->where(array('post_id' => $PostID , 'comment_parent' => 0) )->as_array()->get_all();

        $Comments = array();
        if( !empty($Results) ):
            foreach( $Results as $keys ):
                $comment_reply = $this->getCommentsReply( $keys['comment_id']);
                $LikeCount = $this->db->get_where('cryp_comment_meta', array( 'comment_id' => $keys['comment_id'] , 'meta_like' => 1 )); 
                $IsUser_Like = $this->db->get_where('cryp_comment_meta', array( 'comment_id' => $keys['comment_id'] , 'meta_like' => 1 , 'user_id' => $this->session->User_ID )); 
                $UserData = $this->user_model->getUserDetails($keys['comment_userId']);
                    $Comments[] = array(
                    'comment_id'        => (int)$keys['comment_id'],
                    'post_id'           => (int)$keys['post_id'],
                    'comment_userId'    => (int)$keys['comment_userId'],
                    'comment_userData'  => (empty($UserData))?array():$UserData,
                    'comment_content'   => $keys['comment_content'],
                    'comment_createdOn' => $keys['comment_createdOn'],
                    'like_count'        => $LikeCount->num_rows(),
                    'IsUser_Like'       => $IsUser_Like->num_rows(),
                    'comment_reply'     => $comment_reply
                    );                   
            endforeach;
        endif;
        return $Comments;
    }

    private function getCommentsReply( $CommentID )
    {        
        $Results = $this->where( 'comment_parent' , $CommentID )->as_array()->get_all();
        $Comments = array();
        if( !empty( $Results ) ):
            foreach( $Results as $keys ):
            $comment_reply = $this->getCommentsReply( $keys['comment_id']);
            $LikeCount = $this->db->get_where('cryp_comment_meta', array( 'comment_id' => $keys['comment_id'] , 'meta_like' => 1 ));
            $IsUser_Like = $this->db->get_where('cryp_comment_meta', array( 'comment_id' => $keys['comment_id'] , 'meta_like' => 1 , 'user_id' => $this->session->User_ID ));  

             $UserData = $this->user_model->getUserDetails($keys['comment_userId']);

                 $Comments[] = array( 
                        'comment_id'         => (int)$keys['comment_id'],
                        'post_id'            => (int)$keys['post_id'],
                        'comment_userId'     => (int)$keys['comment_userId'],
                        'comment_userData'   => (empty($UserData))?array():$UserData,
                        'comment_content'    => $keys['comment_content'],
                        'comment_createdOn'  => $keys['comment_createdOn'],
                        'like_count'         => $LikeCount->num_rows(),
                        'IsUser_Like'        => $IsUser_Like->num_rows(),
                        'comment_reply'      => $comment_reply
                 );                           
            endforeach;       
        endif;
        return  $Comments;
    }
	
}


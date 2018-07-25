<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CS_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	private $FolderPath = '';

	public function __construct()
	{		 
		parent::__construct();
		/* Loading Necessary Library */
		$this->load->library('validator');

		/* Load Modals */
		$this->load->model('user_model');		
		$this->load->model('Group_model');		
		

		$this->encryption->initialize(array('driver' => 'openssl'));
		
		$this->FolderPath = './uploads/group/'.$this->user_model->get_userId();
		
		if(!is_dir($this->FolderPath)){
		    mkdir($this->FolderPath, 0777);
		}

		$config['upload_path'] = $this->FolderPath;
		$config['allowed_types'] = '*';
		$config['max_size']     = 0;
		$this->load->library('upload', $config);

		if( empty($this->user_model->is_login()) )
		{
			redirect('/', 'refresh');
		}
	}

	public function index()
	{
		echo $this->user_model->is_login();	
		echo "Chhavi";	
		/*
			group_name
			group_desc
			group_privacy
			group_pic
			group_banner
			group_createdBy
		*/	
	}

	public function new_group()
	{
		$this->load->view('profile/profile-header');
		$this->load->view('profile/left-sidebar');
		$this->load->view('profile/group-index');
		$this->load->view('profile/profile-footer');
	}

	public function InsertGroup()
	{
		$Data = $this->input->post();
		$Data['group_pic'] = $this->UploadImg();

		/* Validate Data */
		$this->ValidInsertGroup($Data);

		if( !empty( $Data ) )
		{
			$Data['group_pic'] = $this->UploadImg();
			/* Insert Post */
			$InsertID = $this->Group_model->GroupInsert( $Data );
			$ReturnId = $this->encryption->encrypt( $InsertID );
			$this->_resp( 1 , $ReturnId );
		}
	}

	private function ValidInsertGroup( $Data )
	{
		$ArrayRules = array();	

		$ArrayRules = array(			
			'group_name'   	 	=> 'required',			
			'group_desc'    	=> 'required',			
			'group_privacy' 	=> 'required',			
			'group_pic' 		=> 'required'			
			//'group_banner'  	=> 'required'
		);

		$this->validator->validation_rules( $ArrayRules );	//	Validating

		$validated_data = $this->validator->run($Data);

		if($validated_data === false) 
		{			
			$Error = $this->validator->get_errors_array();				
			$this->_resp( 0, "" , reset($Error));
		} 
		else 
		{
			return true;
		}
	}

	

	protected function UploadImg()
	{
		
		if ( ! $this->upload->do_upload( 'file' ))
            {
            	$this->output->set_header("HTTP/1.0 400 Bad Request");  
            	$this->_resp( 0, "" , $this->upload->display_errors()); 
            }
            else
            {
                    $data = $this->upload->data();                   
                    return json_encode($data);                    
            }
	}

	public function getPosts( $PostID = NULL )
	{
		$total_posts = $this->post_model->count_rows();
		$posts = $this->post_model->as_array()->paginate(2,$total_posts);
		$Data = array();			
		if(!empty($posts)):
			foreach( $posts as $keys ):
				$Data[] = $this->getPost( $keys['post_id'] );
			endforeach;
		endif;
		//return $Data;
		$this->_pre( $Data );
	}

	public function getUserPosts( $PostID = NULL )
	{
		$total_posts = $this->post_model->count_rows();
		$posts = $this->post_model->where( 'user_id' , $this->session->User_ID )->order_by( 'is_created', 'DESC' )->as_array()->paginate(2,$total_posts);
		$Data = array();			
		if(!empty($posts)):
			foreach( $posts as $keys ):
				$Data[] = $this->getPost( $keys['post_id'] );
			endforeach;
		endif;
		//return $Data;
		$this->_pre( $Data );
	}

	public function getPost( $PostID = NULL )
	{
		$post = $this->post_model->with_media()->as_array()->get($PostID);		
		if( !empty( $post ) )
		{	
			//$this->_pre( $post );			
			$Media = array();		
			if( isset( $post['media'] ) && !empty( $post['media'] ) ):
				$Media = $this->ArrangeMedia( $post['media'] );
			endif;
			 $UserData = $this->user_model->getUserDetails($post['user_id']);

			$Data = array(
				'post_ID' 			=> (int) $post['post_id'],
				'post_content' 		=> $post['post_content'],
				'post_type' 		=> $post['post_type'],
				'created_on' 		=> $post['is_created'],
				'user_id' 			=> (int) $post['user_id'],
				'user_data' 		=> (empty($UserData))? array():$UserData,
				'media' 			=> $Media,
				'comments' 			=> $this->Comment_model->GetPostComments( $PostID )
			);
			
			return $Data;
		}
	
	}

	
	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CS_Controller {

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
		header('Access-Control-Allow-Origin: *');
   		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");   
		parent::__construct();
		/* Loading Necessary Library */
		$this->load->library('validator');
		$this->load->library('sms');


		$this->load->model('user_model');		
		$this->load->model('post_model');		
		$this->load->model('Postupload_model');		
		$this->load->model('postmeta_model');
		$this->load->model('Comment_model');

		$this->encryption->initialize(array('driver' => 'openssl'));
		
		$this->FolderPath = './uploads/post/'.$this->user_model->get_userId();
		
		if(!is_dir($this->FolderPath)){
		    mkdir($this->FolderPath, 0777);
		}

		$config['upload_path'] = $this->FolderPath;
		$config['allowed_types'] = '*';
		$config['max_size']     = 0;
		$this->load->library('upload', $config);
	}

	public function index()
	{
		echo  "POST HOME";		
	}

	public function InsertPost()
	{
		$Data = $this->input->post();
		/* Validate Data */
		$this->ValidInsertPost($Data);

		if( !empty( $Data ) )
		{
			$Data['user_id'] = $this->user_model->get_userId();

			/* Insert Post */
			$InsertID = $this->post_model->InsertPostUser( $Data );
			$ReturnId = $this->encryption->encrypt( $InsertID );
			$this->_resp( 1 , $ReturnId );
		}
	}

	public function InsertMedia()
	{
		/* Insert Post Media */		
		$FileResults = $this->UploadImg();
		$InsertID	 = $this->encryption->decrypt($this->input->post( 'refrence_ID' ));
		$this->Postupload_model->InsertMedia( $this->user_model->get_userId() , $InsertID , $this->FolderPath.'/'.$FileResults['file_name'] , $FileResults['file_type'] );
	}

	private function ValidInsertPost( $Data )
	{
		$ArrayRules = array();	

		$ArrayRules = array(			
			'post_content'    		=> 'required',			
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
  //echo "Error uploading file";
            	$this->_resp( 0, "" , $this->upload->display_errors()); 
            }
            else
            {
                    $data = $this->upload->data();                   
                    return $data;                    
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
			$Data = array(
				'post_ID' 			=> (int) $post['post_id'],
				'post_content' 		=> $post['post_content'],
				'post_type' 		=> $post['post_type'],
				'created_on' 		=> $post['is_created'],
				'user_id' 			=> (int) $post['user_id'],
				'media' 			=> $Media,
				'comments' 			=> $this->Comment_model->GetPostComments( $PostID )
			);
			
			return $Data;
		}
	
	}

	private function ArrangeMedia( $MediaData )
	{		
		$Media = array();
		foreach( $MediaData as $keys ):				
			$FilePath = str_replace("./uploads",base_url().'uploads',$keys->file_path);
			$Media[] = array( 
				'file_path' 	=> $FilePath,
				'type' 			=> $keys->type,
				'created_on' 	=> $keys->created_on

			);
		endforeach;
		return $Media;
	}
	
}

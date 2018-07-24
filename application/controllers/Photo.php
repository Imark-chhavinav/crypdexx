<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photo extends CS_Controller {

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
		$total_posts = $this->Postupload_model->where( 'user_id' , 2 )->count_rows(); // retrieve the total number of posts
		$posts = $this->Postupload_model->as_array()->paginate(3,$total_posts);
		$this->_pre( $posts );
	}

	
	
}

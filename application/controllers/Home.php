<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Home extends CS_Controller {



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



	public function __construct()

	{

		parent::__construct();		

		$this->load->model('user_model');

		$this->load->model('Postupload_model');

		$this->load->helper('url');

		$this->load->library('sms'); 		

	}



	

	public function index()

	{

		if( $this->user_model->is_login() )

		{

			$this->profile();

		}

		else

		{

			$this->HomePage();

		}

	}



	public function signup()

	{

		if( $this->user_model->is_login() )

		{

			redirect('/', 'refresh');

		}

		else

		{

			$this->load->view('common/header');

			$this->load->view('signup');

			$this->load->view('common/footer');

		}		

		

	}



	private function HomePage()

	{

		$this->load->view('HomePage/home-header');

		$this->load->view('HomePage/index');

		$this->load->view('HomePage/home-footer');

	}



	private function profile()

	{

		$this->load->view('profile/profile-header');
		$this->load->view('profile/left-sidebar');
		$this->load->view('profile/index');
		$this->load->view('profile/profile-footer');

	}



	public function Logout()

	{

		$this->session->sess_destroy();

		redirect( site_url() );

	}



	public function ForgotPass()

	{

		$Data = $this->input->post();

		$isEmail = 0;

		$isPhone = 0;

		if( isset( $Data['forgot_pass'] ) && !empty( $Data['forgot_pass'] ) )

		{

			if (filter_var($Data['forgot_pass'], FILTER_VALIDATE_EMAIL)) 

				{

				  $Check['email'] = $Data['forgot_pass'];

				  $isEmail = 1;

				} 

			else 

				{

				  $Check['phone_Number'] = $Data['forgot_pass'];

				  $isPhone = 1;

				}

			$Exists = $this->user_model->where($Check)->get();

			if( !empty( $Exists ) )

			{

				$RandomPassword = $this->random_password();

				if($isPhone == 1  )

				{					

					$this->sms->sendPassword( $Exists->country_code.''.$Exists->phone_Number , $RandomPassword );				

				}

				if( $isEmail == 1 )

				{

					$this->sendEmail( $Exists->email , $RandomPassword , 'Your New Crypdexx Password' );

				}

				$Update = $this->user_model->update( array( 'password' => md5($RandomPassword)  ) , array( 'user_ID' => $Exists->user_ID ) );

				

				if( $Update )

				{

					$this->_resp( 1 , "Please Check Your Email/Mobile for New Password");

				}

			}

			else

			{

				$this->_resp( 0 , "" , "No Record Found!" );

			}

		}	

		else

		{

			$this->_resp( 0 , "" , "Invalid Request !" );

		}

	}



	

	public function update_profile()

	{

		$UserData = $this->user_model->CheckSignIn( array( 'user_ID' => $this->session->User_ID ) );

		$this->_pre($UserData);

		

		$this->load->view('profile/profile-header');

		$this->load->view('profile/update-profile' , $UserData);

		$this->load->view('profile/profile-footer');

	}

	public function feed()
	{
		$url="https://www.reddit.com/r/CryptoCurrency/top/.rss?format=xml";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

		$data = curl_exec($ch); // execute curl request
		curl_close($ch);

		$xml = (array) simplexml_load_string($data);
		echo count($xml);
		$this->_pre($xml);
	}
	
	public function ico_bench()
	{
		$this->load->view('profile/profile-header');
		$this->load->view('profile/left-sidebar');
		$this->load->view('profile/ico');
		$this->load->view('profile/profile-footer');
	}
	
	public function market()
	{
		$Page = $this->uri->segment(2);
		
		if( !empty( $Page ) ):
			$Start = $Page * 100;
			$url="https://api.coinmarketcap.com/v2/ticker/?sort=id&structure=array&start=$Start";
		else:
			$url="https://api.coinmarketcap.com/v2/ticker/?sort=id&structure=array";
		endif;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

		$data = curl_exec($ch); // execute curl request
		curl_close($ch);

		$xml = $data;		
		$get = $this->globalMarketData();
		$Final = (array) json_decode($xml);
		$Final['global'] = $get['data'];
		
			
		$this->load->view('profile/profile-header');
		$this->load->view('profile/left-sidebar');
		$this->load->view('profile/market' , $Final);
		$this->load->view('profile/profile-footer');
	}
	
	protected function globalMarketData()
	{
		$url="https://api.coinmarketcap.com/v2/global/";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

		$data = curl_exec($ch); // execute curl request
		curl_close($ch);

		$xml = $data;		
		return (array)json_decode($xml);		
	}



}






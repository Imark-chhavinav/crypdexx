<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Users extends CS_Controller {



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

			$this->load->library('Validator');

			$this->load->library('sms');

			$this->load->library('encrypt');

			$this->load->model('user_model');

			$this->load->model('Userdetails_model');



			$config['upload_path'] = './uploads/profile';

			$config['allowed_types'] = 'gif|jpg|png|jpeg';

			$config['max_size']     = '10000';

			$this->load->library('upload', $config);



		}



	public function index()

	{

		echo "home";

		//$this->load->view('welcome_message');

	}

	public function InsertUser()

	{



		$Data = $this->input->post();

		//$FileResults = $this->UploadImg();		



		/* Validate Data */

		$this->ValidInsertUser($Data);



		/* Checking User Exist or Not */

		if( isset( $Data['phone_number'] ) && !empty( $Data['phone_number'] ) )

		{

			$Check = $this->user_model->where(array('phone_number'=>$Data['phone_number']))->get();

		}



		if( isset( $Data['email'] ) && !empty( $Data['email'] ) )

		{

			$Check = $this->user_model->where(array('email'=>$Data['email']))->get();

		}



		if( !empty($Check) )

		{

			$this->_resp( 0 , '' ,'User Already Exists with these Profile Details!' );

		}
		
		if( !empty($Data['phone_number']) )

		{

			$Data['phone_number'] = preg_replace("/[^0-9]/", "",$Data['phone_number']);			

			$Data['verified'] = 0;

			$Data['verify_code'] = mt_rand(100000, 999999);

			$this->sms->sendSms( $Data['country_code'].''.$Data['phone_number'] , $Data['verify_code'] );				

		}

		else

		{			

			$Data['verified'] = 0;

			$Data['verify_code'] = mt_rand(100000, 999999);

			$this->sendEmail( $Data['email'] , $Data['verify_code'] );			

		}

		

		$Result = $this->user_model->InsertCrypUser($Data);		

			if( $Result )

			{

				$this->_resp( 2 , $Result );				

			}

			else

			{

				$this->_resp( 0 , '' ,'Please Try Again! User not Register' );

			}		

	} 



	private function UploadImg()

	{

		if ( ! $this->upload->do_upload( 'attachment' ))

            {

            		$this->_resp( 0, "" , $this->upload->display_errors());                   

            }

            else

            {

                    $data = $this->upload->data();

                    return $data;

            }

	}



	private function ValidInsertUser( $Data )
	{

		$ArrayRules = array();
		$ArrayRules = array(
			'user_type'    		=> 'required',			
			'reg_type'    		=> 'required',			
			'password'       	=> 'required',
			'confirm_pass'    	=> 'required'
		);


		if( $Data['user_type'] == '1' )
		{
			$ArrayRules['firstname'] = 'required';
			$ArrayRules['surname'] = 'required';
		}

		if( $Data['user_type'] == '2' )
		{
			$ArrayRules['business_name'] = 'required';
		}

		if( $Data['reg_type'] == 'phone' )
		{
			$ArrayRules['phone_number'] = 'required|min_len,10';
		}

		if( $Data['reg_type'] == 'email' )
		{
			$ArrayRules['email'] = 'required|valid_email';
		}



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



	public function VerifyCode()

	{

		$Data = $this->input->post();



		if( isset( $Data['OTP'] ) && !empty($Data['OTP']) )

		{

			$Check = $this->user_model->where(array('verify_code' => $Data['OTP'] , 'user_ID' => $this->encryption->decrypt( $Data['reference_ID']) ))->get();

			if( !empty( $Check ) )

			{

				 $this->user_model->update( array( 'verified' => 1 ,'verify_code' => NULL ) , array( 'user_ID' =>$this->encryption->decrypt( $Data['reference_ID'])));

				$this->_resp( 1 ,'Verification Done Successfully !');

			}

			else

			{

				$this->_resp( 0 ,'' ,"Code Does'nt match !" );

			}

			//$this->_pre( $Check );

		}

		else

		{

			$this->_resp( 0 ,'' ,'Please Enter Code!' );

		}

	}



	public function UpdateUser()

	{

		$Data = $this->input->post();



		$FileResults = $this->UploadImg();	



		if( !empty($FileResults) ):

			$Data['profile_img'] = json_encode($FileResults);

		endif;	



		$Result = $this->Userdetails_model->InsertUserDetailsCrypUser($Data);

		if( $Result )

			{

				$this->_resp( 1 ,'Registration Done Successfully');

			}

			else

			{

				$this->_resp( 0 ,'' ,"Some think went wrong ! Please Login" );

			}	

	}


	public function UserSignIn()

	{

		$Data = $this->input->post();		



		/* Validate Data */

		$this->ValidSignInUser($Data);



		$Check = array();

		/*Check Is Phone Number or Email*/

		if (filter_var($Data['sign_in'], FILTER_VALIDATE_EMAIL)) 

		{

			// Email

			$Check['email'] = $Data['sign_in'];

		} 

		else 

		{

			// Phone Number

			$Check['phone_number'] = $Data['sign_in'];

		}



		$Check['password'] = md5($Data['password']);



		$Results = $this->user_model->CheckSignIn( $Check );



		//$this->_pre( $Results );

		if( empty($Results) )

		{

			$this->_resp( 0 ,'' ,"Login Credentials does not match in our records !" );

		}

		else

		{

			$this->SetupSession( $Results );

		}



	}



	private function SetupSession( $Data )

	{		

		/* Profile Image */

		if( !empty( $Data['details']->Profile_pic ) )

		{

			$PicData = json_decode($Data['details']->Profile_pic);

			$PicPath = strstr($PicData->full_path, 'uploads');

			$ProfilePic = site_url().$PicPath;			

		}

		else

		{

			if( !empty($Data['details']->photo_url) )

			{

				if (strpos($Data['details']->photo_url,'sz=50') !== false) 

				{ 

				    $ProfilePic = str_replace('sz=50', 'sz=250', $Data['details']->photo_url); //if yes, we simply replace it with en

				}

				else

				{

					$ProfilePic = $Data['details']->photo_url;	

				}

				

			} 

			else

			{

				$ProfilePic = site_url().'assests/images/profile-pic.jpg';

			}

		}





		$newdata = array(

		        'User_ID'  		=> $Data['user_ID'],

		        'full_Name'     => $Data['full_Name'],

		        'email'     	=> $Data['email'],

		        'User_type'     => $Data['user_role'],

		        'business_name' => $Data['business_name'],

		        'is_login' 		=> TRUE,

		        'user_login' 	=> TRUE,

		        'Profile_pic' 	=> $ProfilePic		        



		);

		$this->session->set_userdata($newdata);

		$this->_resp( 1 ,' Login Successfully ');	

	}



	private function ValidSignInUser( $Data )

	{

		$ArrayRules = array();	



		$ArrayRules = array(			

			'sign_in'    		=> 'required',			

			'password'   		=> 'required'			

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



	public function SocialLogin()

	{

		$Data = $this->input->post();

		//$this->_pre( $Data );



		$Check = $this->user_model->where(array('email'=>$Data['email']))->with_details()->as_array()->get();

		if( !empty($Check) )

		{

			$this->SetupSession( $Check );

		}

		else

		{

			$NewUser = array(

                'fullname'     		=> $Data['fullname'],

                'email'         	=> $Data['email'],                

                'password'      	=> md5('P@$$w@r%'),

                'user_role'     	=> 1, // 1:Customer , 2:Business , 3:Crypto user               

                'reg_type'      	=> 'social',                

                'verified'      	=> 1, 

                'phone_number' 		=> NULL,

                'business_name' 	=> NULL,

                'verify_code' 		=> NULL

            );

			 

			$Result = $this->user_model->InsertCrypUser($NewUser);

			$UserDetails = array(

				'reference_ID' 	=> $Result,

				'profile_img' 	=> NULL,

				'photo_url' 	=> $Data['Image_url'],

				'City' 			=> 'Blank',

				'Country' 		=> 'Blank',

				'fb_ID' 		=> (isset($Data['FBID']))? $Data['FBID']: "",

				'google_ID' 		=> (isset($Data['GOOGLEID']))? $Data['GOOGLEID']: "",

				'about_us' 		=>  NULL

			);

			$Insert = $this->Userdetails_model->InsertUserDetailsCrypUser( $UserDetails );

			$SignIn = $this->user_model->CheckSignIn( array( 'email' => $Data['email'] ) );	

			

			if( empty($SignIn) )

			{

				$this->_resp( 0 ,'' ,"Login Credentials does not match in our records !" );

			}

			else

			{

				$this->SetupSession( $SignIn );

			}		



		}

	}

	
	public function ChangePassword()
	{
		$Data = $this->input->post();
		/* Validate Data */
		$this->ValidChangePassword($Data);
		
		if( $Data['new_pass'] == $Data['confnew_pass'])
		{
			$OldPass = $this->user_model->where( array( 'user_ID' => $this->session->User_ID , 'password' => md5( $Data['old_pass'] ) ) )->get();
			if( !empty( $OldPass ) )
			{
				$Update = $this->user_model->update( array( 'password' => md5( $Data['new_pass'] ) ) , array( 'user_ID' => $this->session->User_ID ));
				if( $Update )
				{
					$this->_resp( 1 , 'Password Updated Successfully !' );
				}
				else
				{
					$this->_resp( 0 , '' , 'Please Try Again Password not Updated' );
				}
			}
			else
			{
				$this->_resp( 0 , '' ,'Old Password is Incorrect!' );
			}
		}
		else
		{
			$this->_resp( 0 , 'New Password and Confirm Password Does\'nt Match' );
		}
	}
	
	private function ValidChangePassword( $Data )
	{
		$ArrayRules = array();
		$ArrayRules = array(
			'old_pass'    		=> 'required',
			'new_pass'   		=> 'required',
			'confnew_pass'   	=> 'required'
		);
		$this->validator->validation_rules( $ArrayRules );	
		//	Validating
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
}


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CS_Admin extends CI_Controller
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
   		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");   
		parent::__construct();
	}

	public function _resp( $success = 0, $result = '' , $error = 'No Error Found !' )
	{
		echo json_encode(array( 'success' => $success, 'result'=> $result, 'error' => $error ));
		exit;
	}

	public function _pre( $Data )
	{
		echo "<pre>";
		print_R( $Data );
		echo "</pre>";
	}
	
	public function random_password( $length = 8 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}
	
	public function sendEmail( $Email , $Code , $Content = 'Verification Code' )
	{

		$this->email->from('info@customer-devreview.com', 'Your Name');
		$this->email->to($Email);		
		$this->email->bcc('shadow_chhavi@yahoo.com');
		$this->email->subject('Email Test');
		$this->email->message(" $Content : $Code ");
		$this->email->send();
	}

	public static function slugify($text)
	{
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
	    return 'n-a';
	  }

	  return $text;
	}
}
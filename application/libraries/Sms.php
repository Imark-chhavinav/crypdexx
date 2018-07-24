<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Required if your environment does not handle autoloading
require __DIR__ . '/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

class Sms
{

	public function sendSms( $PhoneNumber , $VerifyCode )
	{
				// Your Account SID and Auth Token from twilio.com/console
		$sid = 'AC0a95d217609bd526200ae2ab5348547f';
		$token = '0792e7a278000c67faa3309f05b73931';
		$client = new Client($sid, $token);

		// Use the client to do fun stuff like send text messages!
		$client->messages->create(
		    // the number you'd like to send the message to
		    '+'.$PhoneNumber,
		    array(		        
		        'from' => '+16179967574',		        
		        'body' => "Your Crypdexx Verification Code : $VerifyCode"
		    )
		);

	}
	
	public function sendPassword( $PhoneNumber , $Password )
	{
				// Your Account SID and Auth Token from twilio.com/console
		$sid = 'AC0a95d217609bd526200ae2ab5348547f';
		$token = '0792e7a278000c67faa3309f05b73931';
		$client = new Client($sid, $token);

		// Use the client to do fun stuff like send text messages!
		$client->messages->create(
		    // the number you'd like to send the message to
		    '+'.$PhoneNumber,
		    array(		        
		        'from' => '+16179967574',		        
		        'body' => "Your Crypdexx Password : $Password"
		    )
		);

	}

}
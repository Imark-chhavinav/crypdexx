<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Market extends CS_Controller {



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
		$this->load->helper('url');
		$this->load->library('sms');
	}

	public function index()
	{		
		if( $this->uri->segment(2) == 'index' )
		{
			$Page = $this->uri->segment(3);
		}
		else
		{
			$Page = $this->uri->segment(2);
		}
		
		if( !empty( $Page ) ):
			$Start = $Page * 100;
			$url="https://api.coinmarketcap.com/v2/ticker/?sort=id&start=$Start";
		else:
			$url="https://api.coinmarketcap.com/v2/ticker/?sort=id";
		endif;
		
		//$url="https://api.coinmarketcap.com/v2/ticker/?sort=id&start=$Start";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

		$data = curl_exec($ch); // execute curl request
		curl_close($ch);

		$xml = $data;		
		$this->_pre($xml);
	}
}

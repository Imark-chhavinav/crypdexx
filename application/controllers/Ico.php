<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ico extends CS_Controller {

	private $privateKey	= 'c526708a-bd22-4c98-bc52-617a749b6038';
	private $publicKey	= '7b00b3c5-b138-41c9-95b9-e322912edc1e';
	private $apiUrl		= 'https://icobench.com/api/v1/';
	public	$result;
	
	public function __construct()
	{
		parent::__construct();		
		$this->load->helper('url');	
	}

	private function getICOs($type = 'all', $data = ''){ 
		return $this->send('icos/' . $type, $data); 
	}	
	
	private function getICO($icoId, $data = ''){ 
		return $this->send('ico/' . $icoId, $data); 
	}
	
	private function getOther($type){ 
		return $this->send('other/' . $type, ''); 
	}
	
	private function getPeople($type = 'registered', $data = ''){ 
		return $this->send('people/' . $type, $data); 
	}	
	
	private function send($action, $data){
		
		$dataJson = json_encode($data); 				
		$sig = base64_encode(hash_hmac('sha384', $dataJson, $this->privateKey, true));	
		
		$ch = curl_init($this->apiUrl . $action);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($dataJson),
			'X-ICObench-Key: ' . $this->publicKey,
			'X-ICObench-Sig: ' . $sig)
		);

		$reply = curl_exec($ch);
		$ff = $reply;
		$reply = json_decode($reply,true);

		if(isset($reply['error'])){
			$this->result = $reply['error'];
			return false;
		}else if(isset($reply['message'])){
			$this->result = $reply['message'];
			return true;
		}else if(isset($reply)){
			//$this->result = json_encode($reply);
			$this->result = $reply;
			return true;
		}else{
			$this->result = htmlspecialchars($ff);
			return false;
		}
	}

	private function result()
	{
		return $this->result;
	}
	
	public function getListing()
	{
		$Page = $this->uri->segment(3);
		$Data = $this->input->post();
		if( empty( $Page ) )
		{
			$Page = 0;
		}
		$this->getICOs('all',['page'=>$Page]);
		$Result = $this->result;
		$Newdata = array();
		foreach( $Result['results'] as $keys ):
			$Details = $this->getrating( $keys['id'] );	
			if( !empty($Details) ):
				if( isset( $Data ) && isset( $Data['format'] ) &&$Data['format'] == 'html' )
				{					
					$Image = $this->getImage( $Details['links']['youtube'] );
					$Newdata[] = '<div class="video_frame"> <label class="title-lab">'.$Details["name"].'<i data-id="'.$Details["id"].'" class="fa fa-heart"></i></label> <figure style="background-image : url('.$Image.')"></figure> <div class="vedio_information"> <label>'.$Details["rating"].'</label> <ul><li><a href="">'.$Details["ratingProfile"].'<br>Profile</a></li><li><a href="">'.$Details["ratingTeam"].'<br>Team</a></li><li><a href="">'.$Details["ratingVision"].'<br>Vision</a></li></ul> <a target="_blank" class="more_ico" href="'.$Details["url"].'">More On ICO</a> </div></div>';
				}
				else
				{
					$Image = $this->getImage( $Details['links']['youtube'] );			
					$Newdata[] = array( 
						'id' 			=> $Details['id'],	
						'name' 			=> $Details['name'],
						'rating' 		=> $Details['rating'],
						'ratingTeam' 	=> $Details['ratingTeam'],
						'ratingVision' 	=> $Details['ratingVision'],
						'ratingProduct' => $Details['ratingProduct'],
						'ratingProfile' => $Details['ratingProfile'],
						'url' 			=> $Details['url'],
						'youtube' 		=> $Details['links']['youtube'],
						'youtube_img' 	=> $Image
					);
				}				
			endif;			
		endforeach; 
		$this->_resp( 1 , $Newdata );
	}
	
	public function getrating( $ID)
	{
		$this->getICO( $ID );
		return $this->result;		
	}
	
	protected function getImage( $Link )
	{
		$Image = 'https://img.youtube.com/vi/0.jpg';
		if (strpos($Link, '?ecver=2') !== false) 
		{
			$EImage = explode( 'embed/' , $Link );
			$EImage = explode( '?' , $EImage[1] );
			$Image = 'https://img.youtube.com/vi/'.$EImage[0].'/0.jpg';
		}
		elseif (strpos($Link, 'watch?v=') !== false) 
		{
			$EImage = explode( 'watch?v=' , $Link );
			$Image = 'https://img.youtube.com/vi/'.$EImage[1].'/0.jpg';
		}
		elseif(strpos($Link, 'embed') !== false) 
		{
			$EImage = explode( 'embed/' , $Link );
			$Image = 'https://img.youtube.com/vi/'.$EImage[1].'/0.jpg';
		}
		elseif( strpos($Link, 'vimeo') !== false )
		{
			$explode 	= explode( 'video/' , $Link );
			$imgid 		= $explode[1];
			$hash 		= unserialize($this->url_get_contents( "https://vimeo.com/api/v2/video/$imgid.php" ));
			$Image 		= $hash[0]['thumbnail_medium'];
		}
		
		return $Image;
	}
	
	
	protected function url_get_contents ($Url) 
	{
		if (!function_exists('curl_init')){ 
			die('CURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
		//print_R($output);
		return $output;
	}
}

?>
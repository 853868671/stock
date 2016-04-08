<?php

namespace Tiger;
use Tiger\helper;
class tigerAuth
{
	const dev_url = 'https://open-dev.tigerbrokers.com/v1/';
	const open_url = 'https://open.tigerbrokers.com/v1/';

	private $http_url = self::dev_url;
	private $client_id;
	private $client_secret;
	private $redirect_uri;
	private $response_type="code";

	public function __construct($client_id,$client_secret,$redirect_uri,$open=false)
	{
		if($open){
			$this->http_url = self::open_url;
		}
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->redirect_uri = $redirect_uri;
	}



	public function getAuth()
	{
		$url = $this->http_url.'oauth2/authorize?client_id='.$this->client_id.'&redirect_uri='.$this->redirect_uri.'&response_type=code';
		header("location:$url");
	}		

	public function getToken($grant_type='authorization_code',$code_or_refresh_token)
	{
		$params = array();
		$params['client_id'] = $this->client_id;
		$params['client_secret'] = $this->client_secret;
		$params['grant_type'] = $grant_type;
		$params['redirect_uri'] = $this->redirect_uri;
		if($grant_type=='authorization_code'){
			$params['code'] = $code_or_refresh_token; 
		}
		if($grant_type=='refresh_token'){
			$params['refresh_token'] = $code_or_refresh_token;
		}

		$res = helper::curl($url,false,$params,1);
		return $res;
	}
}
<?php
function NoErrors($c, $t, $d, $z){
    return true;
}

class MojangLoginAPI
{
	private $name = 'unknown';
	private $passwd = 'unknown';
	private $email = 'unknown';
	private $id = 'unknown';
	private $token = 'unknown';
	private $ctoken = 'unknown';
	private $raw = array();
	private $response = array();
	private $premium = false;

	public function login($name, $passwd)
	{
		if(strpos($name, "@") !== FALSE)
		{
			$this->email = $name;
		}
		$this->name = $name;
		$this->passwd = $passwd;
		$preload = array(
			"agent" => array(
				"name" => "Minecraft",
				"version" => 1 ),
			"username" => $name,
			"password" => $passwd
		);
		$payload = json_encode($preload);
		$old = set_error_handler("NoErrors");
		try {
		$result = file_get_contents('https://authserver.mojang.com/authenticate', null, stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-Type: application/json'."\r\n".'Content-Length: '.strlen($payload) . "\r\n",
				'content' => $payload
				)
			)
		));
		} catch(Exception $ex)
		{ $premium = false; }
		set_error_handler($old);
   		$this->raw = $result;
   		$this->response = $http_response_header;
		if(trim($result) == "")
		return false;
		$profileInfo = json_decode($result, true);
		$profile = $profileInfo["selectedProfile"];
		$this->name = $profile["name"];
		$this->id = $profile["id"];
    		$this->token = $profileInfo["accessToken"];
    		$this->ctoken = $profileInfo["clientToken"];
		$this->premium = (isset($profile["legacy"])) ? false : true;
		return true;
	}

	public function validate($token, $ctoken)
	{
		$preload = array(
			"accessToken" => $token,
			"clientToken" => $ctoken
		);
		$payload = json_encode($preload);
		$old = set_error_handler("NoErrors");
		try {
		$result = file_get_contents('https://authserver.mojang.com/validate', null, stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-Type: application/json'."\r\n".'Content-Length: '.strlen($payload) . "\r\n",
				'content' => $payload
				)
			)
		));
		} catch(Exception $ex)
		{ $this->raw = $result; }
		set_error_handler($old);
    		$this->raw = $result;
    		$this->response = $http_response_header;
		if(trim($result) == "") return true;
		$profileInfo = json_decode($result, true);
		return false;
	}

	public function invalidate($token, $ctoken)
	{
	$preload = array(
	    "accessToken" => $token,
	    "clientToken" => $ctoken
	);
		$payload = json_encode($preload);
		$old = set_error_handler("NoErrors");
		try {
		$result = file_get_contents('https://authserver.mojang.com/invalidate', null, stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-Type: application/json'."\r\n".'Content-Length: '.strlen($payload) . "\r\n",
				'content' => $payload
				)
			)
		));
		} catch(Exception $ex)
		{ $this->raw = $result; }
		set_error_handler($old);
		$this->raw = $result;
		$this->response = $http_response_header;
		if(trim($result) == "") return true;
		$profileInfo = json_decode($result, true);
		return false;
	}

	public function refresh($token1, $token2)
	{
		$this->token = $token1;
		if(!empty($token2)){
            $preload = array(
                "accessToken" => $token1,
                "clientToken" => $token2
            );
		}else{
			$preload = array(
				"accessToken" => $token1
			);
		}
		$payload = json_encode($preload);
		$old = set_error_handler("NoErrors");
		try {
		$result = file_get_contents('https://authserver.mojang.com/refresh', null, stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-Type: application/json'."\r\n".'Content-Length: '.strlen($payload) . "\r\n",
				'content' => $payload
				)
			)
		));
		} catch(Exception $ex)
		{ $premium = false; }
		set_error_handler($old);
    	$this->response = $http_response_header;
    	$this->raw = $result;
		if(trim($result) == "")
		return false;
		$profileInfo = json_decode($result, true);
		$profile = $profileInfo["selectedProfile"];
		$this->name = $profile["name"];
		$this->id = $profile["id"];
		$this->token = $profileInfo["accessToken"];
    	$this->ctoken = $profileInfo["clientToken"];
		$this->premium = (isset($profile["legacy"])) ? false : true;
		return true;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getID()
	{
		return $this->id;
	}

	public function getToken()
	{
		return $this->token;
	}

	public function getcToken()
	{
		return $this->ctoken;
	}

	public function getRaw()
	{
		return $this->raw;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function isPremium()
	{
		return $this->premium;
	}

	public function isEmailKnown()
	{
		if($this->email != 'unknown')
			return true;
		else return false;
	}

	public function reset()
	{
		$this->name = 'unknown';
		$this->passwd = 'unknown';
		$this->email = 'unknown';
		$this->id = 'unknown';
		$this->token = 'unknown';
		$this->ctoken = 'unknown';
    	$this->raw = array();
    	$this->response = array();
		$this->premium = false;
		return true;
	}
}
?>

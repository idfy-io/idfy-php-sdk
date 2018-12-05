<?php
declare(strict_types=1);

class BadAccessTokenException extends Exception {}
class UnsupportedTokenTypeException extends Exception {}
class BadExpiresInException extends Exception {}

final class OAuthToken{

	private $accessToken = "";
	private $expiresIn = 0;
	private $tokenType = "";
	private $tokenValidFrom;

	public function __construct($accessToken, $expiresIn, $tokenType, $tokenValidFrom = null){
		if($tokenValidFrom == null){
			$this->tokenValidFrom = new DateTimeImmutable(); /* This is quite shaky, should get from response headers instead. */
		} else {
			$this->tokenValidFrom = $tokenValidFrom;
		}
		$this->setAccessToken($accessToken);
		if(!is_numeric($expiresIn)){
			throw new BadExpiresInException("Could not parse expires_in: ".$expiresIn.".");
		}
		if((int)$expiresIn < 1)
			throw new BadExpiresInException("expires_in must be a positive integer. Got: ".$expiresIn.".");

		$this->setExpiresIn((int)$expiresIn);
		if($tokenType != "Bearer")
			throw new UnsupportedTokenTypeException("Unsupported token type: ".$tokenType.". Only Bearer is supported for now.");
		$this->$tokenType = "Bearer";
	}

	private function setAccessToken($accessToken){
		if(strlen(trim($accessToken)) == 0){
			throw new BadAccessTokenException("Empty access token received.");
		}
		if(substr_count($accessToken, ".") < 2){
			throw new BadAccessTokenException("Access token incomplete.");
		}

		$contents=explode(".",$accessToken);
		$header = json_decode(base64_decode($contents[0]), TRUE);
		$info = json_decode(base64_decode($contents[1]), TRUE);
		if(! isset($header) || ! isset($info)){
			throw new BadAccessTokenException("Access token missing header information.");
		}

		if(isset($header) && array_key_exists("typ", $header) && $header["typ"] == "JWT"){
			$this->accessToken = $accessToken;
		} else {
			throw new BadAccessTokenException("Access token has no JWT.");
		}
	}

	public function getAccessToken(){
		return $this->accessToken;
	}

	public function setExpiresIn($expires){
		$this->expiresIn = (int)$expires;	
	}

	public function getExpiresIn() : int {
		return $this->expiresIn;
	}

	public function getExpiry() : DateTimeImmutable {
		return $this->tokenValidFrom->add(new DateInterval('PT'.$this->getExpiresIn().'S'));
	}


}

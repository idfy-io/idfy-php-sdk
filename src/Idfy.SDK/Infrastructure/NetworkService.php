<?php
declare(strict_types=1);

$dn = dirname(__FILE__)."/";
include_once($dn.'Exceptions.php');
include_once($dn.'iNetworkService.php');

final class NetworkService implements iNetworkService {

	protected $baseUrl;
	protected $curl;

	public function __construct($baseUrl="https://api.idfy.io", $curl_init=null){	/*TODO: Wrap curl in a class of its own to allow clean abstraction and mocking */
		if(empty($baseUrl)){
			throw new MissingBaseUrlException("Baseurl parameter empty");
		}
		if(! filter_var($baseUrl, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)){
			throw new InvalidBaseUrlException("Baseurl is not well formed: ".$baseUrl);
		}
		$this->baseUrl = $baseUrl."/";
		if($curl_init == null){
			$this->curl = curl_init();
		}
		else{
			$this->curl = $curl_init();
		}
	}

	public function PostFormData($resource, $formData, $headers = []) : string {
		return $this->POST($resource, http_build_query($formData));
	}

	private function POST($resource, $payload, $headers = []){
		$url = $this->baseUrl.$resource;
		$heads=$headers+["Content-Type"=> "application/x-www-form-urlencoded; charset=utf-8", "Cache-Control" => "no-cache"];
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $payload,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_VERBOSE => true
		);
		curl_setopt_array($this->curl, $options);
		$result = curl_exec($this->curl);
		return $result;
	}

}

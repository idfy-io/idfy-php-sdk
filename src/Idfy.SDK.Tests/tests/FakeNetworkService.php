<?php
declare(strict_types=1);
$dn = dirname(__FILE__).'/';
include_once($dn.'../../Idfy.SDK/Infrastructure/iNetworkService.php');
include_once($dn.'TestData.php');

final class FakeNetworkService implements iNetworkService
{

	public function PostFormData($resource, $formData, $headers = []) : string {
		if(empty($resource)){
			throw new TypeError("resource must not be empty");
		}
		if(!is_array($formData)){
			throw new TypeError("formData must be an array");
		}
		if(!is_array($headers)){
			throw new TypeError("headers must be an array");
		}
		return TestData::$access_token_response;
	}
}

final class InvalidClientNetworkService implements iNetworkService
{
	public function PostFormData($resource, $formData, $headers = []) : string {
		return json_encode(["error" => "invalid_client"]);
	}
}

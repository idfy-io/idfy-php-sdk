<?php
declare(strict_types=1);
$dn = dirname(__FILE__)."/";
include_once($dn.'../Entities/OAuthToken.php');
include_once($dn.'Exceptions.php');

final class AuthManager{

	protected $clientId;
	protected $clientSecret;
	protected $networkService;

	public function __construct($clientId, $clientSecret, $networkService) {
		if($networkService == null || ! $networkService instanceof iNetworkService){
			throw new MissingNetworkServiceException("No instance of iNetworkService supplied");
		}
		$this->networkService = $networkService;

		if(empty($clientId)){
			throw new BadClientIdException("No client_id supplied.");
		}
		$this->clientId = $clientId;

		if(empty($clientSecret)){
			throw new BadClientSecretException("No client_secret supplied.");
		}
		$this->clientSecret = $clientSecret;
	}

	private static function build_basic_auth_header($clientId, $clientSecret) {
		return ["Authorization" => "Basic ".base64_encode($clientId.":".$clientSecret)];
	}

	public function Authorize($scopes): OAuthToken {
		if(!is_array($scopes) || count($scopes) < 1){
			throw new BadOAuthScopesException("No scopes supplied.");
		}

		/* TODO: Figure out why credentials must go in the body instead of the headers. Postman is OK with headers */
		$body = ["grant_type" => "client_credentials", "scope" => implode(' ', $scopes), "client_id" => $this->clientId, "client_secret" => $this->clientSecret];
		$token_received = $this->networkService->PostFormData("oauth/connect/token", $body, []); //, $basic_auth);
		$tok= json_decode($token_received, true);
		if(array_key_exists("error", $tok)){
			throw new AuthorizeFailedException("Could not authorize client: ".$tok["error"]);
		}
		return new OAuthToken($tok["access_token"], $tok["expires_in"], $tok["token_type"]);
	}
}

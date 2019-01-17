<?php
declare(strict_types=1);
$dn = dirname(__FILE__)."/";
include_once($dn.'Infrastructure/Exceptions.php');
include_once($dn.'OAuthScope.php');

final class IdfyConfiguration
{
	private static $ClientId;
	private static $ClientSecret;
	private static $Scopes;
	private static $Token;
	private static $DefaultBaseUrl = "http://api.idfy.io/";
	private static $DefaultOAuthUrl = "http://api.idfy.io/oauth/connect/token";

	public function __construct(){
		throw new Exception("IdfyConfiguration only allows static invocation");
	}

	public static function SetClientCredentials($clientId, $clientSecret, $oAuthScopes){
		if(!isset($clientId)|empty($clientId)|ctype_space($clientId)){
			throw new BadClientIdException("OAuth2 Client ID missing or empty.");
		}
		if(!isset($clientSecret)|empty($clientSecret)|ctype_space($clientSecret)){
			throw new BadClientSecretException("OAuth2 client SECRET missing or empty");
		}
		if(empty($oAuthScopes)){
			throw new BadOAuthScopesException("OAuth Scopes ARRAY missing or empty.");
		}
		if(!OAuthScope::ValidateScopes($oAuthScopes)){
			throw new BadOAuthScopesException("Invalid OAuth scope");
		}
	
		self::$ClientId = $clientId;
		self::$ClientSecret = $clientSecret;
		self::$Scopes = $oAuthScopes;
	}

	public static function GetClientId(){
		return self::$ClientId;
	}

	public static function GetClientSecret(){
		return self::$ClientSecret;
	}

	public static function GetScopes(){
		return self::$Scopes;
	}
	
}

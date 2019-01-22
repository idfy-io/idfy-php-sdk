<?php
declare(strict_types=1);
$dn = dirname(__FILE__)."/";
include_once($dn.'Infrastructure/Exceptions.php');
include_once($dn.'OAuthScope.php');
include_once($dn.'Infrastructure/Urls.php');

final class IdfyConfiguration
{
	private const SDK_VERSION = '0.0.1 Alpha1';
	private static $ClientId;
	private static $ClientSecret;
	private static $Scopes;
	private static $Token;
	private static $BaseUrl;
	private static $OAuthBaseUrl;
	private static $HttpTimeoutSeconds = 0;

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

	public static function GetSdkVersion(){
		return self::SDK_VERSION;
	}

	public static function GetBaseUrl(){
		if(!empty(self::$BaseUrl)){
			return self::$BaseUrl;
		}
		return Urls::DefaultBaseUrl;
	}

	public static function SetBaseUrl($url){
		self::$BaseUrl = $url;
	}

	public static function GetOAuthBaseUrl(){
		if(!empty(self::$OAuthBaseUrl)){
			return self::$OAuthBaseUrl;
		}
		return Urls::DefaultOAuthBaseUrl;
	}

	public static function SetOAuthBaseUrl($url){
		self::$OAuthBaseUrl = $url;
	}

	public static function GetHttpTimeout(){
		return self::$HttpTimeoutSeconds;
	}

	public static function SetHttpTimeout($secondsToTimeout){
		self::$HttpTimeoutSeconds = $secondsToTimeout;
	}
	
}

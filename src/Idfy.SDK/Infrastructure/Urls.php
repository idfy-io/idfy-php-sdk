<?php
declare(strict_types=1);
$dn = dirname(__FILE__)."/";
include_once($dn."../IdfyConfiguration.php");

use IdfyConfiguration as IC;
final class Urls
{
	public const DefaultBaseUrl = "https://api.idfy.io";
	public const DefaultOAuthBaseUrl = self::DefaultBaseUrl;

	public static function BaseUrl(){ return IC::GetBaseUrl(); }
	public static function OAuthToken(){ return IC::GetOAuthBaseUrl()."/oauth/connect/token"; }
	public static function Signature(){ return  IC::GetBaseUrl()."/signature"; }
	public static function SignatureDocuments() { return self::Signature()."/documents"; }
	public static function Notification(){ return self::BaseUrl()."/notification";}
	public static function Identification(){ return self::BaseUrl()."/identification"; }
	public static function MerchantSign(){ return self::BaseUrl()."/merchant"; }
	public static function Jwt(){ return self::BaseUrl()."/jwt"; }
	public static function Validation() { return self::BaseUrl()."/validation"; }
	public static function Admin() { return self::BaseUrl()."/admin"; }
}

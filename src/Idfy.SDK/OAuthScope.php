<?php
declare(strict_types=1);
$dn = dirname(__FILE__)."/";
include_once($dn."Infrastructure/Enum.php");

final class OAuthScope extends Enum
{
	public static function AccountRead() { return self::create(0); }
	public static function AccountWrite() { return self::create(1); }
	public static function DocumentRead() { return self::create(2); }
	public static function DocumentWrite() { return self::create(3); }
	public static function DocumentFile() { return self::create(4); }
	public static function Event() { return self::create(5); }
	public static function Identify() { return self::create(6); }
	public static function Validation() { return self::create(7); }
	public static function ValidationSsn() { return self::create(8); }


	private static function enabledScopes(){ return array ([self::AccountRead(), self::AccountWrite(),
		self::DocumentRead(), self::DocumentWrite(), self::DocumentFile(), self::Event(), self::Identify(),
		self::Validation(), self::ValidationSsn() ]); 
	}
	
	public function toString(){
		return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $this->getName()));
	}

	public function ValidateScopes($scopes){
		foreach($scopes as $scope){
			if(!$scope instanceof OAuthScope){
				return false;}
		}
		return true;
	}
}

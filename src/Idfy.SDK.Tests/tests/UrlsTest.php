<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

$dn = dirname(__FILE__)."/";
$sdk = $dn."../../Idfy.SDK/";
include_once($sdk."Infrastructure/Urls.php");

final class UrlsTest extends TestCase
{
	protected function setUp(){
		$this->baseUrl = "https://api.idfy.io";
	}

	public function test_has_base_url(){
		$this->assertEquals($this->baseUrl, Urls::BaseUrl());
	}

	public function test_has_oauthtoken_url(){
		$this->assertEquals($this->baseUrl."/oauth/connect/token", Urls::OAuthToken());
	}

	public function test_has_signature_url(){
		$this->assertEquals($this->baseUrl."/signature", Urls::Signature());
	}

	public function test_has_document_signature_url(){
		$this->assertEquals($this->baseUrl."/signature/documents", Urls::SignatureDocuments());
	}

	public function test_has_notification_url(){
		$this->assertEquals($this->baseUrl."/notification", Urls::Notification());
	}

	public function test_has_identification_url(){
		$this->assertEquals($this->baseUrl."/identification", Urls::Identification());
	}

	public function test_has_merchant_sign_url(){
		$this->assertEquals($this->baseUrl."/merchant", Urls::MerchantSign());
	}

	public function test_has_jwt_url(){
		$this->assertEquals($this->baseUrl."/jwt", Urls::Jwt());
	}

	public function test_has_validation_url(){
		$this->assertEquals($this->baseUrl."/validation", Urls::Validation());
	}

	public function test_has_admin_url(){
		$this->assertEquals($this->baseUrl."/admin", Urls::Admin());
	}
}

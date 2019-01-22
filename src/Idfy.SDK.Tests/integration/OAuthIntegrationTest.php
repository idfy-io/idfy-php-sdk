<?php
declare(strict_types=1);
$dn = dirname(__FILE__)."/";

use PHPUnit\Framework\TestCase;

include_once '../Idfy.SDK/Infrastructure/NetworkService.php';
include_once '../Idfy.SDK/Infrastructure/Exceptions.php';
include_once '../Idfy.SDK/Infrastructure/AuthManager.php';

final class OAuthIntegrationTest extends TestCase
{
	protected $ns;
	protected $s_id;
	protected $s_sec;
	protected $got_secrets;

	protected function setUp(){
		$dn = dirname(__FILE__)."/";
		$secrets = $dn.'.secret/Secrets.php';
		if(file_exists($secrets)){
			if(isset($DEBUG)){printf("\n.Found secrets in ".$secrets.".\n");}
			include_once($secrets);
			$this->s_id = Secrets::$client_id;
			$this->s_sec = Secrets::$client_secret;
			$this->got_secrets = true;
		} else {
			$this->got_secrets = false;
			if(isset($DEBUG)){printf("\nNo secrets found in ".$secrets.".\n");}
		}

		$this->ns = new NetworkService(IdfyConfiguration::GetBaseUrl());
	}


	public function test_can_exchange_a_valid_key_and_secret_for_an_access_token(){
		$body = array("grant_type" => "client_credentials", "scope" => "document_read", "client_id" => $this->s_id, "client_secret" => $this->s_sec);
		$result = $this->ns->PostFormData("oauth/connect/token", $body);
		$decoded_result = json_decode($result, true);
		$this->assertArrayHasKey("access_token", $decoded_result);	
		$this->assertArrayHasKey("expires_in", $decoded_result);	
		$this->assertArraySubset(["token_type" => "Bearer"], $decoded_result);
	}

	public function test_an_Authorize_request_returns_an_OAuthToken(){
		if($this->got_secrets == false) {
			throw new Exception("Must set client id and secret in .secret/Secrets.php to run integration tests.");
		}

		$nm = new NetworkService(IdfyConfiguration::GetOAuthBaseUrl());
		$as = new AuthManager($this->s_id, $this->s_sec, $nm);
		$token = $as->Authorize(["document_read"]);
		$this->assertInstanceOf(OAuthToken::class, $token);
	}

}

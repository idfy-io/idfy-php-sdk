<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Idfy.SDK/Infrastructure/NetworkService.php';
include_once '../Idfy.SDK/Infrastructure/Exceptions.php';
include_once './tests/TestData.php';

final class NetworkServiceTest extends TestCase
{
	protected $ns;
	protected $s_id;
	protected $s_sec;
	protected $got_secrets;

	protected function setUp(){
			
		$dn = dirname(__FILE__)."/";
		$secrets = $dn.'.secret/Secrets.php';
		if(file_exists($secrets)){
			printf("\n.Found secrets in ".$secrets.".\n");
			include_once($secrets);
			$this->s_id = Secrets::$client_id;
			$this->s_sec = Secrets::$client_secret;
			$this->got_secrets = true;
		} else {
			$this->got_secrets = false;
		printf("\nNo secrets found in ".$secrets.".\n");
	}

	$this->ns = new NetworkService();
	}

	public function test_has_NetworkService_type(){
		$this->assertInstanceOf(NetworkService::class, $this->ns);
	}

	public function test_it_throws_MissingBaseUrlException_if_given_empty_base_url(){
		$this->expectException(MissingBaseUrlException::class);
		$ns = new NetworkService("");
	}

	public function test_it_throws_InvalidBaseUrlException_if_given_an_invalid_base_url(){
		$this->expectException(InvalidBaseUrlException::class);
		$nw = new NetworkService("this\"is>not<a%well|formed@url");
	}

	public function test_a_POST_request_returns_a_valid_json_response(){
		$cid = TestData::$client_id;	/*needs more work for integration testing*/
		$csr = TestData::$client_secret;
		if($this->got_secrets == true) {
			$cid = $this->s_id;
			$csr = $this->s_sec;
			$csr = Secrets::$client_secret;
		}
		$body = array("grant_type" => "client_credentials", "scope" => "document_read", "client_id" => $cid, "client_secret" => $csr);
		$result = $this->ns->PostFormData("oauth/connect/token", $body);
		$decoded_result = json_decode($result, true);
		$this->assertTrue(is_array($decoded_result));	
	}

	/* Integration tests should go elsewhere */
	public function test_an_Authorize_request_returns_an_OAuthToken(){
		$this->assertTrue(false);
	}

}

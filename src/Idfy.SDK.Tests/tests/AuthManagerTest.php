<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Idfy.SDK/Infrastructure/AuthManager.php';
include_once '../Idfy.SDK/Infrastructure/Exceptions.php';
include_once './tests/TestData.php';
include_once './tests/FakeNetworkService.php';

final class AuthManagerTest extends TestCase
{
	protected $am;
	protected $valid_client_id;
	protected $valid_client_secret;
	protected $valid_scopes;
	protected $fakeNetworkService;

	protected function setUp(){
		$this->fakeNetworkService = new FakeNetworkService();
		$this->valid_client_id = TestData::$client_id;
		$this->valid_client_secret = TestData::$client_secret;
		$this->valid_scopes = TestData::$scopes_readwrite;
		$this->am = new AuthManager($this->valid_client_id, $this->valid_client_secret, $this->fakeNetworkService);
	}

	public function test_has_AuthManager_type(){
		$this->assertInstanceOf(AuthManager::class, $this->am);
	}

	public function test_Authorize_returns_an_OAuthToken_when_given_correct_input_and_the_service_is_available(){
		$oam = $this->am->Authorize($this->valid_scopes);
		$this->assertInstanceOf(OAuthToken::class, $oam);
	}

	public function test_Authorize_throws_MissingNetworkServiceException_if_no_networkservice_is_provided(){
		$this->expectException(MissingNetworkServiceException::class);
		$am = new AuthManager($this->valid_client_id, $this->valid_client_secret, null);
	}

	public function test_Authorize_throws_BadClientSecretException_when_client_secret_is_empty(){
		$this->expectException(BadClientIdException::class);
		$am = new AuthManager("", $this->valid_client_secret, $this->fakeNetworkService);
	}

	public function test_Authorize_throws_BadOAuthScopesEception_when_scopes_is_not_an_array(){
		$this->expectException(BadOAuthScopesException::class);
		$this->am::Authorize("noarrayhere");
	}

	public function test_Authorize_throws_BadOAuthScopesException_when_scopes_is_empty(){
		$this->expectException(BadOAuthScopesException::class);
		$this->am::Authorize([]);
	}

	public function test_Authorize_throws_AuthorizeFailedException_when_an_error_is_received_in_the_response(){
		$this->expectException(AuthorizeFailedException::class);
		$nm = new AuthManager("something", "something", new InvalidClientNetworkService());
		$nm->Authorize($this->valid_scopes);
	}

}

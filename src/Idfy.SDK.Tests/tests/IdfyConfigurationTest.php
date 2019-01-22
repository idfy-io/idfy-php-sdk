<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

$dn = dirname(__FILE__)."/";
$sdk = $dn."../../Idfy.SDK/";
include_once($sdk."Infrastructure/Exceptions.php");
include_once($sdk."IdfyConfiguration.php");
include_once($sdk."OAuthScope.php");

use OAuthScope as OAS;

final class IdfyConfigurationTest extends TestCase
{
	protected $ic;
	protected $validScope;

	protected function setUp(){
		$this->validScope =[OAS::AccountRead(), OAS::AccountWrite()];
	}

	protected function tearDown(){
		IdfyConfiguration::SetBaseUrl("");
		IdfyConfiguration::SetOAuthBaseUrl("");
		IdfyConfiguration::SetHttpTimeout(0);
	}

	public function invalidStrings()
	{
		return array(
			array(null),
			array(""),
			array(" "),
		);
	}

	public function invalidScopes(){
		return array(
			array(["NOT_VALID"]),
			array(["BAD_SCOPE",OAS::DocumentRead()])
		);
	}

	public function validScopes(){
		return array(
			array([OAS::AccountRead()]),
			array([OAS::AccountWrite()]),
			array([OAS::DocumentRead()]),
			array([OAS::DocumentWrite()]),
			array([OAS::DocumentFile()]),
			array([OAS::Event()]),
			array([OAS::Identify()]),
			array([OAS::Validation()]),
			array([OAS::ValidationSsn()]),
			array([OAS::AccountRead(),OAS::AccountWrite(),OAS::Identify(),OAS::Event()]),
			array([OAS::DocumentWrite(),OAS::Validation()])
		);
	}

	public function test_cant_instance_IdfyConfiguration(){
		$this->expectException(Exception::class);
		$ic = new IdfyConfiguration();
	}

	public function test_can_set_client_id(){
		IdfyConfiguration::SetClientCredentials("id"," something", $this->validScope);
		$this->assertEquals("id", IdfyConfiguration::GetClientId());
	}

	public function test_can_set_client_secret(){
		IdfyConfiguration::SetClientCredentials("something", "secret", $this->validScope);
		$this->assertEquals("secret", IdfyConfiguration::GetClientSecret());
	}

	/**
	 * @dataProvider invalidStrings
	 * @expectedException BadClientIdException
	 */
	public function test_it_throws_when_given_a_null_or_empty_id($invalidId){
		IdfyConfiguration::SetClientCredentials($invalidId, "secret", $this->validScope);
	}

	/**
	 * @dataProvider invalidStrings
	 * @expectedException BadClientSecretException
	 */
	public function test_it_throws_when_given_a_null_or_empty_secret($invalidSecret){
		IdfyConfiguration::SetClientCredentials("id", $invalidSecret, $this->validScope);
	}

	public function test_it_throws_when_given_an_empty_list_of_scopes(){
		$this->ExpectException(BadOAuthScopesException::class);
		IdfyConfiguration::SetClientCredentials("id", "secret", []);
	}

	/**
	 * @dataProvider invalidScopes
	 * @expectedException BadOAuthScopesException
	 */
	public function test_it_throws_when_given_a_bad_list_of_scopes($invalidScopes){
		IdfyConfiguration::SetClientCredentials("id", "secret", $invalidScopes);
	}

	/**
	 * @dataProvider validScopes
	 */
	public function test_can_set_oauth_scopes($validScope){
		IdfyConfiguration::SetClientCredentials("id", "secret", $validScope);
		$this->assertEquals($validScope, IdfyConfiguration::GetScopes());
	}

	public function test_can_get_SDK_version(){
		$version = IdfyConfiguration::GetSdkVersion();
		$regex = '/\d+.\d+.\d+\s\w+/';
		$result = preg_match($regex, $version);
		$this->assertEquals(1, $result);
	}

	public function test_baseurl_has_default_value(){
		$expected = "https://api.idfy.io";
		$actual = IdfyConfiguration::GetBaseUrl();
		$this->assertEquals($expected, $actual);
	}

	public function test_can_set_custom_base_url(){
		$expected = "https://some.random.url.io";
		IdfyConfiguration::SetBaseUrl($expected);
		$actual = IdfyConfiguration::GetBaseUrl();
		$this->assertEquals($expected, $actual);
	}

	public function test_can_set_custom_oauth_base_url(){
		$expected = "https://oauth.here.io";
		IdfyConfiguration::SetOAuthBaseUrl($expected);
		$actual = IdfyConfiguration::GetOAuthBaseUrl();
		$this->assertEquals($expected, $actual);
	}

	public function test_changing_the_base_url_does_not_change_oauth_base_url(){
		IdfyConfiguration::SetBaseUrl("https://some.random.url.io");
		$actual = IdfyConfiguration::GetOAuthBaseUrl();
		$expected = "https://api.idfy.io";
		$this->assertEquals($expected, $actual);
	}

	public function test_changing_the_oauth_base_url_does_not_change_base_url(){
		IdfyConfiguration::SetOAuthBaseUrl("https://some.random.url.io");
		$actual = IdfyConfiguration::GetBaseUrl();
		$expected = "https://api.idfy.io";
		$this->assertEquals($expected, $actual);
	}

	public function test_can_get_the_default_http_timeout(){
		$actual = IdfyConfiguration::GetHttpTimeout();
		$this->assertEquals(0, $actual);
	}

	public function test_can_set_the_http_timeout(){
		IdfyConfiguration::SetHttpTimeout(60);
		$actual = IdfyConfiguration::GetHttpTimeout();
		$this->assertEquals(60, $actual);
	}

}

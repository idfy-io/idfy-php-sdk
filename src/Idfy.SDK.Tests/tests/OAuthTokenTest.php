<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include '../Idfy.SDK/Entities/OAuthToken.php';
include './tests/TestData.php';

final class OAuthTokenTest extends TestCase
{
	protected $valid_token;
	protected $valid_b64;
	protected $token_missing_jwt;
	protected $valid_expires;
	protected $valid_token_type;

	protected function setUp(){
		$this->valid_token = TestData::$token;
		$this->valid_b64 = TestData::$valid_b64;
		$this->token_missing_jwt = TestData::$token_missing_jwt;
		$this->valid_expires = 3600;
		$this->valid_token_type = "Bearer";
	}

	public function test_has_OAuthToken_type(){
		$oat = new OAuthToken($this->valid_token, $this->valid_expires, $this->valid_token_type);
		$this->assertInstanceOf(OAuthToken::class, $oat);
	}

	public function test_can_construct_OAuthTokens(){
		$oat = new OAuthToken($this->valid_token, $this->valid_expires, $this->valid_token_type );
		$this->assertInstanceOf(OAuthToken::class, $oat);
	}

	public function test_accessToken_throws_given_empty_string(){
		$this->expectException(BadAccessTokenException::class);
		$oat = new OAuthToken(" ", $this->valid_expires, $this->valid_token_type);
	}	

	public function test_accessToken_throws_when_contents_are_not_url_encoded_base64(){
		$this->expectException(BadAccessTokenException::class);
		$oat = new OAuthToken($this->valid_b64, $this->valid_expires, $this->valid_token_type);
	}

	public function test_accessToken_throws_when_no_jwt_is_present(){
		$this->expectException(BadAccessTokenException::class);
		$oat = new OAuthToken($this->token_missing_jwt, 1, "", "");
	}

	public function test_can_get_accessToken(){
		$oat = new OAuthToken($this->valid_token, $this->valid_expires, $this->valid_token_type);
		$this->assertSame($this->valid_token, $oat->getAccessToken());
	}

	public function test_can_get_expires_in(){
		$oat = new OAuthToken($this->valid_token, $this->valid_expires, $this->valid_token_type);
		$this->assertSame($this->valid_expires, $oat->getExpiresIn());
	}

	public function test_it_throws_when_given_bad_expires(){
		$this->expectException(BadExpiresInException::class);
		$oat = new OAuthToken($this->valid_token, "expire this!", $this->valid_token_type);
	}

	public function test_it_throws_when_given_negative_expires(){
		$this->expectException(BadExpiresInException::class);
		$oat = new OAuthToken($this->valid_token, -3600, $this->valid_token_type);
	}

	public function test_it_throws_when_given_zero_expires(){
		$this->expectException(BadExpiresInException::class);
		$oat = new OAuthToken($this->valid_token, 0, $this->valid_token_type);
	}

	public function test_it_throws_when_given_any_other_token_type_than_bearer(){
		$this->expectException(UnsupportedTokenTypeException::class);
		$oat = new OAuthToken($this->valid_token, $this->valid_expires, "NotBearer");
	}

	public function test_expiry_is_at_the_correct_time(){
		$startTime = new DateTimeImmutable();
		$expected = $startTime->add(new DateInterval('PT'.$this->valid_expires.'S'));
		$oat = new OAuthToken($this->valid_token, $this->valid_expires, $this->valid_token_type, $startTime);
		$result = $oat->getExpiry();
		$this->assertEquals($expected, $result);
	}

	public function test_default_valid_from_always_gives_expiry_in_the_future(){
		$oat = new OAuthToken($this->valid_token, 1, $this->valid_token_type);
		$this->assertTrue($oat->getExpiry() > new DateTimeImmutable);
	}

}

<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include '../Idfy.SDK/Entities/OAuthToken.php';

final class EntityTest extends TestCase
{
	public function test_has_OAuthToken_type(){
		$oat = new OAuthToken();
		$this->assertInstanceOf(OAuthToken::class, $oat);
	}
}

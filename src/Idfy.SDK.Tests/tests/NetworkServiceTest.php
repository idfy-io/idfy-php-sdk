<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once '../Idfy.SDK/Infrastructure/NetworkService.php';
include_once '../Idfy.SDK/Infrastructure/Exceptions.php';
include_once './tests/TestData.php';

final class NetworkServiceTest extends TestCase
{
	protected function setUp(){
		$this->ns = new NetworkService("https://some.base.url.io");
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

}

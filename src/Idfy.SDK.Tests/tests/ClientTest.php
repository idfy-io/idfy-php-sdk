<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestType
{
	private $privateData;

	public function __construct(string $assertable){
		$this->privateData = $assertable;
	}

	public function AssertMeNow(string $joiner){
		return $this->privateData.$joiner;
	}
}

final class TestFrameworkTest extends TestCase
{
	public function test_can_assert_types(){
		$tt = new TestType("");
		$this->assertInstanceOf(TestType::class, $tt);
	}

	public function test_can_fail(){
		$this->assertTrue(1 == 1);
	}
}

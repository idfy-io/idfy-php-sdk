<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class RandomType 
{
	private $privateData;

	public function __construct(string $assertable){
		$this->privateData = $assertable;
	}

	public function AssertMeNow(string $joiner){
		return $this->privateData.$joiner;
	}
}

final class CanUseFrameworkTest extends TestCase
{
	public function test_can_assert_types(){
		$tt = new RandomType("");
		$this->assertInstanceOf(RandomType::class, $tt);
	}
}

<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

$dn = dirname(__FILE__)."/";
$sdk = $dn."../../Idfy.SDK/";
include_once($sdk."Infrastructure/Exceptions.php");
include_once($sdk."IdfyConfiguration.php");

final class IdfyConfigurationTest extends TestCase
{
	protected $ic;

	protected function setUp(){
		$this->ic = new IdfyConfiguration();
	}


	public function test_has_IdfyConfigurationType(){
		$this->assertInstanceOf(IdfyConfiguration::class, $this->ic);
	}
}

<?php
declare(strict_types=1);

/* 
 * PHP still lacks a strongly typed enum type. Since we are not using composer
 * and after attempting my own hacks and scouring the net for information, 
 * the best solution I could find came from this StackOverflow answer:
 * https://stackoverflow.com/questions/254514/php-and-enumerations/25526473#25526473
 * (I changed the formatting to suit the project)
*/

abstract class Enum
{

	private static $instancedValues;

	private $value;
	private $name;

	private function __construct($value, $name){
		$this->value = $value;
		$this->name = $name;
	}

	private static function fromGetter($getter, $value){
		$reflectionClass = new ReflectionClass(get_called_class());
		$methods = $reflectionClass->getMethods(ReflectionMethod::IS_STATIC | ReflectionMethod::IS_PUBLIC);    
		$className = get_called_class();

		foreach($methods as $method){
			if ($method->class === $className){
				$enumItem = $method->invoke(null);

				if ($enumItem instanceof $className && $enumItem->$getter() === $value){
					return $enumItem;
				}
			}
		}
		throw new OutOfRangeException();
	}

	protected static function create($value){
		if(self::$instancedValues === null)		{
			self::$instancedValues = array();
		}

		$className = get_called_class();

		if(!isset(self::$instancedValues[$className])){
			self::$instancedValues[$className] = array();
		}

		if(!isset(self::$instancedValues[$className][$value])){
			$debugTrace = debug_backtrace();
			$lastCaller = array_shift($debugTrace);

			while ($lastCaller['class'] !== $className && count($debugTrace) > 0){
				$lastCaller = array_shift($debugTrace);
			}

			self::$instancedValues[$className][$value] = new static($value, $lastCaller['function']);
		}

		return self::$instancedValues[$className][$value];
	}

	public static function fromValue($value)	{
		return self::fromGetter('getValue', $value);
	}

	public static function fromName($value){
		return self::fromGetter('getName', $value);
	}

	public function getValue(){
		return $this->value;
	}

	public function getName(){
		return $this->name;
	}
}

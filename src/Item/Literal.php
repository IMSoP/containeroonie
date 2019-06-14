<?php


namespace IMSoP\Containeroonie\Item;


use IMSoP\Containeroonie\Container;

class Literal implements AnyItem
{
	private $value;

	/**
	 * Literal constructor.
	 * @param $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	public function build(Container $container)
	{
		return $this->value;
	}
}

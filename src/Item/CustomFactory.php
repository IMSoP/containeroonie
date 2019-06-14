<?php


namespace IMSoP\Containeroonie\Item;


use IMSoP\Containeroonie\Container;

class CustomFactory implements AnyItem
{
	/**
	 * @var callable $callback
	 */
	private $callback;

	/**
	 * CustomFactory constructor.
	 * @param callable $callback
	 */
	public function __construct(callable $callback)
	{
		$this->callback = $callback;
	}


	public function build(Container $container)
	{
		return ($this->callback)($container);
	}
}

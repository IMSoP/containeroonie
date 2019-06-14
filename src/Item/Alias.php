<?php


namespace IMSoP\Containeroonie\Item;


use IMSoP\Containeroonie\Container;

class Alias implements AnyItem
{
	/**
	 * @var AnyItem $target
	 */
	private $target;

	/**
	 * Alias constructor.
	 * @param AnyItem $target
	 */
	public function __construct(AnyItem $target)
	{
		$this->target = $target;
	}

	public function build(Container $container)
	{
		return $container->get($this->target)->build($container);
	}
}

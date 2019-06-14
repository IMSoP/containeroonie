<?php


namespace IMSoP\Containeroonie\Item;


use IMSoP\Containeroonie\Container;

class Singleton implements AnyItem
{
	/**
	 * @var boolean $resolved
	 */
	private $resolved = false;

	/**
	 * @var mixed $value
	 */
	private $value;
	
	/**
	 * @var AnyItem $innerItem
	 */
	private $innerItem;

	/**
	 * Singleton constructor.
	 * @param AnyItem $innerItem
	 */
	public function __construct(AnyItem $innerItem)
	{
		$this->innerItem = $innerItem;
	}

	public function build(Container $container)
	{
		if ( ! $this->resolved ) {
			$this->value = $this->innerItem->build($container);
			$this->resolved = true;
		}
		
		return $this->value;
	}
}

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
	 * @var array
	 */
	private $args;

	/**
	 * CustomFactory constructor.
	 * @param callable $callback
	 */
	public function __construct(callable $callback, array $args)
	{
		$this->callback = $callback;
		$this->args = $args;
	}


	public function build(Container $container)
	{
		$resolvedArgs = [];
		foreach ( $this->args as $argAlias ) {
			if ( $argAlias instanceof AnyItem ) {
				$resolvedArgs[] = $argAlias->build($container);
			}
			else {
				$resolvedArgs[] = $container->get($argAlias);
			}
		}
		
		return ($this->callback)($container, ...$resolvedArgs);
	}
}

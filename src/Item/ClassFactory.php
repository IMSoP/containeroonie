<?php


namespace IMSoP\Containeroonie\Item;


use IMSoP\Containeroonie\Container;

class ClassFactory implements AnyItem
{
	/**
	 * @var string $className
	 */
	private $className;
	
	/**
	 * @var string[] $args
	 */
	private $args;

	/**
	 * ClassFactory constructor.
	 * @param string $className
	 * @param string[] $args
	 */
	public function __construct(string $className, array $args)
	{
		$this->className = $className;
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
		
		return new ($this->className)(...$resolvedArgs);
	}
}

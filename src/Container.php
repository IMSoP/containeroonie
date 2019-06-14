<?php


namespace IMSoP\Containeroonie;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
	private $initialisers = [];
	private $instances = [];

	public function addLiteral($alias, $value)
	{
		$this->instances[$alias] = $value;
	}
	
	public function addInitialiser($alias, $callable)
	{
		$this->initialisers[$alias] = $callable;
	}
	
	public function addClass($alias, $className, $constructorArgs)
	{
		if ( is_null($alias) ) {
			$alias = $className;
		}
		
		$this->addInitialiser($alias, function(ContainerInterface $container) use ($className, $constructorArgs) {
			return new $className(
				...array_map([$container, 'get'], $constructorArgs)
			);
		});
	}
	
	public function addAlias($aliasFrom, $aliasTo)
	{
		$this->initialisers[$aliasFrom] = function(ContainerInterface $container) use ($aliasTo) {
			return $container->get($aliasTo);
		};
	}

	/**
	 * Finds an entry of the container by its identifier and returns it.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return mixed Entry.
	 * 
	 * @throws ContainerExceptionInterface Error while retrieving the entry.
	 * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
	 */
	public function get($id)
	{
		if ( array_key_exists($id, $this->instances) )  {
			return $this->instances[$id];
		}
		elseif ( array_key_exists($id, $this->initialisers) )  {
			$this->instances[$id] = $this->initialisers[$id]($this);
			return $this->instances[$id];
		}
		else {
			throw new ItemNotFoundException;
		}
	}

	/**
	 * Returns true if the container can return an entry for the given identifier.
	 * Returns false otherwise.
	 *
	 * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
	 * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return bool
	 */
	public function has($id)
	{
		return array_key_exists($id, $this->initialisers);
	}
}

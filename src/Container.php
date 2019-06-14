<?php

namespace IMSoP\Containeroonie;

use IMSoP\Containeroonie\Item\Alias;
use IMSoP\Containeroonie\Item\ClassFactory;
use IMSoP\Containeroonie\Item\CustomFactory;
use IMSoP\Containeroonie\Item\Literal;
use IMSoP\Containeroonie\Item\Singleton;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
	private $items = [];

	public function addLiteral($id, $value)
	{
		$this->items[$id] = new Literal($value);
	}
	
	public function addCustomFactory($id, $callable)
	{
		$this->items[$id] = new CustomFactory($callable);
	}
	
	public function addCustomSingleton($id, $callable)
	{
		$this->items[$id] = new Singleton(
			new CustomFactory($callable)
		);
	}
	
	public function addClassFactory($id, $className, $constructorArgs)
	{
		if ( is_null($id) ) {
			$id = $className;
		}
		
		$this->items[$id] = new ClassFactory($className, $constructorArgs);
	}
	
	public function addClassSingleton($id, $className, $constructorArgs)
	{
		if ( is_null($id) ) {
			$id = $className;
		}
		
		$this->items[$id] = new Singleton(
			new ClassFactory($className, $constructorArgs)
		);
	}
	
	public function addAlias($aliasFrom, $aliasTo)
	{
		$this->items[$aliasFrom] = new Alias($aliasTo);
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
		if ( array_key_exists($id, $this->items) ) {
			return $this->items[$id]->build($this);
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
		return array_key_exists($id, $this->items);
	}
}

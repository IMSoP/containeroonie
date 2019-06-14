<?php


namespace IMSoP\Containeroonie\Item;


use IMSoP\Containeroonie\Container;

interface AnyItem
{
	public function build(Container $container);
}

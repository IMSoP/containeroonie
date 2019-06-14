<?php


namespace IMSoP\Containeroonie;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class ItemNotFoundException extends Exception implements NotFoundExceptionInterface
{
}

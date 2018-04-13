<?php

namespace App\Api;

use Psr\Container\ContainerInterface;

class TrendsApiFactory
{
	public function __invoke(ContainerInterface $container, $name)
	{
		return new $name($container->get('config'));
	}
}
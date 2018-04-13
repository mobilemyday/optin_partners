<?php

namespace App;

use Psr\Container\ContainerInterface;

class ActitoFactory
{
	public function __invoke(ContainerInterface $container)
	{
		$config = $container->get('config');

		$config = (isset($config['mails']))? $config['mails'] : [];

		return new Actito($config);
	}
}
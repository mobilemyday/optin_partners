<?php

namespace App\Twig;

use Psr\Container\ContainerInterface;
use App\Factory\Translator;

class FormExtensionFactory
{
	public function __invoke(ContainerInterface $container)
	{
		return new FormExtension(
			$container->get(Translator::class)
		);
	}
}
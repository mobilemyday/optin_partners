<?php

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Factory\Translator;

class LocalizationFactory
{
    public function __invoke(ContainerInterface $container)
    {
    	$config = $container->get('config');

    	$locale = $config['locale'] ?? [];

        return new Localization(
			$container->get(Translator::class),
			$container->get(TemplateRendererInterface::class),
        	$locale
		);
    }
}

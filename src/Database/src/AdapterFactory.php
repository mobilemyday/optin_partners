<?php

namespace Database;

use Psr\Container\ContainerInterface;
//use Zend\Expressive\Router\RouterInterface;
//use Zend\Expressive\Template\TemplateRendererInterface;

//use Whoops\Exception\ErrorException;
use Exception;
use Database\ApplicationAdapters;

class AdapterFactory
{
	/**
	 * @param ContainerInterface $container
	 * @return ApplicationAdapters
	 * @throws Exception
	 */
	public function __invoke(ContainerInterface $container)
	{
		$config = $container->get('config');

		$databasesConfig = (isset($config['databases']))? $config['databases'] : null;

		if($databasesConfig)
		{
			$adapters = new ApplicationAdapters($databasesConfig);
			return $adapters;
		}
		else {
			throw new Exception('No database configuration provided');
		}
	}
}
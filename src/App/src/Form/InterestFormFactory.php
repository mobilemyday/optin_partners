<?php

namespace App\Form;

use App\Api\Software as SoftwareApi;
use App\Helper\UrlHelper;
use App\Factory\Translator;
use Zend\Expressive\Helper\UrlHelper as ZendUrlHelper;
use Psr\Container\ContainerInterface;

class InterestFormFactory
{
	public function __invoke(ContainerInterface $container)
	{
		/**
		 * @var UrlHelper $urlHelper
		 */
		$urlHelper = $container->get(ZendUrlHelper::class);

		$partner = null;
		$routeResult = $urlHelper->getRouteResult();

		if($routeResult && !empty($routeResult->getMatchedParams()['partner']))
		{
			$partner = $routeResult->getMatchedParams()['partner'];
		}

		return new InterestForm(
			$container->get(SoftwareApi::class),
			$container->get(Translator::class),
			$partner
		);
	}
}
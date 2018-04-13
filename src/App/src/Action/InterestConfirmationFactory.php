<?php

namespace App\Action;

use PointOfSale\Model\ConnectedInterestTable;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

class InterestConfirmationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new InterestConfirmationAction(
			$container->get(ConnectedInterestTable::class),
			$container->get(UrlHelper::class),
			$container->get(TemplateRendererInterface::class)
		);
    }
}

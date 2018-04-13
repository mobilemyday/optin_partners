<?php

namespace App\Action;

use App\Actito;
use App\Api\PointOfSale as PointOfSaleApi;
use App\Form\InterestForm;
use PointOfSale\Model\ConnectedInterestEmailTable;
use PointOfSale\Model\ConnectedOptinTable;
use PointOfSale\Model\ConnectedFormTable;
use PointOfSale\Model\ConnectedFormsOldSoftwareTable;
use PointOfSale\Model\ConnectedInterestTable;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Helper\ServerUrlHelper;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

class InterestFormFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new InterestFormAction(
			$container->get(InterestForm::class),
			$container->get(PointOfSaleApi::class),
			$container->get(ConnectedFormTable::class),
			$container->get(ConnectedInterestTable::class),
			$container->get(ConnectedInterestEmailTable::class),
			$container->get(ConnectedFormsOldSoftwareTable::class),
			$container->get(ConnectedOptinTable::class),
			$container->get(UrlHelper::class),
			$container->get(ServerUrlHelper::class),
			$container->get(TemplateRendererInterface::class),
			$container->get(Actito::class)
		);
    }
}

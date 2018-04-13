<?php

namespace PointOfSale\Model;

use Psr\Container\ContainerInterface;
use Database\AdapterFactory;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ConnectedInterestTableFactory
{
	protected $tableIdentifier = 'PointsOfSaleConnectedInterests';

	protected $adapterName = 'optin';

	public function __invoke(ContainerInterface $container)
	{
		$dbAdapters = $container->get(AdapterFactory::class);
		$dbAdapter = $dbAdapters->getAdapter($this->adapterName);

		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new ConnectedInterest());

		$tableGateway = new TableGateway($this->tableIdentifier, $dbAdapter, null, $resultSetPrototype);

		return new ConnectedInterestTable($tableGateway);
	}
}
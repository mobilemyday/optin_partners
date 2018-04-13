<?php

namespace App\Model;

use Psr\Container\ContainerInterface;
use Database\AdapterFactory;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class SoftwareTableFactory
{
	protected $tableIdentifier = 'Software';

	protected $adapterName = 'trends';

	public function __invoke(ContainerInterface $container)
	{
		$dbAdapters = $container->get(AdapterFactory::class);
		$dbAdapter = $dbAdapters->getAdapter($this->adapterName);

		$resultSetPrototype = new ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new Software());

		$tableGateway = new TableGateway($this->tableIdentifier, $dbAdapter, null, $resultSetPrototype);

		return new SoftwareTable($tableGateway);
	}
}
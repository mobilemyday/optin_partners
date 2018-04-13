<?php

namespace Database;

use Exception;
use Zend\Db\Adapter\Adapter as DbAdapter;

class ApplicationAdapters
{
	protected $adapters = [];

	protected $configuration;

	public function __construct(Array $configuration)
	{
		$this->configuration = $configuration;
	}

	public function getAdapter($name, $config = null)
	{
		if(isset($this->adapters[$name]))
		{
			return $this->adapters[$name];
		}
		else {

			if($config)
			{
				$this->setAdapter($name, $config);
			}
			elseif(isset($this->configuration[$name]))
			{
				$config = $this->configuration[$name];
				$this->setAdapter($name, $config);
			}
			else {
				$message = sprintf('No configuration provided for "%s" db adapter', $name);
				throw new Exception($message);
			}
			return $this->adapters[$name];
		}
	}

	private function setAdapter($name, $config)
	{
		$this->adapters[$name] = new DbAdapter($config);
	}
}
<?php

namespace App\Api;

use Exception;
use App\HttpClient;
use App\Model\Software as SoftwareModel;

class Software extends HttpClient
{
	public function __construct($config)
	{
		if(empty($config['trends']) || empty($config['trends']['api']) || empty($config['trends']['api']['baseUrl']))
		{
			throw new Exception('Trends API configuration is missing');
		}
		parent::__construct();

		$this->baseUrl = $config['trends']['api']['baseUrl'];
	}

	public function getSoftwareWithCompany()
	{
		$url = $this->getBaseUrl() . '/software-with-company';
		$this->setUrl($url);

		$response = $this->get();

		$data = [];

		if($response)
		{
			$response = json_decode($response, JSON_OBJECT_AS_ARRAY);

			foreach ($response as $item)
			{
				$software = new SoftwareModel();
				$software->exchangeArray($item);
				$data[] = $software;
			}
		}
		return $data;
	}
}
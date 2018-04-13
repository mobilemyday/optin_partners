<?php

namespace App\Api;

use Exception;
use App\HttpClient;
use App\Model\PointOfSale as PointOfSaleModel;

class PointOfSale extends HttpClient
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

	public function getByAPB($apb)
	{
		$url = $this->getBaseUrl() . '/pos-by-apb/'.$apb;
		$this->setUrl($url);

		$response = $this->get();

		if($response)
		{
			$response = json_decode($response, JSON_OBJECT_AS_ARRAY);

			$pos = new PointOfSaleModel();
			$pos->exchangeArray($response);
			return $pos;
		}
		return null;
	}
}
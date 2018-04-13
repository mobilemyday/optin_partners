<?php

namespace PointOfSale\Model;

use Database\Model\AbstractModel;

class ConnectedInterestEmail extends AbstractModel
{

	public $id;
	public $idPointOfSaleConnectedInterest;
	public $idMail;
	public $dateCreate;

	public function exchangeArray(array $data)
	{
		$this->id = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idPointOfSaleConnectedInterest = !empty($data['idPointOfSaleConnectedInterest']) ? (int)$data['idPointOfSaleConnectedInterest'] : null;
		$this->idMail = !empty($data['idMail']) ? (int)$data['idMail'] : null;
		$this->dateCreate = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
	}

	public function toArray()
	{
		return [
			'id'                             => $this->id,
			'idPointOfSaleConnectedInterest' => $this->idPointOfSaleConnectedInterest,
			'idMail'                         => $this->idMail,
			'dateCreate'                     => $this->dateCreate,
		];
	}
}

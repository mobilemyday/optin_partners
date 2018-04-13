<?php

namespace PointOfSale\Model;

use Database\Model\AbstractModel;

class ConnectedOptin extends AbstractModel
{
	public $id;
	public $idPointOfSaleConnectedInterest;
	public $idPointOfSaleConnectedForm;
	public $idPointOfSale;
	public $date;
	public $dateOptOut;
	public $ip;
	public $status;
	public $dateCreate;
	public $dateUpdate;

	public function exchangeArray(array $data)
	{
		$this->id                             = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idPointOfSaleConnectedInterest = !empty($data['idPointOfSaleConnectedInterest']) ? (int)$data['idPointOfSaleConnectedInterest'] : null;
		$this->idPointOfSaleConnectedForm     = !empty($data['idPointOfSaleConnectedForm']) ? (int)$data['idPointOfSaleConnectedForm'] : null;
		$this->idPointOfSale                  = !empty($data['idPointOfSale']) ? (int)$data['idPointOfSale'] : null;
		$this->date                           = !empty($data['date']) ? $data['date'] : null;
		$this->dateOptOut                     = !empty($data['dateOptOut']) ? $data['dateOptOut'] : null;
		$this->ip                             = !empty($data['ip']) ? $data['ip'] : null;
		$this->status                         = !empty($data['status']) ? (int)$data['status'] : null;
		$this->dateCreate                     = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate                     = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;
	}

	public function toArray()
	{
		return [
			'id'                             => $this->id,
			'idPointOfSaleConnectedInterest' => $this->idPointOfSaleConnectedInterest,
			'idPointOfSaleConnectedForm'     => $this->idPointOfSaleConnectedForm,
			'idPointOfSale'                  => $this->idPointOfSale,
			'date'                           => $this->date,
			'dateOptOut'                     => $this->dateOptOut,
			'ip'                             => $this->ip,
			'status'                         => $this->status,
			'dateCreate'                     => $this->dateCreate,
			'dateUpdate'                     => $this->dateUpdate,
		];
	}
}

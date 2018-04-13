<?php

namespace PointOfSale\Model;

use Database\Model\AbstractModel;

class ConnectedInterest extends AbstractModel
{

	public $id;
	public $idPointOfSaleConnectedForm;
	public $typeSource;
	public $idClient;
	public $idUser;
	public $idPointOfSale;
	public $date;
	public $isErrorPointOfSale = 0;
	public $isErrorEmail       = 0;
	public $isAlreadyOptin     = 0;
	public $token;
	public $status;
	public $dateCreate;
	public $dateUpdate;

	public function exchangeArray(array $data)
	{
		$this->id                         = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idPointOfSaleConnectedForm = !empty($data['idPointOfSaleConnectedForm']) ? (int)$data['idPointOfSaleConnectedForm'] : null;
		$this->typeSource                 = !empty($data['typeSource']) ? $data['typeSource'] : null;
		$this->idClient                   = !empty($data['idClient']) ? (int)$data['idClient'] : null;
		$this->idUser                     = !empty($data['idUser']) ? (int)$data['idUser'] : null;
		$this->idPointOfSale              = !empty($data['idPointOfSale']) ? (int)$data['idPointOfSale'] : null;
		$this->date                       = !empty($data['date']) ? $data['date'] : null;
		$this->isErrorPointOfSale         = !empty($data['isErrorPointOfSale']) ? (int)$data['isErrorPointOfSale'] : 0;
		$this->isErrorEmail               = !empty($data['isErrorEmail']) ? (int)$data['isErrorEmail'] : 0;
		$this->isAlreadyOptin             = !empty($data['isAlreadyOptin']) ? (int)$data['isAlreadyOptin'] : 0;
		$this->token                      = !empty($data['token']) ? $data['token'] : 0;
		$this->status                     = !empty($data['status']) ? (int)$data['status'] : 0;
		$this->dateCreate                 = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate                 = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;
	}

	public function toArray()
	{
		return [
			'id'                         => $this->id,
			'idPointOfSaleConnectedForm' => $this->idPointOfSaleConnectedForm,
			'typeSource'                 => $this->typeSource,
			'idClient'                   => $this->idClient,
			'idUser'                     => $this->idUser,
			'idPointOfSale'              => $this->idPointOfSale,
			'date'                       => $this->date,
			'isErrorPointOfSale'         => $this->isErrorPointOfSale,
			'isErrorEmail'               => $this->isErrorEmail,
			'isAlreadyOptin'             => $this->isAlreadyOptin,
			'token'                      => $this->token,
			'status'                     => $this->status,
			'dateCreate'                 => $this->dateCreate,
			'dateUpdate'                 => $this->dateUpdate,
		];
	}
}

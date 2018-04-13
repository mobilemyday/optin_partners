<?php

namespace App\Model;

use Database\Model\AbstractModel;

class Code extends AbstractModel
{
	public $id;
	public $idPointOfSale;
	public $idPointOfSaleCodeType;
	public $value;
	public $status;
	public $dateCreate;
	public $dateUpdate;

	public function exchangeArray(array $data)
	{
		$this->id                    = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idPointOfSale         = !empty($data['idPointOfSale']) ? (int)$data['idPointOfSale'] : null;
		$this->idPointOfSaleCodeType = !empty($data['idPointOfSaleCodeType']) ? (int)$data['idPointOfSaleCodeType'] : null;
		$this->value                 = !empty($data['value']) ? $data['value'] : null;
		$this->status                = !empty($data['status']) ? (int)$data['status'] : null;
		$this->dateCreate            = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate            = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;
	}

	public function toArray()
	{
		return [
			'id'                    => $this->id,
			'idPointOfSale'         => $this->idPointOfSale,
			'idPointOfSaleCodeType' => $this->idPointOfSaleCodeType,
			'value'                 => $this->value,
			'status'                => $this->status,
			'dateCreate'            => $this->dateCreate,
			'dateUpdate'            => $this->dateUpdate,
		];
	}
}

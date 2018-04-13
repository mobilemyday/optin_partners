<?php

namespace App\Model;

use Database\Model\AbstractModel;

class PointOfSale extends AbstractModel
{
	public $id;
	public $idPointOfSaleType;
	public $name;
	public $phone;
	public $fax;
	public $email;
	public $status;
	public $dateCreate;
	public $dateUpdate;

	public function exchangeArray(array $data)
	{
		$this->id                = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idPointOfSaleType = !empty($data['idPointOfSaleType']) ? (int)$data['idPointOfSaleType'] : null;
		$this->name              = !empty($data['name']) ? $data['name'] : null;
		$this->phone             = !empty($data['phone']) ? $data['phone'] : null;
		$this->fax               = !empty($data['fax']) ? $data['fax'] : null;
		$this->email             = !empty($data['email']) ? $data['email'] : null;
		$this->status            = !empty($data['status']) ? (int)$data['status'] : null;
		$this->dateCreate        = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate        = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;
	}

	public function toArray()
	{
		return [
			'id'                => $this->id,
			'idPointOfSaleType' => $this->idPointOfSaleType,
			'name'              => $this->name,
			'phone'             => $this->phone,
			'fax'               => $this->fax,
			'email'             => $this->email,
			'status'            => $this->status,
			'dateCreate'        => $this->dateCreate,
			'dateUpdate'        => $this->dateUpdate,
		];
	}
}

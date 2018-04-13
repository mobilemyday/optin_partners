<?php

namespace PointOfSale\Model;

use Database\Model\AbstractModel;

class ConnectedFormsOldSoftware extends AbstractModel
{
	public $id;
	public $idPointOfSaleConnectedForm;
	public $idSoftware;
	public $otherSoftware;

	public function exchangeArray(array $data)
	{
		$this->id                         = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idPointOfSaleConnectedForm = !empty($data['idPointOfSaleConnectedForm']) ? (int)$data['idPointOfSaleConnectedForm'] : null;
		$this->idSoftware                 = !empty($data['idSoftware']) ? (int)$data['idSoftware'] : null;
		$this->otherSoftware              = !empty($data['otherSoftware']) ? $data['otherSoftware'] : null;
	}

	public function toArray()
	{
		return [
			'id'                         => $this->id,
			'idPointOfSaleConnectedForm' => $this->idPointOfSaleConnectedForm,
			'idSoftware'                 => $this->idSoftware,
			'otherSoftware'              => $this->otherSoftware,
		];
	}
}

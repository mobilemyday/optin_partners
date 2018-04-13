<?php

namespace App\Model;

use Database\Model\AbstractModel;

class Company extends AbstractModel
{
	public $id;
	public $idSuperCompanies;
	public $name;
	public $image;
	public $status;
	public $dateCreate;
	public $dateUpdate;

	public function exchangeArray(array $data)
	{
		$this->id               = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idSuperCompanies = !empty($data['idSuperCompanies']) ? (int)$data['idSuperCompanies'] : null;
		$this->name             = !empty($data['name']) ? $data['name'] : null;
		$this->image            = !empty($data['image']) ? $data['image'] : null;
		$this->status           = !empty($data['status']) ? (int)$data['status'] : null;
		$this->dateCreate       = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate       = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;
	}

	public function toArray()
	{
		return [
			'id'               => $this->id,
			'idSuperCompanies' => $this->idSuperCompanies,
			'name'             => $this->name,
			'image'            => $this->image,
			'status'           => $this->status,
			'dateCreate'       => $this->dateCreate,
			'dateUpdate'       => $this->dateUpdate,
		];
	}
}
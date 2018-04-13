<?php

namespace App\Model;

use Database\Model\AbstractModel;

class CodeType extends AbstractModel
{
	const ID_APB = 1;

	public $id;
	public $idTranslate;
	public $idClient;
	public $name;
	public $language;
	public $status;
	public $dateCreate;
	public $dateUpdate;

	public function exchangeArray(array $data)
	{
		$this->id          = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idTranslate = !empty($data['idTranslate']) ? (int)$data['idTranslate'] : null;
		$this->idClient    = !empty($data['idClient']) ? (int)$data['idClient'] : null;
		$this->name        = !empty($data['name']) ? $data['name'] : null;
		$this->language    = !empty($data['language']) ? $data['language'] : null;
		$this->status      = !empty($data['status']) ? (int)$data['status'] : null;
		$this->dateCreate  = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate  = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;
	}

	public function toArray()
	{
		return [
			'id'          => $this->id,
			'idTranslate' => $this->idTranslate,
			'idClient'    => $this->idClient,
			'name'        => $this->name,
			'language'    => $this->language,
			'status'      => $this->status,
			'dateCreate'  => $this->dateCreate,
			'dateUpdate'  => $this->dateUpdate,
		];
	}
}

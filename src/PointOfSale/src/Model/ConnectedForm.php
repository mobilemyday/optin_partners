<?php

namespace PointOfSale\Model;

use Database\Model\AbstractModel;

class ConnectedForm extends AbstractModel
{
	public $id;
	public $idPointOfSaleCodeType;
	public $code;
	public $email;
	public $firstname;
	public $lastname;
	public $sex;
	public $language;
	public $idSoftware;
	public $otherSoftware;
	public $pointOfSaleName;
	public $country;
	public $zip;
	public $city;
	public $street;
	public $number;
	public $box;
	public $dateCreate;
	public $dateUpdate;

	public function exchangeArray(array $data)
	{
		$this->id                    = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idPointOfSaleCodeType = !empty($data['idPointOfSaleCodeType']) ? (int)$data['idPointOfSaleCodeType'] : null;
		$this->code                  = !empty($data['code']) ? $data['code'] : null;
		$this->email                 = !empty($data['email']) ? $data['email'] : null;
		$this->firstname             = !empty($data['firstname']) ? $data['firstname'] : null;
		$this->lastname              = !empty($data['lastname']) ? $data['lastname'] : null;
		$this->sex                   = !empty($data['sex']) ? $data['sex'] : null;
		$this->language              = !empty($data['language']) ? $data['language'] : null;
		$this->idSoftware            = !empty($data['idSoftware']) ? (int)$data['idSoftware'] : null;
		$this->otherSoftware         = !empty($data['otherSoftware']) ? $data['otherSoftware'] : null;
		$this->pointOfSaleName       = !empty($data['pointOfSaleName']) ? $data['pointOfSaleName'] : null;
		$this->country               = !empty($data['country']) ? $data['country'] : null;
		$this->zip                   = !empty($data['zip']) ? $data['zip'] : null;
		$this->city                  = !empty($data['city']) ? $data['city'] : null;
		$this->street                = !empty($data['street']) ? $data['street'] : null;
		$this->number                = !empty($data['number']) ? $data['number'] : null;
		$this->box                   = !empty($data['box']) ? $data['box'] : null;
		$this->dateCreate            = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate            = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;
	}

	public function toArray()
	{
		return [
			'id'                    => $this->id,
			'idPointOfSaleCodeType' => $this->idPointOfSaleCodeType,
			'code'                  => $this->code,
			'email'                 => $this->email,
			'firstname'             => $this->firstname,
			'lastname'              => $this->lastname,
			'sex'                   => $this->sex,
			'language'              => $this->language,
			'idSoftware'            => $this->idSoftware,
			'otherSoftware'         => $this->otherSoftware,
			'pointOfSaleName'       => $this->pointOfSaleName,
			'country'               => $this->country,
			'zip'                   => $this->zip,
			'city'                  => $this->city,
			'street'                => $this->street,
			'number'                => $this->number,
			'box'                   => $this->box,
			'dateCreate'            => $this->dateCreate,
			'dateUpdate'            => $this->dateUpdate,
		];
	}
}

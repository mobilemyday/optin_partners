<?php

namespace App\Model;

use Database\Model\AbstractModel;

class Software extends AbstractModel
{
	public $id;
	public $idCompany;
	public $name;
	public $extract;
	public $status;
	public $dateCreate;
	public $dateUpdate;

	public $company;

	public function exchangeArray(array $data)
	{
		$this->id         = !empty($data['id']) ? (int)$data['id'] : null;
		$this->idCompany  = !empty($data['idCompany']) ? (int)$data['idCompany'] : null;
		$this->name       = !empty($data['name']) ? $data['name'] : null;
		$this->extract    = !empty($data['extract']) ? $data['extract'] : null;
		$this->status     = !empty($data['status']) ? (int)$data['status'] : null;
		$this->dateCreate = !empty($data['dateCreate']) ? $data['dateCreate'] : null;
		$this->dateUpdate = !empty($data['dateUpdate']) ? $data['dateUpdate'] : null;

		if(isset($data['company_id']))
		{
			$this->exchangeCompanyArray($data);
		}
	}

	protected function exchangeCompanyArray(array $data)
	{
		$companyData                     = [];
		$companyData['id']               = !empty($data['company_id']) ? (int)$data['company_id'] : null;
		$companyData['idSuperCompanies'] = !empty($data['company_idSuperCompanies']) ? (int)$data['company_idSuperCompanies'] : null;
		$companyData['name']             = !empty($data['company_name']) ? $data['company_name'] : null;
		$companyData['image']            = !empty($data['company_image']) ? $data['company_image'] : null;
		$companyData['status']           = !empty($data['company_status']) ? $data['company_status'] : null;
		$companyData['dateCreate']       = !empty($data['company_dateCreate']) ? $data['company_dateCreate'] : null;
		$companyData['dateUpdate']       = !empty($data['company_dateUpdate']) ? $data['company_dateUpdate'] : null;

		$company = new Company();
		$company->exchangeArray($companyData);

		$this->company = $company;
	}

	public function toArray()
	{
		return [
			'id'         => $this->id,
			'idCompany'  => $this->idCompany,
			'name'       => $this->name,
			'extract'    => $this->extract,
			'status'     => $this->status,
			'dateCreate' => $this->dateCreate,
			'dateUpdate' => $this->dateUpdate,
		];
	}
}
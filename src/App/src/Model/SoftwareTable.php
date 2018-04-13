<?php

namespace App\Model;

use Database\Model\Table;
use Zend\Db\Sql\Select;

class SoftwareTable extends Table
{
	public function fetchAllWithCompany()
	{
		$rowset = $this->tableGateway->select(function(Select $select){
			$select->where(['Companies.status' => 0]);
			$select->join('Companies', 'Companies.id = Software.idCompany', [
				'company_id' => 'id',
				'company_idSuperCompanies' => 'idSuperCompanies',
				'company_name' => 'name',
				'company_image' => 'image',
				'company_status' => 'status',
				'company_dateCreate' => 'dateCreate',
				'company_dateUpdate' => 'dateUpdate',
			]);
		});

		return $rowset;
	}
}
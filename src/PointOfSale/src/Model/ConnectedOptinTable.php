<?php

namespace PointOfSale\Model;

use Database\Model\Table;

class ConnectedOptinTable extends Table
{
	public function isAlreadyOptIn($idPointOfSale)
	{
		$select = $this->tableGateway->getSql()->select();
		$select->where([
			'idPointOfSale' => $idPointOfSale,
			'status' => 0,
		]);
		$select->limit(1);

		$rowset = $this->tableGateway->selectWith($select);

		if($rowset->count())
		{
			return true;
		}
		return false;
	}
}
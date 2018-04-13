<?php

namespace PointOfSale\Model;

use Database\Model\Table;

class ConnectedInterestTable extends Table
{
	/**
	 * @param string $token
	 * @return ConnectedInterest|null
	 */
	public function fetchByToken($token)
	{
		$select = $this->tableGateway->getSql()->select();

		$select->where([
			'token' => $token,
		]);
		$select->limit(1);

		$rowset = $this->tableGateway->selectWith($select);

		$row = null;
		if($rowset->count())
		{
			$row = $rowset->current();
		}

		return $row;
	}
}
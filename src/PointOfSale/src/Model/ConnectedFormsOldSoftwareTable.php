<?php

namespace PointOfSale\Model;

use Database\Model\Table;

class ConnectedFormsOldSoftwareTable extends Table
{
	/**
	 * @param int $idForm
	 * @return ConnectedFormsOldSoftware|null
	 */
	public function fetchByFormId($idForm)
	{
		$select = $this->tableGateway->getSql()->select();

		$select->where([
			'idPointOfSaleConnectedForm' => $idForm,
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
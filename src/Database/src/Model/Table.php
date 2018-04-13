<?php

namespace Database\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGateway;

class Table
{
	/**
	 * @var TableGateway
	 */
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		return $this->tableGateway->select();
	}

	public function getConnection()
	{
		return $this->tableGateway->getAdapter()->getDriver()->getConnection();
	}

	public function getRow($id)
	{
		$id = (int) $id;
		$rowset = $this->tableGateway->select(['id' => $id]);
		$row = $rowset->current();
		if (! $row) {
			throw new RuntimeException(sprintf(
				'Could not find row with identifier %d',
				$id
			));
		}

		return $row;
	}

	public function saveRow(AbstractModel $row)
	{
		$data = $row->toArray();

		$id = (int) $row->id;

		if ($id === 0) {
			$this->tableGateway->insert($data);
			return $this->tableGateway->getLastInsertValue();
		}

		if (! $this->getConfiguration($id)) {
			throw new RuntimeException(sprintf(
				'Cannot update row with identifier %d; does not exist',
				$id
			));
		}

		$this->tableGateway->update($data, ['id' => $id]);
		return $id;
	}

	public function deleteRow($id)
	{
		return $this->tableGateway->delete(['id' => (int) $id]);
	}
}
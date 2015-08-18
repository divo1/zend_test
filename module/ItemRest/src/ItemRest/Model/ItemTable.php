<?php
namespace ItemRest\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ItemTable {
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll() {
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function fetchAmountGtAll($amount) {
		$resultSet = $this->tableGateway->select(function(Select $select) use ($amount) {
			$select->where->greaterThan('amount', $amount);
		});
                return $resultSet;
	}

        public function fetchLacksAll() {
                $resultSet = $this->tableGateway->select(function(Select $select) use ($amount) {
                        $select->where->equalTo('amount', 0);
                });
                return $resultSet;
        }

	public function getItem($id) {
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(['id' => $id]);
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		if ($row->amount==NULL) {
			$row->amount = 0;
		}
		return $row;
	}

	public function saveItem(Item $item) {
		$data = [
			'name' => $item->name,
			'amount'  => ($item->amount==NULL) ? 0 : $item->amount, 
		];

		$id = (int) $item->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
			return $this->tableGateway->adapter->getDriver()->getConnection()->getLastGeneratedValue();
		} else {
			if ($this->getItem($id)) {
				$this->tableGateway->update($data, ['id' => $id]);
			} else {
				throw new \Exception('Item id does not exist');
			}
		}
		return $id;
	}

	public function deleteItem($id) {
		return $this->tableGateway->delete(['id' => (int) $id]);
	}
}

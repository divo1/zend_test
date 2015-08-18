<?php

namespace ItemRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use ItemRest\Model\Item;
use ItemRest\Form\ItemForm;
use Zend\View\Model\JsonModel;

class ItemRestController extends AbstractRestfulController {
    protected $itemTable;

    public function getList() {
	$amount = (int)$this->params()->fromQuery('amount');
	if ($amount == NULL) {
	    $results = $this->getItemTable()->fetchAll();
	} else if ($amount < 0) {
	    $results = $this->getItemTable()->fetchLacksAll();
	} else {
      	    $results = $this->getItemTable()->fetchAmountGtAll($amount);
	}
        $data = [];
        foreach($results as $result) {
	    if ($result->amount == NULL) {
		$result->amount = 0;
	    }
            $data[] = $result;
        }

        return new JsonModel([
            'data' => $data,
        ]);
    }

    public function get($id) {
        $item = $this->getItemTable()->getItem($id);

        return new JsonModel(array(
            'data' => $item,
        ));
    }

    public function create($data) {
        $form = new ItemForm();
        $item = new Item();
        $form->setInputFilter($item->getInputFilter());
        $form->setData($data);

        if ($form->isValid()) {
            $item->exchangeArray($form->getData());
            $id = $this->getItemTable()->saveItem($item);
        }
        
        return $this->get($id);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $item = $this->getItemTable()->getItem($id);
        $form  = new ItemForm();
        $form->bind($item);
        $form->setInputFilter($item->getInputFilter());
        $form->setData($data);
        if ($form->isValid()) {
            $id = $this->getItemTable()->saveItem($form->getData());
        }

        return $this->get($id);
    }

    public function delete($id) {
        $this->getItemTable()->deleteItem($id);

        return new JsonModel([
            'data' => 'deleted',
        ]);
    }

    public function getItemTable() {
        if (!$this->itemTable) {
            $sm = $this->getServiceLocator();
            $this->itemTable = $sm->get('ItemRest\Model\ItemTable');
        }
        return $this->itemTable;
    }
}

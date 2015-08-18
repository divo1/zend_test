<?php
namespace ItemRest\Form;

use Zend\Form\Form;

class ItemForm extends Form {
	public function __construct($name = null) {
		parent::__construct('item');

		$this->add([
			'name' => 'id',
			'type' => 'Hidden',
		]);
		$this->add([
			'name' => 'name',
			'type' => 'Text',
			'options' => [
				'label' => 'Nazwa',
			],
		]);
		$this->add([
			'name' => 'amount',
			'type' => 'Number',
			'options' => [
				'label' => 'Ilosc',
			],
		]);
		$this->add([
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => [
				'value' => 'Go',
				'id' => 'submitbutton',
			],
		]);
	}
}

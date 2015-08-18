<?php
namespace ItemRest\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Item implements InputFilterAwareInterface {
	public $id;
	public $name;
	public $amount;

	protected $inputFilter;

	public function exchangeArray($data) {
		$this->id     = (!empty($data['id']))     ? $data['id']     : null;
		$this->name   = (!empty($data['name']))   ? $data['name']   : null;
		$this->amount = (!empty($data['amount'])) ? $data['amount'] : null;
	}

	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception("Not used");
	}

	public function getInputFilter() {
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add([
				'name'     => 'id',
				'required' => false,
				'filters'  => [
					['name' => 'Int'],
				],
			]);

			$inputFilter->add([
				'name'     => 'name',
				'required' => true,
				'filters'  => [
					['name' => 'StripTags'],
					['name' => 'StringTrim'],
				],
				'validators' => [[
					'name'    => 'StringLength',
					'options' => [
						'encoding' => 'UTF-8',
						'min'      => 1,
						'max'      => 255,
					]
				]],
			]);

			$inputFilter->add([
				'name'     => 'amount',
				'required' => true,
                                'filters'  => [
                                        ['name' => 'Int'],
                                ],
			]);

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}

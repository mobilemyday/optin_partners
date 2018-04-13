<?php

namespace App\Form;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;
use Zend\Validator\NotEmpty;

class InterestFormFilter
{
	public function getInputFilter()
	{
		$inputFilter = new InputFilter();


		$inputFilter->add([
			'name' => 'optin_mmd',
			'required' => true,
			'validators' => [
				[
					'name' => Identical::class,
					'break_chain_on_failure' => true,
					'options' => array(
						'token' => '1',
						'messages' => array(
							Identical::NOT_SAME => 'This optin must be checked',
						),
					),
				],
			],
		]);

		$inputFilter->add([
			'name' => 'code',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 6,
						'max' => 6,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'sex',
			'required' => true,
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 1,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'firstname',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 100,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'lastname',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 100,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'email',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => EmailAddress::class,
				],
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 150,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'street',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 255,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'number',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 10,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'box',
			'required' => false,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'max' => 5,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'city',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 255,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'zip',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 10,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'idSoftware',
			'required' => true,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 10,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'otherSoftware',
			'required' => false,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'max' => 255,
					],
				],
			],
		]);

		$inputFilter->add([
			'name' => 'old_idSoftware',
			'required' => false,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			]
		]);

		$inputFilter->add([
			'name' => 'old_otherSoftware',
			'required' => false,
			'filters' => [
				['name' => StripTags::class],
				['name' => StringTrim::class],
			],
			'validators' => [
				[
					'name' => StringLength::class,
					'options' => [
						'encoding' => 'UTF-8',
						'max' => 255,
					],
				],
			],
		]);

		return $inputFilter;
	}
}
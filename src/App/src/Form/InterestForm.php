<?php

namespace App\Form;

use App\Api\Software as SoftwareApi;
use App\Model\Company as CompanyModel;
use Zend\I18n\Translator\Translator;
use Zend\Form\Form as ZendForm;
use Zend\Form\Element as ZendElement;

class InterestForm extends ZendForm
{
	protected $softwareApi;

	protected $partner;

	protected $softwareTable;

	protected $companyTable;

	protected $translator;

	protected $softwareOptions;

	public function __construct(
		SoftwareApi $softwareApi,
		Translator $translator,
		$partner = null)
	{
		parent::__construct('interest');

		$this->softwareApi   = $softwareApi;
		$this->translator    = $translator;
		$this->partner       = $partner;

		$this->setElements();
	}

	protected function setElements()
	{
		$this->add([
			'name' => 'code',
			'type' => ZendElement\Text::class,
			'options' => [
				'label' => 'N°APB',
			],
			'attributes' => [
				'required' => true,
				'id' => 'code-input',
				//'placeholder' => 'N°APB',
				//'class' => 'form-control',
			],
		]);

		$this->add([
			'name' => 'sex',
			'type' => ZendElement\Select::class,
			'options' => [
				'label' => 'Gender',
				'value_options' => [
					"" => "interest.form.sex.label",
					"m" => "Mr.",
					"f" => "Mrs.",
				],
			],
			'attributes' => [
				'required' => true,
				'id' => 'sex-select',
				'autocomplete' => 'off',
			],
		]);

		$this->add([
			'name' => 'lastname',
			'type' => ZendElement\Text::class,
			'options' => [
				'label' => 'lastname',
			],
			'attributes' => [
				'required' => true,
				'id' => 'lastname-input',
			],
		]);

		$this->add([
			'name' => 'firstname',
			'type' => ZendElement\Text::class,
			'options' => [
				'label' => 'firstname',
			],
			'attributes' => [
				'required' => true,
				'id' => 'firstname-input',
			],
		]);

		$this->add([
			'name' => 'email',
			'type' => ZendElement\Email::class,
			'options' => [
				'label' => 'email',
			],
			'attributes' => [
				'required' => true,
				'id' => 'email-input',
			],
		]);

		$this->add([
			'name' => 'pointOfSaleName',
			'type' => ZendElement\Text::class,
			'attributes' => [
				'required' => true,
				'id' => 'pos-name-input',
			],
		]);

		$this->add([
			'name' => 'street',
			'type' => ZendElement\Text::class,
			'attributes' => [
				'required' => true,
				'id' => 'street-input',
			],
		]);

		$this->add([
			'name' => 'number',
			'type' => ZendElement\Text::class,
			'attributes' => [
				'required' => true,
				'id' => 'number-input',
			],
		]);

		$this->add([
			'name' => 'box',
			'type' => ZendElement\Text::class,
			'attributes' => [
				'id' => 'box-input',
			],
		]);

		$this->add([
			'name' => 'city',
			'type' => ZendElement\Text::class,
			'attributes' => [
				'required' => true,
				'id' => 'city-input',
			],
		]);

		$this->add([
			'name' => 'zip',
			'type' => ZendElement\Text::class,
			'attributes' => [
				'required' => true,
				'id' => 'zip-input',
			],
		]);

		$this->add([
			'name' => 'country',
			'type' => ZendElement\Hidden::class,
			'attributes' => [
				'required' => true,
				'id' => 'country-input',
			],
		]);

		$this->add([
			'name' => 'idSoftware',
			'type' => ZendElement\Select::class,
			'options' => [
				'label' => 'Sélectionnez le logiciel de gestion',
				'value_options' => $this->getSoftwareValueOptions(),
			],
			'attributes' => [
				'required' => true,
				'id' => 'software-select',
				'class' => 'software-select',
				'autocomplete' => 'off',
			],
		]);

		$this->add([
			'name' => 'otherSoftware',
			'type' => ZendElement\Text::class,
			'options' => [
				'label' => 'otherSoftware',
			],
			'attributes' => [
				'id' => 'software-other-input',
				//'required' => true,
			],
		]);

		$this->add([
			'name' => 'old_idSoftware',
			'type' => ZendElement\Select::class,
			'options' => [
				'value_options' => $this->getSoftwareValueOptions(),
			],
			'attributes' => [
				'id' => 'old-software-select',
				'class' => 'software-select',
				'autocomplete' => 'off',
			],
		]);

		$this->add([
			'name' => 'old_otherSoftware',
			'type' => ZendElement\Text::class,
			'options' => [
				'label' => 'otherSoftware',
			],
			'attributes' => [
				'id' => 'old-software-other-input',
				//'required' => true,
			],
		]);

		$this->add([
			'type' => ZendElement\Checkbox::class,
			'name' => 'software_has_change',
			'options' => [
				'label' => 'interest.form.software.has.change',
				'use_hidden_element' => true,
				'checked_value' => '1',
				'unchecked_value' => '0',
			],
			'attributes' => [
				'id' => 'software-has-change-checkbox',
			],
		]);

		$this->add([
			'type' => ZendElement\Checkbox::class,
			'name' => 'optin_mmd',
			'options' => [
				'label' => 'interest.form.optin.mmd',
				'use_hidden_element' => true,
				'checked_value' => '1',
				'unchecked_value' => '0',
			],
			'attributes' => [
				'id' => 'optin-mmd-checkbox',
			],
		]);

		if($this->partner)
		{
			$this->add([
				'type' => ZendElement\Checkbox::class,
				'name' => 'optin_partner',
				'options' => [
					'label' => 'interest.form.optin.partner.'.$this->partner,
					'use_hidden_element' => true,
					'checked_value' => '1',
					'unchecked_value' => '0',
				],
				'attributes' => [
					'id' => 'optin-mmd-partner',
				],
			]);
		}
	}

	/**
	 * @return array
	 */
	protected function getSoftwareValueOptions()
	{
		if(!$this->softwareOptions)
		{
			$options   = [];
			$default   = [];
			$softwares = $this->softwareApi->getSoftwareWithCompany();

			foreach ($softwares as $software)
			{
				$value = [];

				if(
					isset($software->company) &&
					$software->company instanceof CompanyModel &&
					$software->company->name != $software->name
				)
				{
					$value[] = $software->company->name;
					$value[] = '-';
				}

				$value[] = $software->name;
				$options[$software->id] = join(' ', $value);
			}

			natcasesort($options);

			$default[""] = "interest.form.software.label";
			$options = $default + $options;
			$options["other"] = "interest.form.software.other";

			$this->softwareOptions = $options;
		}

		return $this->softwareOptions;
	}
}
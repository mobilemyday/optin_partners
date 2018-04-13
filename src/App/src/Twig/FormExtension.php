<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use Zend\Form\Element as FormElement;
use Zend\Form\Element\Checkbox as FormCheckbox;
use Zend\Form\Element\Button as FormButton;
use Zend\Form\Element\Select as FormSelect;
use Zend\I18n\Translator\Translator as ZendTranslator;

class FormExtension extends AbstractExtension
{
	protected $translator;

	public function __construct(ZendTranslator $translator = null)
	{
		$this->translator = $translator;
	}

	public function getFilters()
	{
		return array(
			new TwigFilter('formLabel', array($this, 'formLabelFilter')),
			new TwigFilter('formPlaceholder', array($this, 'formPlaceholderFilter')),
			new TwigFilter('formInput', array($this, 'formInputFilter')),
			new TwigFilter('formButton', array($this, 'formButtonFilter')),
			new TwigFilter('formCheckbox', array($this, 'formCheckboxFilter')),
			new TwigFilter('formSelect', array($this, 'formSelectFilter')),
			new TwigFilter('translate', array($this, 'translateFilter')),
		);
	}

	public function translateFilter($label, $domain = 'default')
	{
		if($this->translator)
		{
			$label = $this->translator->translate($label, $domain);
		}

		return $label;
	}

	public function formLabelFilter(FormElement $element)
	{
		return $element->getLabel();
	}

	public function formPlaceholderFilter(FormElement $element)
	{
		return $element->getAttribute('placeholder');
	}

	public function formInputFilter(FormElement $element)
	{
		$html = '<input %s>%s';

		$attributes = [
			'name' => $element->getName(),
			'type' => $element->getAttribute('type'),
			'placeholder' => $element->getAttribute('placeholder'),
			'class' => $element->getAttribute('class'),
			'id' => $element->getAttribute('id'),
			'value' => ($element->getAttribute('type') !== 'password')? $element->getValue() : null,
		];

		if($this->hasError($element))
		{
			$attributes['class'] = trim($attributes['class']. ' is-invalid');
		}

		$required = $element->getAttribute('required');

		if($required)
		{
			$attributes['required'] = '';
		}

		$attributes = $this->createInputAttributeString($attributes);
		$errors = $this->getErrorMessages($element);

		$input = sprintf($html, $attributes, $errors);

		return new Markup($input, 'UTF-8');
	}

	public function formButtonFilter(FormButton $element)
	{
		$html = '<button %s>%s</button>';

		$attributes = [
			'name' => $element->getName(),
			'type' => $element->getAttribute('type'),
			'class' => $element->getAttribute('class'),
			'id' => $element->getAttribute('id'),
			'value' => $element->getValue(),
		];

		$label = $element->getLabel();

		$html = sprintf($html, $this->createInputAttributeString($attributes), $label);

		return new Markup($html, 'UTF-8');
	}

	public function formCheckboxFilter(FormCheckbox $element)
	{
		$html = '%s<input %s><label %s>%s</label>%s';

		$defaultValue = '';
		if($element->useHiddenElement())
		{
			$attributes = [
				'name' => $element->getName(),
				'type' => 'hidden',
				'value' => $element->getUncheckedValue(),
			];

			$defaultValueHtml = '<input %s>';
			$defaultValue = sprintf($defaultValueHtml, $this->createInputAttributeString($attributes));
		}

		$attributes = [
			'name' => $element->getName(),
			'type' => $element->getAttribute('type'),
			'class' => $element->getAttribute('class'),
			'id' => $element->getAttribute('id'),
			'value' => $element->getCheckedValue(),
		];

		if($element->isChecked())
		{
			$attributes['checked'] = "checked";
		}

		$required = $element->getAttribute('required');

		if($required)
		{
			$attributes['required'] = '';
		}

		$for = '';
		if($element->getAttribute('id'))
		{
			$for = ' for="'.$element->getAttribute('id').'"';
		}

		$label = $element->getLabel();
		if($this->translator)
		{
			$label = $this->translator->translate($label);
		}
		$errors = $this->getErrorMessages($element);

		$input = sprintf($html, $defaultValue, $this->createInputAttributeString($attributes), $for, $label, $errors);

		return new Markup($input, 'UTF-8');
	}

	public function formSelectFilter(FormSelect $element)
	{
		$html = '<select %s>%s</select>';

		$attributes = [
			'name' => $element->getName(),
			'type' => $element->getAttribute('type'),
			'class' => $element->getAttribute('class'),
			'id' => $element->getAttribute('id'),
		];

		$required = $element->getAttribute('required');
		$autocomplete = $element->getAttribute('autocomplete');

		if($required)
		{
			$attributes['required'] = '';
		}

		if($autocomplete)
		{
			$attributes['autocomplete'] = $autocomplete;
		}

		$options = [];

		$optionHtml = '<option %s>%s</option>';

		$valueOptions = $element->getValueOptions();

		$selectedValue = $element->getValue();

		foreach ($valueOptions as $value => $label)
		{
			$optionAttributes = [];
			$optionAttributes["value"] = $value;

			if($selectedValue == $value)
			{
				$optionAttributes["selected"] = "selected";
			}

			if($this->translator)
			{
				$label = $this->translator->translate($label);
			}

			$options[] = sprintf($optionHtml, $this->createInputAttributeString($optionAttributes), $label);
		}

		$input = sprintf($html, $this->createInputAttributeString($attributes), join(PHP_EOL, $options));

		return new Markup($input, 'UTF-8');
	}

	private function createInputAttributeString($attributes)
	{
		$string = [];
		foreach ($attributes as $key => $value)
		{
			$string[] = "$key=\"$value\"";
		}
		return join(' ', $string);
	}

	private function getErrorMessages(FormElement $element)
	{
		$html = '';

		if($this->hasError($element))
		{
			$messages = $element->getMessages();

			$inputId = $element->getAttribute('id');

			$labelAttributes = [];
			if($inputId)
			{
				$labelAttributes["for"] = $inputId;
				$labelAttributes["id"] = "$inputId-error";
			}

			$html = '<label class="error" %s>%s</label>';

			$errors = [];

			foreach ($messages as $message)
			{
				$errors[] = sprintf('%s', $message);
			}

			$html = sprintf($html, $this->createInputAttributeString($labelAttributes), join(PHP_EOL, $errors));
		}
		return $html;
	}

	private function hasError(FormElement $element)
	{
		$messages = $element->getMessages();
		return ($messages && count($messages) > 0)? true : false;
	}
}
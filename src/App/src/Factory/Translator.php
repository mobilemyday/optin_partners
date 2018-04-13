<?php

namespace App\Factory;

use Psr\Container\ContainerInterface;
use Zend\I18n\Translator\Translator as ZendTranslator;

class Translator
{
	public function __invoke(ContainerInterface $container)
	{
		$translator = new ZendTranslator();
		$translator->addTranslationFilePattern(
			'gettext',
			'./src/App/locale',
			'/%s/mmd-optins.mo'
		);

		return $translator;
	}
}
<?php

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
			'locale'         => include __DIR__ . '/../config/locale.php',
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                Action\PingAction::class => Action\PingAction::class,
                Action\HomePageAction::class => Action\HomePageAction::class,
            ],
            'factories'  => [
				Action\InterestFormAction::class => Action\InterestFormFactory::class,
				Action\InterestConfirmationAction::class => Action\InterestConfirmationFactory::class,
				Action\OptinFormAction::class => Action\OptinFormFactory::class,
				Action\OptinConfirmationAction::class => Action\OptinConfirmationFactory::class,
				Middleware\Localization::class => Middleware\LocalizationFactory::class,
				Factory\Translator::class => Factory\Translator::class,
				Form\InterestForm::class => Form\InterestFormFactory::class,
				Model\SoftwareTable::class => Model\SoftwareTableFactory::class,
				Model\CompanyTable::class => Model\CompanyTableFactory::class,
				Model\CodeTable::class => Model\CodeTableFactory::class,
				Model\CodeTypeTable::class => Model\CodeTypeTableFactory::class,
				Actito::class => ActitoFactory::class,
				Api\Software::class => Api\TrendsApiFactory::class,
				Api\PointOfSale::class => Api\TrendsApiFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}

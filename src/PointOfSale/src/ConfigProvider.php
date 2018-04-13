<?php

namespace PointOfSale;

class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
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
            'factories'  => [
				Model\ConnectedFormTable::class => Model\ConnectedFormTableFactory::class,
				Model\ConnectedFormsOldSoftwareTable::class => Model\ConnectedFormsOldSoftwareTableFactory::class,
				Model\ConnectedInterestTable::class => Model\ConnectedInterestTableFactory::class,
				Model\ConnectedInterestEmailTable::class => Model\ConnectedInterestEmailTableFactory::class,
				Model\ConnectedOptinTable::class => Model\ConnectedOptinTableFactory::class,
            ],
        ];
    }
}

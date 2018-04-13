<?php

use Database\AdapterFactory;

return [
    'dependencies' => [
        'factories'  => [
			AdapterFactory::class => AdapterFactory::class
        ],
    ],
	'databases' => [
		'optin' => [
			'driver'   => 'Pdo_Mysql',
			'hostname' => '127.0.0.1',
			'database' => 'optin',
			'username' => 'root',
			'password' => 'root',
			'charset'  => 'utf8mb4',
			'options' => array(
				'buffer_results' => true,
			),
		]
	]
];
<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */

/** @var \Zend\Expressive\Application $app */

$localPattern = '[a-z]{2,3}[-_][a-zA-Z]{2}|';

$app->get(
	"/",
	App\Action\HomePageAction::class
)->setOptions([
	'withoutLocale' => true,
]);

$app->get(
	"/{locale:$localPattern}[/]",
	App\Action\HomePageAction::class,
	'home'
);

$app->get(
	"/{locale:$localPattern}/interest/confirmation",
	App\Action\InterestConfirmationAction::class,
	'interest.confirmation'
);

$app->get(
	"/{locale:$localPattern}/interest/{partner}/confirmation",
	App\Action\InterestConfirmationAction::class,
	'interest.partner.confirmation'
);

$app->route(
	"/{locale:$localPattern}/interest/{partner}",
	App\Action\InterestFormAction::class,
	['GET','POST'],
	'interest.form'
);

$app->get(
	"/{locale:$localPattern}/optin/confirmation",
	App\Action\OptinConfirmationAction::class,
	'optin.confirmation'
);

$app->get(
	"/{locale:$localPattern}/optin/{partner}/confirmation",
	App\Action\OptinConfirmationAction::class,
	'optin.partner.confirmation'
);

$app->route(
	"/{locale:$localPattern}/optin/{partner}/{token}",
	App\Action\OptinFormAction::class,
	['GET','POST'],
	'optin.form'
);

$app->get(
	"/{locale:$localPattern}/api/ping",
	App\Action\PingAction::class,
	'api.ping'
);
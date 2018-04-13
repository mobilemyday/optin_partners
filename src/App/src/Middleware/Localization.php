<?php

namespace App\Middleware;

use Locale;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouteResult;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\I18n\Translator\Translator;

class Localization implements ServerMiddlewareInterface
{
	private $translator;

	private $template;

	private $locale;

	public function __construct(
		Translator $translator,
		TemplateRendererInterface $template,
		$locale
	)
	{
		$this->translator = $translator;
		$this->template = $template;
		$this->locale = $locale;
	}

	public function process(ServerRequestInterface $request, DelegateInterface $delegate)
	{
		$locale = $request->getAttribute('locale');

		$uri = $request->getUri();
		$path = $uri->getPath();
		$pathLocale = null;

		/* @var $route RouteResult */
		$route = $request->getAttribute(RouteResult::class);

		if($route)
		{
			$options = $route->getMatchedRoute()->getOptions();

			if(in_array('withoutLocale', $options) && $options['withoutLocale'] === true)
			{
				return $delegate->process($request);
			}
		}

		if(!$locale && preg_match('/\/([a-z]{2}-[a-z]{2})/', $path, $matches))
		{
			$pathLocale = $matches[1];
		}

		if(!$locale && !$pathLocale)
		{
			$language = Locale::acceptFromHttp(
				$request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? $this->locale['default']
			);

			if(preg_match('/^([a-z]{2})/', $language, $matches))
			{
				$language = $matches[1];
			}

			$country = "be";

			$locale = strtolower($language).'_'.strtoupper($country);

			if(!$this->isLocaleAllowed($locale))
			{
				$locale = $this->locale['default'];
			}
			$locale = $this->localeToUri($locale);

			$url = "/$locale$path";
			return new RedirectResponse($url);
		}

		if(!$locale)
		{
			$locale = $pathLocale;
		}

		$locale = $this->uriToLocal($locale);

		if(!$this->isLocaleAllowed($locale))
		{
			if(preg_match('/\/[a-z]{2}-[a-z]{2}([^ ]*)/', $path, $matches))
			{
				$path = $matches[1];
			}

			$locale = $this->localeToUri($this->locale['default']);
			$url = "/$locale$path";
			return new RedirectResponse($url);
		}

		$uriLocale = $this->localeToUri($locale);
		$this->template->addDefaultParam(TemplateRendererInterface::TEMPLATE_ALL, 'locale', $uriLocale);

		if($route)
		{
			$matchedRouteName = $route->getMatchedRoute()->getName();

		}
		else {
			$matchedRouteName = 'home';
		}
		$this->template->addDefaultParam(
			TemplateRendererInterface::TEMPLATE_ALL,
			'matchedRouteName',
			$matchedRouteName
			);

		$availableRouteUri = [];

		foreach ($this->locale['allowed'] as $value)
		{
			$availableRouteUri[] = (object)[
				'uri' => $this->localeToUri($value),
				'language' => Locale::getPrimaryLanguage($value),
				'country' => Locale::getRegion($value),
			];
		}

		$this->template->addDefaultParam(
			TemplateRendererInterface::TEMPLATE_ALL,
			'availableLocales',
			$availableRouteUri
		);

		$this->translator->setLocale($locale);

		return $delegate->process($request->withAttribute('locale', $locale));
	}

	private function localeToUri($locale)
	{
		if(preg_match('/^([a-zA-Z]{2})[-_]([a-zA-Z]{2,3})$/', $locale, $matches))
		{
			$language = strtolower($matches[1]);
			$country = strtolower($matches[2]);

			return "$country-$language";
		}
	}

	private function uriToLocal($uri)
	{
		if(preg_match('/^([a-zA-Z]{2,3})[-_]([a-zA-Z]{2})$/', $uri, $matches))
		{
			$country = strtoupper($matches[1]);
			$language = strtolower($matches[2]);

			return $language.'_'.$country;
		}
	}

	private function isLocaleAllowed($locale)
	{
		return (in_array($locale, $this->locale['allowed']));
	}
}
